<?php

namespace App\Listeners;

use App\Interfaces\ModelSavedInterface;
use App\Models\Product;
use App\Models\Search;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class GenerateModelSearchText
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ModelSavedInterface $event
     * @return void
     */
    public function handle(ModelSavedInterface $event)
    {
        $model = $event->getModel();
        $model->searches()->delete();
        $model->load('translations');

        $baseClassName = class_basename(get_class($model));

        if (isset($model->status) && $model->status != 1) {
            return;
        }

        if ($baseClassName == 'Product') {
            $searchBody = $this->productSearchBody($model);
        } else {
            $searchBody = '';
            if (!empty($model->name)) {
                $searchBody .= $model->name . PHP_EOL;
            }
            if (!empty($model->description)) {
                $searchBody .= $model->description . PHP_EOL;
            }
            // if (!empty($model->body)) {
            //     $searchBody .= strip_tags($model->body) . PHP_EOL;
            // }
            if (!empty($model->first_name)) {
                $searchBody .= $model->first_name . PHP_EOL;
            }
            if (!empty($model->last_name)) {
                $searchBody .= $model->last_name . PHP_EOL;
            }
            if (!empty($model->middle_name)) {
                $searchBody .= $model->middle_name . PHP_EOL;
            }
            if (!empty($model->specifications)) {
                $searchBody .= strip_tags($model->specifications) . PHP_EOL;
            }

            // localization
            $defaultLocale = config('voyager.multilingual.default');
            foreach (config('laravellocalization.supportedLocales') as $key => $value) {
                if ($key != $defaultLocale) {
                    $texts = [];
                    $texts[] = $model->getTranslatedAttribute('name', $key);
                    $texts[] = $model->getTranslatedAttribute('description', $key);
                    // $texts[] = $model->getTranslatedAttribute('body', $key);
                    $texts[] = $model->getTranslatedAttribute('first_name', $key);
                    $texts[] = $model->getTranslatedAttribute('last_name', $key);
                    $texts[] = $model->getTranslatedAttribute('middle_name', $key);
                    foreach ($texts as $text) {
                        if ($text) {
                            $searchBody .= $text . PHP_EOL;
                        }
                    }
                }
            }
        }

        $search = new Search();
        $search->body = $searchBody;

        $model->searches()->save($search);
    }

    private function productSearchBody($model)
    {
        $searchBody = '';
        if (!$model->isActive()) {
            return $searchBody;
        }
        $brand = $model->brand;
        if ($brand) {
            $brand->load('translations');
        }
        $categories = $model->categories()->withTranslations()->get();
        $searchBody .= $model->name . PHP_EOL;
        $searchBody .= $model->sku . PHP_EOL;
        $searchBody .= $model->description . PHP_EOL;
        $searchBody .= ($brand->name ?? '') . PHP_EOL;
        foreach ($categories as $category) {
            $searchBody .= $category->name . PHP_EOL;
        }

        $defaultLocale = config('voyager.multilingual.default');

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            if ($key != $defaultLocale) {
                $searchBody .= $model->getTranslatedAttribute('name', $key) . PHP_EOL;
                $searchBody .= $model->getTranslatedAttribute('description', $key) . PHP_EOL;

                if ($brand) {
                    $searchBody .= $brand->getTranslatedAttribute('name', $key) . PHP_EOL;
                }

                foreach ($categories as $category) {
                    $searchBody .= $category->getTranslatedAttribute('name') . PHP_EOL;
                }
            }
        }
        return $searchBody;
    }
}

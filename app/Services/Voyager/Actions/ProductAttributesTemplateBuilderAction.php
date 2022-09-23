<?php

namespace App\Services\Voyager\Actions;

use TCG\Voyager\Actions\AbstractAction;

class ProductAttributesTemplateBuilderAction extends AbstractAction
{
    public function getTitle()
    {
        return __('voyager::generic.builder');
    }

    public function getIcon()
    {
        return 'voyager-list';
    }

    public function getPolicy()
    {
        return 'edit';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-success pull-right',
            'target' => '_blank'
        ];
    }

    public function getDefaultRoute()
    {
        // return $this->data->url;
        return route('voyager.product_attributes_templates.builder', $this->data->id);
    }

    public function shouldActionDisplayOnDataType()
    {
        $dataTypes = ['product_attributes_templates'];
        return in_array($this->dataType->slug, $dataTypes);
    }
}

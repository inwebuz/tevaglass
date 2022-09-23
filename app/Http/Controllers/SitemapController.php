<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Publication;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    public function create()
    {
        $locales = array_keys(config('laravellocalization.supportedLocales'));
        $files = [];
        $oldFiles = ['sitemap.xml'];
        $oldFilesQty = 20;
        for ($i = 1; $i <= 20; $i++) {
            $oldFiles[] = 'sitemap' . $i . '.xml';
        }
        $all = [];
        $data = [
            'pages' => ['items' => Page::active()->withTranslations($locales)->get(), 'priority' => 0.9, 'changeFrequency' => 'weekly', ],
            'categories' => ['items' => Category::active()->withTranslations($locales)->get(), 'priority' => 0.8, 'changeFrequency' => 'weekly', ],
            'products' => ['items' => Product::active()->withTranslations($locales)->get(), 'priority' => 0.7, 'changeFrequency' => 'weekly', ],
            'publications' => ['items' => Publication::active()->withTranslations($locales)->get(), 'priority' => 0.7, 'changeFrequency' => 'weekly', ],
            'brands' => ['items' => Brand::active()->withTranslations($locales)->get(), 'priority' => 0.7, 'changeFrequency' => 'weekly', ],
        ];
        foreach ($data as $type => $content) {
            if ($content['items']->isEmpty()) {
                continue;
            }
            foreach ($content['items'] as $item) {
                foreach($locales as $locale) {
                    $all[] = [
                        'url' => $item->getURL($locale),
                        'priority' => $content['priority'],
                        'lastModificationDate' => $item->updated_at->format(DateTime::ATOM) ?? date('Y-m-d'),
                        'changeFrequency' => $content['changeFrequency'],
                    ];
                }
            }
        }

        // echo "Links: " . count($all);

        $all = array_chunk($all, 9000);
        foreach ($all as $key => $urls) {
            $files[] = view('sitemap', compact('urls'))->render();
        }

        // get sitemaps folder path
        $sitemapsDir = $this->getSitemapsDir();

        // delete old files
        foreach ($oldFiles as $oldFile) {
            $file = public_path($oldFile);
            if(file_exists($file)) {
                unlink($file);
            }
        }

        // write new sitemap files
        foreach ($files as $key => $value) {
            $fileName = $sitemapsDir . '/' . 'sitemap' . ($key + 1) . '.xml';
            file_put_contents($fileName, $value);
        }

        $getSitemapsBaseURL = $this->getSitemapsBaseURL();

        // rewrite sitemap index file
        $filesQuantity = count($files);
        $sitemapLastmod = (Carbon::now())->format(DateTime::ATOM);
        $sitemapIndexContent = view('sitemapindex', compact('filesQuantity', 'sitemapLastmod', 'getSitemapsBaseURL'))->render();
        file_put_contents($sitemapsDir . '/sitemapindex.xml', $sitemapIndexContent);
    }

    public function index()
    {
        $this->create();
        $sitemapsDir = $this->getSitemapsDir();

        return response(file_get_contents($sitemapsDir . '/sitemapindex.xml'))
            ->withHeaders([
                'Content-Type' => 'text/xml'
            ]);
    }

    private function getSitemapsDir()
    {
        $sitemapsDir = base_path('../public_html/sitemaps');
        if (!is_dir($sitemapsDir)) {
            $sitemapsDir = public_path() . '/sitemaps';
        }
        return $sitemapsDir;
    }

    private function getSitemapsBaseURL()
    {
        return route('home') . '/sitemaps';
    }
}

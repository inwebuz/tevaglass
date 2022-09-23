<?php

namespace App\View\Components;

use App\Models\StaticText;
use Illuminate\View\Component;

class Advantages extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $locale = app()->getLocale();
        $advantages = StaticText::where('key', 'LIKE', 'advantage_%')->orderBy('key')->withTranslation($locale)->get();
        return view('components.advantages', compact('advantages'));
    }
}

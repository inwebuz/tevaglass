<?php

namespace App\View\Components;

use App\Models\Project;
use Illuminate\View\Component;

class BusinessAreas extends Component
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
        $projects = Project::active()->businessAreas()->withTranslation($locale)->latest()->take(4)->get();
        return view('components.business_areas', compact('projects'));
    }
}

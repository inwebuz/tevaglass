<?php

namespace App\Models\Voyager;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Models\MenuItem as VoyagerMenuItem;
use App\Traits\Translatable;

class MenuItem extends VoyagerMenuItem
{
    protected $translatable = ['title', 'url'];
}

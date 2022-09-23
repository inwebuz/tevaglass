<?php

namespace App\Providers;

use App\Events\ModelDeleted;
use App\Events\ModelSaved;
use App\Events\ProductCreated;
use App\Events\ProductSaved;
use App\Events\UserSaved;
use App\Listeners\CheckProductGroupAttributeValues;
use App\Listeners\CreateInitialReview;
use App\Listeners\DeleteModelSearchText;
use App\Listeners\GenerateModelSearchText;
use App\Listeners\UserSavedListener;
use App\Listeners\VoyagerBreadDataSave;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Models\Role;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // Voyager Admin Custom Listeners
        BreadDataAdded::class => [
            VoyagerBreadDataSave::class,
        ],
        BreadDataUpdated::class => [
            VoyagerBreadDataSave::class,
        ],
        ModelSaved::class => [
            GenerateModelSearchText::class,
        ],
        ModelDeleted::class => [
            DeleteModelSearchText::class,
        ],
        ProductSaved::class => [
            CheckProductGroupAttributeValues::class,
            GenerateModelSearchText::class,
        ],
        ProductCreated::class => [
            CreateInitialReview::class,
        ],
        UserSaved::class => [
            UserSavedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}

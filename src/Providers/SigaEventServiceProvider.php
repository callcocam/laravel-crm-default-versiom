<?php


namespace SIGA\Providers;


use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SIGA\Events\RoleEvent;
use SIGA\Events\UserEvent;
use SIGA\Listeners\RoleListener;
use SIGA\Listeners\UserListener;

class SigaEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
       RoleEvent::class=>[
           RoleListener::class
       ],
        UserEvent::class=>[
            UserListener::class
        ]
    ];


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

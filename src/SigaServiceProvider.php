<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA;

use Illuminate\Support\ServiceProvider;
use SIGA\Acl\AclServiceProvider;
use SIGA\Acl\Models\Permission;
use SIGA\Activitylog\ActivitylogServiceProvider;
use SIGA\Console\Commands\AddPermissionsComand;
use SIGA\Menus\MenuServiceProvider;
use SIGA\Notify\NotifyServiceProvider;
use SIGA\Providers\MacrosServiceProvider;
use SIGA\Providers\SigaEventServiceProvider;
use SIGA\Providers\SigaRouteServiceProvider;
use SIGA\TableView\TableViewServiceProvider;

class SigaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->register(ActivitylogServiceProvider::class);
        $this->app->register(AutoRouteServiceProvider::class);
        $this->app->register(AclServiceProvider::class);
        $this->app->register(TableViewServiceProvider::class);
        $this->app->register(MacrosServiceProvider::class);
        $this->app->register(FormBuilderServiceProvider::class);
        $this->app->register(NotifyServiceProvider::class);
        $this->app->register(MenuServiceProvider::class);
        $this->app->register(SigaEventServiceProvider::class);

        $this->app->register(SigaRouteServiceProvider::class);

        $this->mergeConfigFrom(siga_path('config\\siga.php'),'siga');

       // $this->loadMigrationsFrom(siga_path('database/migrations'));

        $this->loadViewsFrom(siga_path('resources/views'),'siga');

        $this->app->singleton('make.permissions',
            function($app) {

                return new AddPermissionsComand(app(Permission::class));
            });

        $this->commands('make.permissions');

    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/siga.php' => config_path('siga.php'),
        ]);

        $this->publishes([
            __DIR__.'/resources' => resource_path(),
        ],'views');
        $this->publishes([
            __DIR__.'/assets' => public_path('vendor'),
        ], 'public');

        $this->publishes([
            __DIR__.'/database/migrations/' => database_path('migrations')
        ], 'migrations');


        $this->publishes([
            __DIR__.'/database/seeds/' => database_path('seeds')
        ], 'seeds');

        $this->publishes([
            __DIR__.'/database/factories/' => database_path('factories')
        ], 'factories');


        $this->publishes([
            __DIR__.'/database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/webpack.mix.js' => base_path('webpack.mix.js'),
            __DIR__.'/package.json' => base_path('package.json'),
        ]);
    }
}

<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use SIGA\TableView\DataViewFormHelper;
use SIGA\TableView\TableViewForm;

class FormBuilderServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/config.php',
            'laravel-form-builder'
        );
        $this->registerFormHelper();
        $this->registerHtmlIfNeeded();
    }


    /**
     * Bootstrap the service.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'laravel-form-builder');
        $form = $this->app['form'];

        $form->macro('customLabel', function($name, $value, $options = []) use ($form) {
            if (isset($options['for']) && $for = $options['for']) {
                unset($options['for']);
                return $form->label($for, $value, $options);
            }

            return $form->label($name, $value, $options);
        });
    }
    /**
     * Register the form helper.
     *
     * @return void
     */
    protected function registerFormHelper()
    {
        $this->app->singleton('laravel-form-helper', function ($app) {

            $configuration = $app['config']->get('laravel-form-builder');

            return new DataViewFormHelper($app['view'], $app['translator'], $configuration);
        });

        $this->app->alias('laravel-form-helper', DataViewFormHelper::class);
    }
    /**
     * Get the services provided by this provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return ['laravel-form-builder'];
    }

    /**
     * Add Laravel Html to container if not already set.
     */
    private function registerHtmlIfNeeded()
    {

    }

    /**
     * Check if an alias already exists in the IOC.
     *
     * @param string $alias
     * @return bool
     */
    private function aliasExists($alias)
    {
        return array_key_exists($alias, AliasLoader::getInstance()->getAliases());
    }

}

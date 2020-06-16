<?php

namespace Kaitoj\Translator;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\TranslationServiceProvider as IlluminateTranslationServiceProvider;

class TranslationServiceProvider extends IlluminateTranslationServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        parent::register();
        
        $this->mergeConfigFrom(__DIR__.'/../config/translator.php', 'translation-loader');
        
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        
        /**
         * @todo 
         * Implement route and translation import controller
         * Implement command line json importer
         */

        /**
         * Load vendor route, view and controllers
         */
        
        if(!$this->app->routesAreCached()) {
            //$this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }
        //$this->loadViewsFrom(__DIR__.'/../views', 'translator');

        /**
         * Console functionality only
         */
        if ($this->app->runningInConsole() && ! Str::contains($this->app->version(), 'Lumen')) {
            
            /**
             * Register commands to import locale.json files into database
             */
            /*$this->commands([
                FooCommand::class,
                BarCommand::class,
            ]);*/

            /**
             * Publish translator config file to app/config
             */
            
            $this->publishes([
                __DIR__.'/../config/translator.php' => config_path('translator.php'),
            ], 'config');

            /**
             * Publish database migrations to app/database/migrations
             */
            if (! class_exists('CreateTranslationsTable')) {

                $this->publishes([
                    __DIR__.'/../database/migrations/create_translations_table.php' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_translations_table.php'),
                ], 'migrations');
            }
        }
    }

    /**
     * Register the translation line loader. 
     */
    protected function registerLoader()
    {
        $this->app->singleton('translation.loader', function ($app) {
            $class = config('translation-loader.translation_manager');
            
            return new $class($app['files'], $app['path.lang']);
        });
    }
}

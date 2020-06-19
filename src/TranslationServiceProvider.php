<?php

namespace Kaitoj\Translator;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\TranslationServiceProvider as IlluminateTranslationServiceProvider;

class TranslationServiceProvider extends IlluminateTranslationServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot() {

        $this->registerRoutes();
        $this->registerResources();
        $this->registerMigrations();
        $this->registerPublishing();
        //$this->registerCommands();

    }

    /**
     * Register the application services.
     */
    public function register() {
        parent::register();
        $this->registerConfig();
    }

    /**
     * Register the translation line loader.
     * @return $class object
     */
    protected function registerLoader() {
        $this->app->singleton('translation.loader', function ($app) {
            $class = config('translation-loader.translation_manager');

            return new $class($app['files'], $app['path.lang']);
        });
    }

    /**
     * Setup the configuration for Translator.
     *
     * @return void
     */
    protected function registerConfig() {
        $this->mergeConfigFrom(__DIR__.'/../config/translator.php', 'translation-loader');
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes() {
        
        Route::prefix(config('translation-loader.prefix_path'))
            ->namespace(config('translation-loader.namespace'))
            ->name('translator.')
            ->group(
                function () {
                    $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
            });
    }

    /**
     * Register the package resources.
     *
     * @return void
     */
    protected function registerResources() {

        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'translator');
    }

    /**
     * Register the package migrations.
     *
     * @return void
     */
    protected function registerMigrations() {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing() {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../routes/' => app_path('../routes/vendor/translator'),], 'translator-routes');
            $this->publishes([__DIR__.'/../resources/views' => $this->app->resourcePath('views/vendor/translator'),], 'translator-views');
            $this->publishes([__DIR__.'/../config/translator.php' => $this->app->configPath('translator.php'),], 'translator-config');
            if (!class_exists('CreateTranslationsTable')) {
                $this->publishes([__DIR__.'/../database/migrations/create_translations_table.php' => $this->app->databasePath('migrations/'.date('Y_m_d_His', time()).'_create_translations_table.php'),], 'translator-migrations');
            }
        }
    }

    /**
      * Register console Commands
      *
      * @return void
      */
    protected function registerCommands() {

        if ($this->app->runningInConsole() && ! Str::contains($this->app->version(), 'Lumen')) {

            $this->commands([importTranslationsCommand::class,]);

        }
    }
}

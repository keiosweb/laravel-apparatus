<?php namespace Keios\LaravelApparatus;

use Illuminate\Support\ServiceProvider;
use Keios\Apparatus\Core\Dispatcher;
use Keios\Apparatus\Core\Event;
use Keios\LaravelApparatus\Extensions\InjectingScenarioFactory;
use Keios\Apparatus\Core\ScenarioRepository;
use Keios\Apparatus\Core\ScenarioRunner;

class LaravelApparatusServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'apparatus.configuration',
            function () {
                return new RepositoryScenarioConfiguration($this->app['config']);
            }
        );

        $this->app->bind(
            'apparatus.factory',
            function () {
                return new InjectingScenarioFactory($this->app->make('apparatus.configuration'), $this->app);
            }
        );

        $this->app->bind(
            'apparatus.repository',
            function () {
                return new ScenarioRepository($this->app->make('apparatus.factory'));
            }
        );

        $this->app->singleton(
            'apparatus.dispatcher',
            function () {
                return new Dispatcher($this->app->make('apparatus.repository'), new ScenarioRunner());
            }
        );

        $this->app->bind(
            'apparatus.event',
            function () {
                return new Event($this->app->make('apparatus.dispatcher'));
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'apparatus.configuration',
            'apparatus.factory',
            'apparatus.repository',
            'apparatus.dispatcher',
            'apparatus.event'
        ];
    }

}

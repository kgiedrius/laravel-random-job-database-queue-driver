<?php

namespace KGiedrius\Queue;

use KGiedrius\Queue\Connectors\DbRandConnector;
use KGiedrius\Queue\Console\DbRandCommand;
use Illuminate\Support\ServiceProvider;

class DbRandServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Add the connector to the queue drivers.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerDbRandConnector($this->app['queue']);

        $this->commands('command.queue.DbRand');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDbRandCommand();
    }

    /**
     * Register the queue listener console command.
     *
     *
     * @return void
     */
    protected function registerDbRandCommand()
    {
        $this->app->singleton('command.queue.DbRand', function () {
             return new DbRandCommand($this->app['queue.worker']);
        });
    }

    /**
     * Register the DbRand queue connector.
     *
     * @param \Illuminate\Queue\QueueManager $manager
     *
     * @return void
     */
    protected function registerDbRandConnector($manager)
    {
        $manager->addConnector('DbRand', function () {
            return new DbRandConnector($this->app['db']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('command.queue.DbRand');
    }
}

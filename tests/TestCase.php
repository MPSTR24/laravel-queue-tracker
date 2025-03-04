<?php

namespace Mpstr24\QueueTracker\Tests;

use Mpstr24\QueueTracker\QueueTrackerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            QueueTrackerServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app->setBasePath(__DIR__.'/fake');

        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__.'/fake/database/migrations');
    }
}

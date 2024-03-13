<?php

namespace Envor\Platform\Tests;

use Envor\Platform\PlatformServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Livewire\Volt\VoltServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Workbench\App\Providers\WorkbenchServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Envor\\Platform\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            PlatformServiceProvider::class,
            LivewireServiceProvider::class,
            VoltServiceProvider::class,
            WorkbenchServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('database.platform', 'testing');

        $migration = include __DIR__.'/../database/migrations/platform/create_landing_pages_table.php.stub';
        $migration->up();
    }
}

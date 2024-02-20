<?php

namespace Envor\Platform;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PlatformServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('platform')
            ->hasViews()
            ->hasRoute('web')
            ->hasMigration('platform/create_landing_pages_table')
            ->hasConfigFile(['database', 'auth', 'platform', 'session']);
    }

    public function packageBooted()
    {

        $this->app->booted(function () {

            if (class_exists('\Livewire\Volt\Volt')) {

                $voltPaths = collect(\Livewire\Volt\Volt::paths())->map(function ($path) {
                    return $path->path;
                })->toArray();

                $paths = array_merge($voltPaths, [
                    __DIR__.'/../resources/views/livewire',
                    __DIR__.'/../resources/views/pages',
                ]);

                \Livewire\Volt\Volt::mount($paths);
            }
        });
    }
}

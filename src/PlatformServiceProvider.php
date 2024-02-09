<?php

namespace Envor\Platform;

use Envor\Platform\Commands\PlatformCommand;
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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_platform_table')
            ->hasCommand(PlatformCommand::class);
    }
}

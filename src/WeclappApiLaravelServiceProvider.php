<?php

namespace Webhub\WeclappApiLaravel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Webhub\WeclappApiLaravel\Commands\WeclappApiLaravelCommand;

class WeclappApiLaravelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('weclapp-api-laravel')
            ->hasConfigFile('weclapp')
            ->hasCommand(WeclappApiLaravelCommand::class);
    }
}

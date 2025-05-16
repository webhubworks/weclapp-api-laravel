<?php

namespace Webhub\WeclappApiLaravel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Webhub\WeclappApiLaravel\Commands\WeclappApiLaravelCommand;

class WeclappApiLaravelServiceProvider extends PackageServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        if (!config()->has('logging.channels.weclapp-api')) {
            // Merge your custom log channel configuration
            config()->set('logging.channels.weclapp-api', [
                'driver' => 'daily',
                'path' => storage_path('logs/weclapp-api.log'),
                'level' => 'debug',
                'days' => 14,
                'replace_placeholders' => true,
            ]);
        }
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('weclapp-api-laravel')
            ->hasConfigFile('weclapp')
            ->hasCommand(WeclappApiLaravelCommand::class);
    }
}

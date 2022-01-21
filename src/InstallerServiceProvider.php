<?php

namespace Hazelbag\BaseInstaller;

use Hazelbag\BaseInstaller\Console\InstallCommand;
use Illuminate\Support\ServiceProvider;
use Laravel\Tinker\Console\TinkerCommand;

class InstallerServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->registerCommands();
        $this->configurePublishing();
    }

    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }

    private function configurePublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'./Console/InstallCommand.php' => app_path('Console/Commands/InstallCommand.php'),
            ], ['installer', 'base-installer']);
        }
    }
}
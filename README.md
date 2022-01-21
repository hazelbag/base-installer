# Base Installer Checks

To require the package run `composer require hazelbah\base-installer`

This will import the package into your Laravel application.

## Once Required follow one of the below methods;

## To use the package without publishing the vendor files follow the below.

In your Laravel application open the `Kernel.php` folder located at `app/Console` and make sure to add the following

`protected $commands = [ InstallCommand::class ];`

```
class Kernel extends ConsoleKernel
{
    protected $commands = [
        InstallCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
```

Once you have the above added to your `Kernal.php` file you can run `php artisan base:install` to run the base installer checks

## To publish the files locally do the below:

In your terminal, run `php artisan vendor:publish --provider="Hazelbag\BaseInstaller\InstallerServiceProvider"` 

This will publish the file to your `app/Console/Commands` directory
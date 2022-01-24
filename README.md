# Base Laravel Installer Checks

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hazelbag/base-installer.svg?style=flat-square)](https://packagist.org/packages/hazelbag/base-installer)
[![Total Downloads](https://img.shields.io/packagist/dt/hazelbag/base-installer.svg?style=flat-square)](https://packagist.org/packages/hazelbag/base-installer)

Simple package to check the env file exists and you are able to connect to your MySQL database. Once it can connect, you will be prompted for your user details which will create a user account.

## Installation

You can install the package via composer:

```bash
composer require hazelbag\base-installer
```

## Usage

### There are two usage options

#### Option 1 (preferred)

To publish the files locally do the below:

In your terminal, run `php artisan vendor:publish --provider="Hazelbag\BaseInstaller\InstallerServiceProvider"`

This will publish the file to your `app/Console/Commands` directory

---

#### Option 2

To use the package without publishing the vendor files follow the below.

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

---
### Security

If you discover any security related issues, please email jacques@my-web.me instead of using the issue tracker.

---
## Credits

-   [Jacques Olivier](https://github.com/hazelbag)
-   [All Contributors](../../contributors)

---
## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
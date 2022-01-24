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

To make use of the package, once you ran the above `require` command, you can simply run

```bash
php artisan base:install
```

This will run the installer checks and create a user account with the details entered.

---

#### Option 2

To publish the files locally do the below:

In your terminal, run `php artisan vendor:publish --provider="Hazelbag\BaseInstaller\InstallerServiceProvider"`

This will publish the file to your `app/Console/Commands` directory

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
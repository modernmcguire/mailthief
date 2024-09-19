# Mailthief

## A drop-in replacement for Mailtrap

[![Latest Version on Packagist](https://img.shields.io/packagist/v/modernmcguire/mailthief.svg?style=flat-square)](https://packagist.org/packages/modernmcguire/mailthief)
[![Total Downloads](https://img.shields.io/packagist/dt/modernmcguire/mailthief.svg?style=flat-square)](https://packagist.org/packages/modernmcguire/mailthief)


A custom Laravel mailer that captures outbound emails, saves them to the database, and provides a clean UI for viewing. For a local environment you have wonderful tools like HELO or Mailhog. For dev environments, there's really only Mailtrap. This is meant to replace that.

![Alt text](https://raw.githubusercontent.com/modernmcguire/mailthief/main/SCREENSHOT.png?raw=true "MailThief Screenshot")


## Installation

You can install the package via composer:

```bash
composer require modernmcguire/mailthief
```

1. Update your `.env` file

```env
MAIL_MAILER=mailthief
```

2. Run migrations

```bash
php artisan migrate
```

### And that's it!

## Usage

You can publish the config using Laravel's built in `php artisan vendor:publish`

The UI can be found at /dev/emails.
This path is configurable via the config file.

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email ben@modernmcguire.com instead of using the issue tracker.

## Credits

-   [Ben Miller](https://github.com/modernmcguire)
-   [All Contributors](../../contributors)
-   [Icon Creator - kerismaker](https://www.flaticon.com/authors/kerismaker)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).

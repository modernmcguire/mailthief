# Mailthief
## A drop-in replacement for Mailtrap

[![Latest Version on Packagist](https://img.shields.io/packagist/v/modernmcguire/mailthief.svg?style=flat-square)](https://packagist.org/packages/modernmcguire/mailthief)
[![Total Downloads](https://img.shields.io/packagist/dt/modernmcguire/mailthief.svg?style=flat-square)](https://packagist.org/packages/modernmcguire/mailthief)
![GitHub Actions](https://github.com/modernmcguire/mailthief/actions/workflows/main.yml/badge.svg)
![MailThief Logo](https://raw.githubusercontent.com/modernmcguire/mailthief/main/resources/assets/icon.png)


A custom Laravel mailer that captures outbound emails, saves them to the database, and provides a clean UI for viewing. For a local environment you have wonderful tools like HELO or Mailhog. For dev environments, there's really only Mailtrap. This is meant to replace that.

## Installation

You can install the package via composer:

```bash
composer require modernmcguire/mailthief
```

Update your `.env` file

```env
MAIL_MAILER=mailthief
```

### And that's it!

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

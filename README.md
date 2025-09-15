# Laravel Chronos Logger

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

`aic-international/laravel-chronos-logger` is a laravel package providing a logging handler to send logs to a Chronos
Server.

## Installation

You can install the package via composer:

``` bash
composer require aic-international/laravel-chronos-logger
```

## Setup

### Prepare the logger configuration

You must add a new channel to your `config/logging.php` file:

```php
// config/logging.php
'channels' => [
    //...
    'chronos' => [
       'driver' => 'custom',
        'via' => App\Logging\ChronosLogger::class,
        'url' => env('LOG_CHRONOS_WEBHOOK_URL'),
        'token' => env('LOG_CHRONOS_TOKEN'),
        'level' => env('LOG_CHRONOS_LEVEL', 'debug'),
        'labels' => [
            'app' => env('APP_NAME'),
            'env' => env('APP_ENV'),
        ],
    ],
];
```

You can then provide the web-hook URL in your `.env` file:

```
LOG_CHRONOS_WEBHOOK_URL=https://example.com/api/log
```

### Use the logger channel

You have two options: log only to chronos or add the channel to the stack

#### Log only to the chronos channel

Simply change the `.env` variable to use the chronos channel

```
LOG_CHANNEL=chronos
```

#### Add the channel on top of other channels

Add the channel to the stack in the `config/logging.php` configuration:

```php
// config/logging.php
'channels' => [
    //...
    'stack' => [
        'driver'   => 'stack',
        'channels' => ['single', 'chronos'],
    ],
];
```

Then make sure the logging channel is set to stack in your `.env` file:

```
LOG_CHANNEL=stack
```

#### Logging to multiple Chronos channels

Of course, you can send your log messages to multiple Chronos channels. Just create as many channels as desired in
`config/logging.php` and put them in the stack. Each channel should be named differently and should point to a different
web hook URL.

## The communication with Chronos Web hook failed

You might encounter this exception alongside "cURL error 60: SSL certificate problem: unable to get local issuer
certificate" while using/testing your web hook in a development enviroment. This occurs due to your local machine's
inability to verify the server's SSL certificate.

### To resolve this issue, follow these steps:

- Obtain the cacert.pem file from the curl website.

- Store the cacert.pem file in a secure location on your computer, such as C:\xampp\php\extras\ssl\cacert.pem.

- Access your php.ini file, typically found in your PHP installation directory.

- Locate curl.cainfo = in php.ini. If it's commented out (begins with a ;), remove the semicolon.

- Insert the path to cacert.pem you saved earlier. Example: curl.cainfo = "C:\xampp\php\extras\ssl\cacert.pem".

- Save the php.ini file and restart your server to implement the changes.

## Credits

- Got some ideas from [RakInteractive/Chronos](https://github.com/RakInteractive/Chronos)
- Got some ideas from [vpratfr/laravel-discord-logger](https://github.com/vpratfr/laravel-discord-logger)
- Got some ideas from [GrKamil/laravel-telegram-logging](https://github.com/GrKamil/laravel-telegram-logging)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

# EmailListVerify-PHP
[![Github tag](https://badgen.net/github/tag/anibalealvarezs/email-list-verify-php)](https://github.com/anibalealvarezs/email-list-verify-php/tags/) [![GitHub license](https://img.shields.io/github/license/anibalealvarezs/email-list-verify-php.svg)](https://github.com/anibalealvarezs/email-list-verify-php/blob/master/LICENSE) [![Github all releases](https://img.shields.io/github/downloads/anibalealvarezs/email-list-verify-php/total.svg)](https://github.com/anibalealvarezs/email-list-verify-php/releases/) [![GitHub latest commit](https://badgen.net/github/last-commit/anibalealvarezs/email-list-verify-php)](https://GitHub.com/anibalealvarezs/email-list-verify-php/commit/) [![Ask Me Anything !](https://img.shields.io/badge/Ask%20me-anything-1abc9c.svg)](https://github.com/anibalealvarezs/anibalealvarezs)

## About

PHP library to connect to the [emaillistverify.com API](https://docs.publica.la/).

***

## Requirements

* PHP >= 8.0
* Composer

***

## Installation

Add the following to `composer.json`
```json
{
  "require": {
    "anibalealvarezs/email-list-verify-php": "*"
  },
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/anibalealvarezs/email-list-verify-php"
    }
  ]
}
```

Install all composer dependencies using:
```shell
composer install
```

Or install it via GitHub
```shell
composer require anibalealvarezs/email-list-verify-php
```

## Quick Start

### Note that this SDK requires PHP 8.0 or above.

```php
require_once('/path/to/EmailListVerifyPHP/vendor/autoload.php');

$verify = new EmailListVerifyPHP\ApiClient();

$verify->setConfig([
  'apiKey' => 'YOUR_API_KEY',
]);

$response = $verify->email->checkEmail();
print_r($response);
```

## Authentication Method

The client library must be configured to pass the API as a URL parameter.

## Other configuration options
The APIClient class lets you set various configuration options like timeouts, host, user agent, and debug output.
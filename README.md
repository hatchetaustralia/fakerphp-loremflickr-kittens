# Fakerphp LoremFlickr Images

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hatchetaustralia/fakerphp-loremflickr-kittens.svg?style=flat-square)](https://packagist.org/packages/hatchetaustralia/fakerphp-loremflickr-kittens)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/hatchetaustralia/fakerphp-loremflickr-kittens/Tests?label=tests)](https://github.com/hatchetaustralia/fakerphp-loremflickr-kittens/actions?query=workflow%3ATests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/hatchetaustralia/fakerphp-loremflickr-kittens/Check%20&%20fix%20styling?label=code%20style)](https://github.com/hatchetaustralia/fakerphp-loremflickr-kittens/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/hatchetaustralia/fakerphp-loremflickr-kittens.svg?style=flat-square)](https://packagist.org/packages/hatchetaustralia/fakerphp-loremflickr-kittens)

## Introduction

Alternative image provider for [fakerphp](https://github.com/fakerphp/faker) using [loremflickr.com](https://loremflickr.com)

_This package has been forked from [smknstd/fakerphp-picsum-images](https://github.com/smknstd/fakerphp-picsum-images)_
 
## Installation

You can install the package via composer in dev dependency section:

```bash
composer require --dev hatchetaustralia/fakerphp-loremflickr-kittens
```

## Usage

```php
$faker = \Faker\Factory::create();
$faker->addProvider(new \Hatchet\FakerLoremFlickrKittens\FakerLoremFlickrKittensProvider($faker));

// return a string that contains a url like 'https://loremflickr.com/800/600/kitten'
$faker->imageUrl($width = 800, $height = 600); 

// download a properly sized image from LoremFlickr into a file with a file path like '/tmp/13b73edae8443990be1aa8f1a483bc27.jpg'
$filePath= $faker->image($dir = '/tmp', $width = 640, $height = 480);
```

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Arnaud Becher](https://github.com/smknstd)
- [Marcin Morawski](https://github.com/morawskim)
- [Matt Hare](https://github.com/hatchetaustralia)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

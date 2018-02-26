# l5-action-based-form-request

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Total Downloads][ico-downloads]][link-downloads]

Action Based FormRequest for Laravel 5

## Install

Via Composer

``` bash
$ composer require rafflesargentina/l5-action-based-form-request
```

## Usage

Create a class that extends ActionBasedFormRequest. Then define methods that match the name of each action with request data you want to validate, returning an array with rules.

Example:

``` php
<?php

namespace App\Http\Requests;

use RafflesArgentina\ActionBasedFormRequest\ActionBasedFormRequest;

class ArticleRequest extends ActionBasedFormRequest
{
    public static function index()
    {
        return [
            'show' => 'numeric|min:1|max:400',
            'order' => 'in:asc,desc',
        ];
    }

    public static function store()
    {
        return [
            'title' => 'required|max:100',
        ];
    }

    public static function update()
    {
        return static::store();
    } 
}
```

And that's it :)

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email mario@raffles.com.ar instead of using the issue tracker.

## Credits

- [Mario Patronelli][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/rafflesargentina/l5-action-based-form-request.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rafflesargentina/l5-action-based-form-request/master.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rafflesargentina/l5-action-based-form-request.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/rafflesargentina/l5-action-based-form-request
[link-travis]: https://travis-ci.org/rafflesargentina/l5-action-based-form-request
[link-downloads]: https://packagist.org/packages/rafflesargentina/l5-action-based-form-request
[link-author]: https://github.com/patronelli87
[link-contributors]: ../../contributors

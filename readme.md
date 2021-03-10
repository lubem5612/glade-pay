# GladePay

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require lubem/gladepay

Or add the following line to the require block of your composer.json file.

"lubem/gladepay": "@dev"

You'll then need to run composer install or composer update to download it and have the autoloader updated.


Skip this step if using Laravel >=5.5 as the service will be registered automatically
Once installed, you need to register the service provider. Open up config/app.php and add the following to the providers key.
"providers" => [
		.....
		
        Lubem\GladePay\GladePayServiceProvider::class,
		
		.....
            ],
"aliases" => [
		.....
		
        "GladePay": Lubem\GladePay\Facades\GladePay::class,
		
		.....
            ]

```
## Configuration

``` bash
You can publish the configuration file using this command:

php artisan vendor:publish --provider="Lubem\GladePay\GladePayServiceProvider"

A configuration file named gladepay.php with some defaults will be placed in your config directory:

<?php

return [
    /*
   |--------------------------------------------------------------------------
   | MERCHANT ID
   |--------------------------------------------------------------------------
   |
   | set the merchant id from environment
   |
   */

    'mid' => env('GLADE_MERCHANT_ID', 'GP0000001'),

    /*
    |--------------------------------------------------------------------------
    | MERCHANT KEY
    |--------------------------------------------------------------------------
    |
    | set the merchant key from environment
    |
    */

    'key' => env('GLADE_MERCHANT_KEY', '123456789'),

    /*
     |--------------------------------------------------------------------------
     | BASE URL
     |--------------------------------------------------------------------------
     |
     | set the base api endpoint from environment
     |
     */

    'endpoint' => env('GLADE_ENDPOINT', 'https://demo.api.gladepay.com'),
];
```

## Usage

``` bash
Open your .env file and add your glade merchant key, glade merchant id, and glade api base (https://api.glade.ng) url like so:
get more information on the endpoint at https://developer.glade.ng/api/#getting-started

GLADE_MERCHANT_ID=xxxxxxxxxxxxx

GLADE_MERCHANT_KEY=xxxxxxxxxxxxx

GLADE_ENDPOINT=https://api.glade.ng

Set up routes and controller methods like so:

create a controller by through artisan command

$ php artisan make:controller GladePayController

#an example is shown below
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lubem\GladePay\GladePay;

class GladePayController extends Controller
{
    public function initiate()
    {
        $pay = new GladePay();
        $response = $pay->initiateBankTransfer();
        return $response;
    }
}

#routes
you can include routes in routes/web or routes/api like so:
Route::post('/payment', [\App\Http\Controllers\GladePayController::class, 'initiate'])->name('payment');

if using with routes/api, see image example
test with POSTMAN by sending a POST request to the url http://127.0.0.1:8000/api/payment with these form keys
amount (required), email (optional), firstname (optional), lastname (optional), business_name (optional)

an example is shown through the link
```
![Postman](https://github.com/lubem5612/glade-pay/blob/master/postman.png)
```
if using routes/web an example form is shown

<form method="POST" action="{{ route('payment') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
    <div class="row" style="margin-bottom:40px;">
        <div class="col-md-8 col-md-offset-2">
            
            <input name="email"> {{-- optional --}}
            <input name="firstname"> {{-- optional --}}
            <input name="lastname"> {{-- optional --}}
            <input name="business_name"> {{-- optional --}}
            <input type="hidden" name="amount"> {{-- number required --}}
            
            @csrf

            <p>
                <button class="btn btn-success btn-lg btn-block" type="submit" value="Make Payment">
                    <i class="fa fa-plus-circle fa-lg"></i> Make Payment
                </button>
            </p>
        </div>
    </div>
</form>
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email enginlubem@ymail.com instead of using the issue tracker.

## Credits

- [Lubem Tser][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/lubem/gladepay.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/lubem/gladepay.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/lubem/gladepay/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/lubem/gladepay
[link-downloads]: https://packagist.org/packages/lubem/gladepay
[link-travis]: https://travis-ci.org/lubem5612/glade-pay
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/lubem5612
[link-contributors]: ../../contributors

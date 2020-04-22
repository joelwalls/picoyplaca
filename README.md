# Pico y Placa Predictor

[![Latest Version](https://img.shields.io/github/release/joelwalls/picoyplaca.svg?style=flat-square)](https://github.com/joelwalls/picoyplaca/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/joelwalls/picoyplaca/master.svg?style=flat-square)](https://travis-ci.org/joelwalls/picoyplaca)
[![Total Downloads](https://img.shields.io/packagist/dt/joelwalls/picoyplaca.svg?style=flat-square)](https://packagist.org/packages/joelwalls/picoyplaca)

This small package offers a simple class to predict if a certain license plate could be on the road based on the timing restrictions of Quitos's transit regulations. Framework agnostic.

## Install

Via Composer

``` bash
$ composer require joelwalls/picoyplaca
```

## Usage

Simple usage of the class

``` php
require_once "vendor/autoload.php";

$predictor = new JoelWalls\Predictor($license_plate, $date, $time);

if ($predictor->canDrive()) {
    echo "Car can be on the road";
} else {
    echo "Car cannnot be on the road";
}
```

The package supports a DateTime instance as second parameter.

``` php
require_once "vendor/autoload.php";

use JoelWalls\Predictor;

$predictor = new Predictor($license_plate, new \DateTime);

if ($predictor->canDrive()) {
    echo "Car can be on the road";
} else {
    echo "Car cannnot be on the road";
}
```

If needed, you could also especify the timezone of the Predictor object in case the server works 
with a different TimeZone.

``` php
require_once "vendor/autoload.php";

use JoelWalls\Predictor;

$predictor = new Predictor($license_plate, new \DateTime);
$predictor->setTimeZone('America/Guayaquil');

if ($predictor->canDrive()) {
    echo "Car can be on the road";
} else {
    echo "Car cannnot be on the road";
}
```
Note: The setTimeZone() method is recommended to use when the Predictor is initialized when 
a DateTime object as current time.

## Testing

``` bash
$ phpunit
```

## Credits

- [Joel Paredes](https://github.com/joelwalls)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

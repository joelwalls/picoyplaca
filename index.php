<?php

require_once 'vendor/autoload.php';

use JoelWalls\PicoYPlaca\Predictor;

$predictor = new Predictor('PDB2503', '2020-04-22', '18:15');

if ($predictor->canDrive()) {
    echo "Car can be on the road";
} else {
    echo "Car cannnot be on the road";
}
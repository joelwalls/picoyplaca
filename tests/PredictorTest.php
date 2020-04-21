<?php

namespace JoelWalls\PicoYPlaca\Test;

use JoelWalls\PicoYPlaca\Predictor;
use PHPUnit\Framework\TestCase;

class PredictorTest extends TestCase
{
    public function testPredictorConstructorWithRegularValues()
    {
        $predictor = new Predictor('PDB2504', '2020-04-21', '17:30');

        $this->assertIsObject($predictor);
    }

    public function testPredictorConstructorWithDateTime()
    {
        $predictor = new Predictor('PDB2504', new \DateTime);
        $this->assertIsObject($predictor);
    }

    public function testIfPredictorChecksWellFormedLicense()
    {
        $predictor = null;
        try {
            $predictor = new Predictor('LICENCIAINVALIDA', new \DateTime);
        } catch (\Throwable $th) {

            //Predictor should be null as the license plate is invalid
            $this->assertNull($predictor);
        }
    }

    public function testIfPredictorChecksTimeWhenNeeded()
    {
        $predictor = null;
        try {
            $predictor = new Predictor('PDB2503', '2020-04-21');
        } catch (\Throwable $th) {

            //Predictor should be null as no time was specified
            $this->assertNull($predictor);
        }
    }

    public function testIfPredictorChecksWellFormedDate()
    {
        $predictor = null;
        try {
            $predictor = new Predictor('PDB2503', 'invalid-date', 'invalid-time');
        } catch (\Throwable $th) {

            //Predictor should be null as date and time are not valid
            $this->assertNull($predictor);
        }
    }

    public function testIfPredictorIdentifiesRestrictedLicensePlate()
    {
        //The license plate is restricted, should return false
        $predictor = new Predictor('PDB2503', '2020-04-21', '18:15');

        $this->assertFalse($predictor->canDrive());
    }

    public function testIfPredictorIdentifiesEnabledLicensePlate()
    {
        //The license plate is not restricted, should return true
        $predictor = new Predictor('PDB2502', '2020-04-21', '18:15');

        $this->assertTrue($predictor->canDrive());
    }
    
}

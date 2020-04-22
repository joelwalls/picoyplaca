<?php

namespace JoelWalls\PicoYPlaca;

use JoelWalls\PicoYPlaca\Exceptions\PredictorException;

class Predictor
{
    private $license_plate;
    private $digit;
    private $date;

    /**
     * Create a new Predictor Instance
     */
    public function __construct($license_plate, $date, $time = null)
    {
        if (!is_string($license_plate)) {
            throw new PredictorException('License plate must be a string');
        }

        if (strlen($license_plate) < 6) {
            throw new PredictorException('License plate must be at least 6 characters long');
        }

        if (!(int) substr($license_plate, -1)) {
            throw new PredictorException('License plate must end with a number');
        }

        $this->license_plate = $license_plate;
        $this->digit = substr($license_plate, -1);

        if ($date instanceof \DateTime) {
            if (!is_null($time)) {
                throw new PredictorException('You cannot set time when using a DateTime instance');
            }

            $this->date = $date;
        } else {
            if (is_null($time)) {
                throw new PredictorException('You must especify a time in format hh:mm');
            }
            
            if (! \DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $time)) {
                throw new PredictorException('Date and time formats are incorrect.');
            }

            $this->date = \DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $time);
        }
    }

    /**
     * Set the timezone if needed
     *
     * @return void
     */
    public function setTimeZone($time_zone)
    {
        $this->date->setTimeZone(new \DateTimeZone($time_zone));
    }

    /**
     * Main algorithm, checks if the day of the week corresponds with the license plate
     *
     * @return bool Returns true if the car can go out
     */
    public function canDrive()
    {
        $day = $this->date->format("w");
        
        switch ($day) {
            case '1':
                if ($this->digit == '1' || $this->digit == '2') {
                    return $this->checkTime();
                }
                break;

            case '2':
                if ($this->digit == '3' || $this->digit == '4') {
                    return $this->checkTime();
                }
                break;

            case '3':
                if ($this->digit == '5' || $this->digit == '6') {
                    return $this->checkTime();
                }
                break;

            case '4':
                if ($this->digit == '7' || $this->digit == '8') {
                    return $this->checkTime();
                }
                break;

            case '5':
                if ($this->digit == '9' || $this->digit == '0') {
                    return $this->checkTime();
                }
                break;
        }

        return true;
    }

    /**
     * Checks if the hour is bewteen restriction time
     *
     * @return bool Returns true if the time is restricted
     */
    public function checkTime()
    {
        $morning_start = new \DateTime($this->date->format('Y-m-d') . '07:00', $this->date->getTimezone());
        $morning_end = new \DateTime($this->date->format('Y-m-d') . '09:30', $this->date->getTimezone());

        if ($this->date >= $morning_start && $this->date < $morning_end) {
            return false;
        }

        $afternoon__start = new \DateTime($this->date->format('Y-m-d') . ' 16:00', $this->date->getTimezone());
        $afternoon__end = new \DateTime($this->date->format('Y-m-d') . '19:30', $this->date->getTimezone());
        
        if ($this->date >= $afternoon__start && $this->date < $afternoon__end) {
            return false;
        }

        return true;
    }
}

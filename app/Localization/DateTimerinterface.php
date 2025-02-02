<?php

namespace App\Localization;

use DateTime;

interface DateTimerInterface{

    public function getCurrentDateTime();

    public function setCurrentDateTime(DateTime $currentDateTime = null);
}
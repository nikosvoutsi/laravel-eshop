<?php

namespace App\Localization;

use DateTime;

class DateTimer implements DateTimerInterface{

    protected $currentDateTime=null;

    public function getCurrentDateTime(){
        return $this->currentDateTime ?  clone  $this->currentDateTime : new DateTime();
    }

    public function setCurrentDateTime(DateTime $currentDateTime = null){

        $this->currentDateTime=$currentDateTime;
        return $this;
    }
}
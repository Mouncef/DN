<?php

namespace App\Utils;


class Variables {

    private $dateMinus30Days;

    public function __construct()
    {
        $today = new \DateTime('now');
        $today->modify('-30 days');
        $date = $today->format('Y-m-d H:i');
        $this->dateMinus30Days = $date;
    }

    public function getDateMinus30Days(): string
    {
        return $this->dateMinus30Days;
    }



}
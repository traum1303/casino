<?php

namespace App\Interfaces;

interface GamblingInterface
{
    public function gamble():void;
    public function getGambledResult():string|array;
}

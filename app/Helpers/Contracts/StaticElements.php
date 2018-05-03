<?php

namespace App\Helpers\Contracts;


interface StaticElements
{
    public function makeData();

    public function makeAuthData();

    public function makeUnAuthData();
}
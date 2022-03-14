<?php

namespace App\Traits;

trait General
{
    public function index()
    {
        return view($this->service_name . '.index');
    }
}

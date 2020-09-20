<?php

namespace BomberoApp\CJC\Facades;

use Illuminate\Support\Facades\Facade;

class CJC extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cjc';
    }
}

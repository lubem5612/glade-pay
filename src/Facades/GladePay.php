<?php

namespace Lubem\GladePay\Facades;

use Illuminate\Support\Facades\Facade;

class GladePay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'gladepay';
    }
}

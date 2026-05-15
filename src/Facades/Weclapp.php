<?php

namespace Webhub\WeclappApiLaravel\Facades;

use Illuminate\Support\Facades\Facade;
use Webhub\WeclappApiLaravel\WeclappApiLaravel;

/**
 * @see WeclappApiLaravel
 */
class Weclapp extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return WeclappApiLaravel::class;
    }
}

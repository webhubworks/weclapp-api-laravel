<?php

namespace Webhub\WeclappApiLaravel\Facades;

use Illuminate\Support\Facades\Facade;
use Webhub\WeclappApiLaravel\WeclappApiLaravel;

/**
 * @see \Webhub\WeclappApiLaravel\WeclappApiLaravel
 */
class Weclapp extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return WeclappApiLaravel::class;
    }
}

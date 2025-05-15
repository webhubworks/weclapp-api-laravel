<?php

namespace Webhub\WeclappApiLaravel;

use Webhub\WeclappApiLaravel\Services\LaravelHttpClient;
use Webhubworks\WeclappApiCore\Client;

class WeclappApiLaravel
{
    public static function create(): Client
    {
        return Client::create(new LaravelHttpClient);
    }
}

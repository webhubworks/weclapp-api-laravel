# Weclapp API for Laravel

## Configuration
Make sure to have set the following environment variables in your `.env` file:
```dotenv
WECLAPP_API_BASE_URL=
WECLAPP_AUTH_TOKEN=
```

## Usage
Example usage:
```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webhub\WeclappApiLaravel\Facades\Weclapp;

class WeclappTest extends Command
{
    protected $signature = 'weclapp:test';

    protected $description = 'Tests the connection to weclapp';

    public function handle()
    {
        $weclappClient = Weclapp::create();

        $result = $weclappClient->getArticleCount();

        dd($result);
    }
}

```

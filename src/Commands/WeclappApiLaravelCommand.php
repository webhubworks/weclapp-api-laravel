<?php

namespace Webhub\WeclappApiLaravel\Commands;

use Illuminate\Console\Command;

class WeclappApiLaravelCommand extends Command
{
    public $signature = 'weclapp-api-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

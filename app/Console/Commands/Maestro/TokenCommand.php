<?php

namespace App\Console\Commands\Maestro;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class TokenCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'maestro:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Get Token";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (empty(env('APP_KEY'))) {
            return $this->info("Set APP_KEY in file .env");
        }
        if (empty(env('APP_NAME'))) {
            return $this->info("Set APP_NAME in file .env");
        }
        if (empty(env('SERVICE_KEY'))) {
            return $this->info("Run `php artisan maestro:key --set` to key generation");
        }
        
        return $this->info(md5(env('APP_KEY').'.'.env('APP_NAME').env('SERVICE_KEY')));
    }

    /**
     * Get the next value in the sequence.
     *
     * @return mixed
     */
    public function __invoke()
    {
        return $this->fire();
    }
}

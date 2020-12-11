<?php

namespace App\Console\Commands\Maestro;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class KeyCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'maestro:key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Get service current key or set a new service key";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {

        if ($this->option('get')) {
            return $this->line('<comment>'.env('SERVICE_KEY').'</comment>');
        }            

        if ($this->option('set')) {
            $key = $this->getRandomKey();

            $path = base_path('.env');

            if (file_exists($path)) {
                $data = file_get_contents($path);
                $pos = strpos($data, 'SERVICE_KEY=');

                if ($pos === false) {
                    $data .= "\nSERVICE_KEY=".$key."\n";
                    file_put_contents(
                        $path,
                        $data
                    );
                } else {
                    file_put_contents(
                        $path,
                        str_replace('SERVICE_KEY='.env('SERVICE_KEY'), 'SERVICE_KEY='.$key, $data)
                    );
                }
            }

            return $this->info("Application service key $key set successfully.");
        }
        $this->info("Report an option '--get' to current service key or option'--set' to generate new key");
    }

    /**
     * Generate a random key for the application.
     *
     * @return string
     */
    protected function getRandomKey()
    {
        return Str::random(32);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('get', null, InputOption::VALUE_NONE, 'Return current service key.'),
            array('set', null, InputOption::VALUE_NONE, 'Generate ans set a new service key.')
        );
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

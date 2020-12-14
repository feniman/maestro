<?php

namespace App\Console\Commands\Maestro;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use GuzzleHttp\Client;

class RegisterCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'maestro:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Auto register";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {

        if (strlen(env('APP_KEY'))==0) {
            return $this->info('APP_KEY was not generated');
        }
        if (strlen(env('APP_NAME'))==0) {
            return $this->info('APP_NAME was not generated');
        }
        if (strlen(env('SERVICE_KEY'))==0) {
            return $this->info('SERVICE_KEY was not generated');
        }
        try{
            $client = new \GuzzleHttp\Client([
                'base_uri' => env('APP_URL')
            ]);
            $response = $client->post('register/service', [
                \GuzzleHttp\RequestOptions::JSON => [
                    'host' => gethostname(),
                    'app_key' => env('APP_KEY'),
                    'app_name' => env('APP_NAME'),
                    'service_key' => env('SERVICE_KEY'),
                    'remote_addr' => gethostbyname(gethostname())
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                $body = json_decode($response->getBody());
                if (isset($body->message)) {
                    return $this->info($body->message);
                }
                return $this->info($response->getBody());
            }
        } catch(\Exception $e) {
            return $this->error("\n\r".$e->getMessage()."\n\r");
        }
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
        return [];
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

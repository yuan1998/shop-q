<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExampleSchedulerTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'example:scheduler-test {logLevel} {--message=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for logging schedulers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arguments = $this->arguments();
        $options = $this->options();
        $options['message'] = $options['message'] ?? 'lorem ipsum dolor sit amet';

        switch ($arguments['logLevel']) {
            case 'emergency':
                Log::emergency($options['message']);
                break;
            case 'alert':
                Log::alert($options['message']);
                break;
            case 'critical':
                Log::critical($options['message']);
                break;
            case 'error':
                Log::error($options['message']);
                break;
            case 'warning':
                Log::warning($options['message']);
                break;
            case 'notice':
                Log::notice($options['message']);
                break;
            case 'info':
                Log::info($options['message']);
                break;
            default:
                Log::debug($options['message']);
                break;
        }
    }
}

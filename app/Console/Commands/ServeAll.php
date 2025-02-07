<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServeAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serveAll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the Laravel development server on 0.0.0.0:8000';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('serve', [
            '--host' => '0.0.0.0',
            '--port' => '8000',
        ]);

        return 0;
    }
}

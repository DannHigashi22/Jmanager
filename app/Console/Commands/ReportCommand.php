<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Report:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de reporte audiotiras, final de dia ';

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
     * @return int
     */
    public function handle()
    {
        return ;
    }
}

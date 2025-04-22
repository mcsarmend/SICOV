<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\interfacescxcController;

class EnvioInterfaces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Get:Interfaces';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera y envia interfaces a CxC';

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
        $controlador = new interfacescxcController();
        $controlador->generaInterfaces();

    }


}

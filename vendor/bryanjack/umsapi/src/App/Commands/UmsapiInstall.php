<?php

namespace Bryanjack\Umsapi\App\Commands;

use Bryanjack\Dash\Models\Menu;
use Illuminate\Console\Command;

class UmsapiInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'umsapi:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all the dependencies';

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
        // $this->info('--Installing Dash..');
        // $this->call('dash:install');
    }
}

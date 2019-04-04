<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
class InitateImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Artisan::call("import:instagram");
        Artisan::call("import:tokopedia");
        Artisan::call("import:shopee");
        Artisan::call("import:match");
    }
}

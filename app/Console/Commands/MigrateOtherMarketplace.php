<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Http\Lib\Others;

class MigrateOtherMarketplace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:other';

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
        $exists = Storage::allFiles('public/dataset');
        $ot = new Others();
        foreach ($exists as $key => $value) {
            $source = explode('/', $value);
            $source = explode('.',end($source))[0];

            $csvFile = storage_path('app/'.$value);
            $rows = array_map('str_getcsv', file($csvFile));
            $header = array_shift($rows);
            $header[] = 'source';
            $csv = array();
            foreach ($rows as $row) {
                
                $row[] = $source;
                $single = array_combine($header, $row);
                if(empty($ot->checkExist($single['link'],$source)))
                    $csv[] = $single;
            }

            $csv = array_map(function ($i) {
                return array_intersect_key($i, array_flip(array('title', 'link', 'image', 'source')));
            }, $csv);

            if(!empty($csv))
                Others::insert($csv);
        }
    }
}

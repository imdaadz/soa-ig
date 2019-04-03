<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Lib\Match;
class MatchProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:match';

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
        $match = new Match();
        $account = 'imdaadz';
        $source = ['tokopedia','shopee'];
        foreach ($source as $key => $value) {
            $linked_product = $match->match_product($account,$value);
            if(!empty($linked_product))
                Match::insert($linked_product);
        }
      

        echo "Success link account : ".$account."\n";
    }
}

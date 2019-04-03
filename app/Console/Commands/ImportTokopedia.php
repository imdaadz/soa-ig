<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte;
use App\Http\Lib\Tokopedia;

class ImportTokopedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tokopedia';

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
        $tokped = new Tokopedia();
        $url = "https://www.tokopedia.com/logitech";
        $crawler = Goutte::request('GET', $url);
        
        $tokopedia_id = $crawler->filter('.css-w20258')->each(function ($node) {
            return $node->attr('id');
        });
        $tokopedia_id = $tokopedia_id[0];
        $page = 1;
        do {
            $tokped_res = $tokped->request($tokopedia_id,$page);
            if(!empty($tokped_res['data']['GetShopProduct']['data'])){
                $insert = array();
                $ids = array();
                foreach ($tokped_res['data']['GetShopProduct']['data'] as $row) {
                    $ids[] = $row['product_id'];
                    $insert[$row['product_id']] = array(
                        'merchant_id' => $tokopedia_id,
                        'product_id' => $row['product_id'],
                        'product_name' => $row['name'],
                        'tokopedia_link' => $row['product_url'],
                        'tokopedia_price' => $row['price']['text_idr']
                    );
                }
                $checkproduct = $tokped->checkProductID($ids);
                if (!empty($checkproduct)){
                    foreach ($checkproduct as $row) {
                        if($insert[$row->product_id]){
                            unset($insert[$row->product_id]);
                        }
                    }
                }
                if(!empty($insert))
                    Tokopedia::insert($insert);
            }else{
                break;
            }
            $page++;
            
        } while(true);
        echo "Success import data for : ".$url."\n";
    }
}

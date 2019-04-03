<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Lib\Shopee;
class ImportShopee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:shopee';

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
        $shopee = new Shopee();
        $shopee_id = env('SHOPEE_ACCOUNT');
        
        $page = 1;
        do {
            $shopee_res = $shopee->getProducts($shopee_id,$page);
            if(!empty($shopee_res['items'])){

                $insert = array();
                $ids = array();
                foreach ($shopee_res['items'] as $row) {
                    $ids[] = $row['itemid'];
                    $insert[$row['itemid']] = array(
                        'merchant_id' => $shopee_id,
                        'product_id' => $row['itemid'],
                        'product_name' => $row['name'],
                        'shopee_link' => 'https://shopee.co.id/--i.'.$row['shopid'].'.'.$row['itemid']
                    );
                }
                $checkproduct = $shopee->checkProductID($ids);
                if (!empty($checkproduct)){
                    foreach ($checkproduct as $row) {
                        if($insert[$row->product_id]){
                            unset($insert[$row->product_id]);
                        }
                    }
                }
                if(!empty($insert))
                    Shopee::insert($insert);
            }else{
                break;
            }
            $page++;
        }while(true);
    }
}

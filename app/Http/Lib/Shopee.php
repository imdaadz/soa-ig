<?php
namespace App\Http\Lib;

use GuzzleHttp\Client;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shopee extends Model{
	protected $table = 'shopee';
	public function getProducts($shopee_id, $page = 1, $limit= 30){
		
		$endpoint = "https://shopee.co.id/api/v2/search_items/?";
		$data = array(
    		'by' => 'pop',
			'limit' => $limit,
			'match_id' => $shopee_id,
			'newest' => (($page * $limit) - $limit),
			'order' => 'desc',
			'page_type' => 'shop'
		);
		$endpoint = $endpoint.http_build_query($data);
		
		$client = new Client();
		$response = $client->get($endpoint);
		$response = json_decode($response->getBody(), true);

		return $response;
	}

	public function checkProductID($product_ids){
		$items = DB::table($this->table)->whereIn('product_id', $product_ids)->get();
		return $items;
	}
}
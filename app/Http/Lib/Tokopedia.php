<?php
namespace App\Http\Lib;

use GuzzleHttp\Client;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tokopedia extends Model{
	protected $table = 'tokopedia';

	private function making_payload($toko_id, $page = 1, $perPage = 80){
		$base_request = '{"variables":{"sid":"xx","page":1,"perPage":80,"etalaseId":"etalase","sort":1},"query":"query ShopProducts($sid: String!, $page: Int, $perPage: Int, $keyword: String, $etalaseId: String,  $sort: Int){  GetShopProduct(shopID: $sid, filter: { page: $page, perPage: $perPage, fkeyword: $keyword, fmenu: $etalaseId, sort: $sort }){ status errors links { prev next } data { name product_url product_id price { text_idr } primary_image{ original thumbnail resize300 } flags{ isSold isPreorder isWholesale isWishlist } campaign { discounted_percentage original_price_fmt start_date end_date } label{ color_hex content } badge{ title image_url } stats{ reviewCount rating } category{ id }    }  }}","operationName":null}';
		$base_request = json_decode($base_request);
		$base_request->variables->sid = $toko_id;
		$base_request->variables->page = $page;
		$base_request->variables->perPage = $perPage;
		
		return json_encode($base_request);
	}

	public function request($toko_id, $page = 1, $perPage = 80){
		$endpoint = "https://gql.tokopedia.com/graphql/";

		$client = new Client([
		    'headers' => ['Content-Type' => 'application/json']
		]);
		$response = $client->post($endpoint, 
		    ['body' => $this->making_payload($toko_id,$page)]
		);
		$response = json_decode($response->getBody(), true);

		return $response;
	}

	public function checkProductID($product_ids){
		$items = DB::table($this->table)->whereIn('product_id', $product_ids)->get();
		return $items;
	}
}
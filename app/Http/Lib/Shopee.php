<?php
namespace App\Http\Lib;
use GuzzleHttp\Client;

class Shopee{
	public function getShopID($username){
		
		$endpoint = "https://shopee.co.id/api/v1/shop_ids_by_username/";

		$client = new Client();
		$response = $client->post($endpoint, 
		    ['usernames' => [$username]]
		);
		$response = json_decode($response->getBody(), true);

		return $response;
	}
}
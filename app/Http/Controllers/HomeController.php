<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Lib\Instagram;

class HomeController extends Controller
{
	public function index(){
		$ig_data = array();
		$client = new \GuzzleHttp\Client();
		$endpoint = "https://api.instagram.com/oembed/?url=http://instagr.am/p/";

		foreach (Instagram::where('instagram_user','imdaadz')->orderBy('id', 'desc')->get() as $row) {
			$response = $client->request('GET', $endpoint.$row->shortcode);
			$content = json_decode($response->getBody(), true);
			
			$matchs = $row->match;
			$linked = array();
			if(!empty($matchs)){
				foreach ($matchs as $match) {
					if($match->product_type == 'tokopedia'){
						$tokopedia = $match->tokopedia;
						$linked[] = array(
							'type' => $match->product_type,
							'link' => $tokopedia->tokopedia_link,
							'price' => $tokopedia->tokopedia_price
						);
					}elseif($match->product_type == 'shopee'){
						$shopee = $match->shopee;
						$linked[] = array(
							'type' => $match->product_type,
							'link' => $shopee->shopee_link,
							'price' => 0
						);
					}else{
						$other = $match->other;
						$linked[] = array(
							'type' => $match->product_type,
							'link' => $other->link,
							'price' => 0
						);
					}
				}
			}
			$ig_data[] = array(
				'id' => $row->id,
				'linked' => $linked,
				'html' => $content['html']
			);
		}
		$source = array(
			'tokopedia' => array(
				'button' => 'success',
				'from' => 'Tokopedia'
			),
			'shopee' => array(
				'button' => 'warning',
				'from' => 'Shopee'
			),
			'blibli' => array(
				'button' => 'primary',
				'from' => 'Blibli'
			),
			'jdid' => array(
				'button' => 'danger',
				'from' => 'JD.ID'
			),
			'jakartanotebook' => array(
				'button' => 'danger',
				'from' => 'Jakartanotebook'
			),
			'bukalapak' => array(
				'button' => 'danger',
				'from' => 'Bukalapak'
			),
		);
		// print_r($ig_data);
		return view('main', [
			'data' => $ig_data,
			'source_list' => $source
		]);
	}
}
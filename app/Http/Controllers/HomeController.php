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

		foreach (Instagram::where('instagram_user','imdaadz')->get() as $row) {
			$response = $client->request('GET', $endpoint.$row->shortcode);
			$content = json_decode($response->getBody(), true);
			
			$matchs = $row->match;
			$linked = array();
			if(!empty($matchs)){
				foreach ($matchs as $match) {
					if($match->product_type == 'tokopedia')
						$tokopedia = $match->tokopedia;
						$linked[] = array(
							'type' => $match->product_type,
							'link' => $tokopedia->tokopedia_link,
							'price' => $tokopedia->tokopedia_price
						);
				}
			}
			$ig_data[] = array(
				'id' => $row->id,
				'linked' => $linked,
				'html' => $content['html']
			);
		}
		// print_r($ig_data);
		return view('main', [
			'data' => $ig_data
		]);
	}
}
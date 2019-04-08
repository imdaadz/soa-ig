<?php
namespace App\Http\Lib;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Instagram extends Model{
	private $ig;
	protected $table = 'instagrams';

	public function __construct(){
		$this->ig = new \InstagramScraper\Instagram();
	}

	public function getUserFeed($user, $limit = 40){
		$nonPrivateAccountMedias = $this->ig->getMedias($user, $limit);
		return $nonPrivateAccountMedias;
	}

	public function checkCaption($caption){
		preg_match_all('/\[{2}(.*?)\]{2}/is',$caption,$match);
		return $match[0];
	}

	public function getClean($caption){
		$caption = rtrim($caption, ']]');
		$caption = ltrim($caption, '[[');
		return $caption;
	}

	public function checkMediaID($media_ids){
		$items = DB::table($this->table)->whereIn('media_ig_id', $media_ids)->get();
		return $items;
	}
	
	public function match()
    {
        return $this->hasMany('App\Http\Lib\Match');
    }
}
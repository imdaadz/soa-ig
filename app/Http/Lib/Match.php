<?php
namespace App\Http\Lib;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Match extends Model{
	protected $table = 'match_product';

	public function match_product($account, $source = 'tokopedia'){
		$col = '';
		if($source == 'tokopedia'){
			$col = 'product_name';
		}
		$res = array();
		$items = DB::table('instagrams')->where('instagram_user', $account)->get();
		foreach ($items as $row) {
			$product =$this->search_match($source,$col,$row->product);
			if(!empty($product[0])){
				$res[] = array(
					'instagram_id' => $row->id,
					'product_id' => $product[0]->id,
					'product_type' => $source
				);
			}
		}
		return $res;
		
	}

	public function search_match($table, $col, $search){
		$result = DB::select("SELECT * FROM ".$table." WHERE MATCH(".$col.") AGAINST(? IN NATURAL LANGUAGE MODE) LIMIT 1",[$search]);
		return $result;
	}

	public function tokopedia()
    {
        return $this->belongsTo('App\Http\Lib\Tokopedia','product_id','id');
    }
}
<?php
namespace App\Http\Lib;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Match extends Model{
	protected $table = 'match_product';

	public function match_product($account, $source = 'tokopedia'){
		$col = 'product_name';
		$res = array();
		$items = DB::table('instagrams')->where('instagram_user', $account)->get();
		foreach ($items as $row) {
			$product =$this->search_match($source,$col,$row->product);
			if(!empty($product[0])){
				if(empty($this->checkExist($row->id, $product[0]->id, $source)))
					$res[] = array(
						'instagram_id' => $row->id,
						'product_id' => $product[0]->id,
						'product_type' => $source
					);
			}
		}
		return $res;
		
	}
	private function checkExist($instagram_id, $product_id, $product_type){
		$result = DB::select('SELECT * FROM match_product WHERE instagram_id=? AND product_id=? AND product_type=? LIMIT 1',[$instagram_id, $product_id, $product_type]);
		return $result;
	}
	public function search_match($table, $col, $search){
		$must_table = ['tokopedia','shopee'];
		if(in_array($table, $must_table))
			$result = DB::select("SELECT * FROM ".$table." WHERE MATCH(".$col.") AGAINST(? IN NATURAL LANGUAGE MODE) LIMIT 1",[$search]);
		else
			$result = DB::select("SELECT * FROM other_marketplace WHERE source=? AND MATCH(title) AGAINST(? IN NATURAL LANGUAGE MODE) LIMIT 1",[$table,$search]);
		return $result;
	}

	public function tokopedia()
    {
        return $this->belongsTo('App\Http\Lib\Tokopedia','product_id','id');
    }
    public function shopee()
    {
        return $this->belongsTo('App\Http\Lib\Shopee','product_id','id');
    }

     public function other()
    {
        return $this->belongsTo('App\Http\Lib\Others','product_id','id');
    }
}
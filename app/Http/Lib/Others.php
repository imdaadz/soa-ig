<?php
namespace App\Http\Lib;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Others extends Model{
	protected $table = 'other_marketplace';

	public function checkExist($link, $source){
		$result = DB::select('SELECT * FROM other_marketplace WHERE link=? AND source=? LIMIT 1',[$link,$source]);
		return $result;
	}
}
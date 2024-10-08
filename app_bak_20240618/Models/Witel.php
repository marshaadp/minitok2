<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Witel extends Model{
	public static function getWitelQtyMinimum(){
		return DB::select("SELECT * FROM witel");
	}

	public static function getTregQtyMinimum(){
		return DB::select("SELECT regional, regional as 'lokasi_wh', regional as 'lokasi', regional as 'wilayah', SUM(retail_fh) as 'retail_fh', SUM(retail_zte) as 'retail_zte', SUM(retail_hw) as 'retail_hw', SUM(retail_alu) as 'retail_alu', SUM(premium_fh) as 'premium_fh', SUM(premium_zte) as 'premium_zte', SUM(premium_hw) as 'premium_hw' FROM witel GROUP BY regional");
	}
}


?>
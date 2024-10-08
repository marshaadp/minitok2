<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gudang extends Model{
	public static function getQtyMinimum(){
		return DB::select("SELECT `id`, `regional`, `witel`, `lokasi_wh`, `lokasi`, `wilayah`, `minimum_qty`, `retail_zte`, `retail_hw`, `retail_fh`, `retail_alu`, `premium_zte`, `premium_fh`, `premium_hw`, CAST(ROUND(retail_fh * 120 / 100) as int) as 'batas_atas_retail_fh', CAST(ROUND(retail_zte * 120 / 100) as int) as 'batas_atas_retail_zte', CAST(ROUND(retail_hw * 120 / 100) as int) as 'batas_atas_retail_hw', CAST(ROUND(retail_alu * 120 / 100) as int) as 'batas_atas_retail_alu', CAST(ROUND(premium_fh * 120 / 100) as int) as 'batas_atas_premium_fh', CAST(ROUND(premium_hw * 120 / 100) as int) as 'batas_atas_premium_hw', CAST(ROUND(premium_zte * 120 / 100) as int) as 'batas_atas_premium_zte', CAST(ROUND(retail_fh * 70 / 100) as int) as 'batas_bawah_retail_fh', CAST(ROUND(retail_zte * 70 / 100) as int) as 'batas_bawah_retail_zte', CAST(ROUND(retail_hw * 70 / 100) as int) as 'batas_bawah_retail_hw', CAST(ROUND(retail_alu * 70 / 100) as int) as 'batas_bawah_retail_alu', CAST(ROUND(premium_fh * 70 / 100) as int) as 'batas_bawah_premium_fh', CAST(ROUND(premium_hw * 70 / 100) as int) as 'batas_bawah_premium_hw', CAST(ROUND(premium_zte * 70 / 100) as int) as 'batas_bawah_premium_zte' FROM gudang ORDER BY id");
	}

	public static function getTregQtyMinimum(){
		return DB::select("SELECT CONCAT('1000', ROW_NUMBER() OVER(ORDER BY regional ASC)) AS id, regional, SUM(minimum_qty) as minimum_qty, regional as 'lokasi_wh', regional as 'witel', regional as 'lokasi', regional as 'wilayah', SUM(retail_fh) as 'retail_fh', SUM(retail_zte) as 'retail_zte', SUM(retail_hw) as 'retail_hw', SUM(retail_alu) as 'retail_alu', SUM(premium_fh) as 'premium_fh', SUM(premium_zte) as 'premium_zte', SUM(premium_hw) as 'premium_hw', CAST(ROUND(SUM(retail_fh) * 120 / 100) as int) as 'batas_atas_retail_fh', CAST(ROUND(SUM(retail_zte) * 120 / 100) as int) as 'batas_atas_retail_zte', CAST(ROUND(SUM(retail_hw) * 120 / 100) as int) as 'batas_atas_retail_hw', CAST(ROUND(SUM(retail_alu) * 120 / 100) as int) as 'batas_atas_retail_alu', CAST(ROUND(SUM(premium_fh) * 120 / 100) as int) as 'batas_atas_premium_fh', CAST(ROUND(SUM(premium_hw) * 120 / 100) as int) as 'batas_atas_premium_hw', CAST(ROUND(SUM(premium_zte) * 120 / 100) as int) as 'batas_atas_premium_zte', CAST(ROUND(SUM(retail_fh) * 70 / 100) as int) as 'batas_bawah_retail_fh', CAST(ROUND(SUM(retail_zte) * 70 / 100) as int) as 'batas_bawah_retail_zte', CAST(ROUND(SUM(retail_hw) * 70 / 100) as int) as 'batas_bawah_retail_hw', CAST(ROUND(SUM(retail_alu) * 70 / 100) as int) as 'batas_bawah_retail_alu', CAST(ROUND(SUM(premium_fh) * 70 / 100) as int) as 'batas_bawah_premium_fh', CAST(ROUND(SUM(premium_hw) * 70 / 100) as int) as 'batas_bawah_premium_hw', CAST(ROUND(SUM(premium_zte) * 70 / 100) as int) as 'batas_bawah_premium_zte' FROM gudang GROUP BY regional");
	}

	public static function getSTBQtyMinimum(){
		return DB::select("SELECT `id`, `regional`, `witel`, `lokasi_wh`, `lokasi`, `wilayah`, CAST((stb_zte * 10) as int) as `minimum_qty`, CAST((ROUND(stb_zte * 120 / 100)) as int) as 'batas_atas_stb_zte', CAST((ROUND(stb_zte * 70 / 100)) as int) as 'batas_bawah_stb_zte' FROM gudang GROUP BY id, regional, lokasi_wh, lokasi, wilayah, witel, stb_zte ORDER BY id");
	}

	public static function getTregSTBQtyMinimum(){
		return DB::select("SELECT regional, CAST((COUNT(id) * 10) as int) as minimum_qty, regional as 'lokasi_wh', regional as 'witel', regional as 'lokasi', regional as 'wilayah', CAST(ROUND(SUM(stb_zte) * 120 / 100) as int) as 'batas_atas_stb_zte', CAST(ROUND(SUM(stb_zte)*70/100) as int) as 'batas_bawah_stb_zte' FROM gudang GROUP BY regional");
	}

	public static function getWitelFromTreg($witel){
		return DB::select("SELECT DISTINCT `witel` FROM gudang WHERE `regional` = '".$witel."' AND lokasi_wh LIKE '%Witel%'");
	}

	public static function getAllWarehouse(){
		return DB::select("SELECT lokasi_wh, lokasi FROM gudang;");
	}

	public static function deleteAllData(){
		return DB::statement("DELETE FROM `gudang`");
	}

	public static function resetIndex(){
		DB::statement("ALTER TABLE `gudang` AUTO_INCREMENT = 1");
	}

	public static function insertData($data){
		DB::insert("INSERT INTO `gudang`(`regional`, `witel`, `lokasi_wh`, `lokasi`, `wilayah`, `minimum_qty`, `retail_zte`, `retail_hw`, `retail_fh`, `retail_alu`, `premium_zte`, `premium_fh`, `premium_hw`, `stb_zte`) VALUES ('".$data["treg"]."', '".$data["witel"]."', '".$data["lokasi_wh"]."', '".$data["lokasi"]."', '".$data["wilayah"]."', ".$data["minimum_qty"].", ".$data["retail_zte"].", ".$data["retail_hw"].", ".$data["retail_fh"].", ".$data["retail_alu"].", ".$data["premium_zte"].", ".$data["premium_fh"].", ".$data["premium_hw"].", ".$data["stb_zte"].")");
	}

	public static function getAllData(){
		return DB::select("SELECT * FROM gudang");
	}
}
?>
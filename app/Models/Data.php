<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Data extends Model{
	public static function deleteAllData(){
		DB::statement("DELETE FROM data");
	}

	public static function resetIndex(){
		DB::statement("ALTER TABLE `data` AUTO_INCREMENT = 1");
	}

	public static function insertData($data){
		return DB::insert("INSERT INTO `data`(`witel`, `status_perangkat`, `treg_wh`, `merk`, `tipe`, `device_id`, `item_code`) VALUES ('".$data["witel"]."', '".$data["status_perangkat"]."', '".$data["treg_wh"]."', '".$data["merk"]."', '".$data["tipe"]."', '".$data["device_id"]."', '".$data["item_code"]."')");
	}

	// public static function countFHWitel(){
	// 	return DB::select("SELECT witel, count(device_id) FROM `data` WHERE merk = 'FIBERHOME' GROUP BY witel");
	// }

	// public static function countZTEWitel(){
	// 	return DB::select("SELECT witel, count(device_id) FROM `data` WHERE merk = 'ZTE' GROUP BY witel");
	// }

	public static function countRetailPerWitel($merk){
		if($merk == 'zte'){
			return DB::select("SELECT witel, count(device_id) as stock FROM `data` WHERE (merk = '".$merk."' OR merk = 'ont') AND (tipe = 'ONT_ZTE_F670L') AND (status_perangkat = 'AVAILABLE' OR status_perangkat = 'INTECHNICIAN') GROUP BY witel");
		}else{
			return DB::select("SELECT witel, count(device_id) as stock FROM `data` WHERE (merk = '".$merk."' OR merk = 'ont') AND (tipe <> 'F670 V2.0' AND tipe <> 'ZTE_F670_V2.0' AND tipe <> 'HG6245N') AND (status_perangkat = 'AVAILABLE' OR status_perangkat = 'INTECHNICIAN') GROUP BY witel");
		}

		return DB::select($query);
	}

	public static function countPremiumPerWitel($merk){
		if($merk == 'zte'){
			return DB::select("SELECT witel, count(device_id) as stock FROM `data` WHERE (merk = 'zte' OR merk = 'ont') AND (tipe = 'ZTE_F670_V2.0' OR tipe = 'F670 V2.0') AND (status_perangkat = 'AVAILABLE' OR status_perangkat = 'INTECHNICIAN') GROUP BY witel");
		}else{
			return DB::select("SELECT witel, count(device_id) as stock FROM `data` WHERE merk = '".$merk."' AND (tipe = 'HG6245N') AND (status_perangkat = 'AVAILABLE' OR status_perangkat = 'INTECHNICIAN') GROUP BY witel");
		}
	}

	public static function cekWitel($str){
		return DB::select("SELECT lokasi FROM witel WHERE wilayah like '%".$str."%'");
	}

	public static function getCount($witel){
		return DB::select("SELECT count FROM tmp_stock WHERE witel like '%".$witel."%'");
	}

	public static function getWitelsFromDataByMerk($merk){
		return DB::select('SELECT DISTINCT witel FROM data WHERE merk = "'.$merk.'"');
	}

	public static function insertTmpStock($data){
		DB::insert("INSERT INTO `tmp_stock`(`witel`, `count`) VALUES ('".$data["witel"]."', '".$data["count"]."')");
	}
}


?>
<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataTmp extends Model{
	public static function insertData($data){
		DB::insert("INSERT INTO `data_tmp`(`id`, `region`, `lokasi_wh`, `status`, `jumlah`, `deskripsi`) VALUES (".$data["id"].",'".$data["region"]."', '".$data["lokasi_wh"]."', '".$data["status"]."', ".$data["jumlah"].", '".$data["deskripsi"]."')");
	}

	public static function getTableLastUpdate(){
		return DB::select("SELECT UPDATE_TIME as waktu_update, CREATE_TIME as waktu_dibuat FROM information_schema.tables WHERE TABLE_SCHEMA = 'u284882491_scmt' AND TABLE_NAME = 'data_tmp'")[0];
	}

	public static function insertDataSTB($data){
		DB::insert("INSERT INTO `data_tmp`(`region`, `lokasi_wh`, `status`, `jumlah`, `deskripsi`) VALUES ('".$data["region"]."', '".$data["lokasi_wh"]."', '".$data["status"]."', ".$data["jumlah"].", '".$data["deskripsi"]."')");
	}

	public static function deleteAllData(){
		DB::statement("DELETE FROM data_tmp");
	}

	public static function resetIndex(){
		DB::statement("ALTER TABLE `data_tmp` AUTO_INCREMENT = 1");
	}

	public static function countRetailPerWitel($merk){
		if($merk == 'zte'){
			return DB::select("SELECT lokasi_wh, sum(jumlah) as stock FROM `data_tmp` WHERE (deskripsi LIKE '%ONT_ZTE_F670L%') AND (deskripsi like '%ZTE%') AND (status LIKE '%AVAILABLE%' OR status LIKE '%INTECHNICIAN%') GROUP BY lokasi_wh");
		}else if($merk == 'nokia'){
			return DB::select("SELECT lokasi_wh, sum(jumlah) as stock FROM `data_tmp` WHERE (deskripsi like '%G240WL%' OR deskripsi like '%2425G%') AND (status LIKE '%AVAILABLE%' OR status LIKE '%INTECHNICIAN%') GROUP BY lokasi_wh");
		}else if($merk == 'fiberhome'){
			return DB::select("SELECT lokasi_wh, sum(jumlah) as stock FROM `data_tmp` WHERE (deskripsi LIKE '%HG6145D2%' or deskripsi LIKE '%HG6145F%') AND (deskripsi like '%Fiberhome%') AND (status LIKE '%AVAILABLE%' OR status LIKE '%INTECHNICIAN%') GROUP BY lokasi_wh");
		}else if($merk == "huawei"){
			return DB::select("SELECT lokasi_wh, sum(jumlah) as stock FROM `data_tmp` WHERE (deskripsi LIKE '%HG8145%') AND (deskripsi like '%Huawei%') AND (status LIKE '%AVAILABLE%' OR status LIKE '%INTECHNICIAN%') GROUP BY lokasi_wh");
		}
	}

	public static function countPremiumPerWitel($merk){
		if($merk == 'zte'){
			return DB::select("SELECT lokasi_wh, sum(jumlah) as stock FROM `data_tmp` WHERE (deskripsi LIKE '%ZTE_F670 V2.0%' or deskripsi = 'ONT_ZTE_F670 V2.0' or deskripsi = 'ONT_ZTE_F670') AND (deskripsi like '%ZTE%') AND (status LIKE '%AVAILABLE%' OR status LIKE '%INTECHNICIAN%') GROUP BY lokasi_wh");
		}else if($merk == 'fiberhome'){
			return DB::select("SELECT lokasi_wh, sum(jumlah) as stock FROM `data_tmp` WHERE (deskripsi LIKE '%HG6245N%') AND (deskripsi like '%Fiberhome%') AND (status LIKE '%AVAILABLE%' OR status LIKE '%INTECHNICIAN%') GROUP BY lokasi_wh");
		}else if($merk == "huawei"){
			// return DB::select("SELECT lokasi_wh, sum(jumlah) as stock FROM `data_tmp` WHERE (deskripsi = 'ONT_HUAWEI HG8245W5-6T') AND (deskripsi like '%Huawei%') AND (status LIKE '%AVAILABLE%' OR status LIKE '%INTECHNICIAN%') GROUP BY lokasi_wh");
			return DB::select("SELECT lokasi_wh, sum(jumlah) as stock FROM `data_tmp` WHERE (deskripsi = 'ONT_HUAWEI HG8245W5-6') AND (status LIKE '%AVAILABLE%' OR status LIKE '%INTECHNICIAN%') GROUP BY lokasi_wh");
		}
	}

	public static function countSTBPerWitel($merk){
		if($merk == 'zte'){
			return DB::select("SELECT lokasi_wh, sum(jumlah) as stock FROM `data_tmp` WHERE (deskripsi = 'SetTopBox_ZTE_ZX10_B866F_V1.1') AND (deskripsi like '%ZTE%') AND (status LIKE '%AVAILABLE%' OR status LIKE '%INTECHNICIAN%') GROUP BY lokasi_wh");
		}
	}

	public static function countAPPerWitel($merk){
		if($merk == 'zte'){
			return DB::select("SELECT lokasi_wh, sum(jumlah) as stock FROM `data_tmp` WHERE (deskripsi = 'SetTopBox_ZTE_ZX10_B866F_V1.1') AND (deskripsi like '%ZTE%') AND (status LIKE '%AVAILABLE%' OR status LIKE '%INTECHNICIAN%') GROUP BY lokasi_wh");
		}
	}
}

// SetTopBox_ZTE_ZX10_B866F_V1.1
?>
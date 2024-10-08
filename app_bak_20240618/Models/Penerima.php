<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penerima extends Model{
	public static function getAllDataONT(){
		// return DB::select("SELECT p.id, p.type, p.qty, p.alamat_pengirim, p.pic_pengirim, p.alamat_penerima, p.warehouse_penerima, p.pic_penerima, p.tanggal_pengiriman, p.tanggal_sampai, p.ido_gd, p.sn_mac_barcode, p.ido_gd_time_added, g.regional, p.batch FROM penerimaan p LEFT JOIN gudang g ON p.warehouse_penerima = g.lokasi_wh WHERE (p.type LIKE '%ONT_ZTE_F670L%') OR (p.type like '%G240WL%' OR type like '%2425G%') OR (p.type LIKE '%HG6145D2%' or p.type LIKE '%HG6145F%') OR (p.type LIKE '%HG8145%') OR (p.type LIKE '%ZTE_F670 V2.0%' or type = 'ONT_ZTE_F670 V2.0' or p.type = 'ONT_ZTE_F670') OR (p.type LIKE '%HG6245N%') OR (p.type LIKE '%HG8245W5-6T') ORDER BY p.batch");
		  //Assign a date as a string

		date_default_timezone_set('Asia/Jakarta');
		$date_now = date('Y-m-d');
		// echo $date_now."<br>";
		// print_r(date('Y-m-d', strtotime($date_now. ' - 2 day')));
		// echo "<br>";
		// echo $date_now < date('Y-m-d', strtotime($date_now. ' - 2 day'));
		return DB::select("select p.id, p.type, p.qty, p.alamat_pengirim, p.pic_pengirim, p.alamat_penerima, p.warehouse_penerima, p.pic_penerima, p.tanggal_pengiriman, p.tanggal_sampai, p.ido_gd, p.sn_mac_barcode, p.ido_gd_time_added, g.regional, p.batch from penerimaan p JOIN (select gd.lokasi_wh, gd.regional, row_number() over (partition by gd.lokasi_wh) as row_num from gudang gd GROUP BY gd.lokasi_wh,gd.regional) g ON g.lokasi_wh = p.warehouse_penerima where (g.row_num = 1) AND ((p.type LIKE '%ONT_ZTE_F670L%') OR (p.type like '%G240WL%' OR type like '%2425G%') OR (p.type LIKE '%HG6145D2%' or p.type LIKE '%HG6145F%') OR (p.type LIKE '%HG8145%') OR (p.type LIKE '%ZTE_F670 V2.0%' or type = 'ONT_ZTE_F670 V2.0' or p.type = 'ONT_ZTE_F670') OR (p.type LIKE '%HG6245N%') OR (p.type LIKE '%HG8245W5-6T') OR (`type` like '%HG8145V5%')) AND (p.ido_gd_time_added > '".date('Y-m-d', strtotime($date_now. ' - 2 day'))."' OR p.ido_gd_time_added = '') ORDER BY p.batch");
	}

	public static function getAllDataONTExport(){
		date_default_timezone_set('Asia/Jakarta');
		$date_now = date('Y-m-d');
		return DB::select("select p.id, p.type, p.qty, p.alamat_pengirim, p.pic_pengirim, p.alamat_penerima, p.warehouse_penerima, p.pic_penerima, p.tanggal_pengiriman, p.tanggal_sampai, p.ido_gd, p.sn_mac_barcode, p.ido_gd_time_added, g.regional, p.batch from penerimaan p JOIN (select gd.lokasi_wh, gd.regional, row_number() over (partition by gd.lokasi_wh) as row_num from gudang gd GROUP BY gd.lokasi_wh,gd.regional) g ON g.lokasi_wh = p.warehouse_penerima where (g.row_number = 1) AND ((p.type LIKE '%ONT_ZTE_F670L%') OR (p.type like '%G240WL%' OR type like '%2425G%') OR (p.type LIKE '%HG6145D2%' or p.type LIKE '%HG6145F%') OR (p.type LIKE '%HG8145%') OR (p.type LIKE '%ZTE_F670 V2.0%' or type = 'ONT_ZTE_F670 V2.0' or p.type = 'ONT_ZTE_F670') OR (p.type LIKE '%HG6245N%') OR (p.type LIKE '%HG8245W5-6T') OR (`type` like '%HG8145V5%')) ORDER BY p.batch");
	}

	public static function getDataById($id){
	    return DB::select("SELECT * FROM penerimaan WHERE id = '".$id."'");
	}
	
	public static function getIdoGD($ido_gd){
	    return DB::select("SELECT ido_gd WHERE ido_gd = '".$ido_gd."'");
	}

	public static function getAllDataSTB(){
		date_default_timezone_set('Asia/Jakarta');
		$date_now = date('Y-m-d');
		return DB::select("SELECT p.id, p.type, p.qty, p.alamat_pengirim, p.pic_pengirim, p.alamat_penerima, p.warehouse_penerima, p.pic_penerima, p.tanggal_pengiriman, p.tanggal_sampai, p.ido_gd, p.sn_mac_barcode, p.ido_gd_time_added, g.regional, p.batch FROM penerimaan p JOIN gudang g ON p.warehouse_penerima = g.lokasi_wh WHERE (type = 'SetTopBox_ZTE_ZX10_B866F_V1.1') AND p.warehouse_penerima = g.lokasi_wh AND (p.ido_gd_time_added > '".date('Y-m-d', strtotime($date_now. ' - 2 day'))."' OR p.ido_gd_time_added = '')");
	}

	public static function getAllDataSTBExport(){
		return DB::select("SELECT p.id, p.type, p.qty, p.alamat_pengirim, p.pic_pengirim, p.alamat_penerima, p.warehouse_penerima, p.pic_penerima, p.tanggal_pengiriman, p.tanggal_sampai, p.ido_gd, p.sn_mac_barcode, p.ido_gd_time_added, g.regional, p.batch FROM penerimaan p JOIN gudang g ON p.warehouse_penerima = g.lokasi_wh WHERE (type = 'SetTopBox_ZTE_ZX10_B866F_V1.1') AND p.warehouse_penerima = g.lokasi_wh");
	}

	public static function getAllData(){
		// return DB::select("SELECT p.id, p.type, p.qty, p.alamat_pengirim, p.pic_pengirim, p.alamat_penerima, p.warehouse_penerima, p.pic_penerima, p.tanggal_pengiriman, p.tanggal_sampai, p.ido_gd, p.sn_mac_barcode, p.ido_gd_time_added, g.regional, p.batch FROM penerimaan p JOIN gudang g ON p.warehouse_penerima = g.lokasi_wh WHERE AND p.warehouse_penerima = g.lokasi_wh");
		return DB::select("p.id, p.type, p.qty, p.alamat_pengirim, p.pic_pengirim, p.alamat_penerima, p.warehouse_penerima, p.pic_penerima, p.tanggal_pengiriman, p.tanggal_sampai, p.ido_gd, p.sn_mac_barcode, p.ido_gd_time_added, gd.regional, p.batch from penerimaan p JOIN (select gd.lokasi_wh, gd.regional, row_number() over (partition by gd.lokasi_wh) as row_num from gudang gd GROUP BY gd.lokasi_wh,gd.regional) g ON g.lokasi_wh = p.warehouse_penerima where g.row_number = 1 AND (p.ido_gd_time_added > '".date('Y-m-d', strtotime($date_now. ' - 2 day'))."' OR p.ido_gd_time_added = '')");
	}

	public static function getAllDataExport(){
		return DB::select("p.id, p.type, p.qty, p.alamat_pengirim, p.pic_pengirim, p.alamat_penerima, p.warehouse_penerima, p.pic_penerima, p.tanggal_pengiriman, p.tanggal_sampai, p.ido_gd, p.sn_mac_barcode, p.ido_gd_time_added, gd.regional, p.batch from penerimaan p JOIN (select gd.lokasi_wh, gd.regional, row_number() over (partition by gd.lokasi_wh) as row_num from gudang gd GROUP BY gd.lokasi_wh,gd.regional) g ON g.lokasi_wh = p.warehouse_penerima where g.row_number = 1");
	}

	public static function insertData($data){
		DB::insert("INSERT INTO `penerimaan`(`type`, `qty`, `alamat_pengirim`, `pic_pengirim`, `alamat_penerima`, `warehouse_penerima`, `pic_penerima`, `tanggal_pengiriman`, `tanggal_sampai`, `batch`) VALUES ('".$data["type"]."', '".$data["qty"]."', '".$data["alamat_pengirim"]."', '".$data["pic_pengirim"]."', '".$data["alamat_penerima"]."', '".$data["warehouse_penerima"]."', '".$data["pic_penerima"]."', '".$data["tanggal_pengiriman"]."', '".$data["tanggal_sampai"]."', '".$data["batch"]."')");
	}

	public static function insertDataBanyak($data){
		DB::insert("INSERT INTO `penerimaan`(`type`, `qty`, `alamat_pengirim`, `pic_pengirim`, `alamat_penerima`, `warehouse_penerima`, `pic_penerima`, `tanggal_pengiriman`, `tanggal_sampai`, `ido_gd`, `sn_mac_barcode`, `batch`, `ido_gd_time_added`) VALUES ('".$data["type"]."', '".$data["qty"]."', '".$data["alamat_pengirim"]."', '".$data["pic_pengirim"]."', '".$data["alamat_penerima"]."', '".$data["warehouse_penerima"]."', '".$data["pic_penerima"]."', '".$data["tanggal_pengiriman"]."', '".$data["tanggal_sampai"]."', '".$data["ido_gd"]."', '".$data["sn_mac_barcode"]."', '".$data["batch"]."', '".$data["ido_gd_time_added"]."')");
	}

	public static function countRetailPerWitel($merk){
		if($merk == 'zte'){
			return DB::select("SELECT `warehouse_penerima`, sum(qty) as stock FROM `penerimaan` WHERE (`type` LIKE '%ONT_ZTE_F670L%') AND (`type` like '%ZTE%') GROUP BY `warehouse_penerima`");
		}else if($merk == 'nokia'){
			return DB::select("SELECT `warehouse_penerima`, sum(qty) as stock FROM `penerimaan` WHERE (`type` like '%G240WL%' OR `type` like '%2425G%') GROUP BY `warehouse_penerima`");
		}else if($merk == 'fiberhome'){
			return DB::select("SELECT `warehouse_penerima`, sum(qty) as stock FROM `penerimaan` WHERE (`type` LIKE '%HG6145D2%' or `type` LIKE '%HG6145F%') AND (`type` like '%Fiberhome%') GROUP BY `warehouse_penerima`");
		}else if($merk == "huawei"){
			return DB::select("SELECT `warehouse_penerima`, sum(qty) as stock FROM `penerimaan` WHERE ((`type` LIKE '%HG8145%') OR (`type` like '%HG8145V5%')) GROUP BY `warehouse_penerima`");
		}
	}

	public static function countPremiumPerWitel($merk){
		if($merk == 'zte'){
			return DB::select("SELECT `warehouse_penerima`, sum(qty) as stock FROM `penerimaan` WHERE (`type` LIKE '%ZTE_F670 V2.0%' or `type` = 'ONT_ZTE_F670 V2.0' or `type` = 'ONT_ZTE_F670') AND (`type` like '%ZTE%')  GROUP BY `warehouse_penerima`");
		}else if($merk == 'fiberhome'){
			return DB::select("SELECT `warehouse_penerima`, sum(qty) as stock FROM `penerimaan` WHERE (`type` LIKE '%HG6245N%') AND (`type` like '%Fiberhome%')  GROUP BY `warehouse_penerima`");
		}else if($merk == "huawei"){
			return DB::select("SELECT `warehouse_penerima`, sum(qty) as stock FROM `penerimaan` WHERE (`type` = 'ONT_HUAWEI HG8245W5-6T' or `type` = 'ONT_HW_HG8245W5-6T') GROUP BY `warehouse_penerima`");
		}
	}

	public static function countSTBPerWitel($merk){
		if($merk == 'zte'){
			return DB::select("SELECT warehouse_penerima, sum(qty) as stock FROM `penerimaan` WHERE (type = 'SetTopBox_ZTE_ZX10_B866F_V1.1') GROUP BY warehouse_penerima");
		}
	}

	public static function countAPPerWitel($merk){
		if($merk == 'zte'){
			return DB::select("SELECT warehouse_penerima, sum(qty) as stock FROM `penerimaan` WHERE (type = 'SetTopBox_ZTE_ZX10_B866F_V1.1') GROUP BY warehouse_penerima");
		}
	}

	public static function deleteAllData(){
		DB::statement("DELETE FROM penerimaan");
	}

	public static function deleteOnDeliveryById($id){
		DB::statement("DELETE FROM penerimaan WHERE id = ".$id);
	}

	public static function editTanggalPenerimaanById($id, $data){
		DB::statement("UPDATE `penerimaan` SET `tanggal_pengiriman`='".$data["tanggal_pengiriman"]."',`tanggal_sampai`='".$data["tanggal_sampai"]."', `sn_mac_barcode` = '".$data["sn_mac_barcode"]."' WHERE id = ".$id);
	}

	public static function editTanggalOnly($id, $data){
		DB::statement("UPDATE `penerimaan` SET `tanggal_pengiriman`='".$data["tanggal_pengiriman"]."',`tanggal_sampai`='".$data["tanggal_sampai"]."' WHERE id = ".$id);
	}

	public static function getSNById($id){
		return DB::select("SELECT sn_mac_barcode, batch as 'penerimaan_batch' FROM penerimaan WHERE id = ".$id);
	}

	public static function getAllSNExist(){
		return DB::select("SELECT p.*, g.regional from penerimaan p JOIN gudang g ON p.warehouse_penerima = g.lokasi_wh where sn_mac_barcode <> '' AND ido_gd = ''");
	}

	public static function getBatchById($id){
		return DB::select("SELECT batch FROM penerimaan WHERE id = ".$id);
	}

	public static function editIdoGDById($id, $data){
		date_default_timezone_set('Asia/Jakarta');
		DB::statement("UPDATE `penerimaan` SET `ido_gd`='".$data["ido_gd"]."', `ido_gd_time_added` = '".date("Y-m-d H:i:s")."' WHERE id = ".$id);
	}

	public static function getOnDeliveryRetailByWarehouse($nama_warehouse){
		if(str_contains($nama_warehouse, "WH TR TREG")){
			return DB::select("SELECT p.id, p.type, p.qty, p.alamat_pengirim, p.pic_pengirim, p.alamat_penerima, p.warehouse_penerima, p.pic_penerima, p.tanggal_pengiriman, p.tanggal_sampai, p.ido_gd, p.sn_mac_barcode, g.regional, p.batch FROM penerimaan p JOIN gudang g ON p.warehouse_penerima = g.lokasi_wh WHERE ((p.type LIKE '%ONT_ZTE_F670L%') OR (p.type like '%G240WL%' OR type like '%2425G%') OR (p.type LIKE '%HG6145D2%' or p.type LIKE '%HG6145F%') OR (p.type LIKE '%HG8145%') OR (p.type LIKE '%HG8145V5%')) AND (g.regional = '".$nama_warehouse."')");
		}else if(str_contains($nama_warehouse, "WITEL")){
			return DB::select("SELECT p.id, p.type, p.qty, p.alamat_pengirim, p.pic_pengirim, p.alamat_penerima, p.warehouse_penerima, p.pic_penerima, p.tanggal_pengiriman, p.tanggal_sampai, p.ido_gd, p.sn_mac_barcode, g.regional, p.batch FROM penerimaan p JOIN gudang g ON p.warehouse_penerima = g.lokasi_wh WHERE ((p.type LIKE '%ONT_ZTE_F670L%') OR (p.type like '%G240WL%' OR type like '%2425G%') OR (p.type LIKE '%HG6145D2%' or p.type LIKE '%HG6145F%') OR (p.type LIKE '%HG8145%') OR (p.type LIKE '%HG8145V5%')) AND (g.witel = '".$nama_warehouse."')");
		}else{
			return DB::select("SELECT p.id, p.type, p.qty, p.alamat_pengirim, p.pic_pengirim, p.alamat_penerima, p.warehouse_penerima, p.pic_penerima, p.tanggal_pengiriman, p.tanggal_sampai, p.ido_gd, p.sn_mac_barcode, g.regional, p.batch FROM penerimaan p JOIN gudang g ON p.warehouse_penerima = g.lokasi_wh WHERE ((p.type LIKE '%ONT_ZTE_F670L%') OR (p.type like '%G240WL%' OR type like '%2425G%') OR (p.type LIKE '%HG6145D2%' or p.type LIKE '%HG6145F%') OR (p.type LIKE '%HG8145%') OR (p.type LIKE '%HG8145V5%')) AND (g.lokasi_wh = '".$nama_warehouse."')");
		}
	}

	public static function getOnDeliveryPremiumByWarehouse($nama_warehouse){
		if(str_contains($nama_warehouse, "WH TR TREG")){
			return DB::select("SELECT p.id, p.type, p.qty, p.alamat_pengirim, p.pic_pengirim, p.alamat_penerima, p.warehouse_penerima, p.pic_penerima, p.tanggal_pengiriman, p.tanggal_sampai, p.ido_gd, p.sn_mac_barcode, g.regional, p.batch FROM penerimaan p JOIN gudang g ON p.warehouse_penerima = g.lokasi_wh WHERE ((p.type = 'ONT_HUAWEI HG8245W5-6T' or p.type = 'ONT_HW_HG8245W5-6T') OR (p.type LIKE '%ZTE_F670 V2.0%' or type = 'ONT_ZTE_F670 V2.0' or p.type = 'ONT_ZTE_F670') OR (p.type LIKE '%HG6245N%')) AND (g.regional = '".$nama_warehouse."')");
		}else if(str_contains($nama_warehouse, "WITEL")){
			return DB::select("SELECT p.id, p.type, p.qty, p.alamat_pengirim, p.pic_pengirim, p.alamat_penerima, p.warehouse_penerima, p.pic_penerima, p.tanggal_pengiriman, p.tanggal_sampai, p.ido_gd, p.sn_mac_barcode, g.regional, p.batch FROM penerimaan p JOIN gudang g ON p.warehouse_penerima = g.lokasi_wh WHERE ((p.type = 'ONT_HUAWEI HG8245W5-6T' or p.type = 'ONT_HW_HG8245W5-6T') OR (p.type LIKE '%ZTE_F670 V2.0%' or type = 'ONT_ZTE_F670 V2.0' or p.type = 'ONT_ZTE_F670') OR (p.type LIKE '%HG6245N%')) AND (g.witel = '".$nama_warehouse."')");
		}else{
			return DB::select("SELECT p.id, p.type, p.qty, p.alamat_pengirim, p.pic_pengirim, p.alamat_penerima, p.warehouse_penerima, p.pic_penerima, p.tanggal_pengiriman, p.tanggal_sampai, p.ido_gd, p.sn_mac_barcode, g.regional, p.batch FROM penerimaan p JOIN gudang g ON p.warehouse_penerima = g.lokasi_wh WHERE ((p.type = 'ONT_HUAWEI HG8245W5-6T' or p.type = 'ONT_HW_HG8245W5-6T') OR (p.type LIKE '%ZTE_F670 V2.0%' or type = 'ONT_ZTE_F670 V2.0' or p.type = 'ONT_ZTE_F670') OR (p.type LIKE '%HG6245N%')) AND (g.lokasi_wh = '".$nama_warehouse."')");
		}
	}

	public static function deleteDataByTreg($treg){
		DB::statement("DELETE p FROM penerimaan p JOIN gudang g ON p.warehouse_penerima = g.lokasi_wh WHERE g.regional = '".$treg."'");
	}
}
?>
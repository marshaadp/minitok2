<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RequestOutbond extends Model{
	public static function getAllData(){
		return DB::SELECT("SELECT `id`, `type`, `jenis`, `merk`, `qty_delivery`, `delivery_by`, `keperluan`, `catatan`, `alamat_tujuan`, `sn_mac_barcode`, `evident`, `respon`, `added_by`, `approved_by`, DATE_FORMAT(`submitted_time`, '%Y-%m-%d') as submitted_time, `status`, `time_added` FROM request_outbond ORDER BY (submitted_time) DESC");
	}

	public static function insertData($data){
		DB::insert("INSERT INTO `request_outbond`(`type`, `jenis`, `merk`, `qty_delivery`, `delivery_by`, `keperluan`, `catatan`, `alamat_tujuan`, `added_by`) VALUES ('".$data["type"]."', '".$data["jenis"]."', '".$data["merk"]."', '".$data["qty_delivery"]."', '".$data["delivery_by"]."', '".$data["keperluan"]."', '".$data["catatan"]."', '".$data["alamat_tujuan"]."', '".$data["added_by"]."')");
	}

	
	public static function editData($data, $id){
		DB::statement("UPDATE `request_outbond` SET type = '".$data["type"]."', jenis = '".$data["jenis"]."', merk = '".$data["merk"]."', qty_delivery = '".$data["qty_delivery"]."', delivery_by = '".$data["delivery_by"]."', keperluan = '".$data["keperluan"]."', catatan = '".$data["catatan"]."', alamat_tujuan = '".$data["alamat_tujuan"]."' WHERE id = ".$id);
	}

	public static function deleteAllData(){
		DB::statement("DELETE FROM request_outbond");
	}

	public static function editRespon($id, $data){
		date_default_timezone_set('Asia/Jakarta');
		$date_now = date('Y-m-d h:i:sa');
		print_r($date_now);
		DB::statement("UPDATE request_outbond SET respon = '".$data["respon"]."', approved_by = '".$data["approved_by"]."', submitted_time = '".$date_now."' WHERE id = ".$id);
	}

	public static function getTypeUnique(){
		return DB::SELECT("SELECT DISTINCT(type) FROM `request_outbond`");
	}

	public static function getJenisUnique(){
		return DB::SELECT("SELECT DISTINCT(jenis) FROM `request_outbond`");
	}

	public static function getMerkUnique(){
		return DB::SELECT("SELECT DISTINCT(merk) FROM `request_outbond`");
	}

	public static function editSNMac($id, $data){
		DB::statement("UPDATE `request_outbond` SET sn_mac_barcode = '".$data["sn_mac_barcode"]."' WHERE id = ".$id);
	}

	public static function editEvident($id, $data){
		DB::statement("UPDATE `request_outbond` SET evident = '".$data["evident"]."' WHERE id = ".$id);
	}

	public static function deleteData($id){
		DB::statement("DELETE FROM request_outbond WHERE id = ".$id);
	}

	public static function getEvidentById($id){
		return DB::SELECT("SELECT evident FROM request_outbond where id = ".$id);
	}

	public static function getSNMacById($id){
		return DB::SELECT("SELECT sn_mac_barcode FROM request_outbond where id = ".$id);
	}

	public static function getResponById($id){
		return DB::SELECT("SELECT respon, sn_mac_barcode, evident, status FROM request_outbond where id = ".$id);
	}

	public static function editStatus($id, $status){
		DB::statement("UPDATE request_outbond SET status = '".$status."' WHERE id = ".$id);
	}
}
?>
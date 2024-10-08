<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Messages extends Model{
	public static function getAllWithStatusSent($nama_pengirim){
		return DB::select("SELECT m.id, u.fullname, m.message, m.created_date, m.status FROM message m INNER JOIN user u on u.username = m.nama_penerima  WHERE m.nama_pengirim = '".$nama_pengirim."' ORDER BY m.created_date DESC");
	}
	
	public static function getAllWithStatusInbox($nama_penerima){
		return DB::select("SELECT m.id, u.fullname, m.message, m.created_date, m.status FROM message m INNER JOIN user u on u.username = m.nama_pengirim  WHERE m.nama_penerima = '".$nama_penerima."' AND m.status = 'Sent' ORDER BY m.created_date DESC");
	}

	public static function getAll(){
		return DB::select("SELECT DISTINCT m.id, u1.fullname nama_pengirim, u2.fullname nama_penerima, m.message, m.created_date, m.status FROM message m LEFT JOIN user u1 on m.nama_pengirim = u1.username LEFT JOIN user u2 on m.nama_penerima = u2.username ORDER BY m.created_date DESC");
	}

	public static function getAllNotification($user){
		return DB::select("select *, TIMESTAMPDIFF(SECOND, all_data.created_date, now()) 'second', TIMESTAMPDIFF(MINUTE, all_data.created_date, now()) 'minute', TIMESTAMPDIFF(HOUR,all_data.created_date, now()) 'hour',  TIMESTAMPDIFF(DAY, all_data.created_date, now()) 'day' from (SELECT m.id, u.fullname, m.status, m.created_date FROM message m INNER JOIN user u on m.nama_pengirim = u.username WHERE m.nama_penerima = '".$user."' AND m.status = 'Sent' UNION ALL SELECT m.id, u.fullname, m.status, m.updated_date 'created_date' FROM message m INNER JOIN user u on m.nama_penerima = u.username WHERE m.nama_pengirim = '".$user."' AND m.status <> 'Sent') all_data  ORDER BY `all_data`.`created_date` DESC");
	}

	public static function approveMessage($id_msg){
		DB::statement("UPDATE message SET status = 'Approve', updated_date = Now() WHERE id = ".$id_msg);
	}

	public static function rejectMessage($id_msg){
		DB::statement("UPDATE message SET status = 'Reject', updated_date = Now() WHERE id = ".$id_msg);
	}

	public static function insertMessage($data){
		DB::insert("INSERT INTO `message`(`nama_pengirim`, `nama_penerima`, `message`, `status`, `created_date`) VALUES ('".$data["nama_pengirim"]."', '".$data["nama_penerima"]."', '".$data["message"]."', '".$data["status"]."', Now())");
	}
}

?>
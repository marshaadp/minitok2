<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model{
    public static function GetAllUser(){
        return DB::select("SELECT `id`, `username`, `fullname`, `email`, `phone`, `role`, `divisi`, `last_login`, `jenis_akun` FROM user");
    }

    public static function GetUser($username, $password){
        return DB::select("SELECT `username`, `fullname`, `role`, `asal`, `jenis_akun` FROM user WHERE username = '".$username."' AND password = '".$password."'");
    }

    public static function GetUserById($id){
        return DB::select("SELECT `username` FROM user WHERE id = ".$id);
    }

    public static function AddUser($data){
        $insert_statement = "INSERT INTO `user`(`username`, `password`, `fullname`, `email`, `phone`, `role`, `divisi`, `last_login`) VALUES ('".$data['username']."','".$data['password']."','".$data['fullname']."','".$data['email']."','".$data['phone']."','".$data['role']."','".$data['unit']."', '-')";
        DB::insert($insert_statement);
    }

    public static function EditUser($data, $id){
        $update_statement = "UPDATE `user` SET `username`='".$data["username"]."',`fullname`='".$data["fullname"]."', `email`='".$data["email"]."',`phone`='".$data["phone"]."',`role`='".$data["role"]."',`divisi`='".$data["unit"]."' WHERE id = ".$id;
        DB::statement($update_statement);
    }

    public static function DeleteUser($id){
        DB::statement("DELETE FROM user WHERE id = ".$id);
    }

    public static function GetAllUserNotAdmin(){
        return DB::select("SELECT `username`, `fullname` FROM user WHERE role <> 'Administrator'");
    }

    public static function GetAllUserAdminOnly(){
        return DB::select("SELECT `username`, `fullname` FROM user WHERE role = 'Administrator'");
    }
}
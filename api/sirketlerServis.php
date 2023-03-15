<?php 

 
include 'config.php';

if($_GET['token']){ $token = $_GET['token'];}

else{$token = $_POST['token'];}

// --ID ile get metodunu uygulayarak verileri alma ----------------------------------
//https://ankaradisprotez.com.tr/api/degerlerServis.php?token=emre&uid=2
if($_SERVER['REQUEST_METHOD'] == "GET" &&  $_GET['sid'] ) {

$sid=$_GET['sid'];

$uyeler = DB::get("SELECT * FROM sirketler WHERE sid=$sid"); // mysql baglantisi

if($token==TOKEN){ // Güvenlik için token olusturduk, bu token'i bilmeden postmande islem yapilamaz!!! Token'i zor yap ;) Token config.php'de tanimli
$uyeler_array= array(); // array olustur
$uyeler_array['Sirketler']= $uyeler; // verileri arraye at
echo json_encode($uyeler_array); // json'a çevirip gönder
}
else{ // token olmazsa hata ver
$uyeler_array= array();  
$uyeler_array['type']= "error";  
echo json_encode($uyeler_array);
}
}
// --ID ile get metodunu uygulayarak verileri alma BITTI  ----------------------------------------------------
 
// --get ile bütün verileri siralama ----------------------------------
//https://ankaradisprotez.com.tr/api/degerlerServis.php?token=emre
if($_SERVER['REQUEST_METHOD'] == "GET" &&  !$_GET['sid']  ) {

$degerler = DB::get("SELECT * FROM sirketler"); // mysql baglantisi

if($token==TOKEN){ // Güvenlik için token olusturduk, bu token'i bilmeden postmande islem yapilamaz!!! Token'i zor yap ;) TOKEN config.php'de tanimli
$uyeler_array= array(); // array olustur
$uyeler_array['Sirketler']= $degerler; // verileri arraye at
echo json_encode($uyeler_array);
}
else{ // token olmazsa hata ver
$uyeler_array= array();  
$uyeler_array['type']= "error";  
echo json_encode($uyeler_array);
}
}
// --get ile verileri siralama bitti ----------------------------------------------------

// --Ekleme Islemi  ----------------------------------------------------
//https://ankaradisprotez.com.tr/api/degerlerServis.php?token=emre
if($_SERVER['REQUEST_METHOD'] == "POST" ) {

$data=json_decode(file_get_contents('php://input'),true); // gönderilen verileri al

if($token == TOKEN){

$sisim=$data['sisim'];
$ssehir=$data['ssehir'];
$sbilgi=$data['sbilgi'];

DB::insert("INSERT INTO sirketler(sisim,ssehir,	sbilgi) VALUES (?, ?, ?)", array($sisim, $ssehir, $sbilgi));
 
$return_array =array();
$return_array['type'] ="success";
echo json_encode($return_array);
}

else{
$return_array =array();
$return_array['type'] ="error";
echo json_encode($return_array);
die();
}
}

// --Ekleme Islemi BITTI ----------------------------------------------------

// --Düzenleme Islemi  ----------------------------------------------------
//https://ankaradisprotez.com.tr/api/degerlerServis.php?token=emre
if($_SERVER['REQUEST_METHOD'] == "PUT" ) {

$data=json_decode(file_get_contents('php://input'),true);

if($token == TOKEN){

$sid=$data['sid'];
$sisim=$data['sisim'];
$ssehir=$data['ssehir'];
$sbilgi=$data['sbilgi'];


DB::exec('UPDATE sirketler SET sisim=?,	ssehir=?,	sbilgi=? WHERE sid=?',array($sisim,$ssehir,$sbilgi,$sid));
 
$return_array =array();
$return_array['type'] ="success";
echo json_encode($return_array);
}

else{
$return_array =array();
$return_array['type'] ="error";
echo json_encode($return_array);
die();
}
}

// --Düzenleme Islemi BITTI ----------------------------------------------------

// --silme Islemi  ----------------------------------------------------
//https://ankaradisprotez.com.tr/api/degerlerServis.php?token=emre
if($_SERVER['REQUEST_METHOD'] == "DELETE" ) {

$data=json_decode(file_get_contents('php://input'),true);

if($token == TOKEN){

$sid=$data['sid'];

DB::exec('DELETE FROM sirketler WHERE sid=?',array($sid));
 
$return_array =array();
$return_array['type'] ="success";
echo json_encode($return_array);
}

else{
$return_array =array();
$return_array['type'] ="error";
echo json_encode($return_array);
die();
}
}

// --silme Islemi BITTI ----------------------------------------------------




?>
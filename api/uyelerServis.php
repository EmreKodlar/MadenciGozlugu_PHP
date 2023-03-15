<?php 

 
include 'config.php';

if($_GET['token']){ $token = $_GET['token'];}

else{$token = $_POST['token'];}

// --ID ile get metodunu uygulayarak verileri alma ----------------------------------
//https://ankaradisprotez.com.tr/api/uyelerServis.php?token=emre&uid=2
if($_SERVER['REQUEST_METHOD'] == "GET" &&  $_GET['uid'] ) {
 
$uyeler = DB::get("SELECT * FROM uyeler WHERE uid=".$_GET['uid']); // mysql baglantisi

if($token==TOKEN){ // Güvenlik için token olusturduk, bu token'i bilmeden postmande islem yapilamaz!!! Token'i zor yap ;) Token config.php'de tanimli
$uyeler_array= array(); // array olustur
$uyeler_array['Uyeler']= $uyeler; // verileri arraye at
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
//https://ankaradisprotez.com.tr/api/uyelerServis.php?token=emre
if($_SERVER['REQUEST_METHOD'] == "GET" &&  !$_GET['uid'] ) {

$uyeler = DB::get("SELECT * FROM uyeler"); // mysql baglantisi

if($token==TOKEN){ // Güvenlik için token olusturduk, bu token'i bilmeden postmande islem yapilamaz!!! Token'i zor yap ;) TOKEN config.php'de tanimli
$uyeler_array= array(); // array olustur
$uyeler_array['Uyeler']= $uyeler; // verileri Uyeler isimli  arraye at
echo json_encode($uyeler_array);
}
else{ // token olmazsa hata ver
$uyeler_array= array();  
$uyeler_array['type']= "error";  
echo json_encode($uyeler_array);
}
}
// --get ile verileri siralama bitti ----------------------------------------------------






// --Ekleme Islemi (üye olma)  ----------------------------------------------------
if($_SERVER['REQUEST_METHOD'] == "POST"   ) {// ayni sayfada 2. bir post yapilacaksa, submit butonunun name'ine deger ver  ve burada $_POST ile çagir ;) o seni bulur :))

$data=json_decode(file_get_contents('php://input'),true); // gönderilen verileri al

if($token == TOKEN){

$utel=$data['utel'];
$usirket=$data['usirket'];
$uisim=$data['uisim']; 
$usifre=$data['usifre'];
$umail=$data['umail'];

DB::insert("INSERT INTO uyeler(utel, usirket, uisim,usifre,umail) VALUES (?, ?, ?, ?, ?)", array($utel, $usirket, $uisim, $usifre, $umail));
 
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
if($_SERVER['REQUEST_METHOD'] == "PUT" ) {

$data=json_decode(file_get_contents('php://input'),true);

if($token == TOKEN){
cors();
$uid=$data['uid'];
$utel=$data['utel'];
$usirket=$data['usirket'];
$uisim=$data['uisim'];
$usifre=$data['usifre'];
$umail=$data['umail'];

DB::exec('UPDATE uyeler SET umail=?, utel=?, usirket=?, uisim=?, usifre=? WHERE uid=?',array($umail,$utel,$usirket,$uisim,$usifre,$uid));
 
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
if($_SERVER['REQUEST_METHOD'] == "DELETE" ) {

$data=json_decode(file_get_contents('php://input'),true);

if($token == TOKEN){

$uid=$data['uid'];

DB::exec('DELETE FROM uyeler WHERE uid=?',array($uid));
 
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

function cors() {
    
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
        exit(0);
    }
    
    
}



?>
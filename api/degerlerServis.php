<?php 

 
include 'config.php';

if($_GET['token']){ $token = $_GET['token'];}

else{$token = $_POST['token'];}

// --ID ile get metodunu uygulayarak verileri alma ----------------------------------
//https://ankaradisprotez.com.tr/api/degerlerServis.php?token=emre&uid=2
if($_SERVER['REQUEST_METHOD'] == "GET" &&  $_GET['did'] ) {

$did=$_GET['did'];

$uyeler = DB::get("SELECT * FROM degerler WHERE did=$did"); // mysql baglantisi

if($token==TOKEN){ // Güvenlik için token olusturduk, bu token'i bilmeden postmande islem yapilamaz!!! Token'i zor yap ;) Token config.php'de tanimli
$uyeler_array= array(); // array olustur
$uyeler_array['Degerler']= $uyeler; // verileri arraye at
echo json_encode($uyeler_array); // json'a çevirip gönder
}
else{ // token olmazsa hata ver
$uyeler_array= array();  
$uyeler_array['type']= "error";  
echo json_encode($uyeler_array);
}
}
// --ID ile get metodunu uygulayarak verileri alma BITTI  ----------------------------------------------------


// --kullanici ID ile get metodunu uygulayarak verileri alma ----------------------------------
//https://ankaradisprotez.com.tr/api/degerlerServis.php?token=emre&uid=2
if($_SERVER['REQUEST_METHOD'] == "GET" &&  $_GET['uid'] ) {

$uid=$_GET['uid'];

$uyeler = DB::get("SELECT * FROM degerler WHERE userid=$uid"); // mysql baglantisi

if($token==TOKEN){
cors(); // Güvenlik için token olusturduk, bu token'i bilmeden postmande islem yapilamaz!!! Token'i zor yap ;) Token config.php'de tanimli
$uyeler_array= array(); // array olustur
$uyeler_array['Degerler']= $uyeler; // verileri arraye at
echo json_encode($uyeler_array); // json'a çevirip gönder
}
else{ // token olmazsa hata ver
$uyeler_array= array();  
$uyeler_array['type']= "error";  
echo json_encode($uyeler_array);
}
}
// --kullanici ile get metodunu uygulayarak verileri alma BITTI  ----------------------------------------------------


// --get ile bütün verileri siralama ----------------------------------
//https://ankaradisprotez.com.tr/api/degerlerServis.php?token=emre
if($_SERVER['REQUEST_METHOD'] == "GET" &&  !$_GET['did'] &&  !$_GET['uid'] ) {

$degerler = DB::get("SELECT * FROM degerler"); // mysql baglantisi

if($token==TOKEN){ // Güvenlik için token olusturduk, bu token'i bilmeden postmande islem yapilamaz!!! Token'i zor yap ;) TOKEN config.php'de tanimli
cors();
$uyeler_array= array(); // array olustur
$uyeler_array['Degerler']= $degerler; // verileri arraye at 'Degerler' baslikli Koleksiyon olusturacak.
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
 cors();
$metan=$data['metan'];
$butan=$data['butan'];
$propan=$data['propan'];
$temizHava=$data['temizHava'];
$co=$data['co'];
$userid=$data['userid'];
$tarih=$data['tarih'];

DB::insert("INSERT INTO degerler(metan,	butan,	propan,	temizHava,	co,	userid,	tarih	
) VALUES (?, ?, ?, ?, ?, ?, ?)", array($metan, $butan, $propan, $temizHava, $co, $userid, $tarih));
 
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

$did=$data['did'];
$metan=$data['metan'];
$butan=$data['butan'];
$propan=$data['propan'];
$temizHava=$data['temizHava'];
$co=$data['co'];
$userid=$data['userid'];
$tarih=$data['tarih'];

DB::exec('UPDATE degerler SET metan=?,	butan=?,	propan=?,	temizHava=?,	co=?,	userid=?,	tarih=? WHERE did=?',array($metan,$butan,$propan,$temizHava,$co,$userid,$tarih,$did));
 
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

$did=$data['did'];

DB::exec('DELETE FROM degerler WHERE did=?',array($did));
 
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

//---cors izinleri
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
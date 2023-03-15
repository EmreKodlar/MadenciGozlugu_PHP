<?php 

 
include 'config.php';

if($_GET['token']){ $token = $_GET['token'];}

else{$token = $_POST['token'];}

// --Giris Islemi  ----------------------------------------------------
  
if($_SERVER['REQUEST_METHOD'] == "POST") { 

$data=json_decode(file_get_contents('php://input'),true); // gönderilen verileri al

$umail=$data['umail'];
$usifre=$data['usifre'];
 
$uyeler = DB::get('SELECT * FROM uyeler WHERE umail=? AND  usifre=?', array($umail, $usifre));

if(!empty($uyeler)){
if($token==TOKEN){ // Güvenlik için token olusturduk, bu token'i bilmeden postmande islem yapilamaz!!! Token'i zor yap ;) Token config.php'de tanimli
$uyeler_array= array(); // array olustur
$uyeler_array['type']= "success"; 
$uyeler_array['success'] = true;  
$uyeler_array['Uyeler']= $uyeler; // Uyeler koleksiyonundaki verileri arraye at
echo json_encode($uyeler_array) ; // json'a çevirip gönder
}
else{ // token olmazsa hata ver
$uyeler_array= array();  
$uyeler_array['type']= "error T"; 
$uyeler_array['success'] = false;  
echo json_encode($uyeler_array);
}
}
else{
$uyeler_array= array();  
$uyeler_array['type']= "error!"; 
$uyeler_array['success'] = false;  
echo json_encode($uyeler_array);
}
 
 }
 
// --Giris Islemi BITTI ----------------------------------------------------




?>
<?php
 session_start();  
 ?>

<!DOCTYPE html>
<html lang="tr">

<head> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Üye Girişi</title>
</head>


<body topmargin="0">
 
 <div class="container-fluid" style="background-color:#333333">
 
 <div class="row" >
 
 <div class="col-1"></div>
 
  <div class="col-12" lang="tr">
  
  
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
 
 <a class="navbar-brand" href="index.php"><i>Online Gaz Değerleri</i></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
       
      <li class="nav-item">
        <a class="nav-link" href="sirket_listesi.php">Şirket Listesi</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Hakkımızda
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="biz_kimiz.php">Biz Kimiz?</a>
          
          <div class="dropdown-divider"></div>
           <a class="dropdown-item" href="amac.php">Amaç &amp; Fayda</a>
        </div>
      </li>
      
    </ul>
    <form class="form-inline my-2 my-lg-0">
      
      <a class="btn btn-outline-success my-2 my-sm-0" style="color:#FFFFFF" href="uye_girisi.php" >Üye Girişi</a>
    </form>
  </div>
</nav>

 <div class="col-1"></div>


</div>
 
 </div>
 
 </div>
 
 
<div class="container">

<div class="row">
  <div class="col-sm-12" >
  
  <img src="resimler/baret.jpg" width="100%">

  </div>
 </div>
 <br>

 <div class="row">
 
   
   <div class=" col-sm-12  justify-content " >
   
    <H2>ÜYE GİRİŞİ</H2>
   <HR>
   <form method="post" action="uye_girisi.php" name="form1"  >

    <table class="table ">
    <tbody>
        <tr>
            <td><input class="form-control" type="email" name="umail" id="umail"  placeholder="Mail Giriniz..." required /></td>
        </tr>
        <tr>
            <td><input class="form-control" type="password" name="usifre" id="usifre" placeholder="Şifre Giriniz..." required /></td>
        </tr>
        <tr>
            <td><input type="submit"  name="giris" id="giris"  value="GİRİŞ" class="btn btn-warning" /> </td>
        </tr>
        <tr bgcolor="#CCCCCC">
            <td>
        <?php

        if($_POST["giris"]){
	
		// POST verilerini al
  
		 $umail  = $_POST["umail"];
		 $usifre  = $_POST["usifre"];
	 
		
		$postVerileri=array(
		
		'umail' => $umail,
		'usifre' => $usifre   );
  
  		$content=json_encode($postVerileri); // verileri array'e çevir
  
  	    $curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, 'https://madencigozlugu.com.tr/api/loginServis.php?token=emre');
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content); // verileri gönder
		 
		$json_response = curl_exec($curl);
 
		curl_close($curl);

		//gelen cevaba göre verileri çek
		$response = json_decode($json_response, true);
		
		$data = $response['Uyeler']; // bu 'data', apide koleksiyonun adı.
		 
		$sayi= count($response['Uyeler']); // dönen değer sayısı
		 
	 	if($sayi>0){
		/*
		foreach($data as $emre ){
		
		$_SESSION["uid"]=$emre['userid'];
		$_SESSION["uisim"]=$emre['userid'];
		$_SESSION["utel"]=$emre['userid'];
		$_SESSION["isim"]=$emre['userid'];
		
		
		}
		*/
		
		
		
		if($umail=="emre@emre.com"){
		
		$_SESSION["kimlik"]=$umail;
		
		
		header("Refresh:0; url=adminIndex.php");
		}
		else{echo "Yetkisiz Kullanıcı!!!";}
		
		}
		else{
		echo "Hatalı Giriş!!!";
		}
		 
		 
	 
	 
    }

       ?>         
        
        </td>
        </tr>
    </tbody>
   </table>
    
   </form>
   



  </div>
  
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
</body>
</html>
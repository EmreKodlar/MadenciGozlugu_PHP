 <?php
 session_start();
 
 
 ?>

<!DOCTYPE html>
<html lang="tr">

<head> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Online Gaz Değerleri</title>
</head>


<body topmargin="0">
 
 <div class="container-fluid" style="background-color:#333333">
 
 <div class="row" >
 
 <div class="col-1"></div>
 
  <div class="col-12"   lang="tr">
  
  
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
 
  <div class=" table-responsive "  style="background-color:#009966;">
   
  <h4>  &nbsp;>>Kırmızı Şeritte olan değerlerde <b><i>PATLAMA</i></b> riski vardır. Lütfen: 0555 555 55 55 No'lu telefona bildiriniz!</h4>
 <table id="datatable" class="table table-dark table-bordered" style="width:100%; table-layout: fixed; overflow-wrap: break-word; margin-left:auto;
      margin-right:auto; ">
                <thead>
                    <tr>
                       
                        <th>ŞİRKET - İSİM (ID)</th>
                        <th>METAN<br>(Max. 290ppm)</th>
                        <th>PROPAN<br>(Max. 1000ppm)</th>
                        <th>BUTAN<br>(Max. 1000ppm)</th>
                        <th>CO<br>(Max. 400ppm)</th>
                        <th>TEMİZ HAVA<br>(Max. 1000ppm)</th>
                        <th>TARİH</th>
                        
                    </tr>
                </thead>
                <tbody>
                
 
                
                <?php
		$cURLConnection = curl_init();
		curl_setopt($cURLConnection, CURLOPT_URL, "https://madencigozlugu.com.tr/api/degerlerServis.php?token=emre");
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($cURLConnection);
		curl_close($cURLConnection);
		$decoded_json = json_decode($response,true);
  		
		$data = $decoded_json['Degerler']; //  bu 'Degerler', apideki koleksiyonun adı.Örnek: {"Degerler":[{"uid":"1","uisim":"Emre }]}

		 

		foreach($data as $emre) 
		{
		
		   if($emre['metan'] > 290 || $emre['propan'] > 1000 || $emre['butan'] > 1000 || $emre['co'] >400 || $emre['temizHava'] > 1000){ 
		  $renk= " style=background-color:#FF0000" ; 
		   }
		   else  { 
		  $renk= "  " ; 
		 }
		 
		 $cURLConnection2 = curl_init();
		curl_setopt($cURLConnection2, CURLOPT_URL,"https://madencigozlugu.com.tr/api/uyelerServis.php?token=emre&uid=".$emre['userid']);
		curl_setopt($cURLConnection2, CURLOPT_RETURNTRANSFER, true);
		$response2 = curl_exec($cURLConnection2);
		curl_close($cURLConnection2);
		$decoded_json2 = json_decode($response2,true);
		$data2 = $decoded_json2['Uyeler'];
		
		foreach($data2 as $emre2) 
		{
		$isim= $emre2["uisim"];
		
		$cURLConnection3 = curl_init();
		curl_setopt($cURLConnection3, CURLOPT_URL,"https://madencigozlugu.com.tr/api/sirketlerServis.php?token=emre&sid=".$emre2['usirket']);
		curl_setopt($cURLConnection3, CURLOPT_RETURNTRANSFER, true);
		$response3 = curl_exec($cURLConnection3);
		curl_close($cURLConnection3);
		$decoded_json3 = json_decode($response3,true);
		$data3 = $decoded_json3['Sirketler'];
		
		foreach($data3 as $emre3) 
		{
		$sirket= $emre3["sisim"];
		
		}
		}
		 
		   
		
			echo '<tr'. $renk . '>
			<td> '. $sirket . ' - ' . $isim.'('.$emre['userid'].') </td>' . 
			'<td >'. $emre['metan'] . '</td>' . 
			'<td >'. $emre['propan'] . '</td>' . 
			'<td >'. $emre['butan'] . '</td>' . 
			'<td >'. $emre['co'] . '</td>' . 
			'<td >'. $emre['temizHava'] .'</td>' . 
			'<td>'. $emre['tarih'] .'</td>' . 
			'</tr>';
		
		
			
		
		 
		}
		 
			  
			   ?>
	 
                </tbody>
</table>


  </div>
  
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
</body>
</html>

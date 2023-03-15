<?php
/*
*
* Veritabanı bağlantısı için
* gerekli bağlantı bilgilerinin
* bulunduğu ayar dosyası.
*
*/

//NOT: db.php'de herhangi bir şeyi değiştirmeyeceksin..

header('Content-Type: application/json; Charset=UTF-8');
date_default_timezone_set('Europe/Istanbul');

define('MYSQL_HOST',	'localhost');
define('MYSQL_DB',		'madencigozlugu_emre');
define('MYSQL_USER',	'madencigozlugu_emre');
define('MYSQL_PASS',	'alya2021');

define('TOKEN',	'emre'); // APİ GÜVENLİĞİ İÇİN GEREKLİ

// define('BASE_URL',	'https://ankaradisprotez.com.tr/api'); // ana api adresi

include 'db.php';

?>
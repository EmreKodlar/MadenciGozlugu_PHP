<?php
session_start();
 
unset($_SESSION['kimlik']);
session_destroy();

header("Refresh:0; url=index.php");
 
?>
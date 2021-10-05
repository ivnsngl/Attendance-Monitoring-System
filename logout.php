<?php 
// log user out if logout button clicked
   session_start();
   session_destroy(); 
   header('Refresh: 0.4; URL = login.php');
?>
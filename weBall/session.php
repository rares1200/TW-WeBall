<?php

	
   	
    include('config.php');
    session_start();
	$user_check = $_SESSION['login_user'];
   if(!isset($_SESSION['login_user'])){
      header("location:http://students.info.uaic.ro/~rares.nechita/weBall/login.php");
   }
?>
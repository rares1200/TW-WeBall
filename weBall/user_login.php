<?php

include("config.php");
include('models/functions.php');

if($_SERVER["REQUEST_METHOD"]=="POST"){

	$username = mysqli_real_escape_string($db,$_POST['username']);
	$password = mysqli_real_escape_string($db,$_POST['password']);
	
	//echo $username;
	//echo $password;
	$username = make_safe($username);
	$password = make_safe($password);
	$password = trim($password);
	$sql = "SELECT id FROM users WHERE email = '$username' and parola = '$password'";
	//echo $sql;
	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	$count = mysqli_num_rows($result);
	$user = explode("@",$username);
	if($count == 1){
		session_register('username');
		$_SESSION['login_user'] = $user[0];
		
		header("location:user_competitions.php");
	}else{
		$error = "Login failed";
	}
}
?>

<html>
   
   <head>
      <title>Login Page</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form action = "login.php" method = "POST">
                  <label>Email  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Log In "/>
                  <br />
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>



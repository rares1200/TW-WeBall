<?php

include("config.php");
include('models/functions.php');
if(isset($_COOKIE["user"])){
	header("location:index.php");	
}
if($_SERVER["REQUEST_METHOD"]=="POST"){

	$username = mysqli_real_escape_string($db,$_POST['username']);
	$password = mysqli_real_escape_string($db,$_POST['password']);
	
	//echo $username;
	//echo $password;
	$username = make_safe($username);
	$password = make_safe($password);
	$password = trim($password);
	$sql = "SELECT id,type FROM users WHERE email = '$username' and parola = '$password' ";
	//echo $sql;
	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	$count = mysqli_num_rows($result);
	if($count == 1){
		if(!isset($_COOKIE['user'])){
				setcookie("user",$username,time() + (86400 * 3650));
			}else{
				setcookie("user",$username,time() + (86400 * 3650));	
			}
		session_register('username');
		$_SESSION['login_user'] = $username;
		
		if($row['type']==1){
			
			header("location:index_admin.php");
		}else{
			header("location:user_competitions.php");	
		}
	}else{
		$error = "Login failed";
	}
}
?>

<html>
   
   <head>
    <link href="Style.css" rel="stylesheet" type="text/css">
      <title>Login Page</title>
      
      
   </head>
   
 <body>
    
	
      <div class="login">
         
            <div class="login_header"><b>Login</b></div>
				
            <div class="inside_login_box">
               
               <form action = "login.php" method = "POST">
                  <label>Username  <br></label><input type = "text" name = "username" class = "inside_label"/>
				  <br>
                  <label>Parola  <br></label><input type = "password" name = "password" class = "iside_label" />
				  <br>
				  <br>
				  <br>
                  <input type = "submit" value = " Log In "/>
                  <br />
               </form>
               <a href="recuperare_parola.php">Am uitat parola...</a>
			   <br>
			   <br>
			   <a href="register.php">Nu ai cont? Inregistreaza-te!</a>
			   <br>
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            
				
         </div>
			
      </div>
	 
	 <br>
	 <div class="log_page">
		<img  src="Images/minge.gif" alt="animated ball" height=100px width=100px>
		<img  src="Images/home.png" alt="WeBall-Home">
	</div>
	 
   </body>
</html>
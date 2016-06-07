<?

include("config.php");
include('models/functions.php');

if($_SERVER["REQUEST_METHOD"]=="POST"){

	$mail = mysqli_real_escape_string($db,$_POST['username']);
	$passwd = mysqli_real_escape_string($db,$_POST['password']);
	$email_check = true;
	//echo $username;
	//echo $password;
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $mail)) { 
	
	  	$error =  "Invalid email address."; 
		$email_check = false;
	} 
	$mail = make_safe($mail);
	$passwd = make_safe($passwd);
	$passwd = trim($passwd);
	$sql = "SELECT id FROM users WHERE email = '$mail'";
	//echo $sql;
	$result = mysqli_query($db,$sql);
	
	$username = $mail;
	$count = mysqli_num_rows($result);
	if($email_check){
		if($count>0 ){
			$error = "Exista deja un utilizator cu acest email";	
		}else{
			$query = "INSERT INTO users(email,parola) VALUES('$mail','$passwd')"; 
			execute_query($db,$query);	
			setcookie("user",$username,time() + (86400 * 3650));
			session_register('username');
			$_SESSION['login_user'] = $username;
			//header("location:index_admin.php");
			header("location:user_competitions.php");
		}
	}
}
?>

<html>
   
   <head>
    <link href="Style.css" rel="stylesheet" type="text/css">
      <title>Register</title>
      
      
   </head>
   
 <body>
    
	
      <div class="login">
         
            <div class="login_header"><b>Inregistreaza-te!</b></div>
				
            <div class="inside_login_box">
               
               <form action = "login.php" method = "POST">
                  <label>Email  <br></label><input type = "text" name = "username" class = "inside_label"/>
				  <br>
                  <label>Parola  <br></label><input type = "password" name = "password" class = "iside_label" />
				  <br>
				  <br>
				  <br>
                  <input type = "submit" value = " Submit "/>
                  <br />
               </form>
              
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
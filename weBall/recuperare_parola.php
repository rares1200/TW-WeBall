<?php

include('client_controller.php');

if(isset($_POST['send']) && isset($_POST['email'])){
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['email'])){
		$response = "Adresa de email nu este valida";
	}else{
		if(empty($_POST['email'])){
			$response = "Nu ati introdus o adresa de e-mail";	
		}else{
			$response = forgot_pass($_POST['email']);	
		}
	}
	
}else{
	$response = "";	
}


?>

<html>
   
   <head>
    <link href="Style.css" rel="stylesheet" type="text/css">
      <title>Recuperare parola</title>
      
      
   </head>
   
 <body>
    
	
      <div class="login">
         
            <div class="login_header"><b>Recuperare parola!</b></div>
				
            <div class="inside_login_box">

				<form action="" method="post">	
                  <label>Email  <br></label><input type="text" name="email" class = "inside_label"/>
				  <br>
                  <label>Va fi trimis un email pe adresa ta cu parola  <br></label>
                  <input type="submit" value="Trimite" name="send"/>
                  <br />
               </form>
              
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            	
				
         </div>
			
      </div>
	 <?php echo $response;?>
	 <br>
	 <div class="log_page">
		<img  src="Images/minge.gif" alt="animated ball" height=100px width=100px>
		<img  src="Images/home.png" alt="WeBall-Home">
	</div>
    
</body>
</html>


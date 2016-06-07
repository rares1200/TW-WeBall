<?php
include("client_controller.php");
	if(isset($_POST['numecompetitie']) && isset($_POST['nrechipe']) && isset($_POST['nrechipe_calif']) && isset($_POST['sport'])){
	
		$nume_competitie = $_POST['numecompetitie'];
		$nr_echipe = $_POST['nrechipe'];
		$nr_echipe_calif = $_POST['nrechipe_calif'];
		$id_sport = $_POST['sport'];
		$next_page = "location:creaza_competitie2_user.php?nr_echipe=".$nr_echipe."&nume_competitie=".$nume_competitie.
					"&nr_echipe_calif=".$nr_echipe_calif."&sport=".$id_sport
					;
		header($next_page);
	}
	

?>

<html>
<head>
 <link href="Style.css" rel="stylesheet" type="text/css">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<title>
	Creaza competitie
</title> 
</head>
<body>
<section class="title">
   	<img src="Images/minge.gif" alt="animated ball" height=90px width=90px>
	<img src="Images/home.png" alt="WeBall-Home">
	</section>
	
	
	<br>
     
	  <h2 class="welcome">Welcome <?php echo $_COOKIE['user']; ?></h2> 
	
	
	
	    <nav class="meniu">

	<ul>
		
		<li>
			<a href="index.php">Home</a>
		</li>
		
		<li>
			<a href = "competitii.php?page=1">Competitii</a>
		</li>
			
        <li>
        	<a href = "user_competitions.php">Competitiile mele</a>
        </li>
		<?php if(!isset($_COOKIE['user'])){
                echo " <li>
        	 <a href = \"login.php\">Login</a>
        </li>";
        }else{	
			 echo " <li><a href = \"logout.php\">Logout</a>
</li>";
        }?>
		
		
	</ul>
	
	<div class="box">
<form action="" method="post" name="creaza_comp1">
        	<p> 
            	<label>Nume competitie:</label>
                <input type="text" name="numecompetitie"/>
               	<br><br>
                <label>Numarul de echipe</label>
                	<select name="nrechipe">
                        <option value="4">4</option>
                        <option value="8">8</option>
                        <option value="16">16</option>
                        <option value="32">32</option>
                    </select>
                 <br><br>
                <label>Numarul de echipe calificate din grupa</label>
                	<select name="nrechipe_calif">
                    	<option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                    <br><br>
               
               
               <label>Sport:</label>
               		<input type="text" name="sport"/>                    
               <input type = "submit" value = " Continua "/><br />
                
            </p>       
 	
</form>
</div>

</body>
</html>
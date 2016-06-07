<?php
include('client_controller.php');


$id_comp = $_GET['id_comp'];

if(isset($_GET['id_comp']) && isset($_GET['actualizare_g'])){
		echo update_competition_groups_user($_GET['id_comp']);
	}
	
	if(isset($_GET['id_comp']) && isset($_GET['actualizare_c'])){
		echo update_competition_knockout_user($_GET['id_comp']);
	}

?>

<html>
<head>
 <link href="Style.css" rel="stylesheet" type="text/css">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<title>
	Competitie
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
		<?php if(isset($_COOKIE['user'])){
			 		echo show_groups_user($id_comp);
					?>
                    
         <form><br />
	<input type="hidden" name="id_comp" value="<?php echo $id_comp ?>"/>
    <input type="hidden" name="actualizare_g" value="a"/>
    <input type="submit" value="Actualizare grupa"/>
</form>
	
<form>

	<input type="hidden" name="id_comp" value="<?php echo $id_comp ?>"/>
    <input type="hidden" name="actualizare_c" value="a"/>
    <input type="submit" value="Actualizare competitie"/>

</form>
<?php

					echo show_knockout_user($id_comp);	
				echo "<a href=\"groups_csv.php?id_comp=".urlencode($id_comp)."\">CSV_GRUPE</a><br>";
				echo "<a href=\"knockout_csv.php?id_comp=".urlencode($id_comp)."\">CSV_FAZA_ELIMINATORIE</a><br>";
				echo "<a href=\"grupe_json.php?id_comp=".urlencode($id_comp)."\">JSON_GRUPE</a><br>";
				echo "<a href=\"knockout_json.php?id_comp=".urlencode($id_comp)."\">JSON_FAZA_ELIMINATORIE</a><br>";
				echo "<a href=\"grupe_pdf.php?id_comp=".urlencode($id_comp)."\">PDF</a><br>";
		}
				
		?>	
        </div>
    </body>
</html>
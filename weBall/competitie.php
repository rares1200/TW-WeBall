<?php
include("client_controller.php");
		$id_comp = $_GET['id_comp'];
?>

<html>
<head>
<title>Competitie</title>
<link href="Style.css" rel="stylesheet" type="text/css">
</head>
    <body>
	
	<section class="title">
   	<img src="Images/minge.gif" alt="animated ball" height=90px width=90px>
	<img src="Images/meciuri.png" alt="WeBall-Home">
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
		
		
	</ul><br>
	
	
	<div class="box">
	<br>
		<?php echo "<br>".show_groups($id_comp)."<br>";
				echo show_knockout($id_comp);	
				echo "<a href=\"groups_csv.php?id_comp=".urlencode($id_comp)."\">CSV_GRUPE</a><br>";
				echo "<a href=\"knockout_csv.php?id_comp=".urlencode($id_comp)."\">CSV_FAZA_ELIMINATORIE</a><br>";
				echo "<a href=\"grupe_json.php?id_comp=".urlencode($id_comp)."\">JSON_GRUPE</a><br>";
				echo "<a href=\"knockout_json.php?id_comp=".urlencode($id_comp)."\">JSON_FAZA_ELIMINATORIE</a><br>";
				echo "<a href=\"grupe_pdf.php?id_comp=".urlencode($id_comp)."\">PDF</a><br>";
				echo "<a href=\"atom.php?id_comp=".urlencode($id_comp)."\">Flux Atom</a><br>";
		?>	
        
	</div>
		
    </body>
</html>
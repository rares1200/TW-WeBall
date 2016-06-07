<?php
include("../admin_controller.php");
if($_COOKIE["user"]=="rares" || $_COOKIE["user"]=="bianca" || $_COOKIE["user"]=="sergiu"){

	if(isset($_POST['numecompetitie']) && isset($_POST['nrechipe']) && isset($_POST['nrechipe_calif']) && isset($_POST['sport'])){
	
		$nume_competitie = $_POST['numecompetitie'];
		$nr_echipe = $_POST['nrechipe'];
		$nr_echipe_calif = $_POST['nrechipe_calif'];
		$id_sport = $_POST['sport'];
		$next_page = "location:creaza_competitie2.php?nr_echipe=".$nr_echipe."&nume_competitie=".$nume_competitie.
					"&nr_echipe_calif=".$nr_echipe_calif."&sport=".$id_sport
					;
		header($next_page);
	}
	

?>

<html>
<head>
<link href="Style.css" rel="stylesheet" type="text/css">
<title>Creaza competitie</title>
</head>
<body>

<section class="title">
   	<img src="Images/minge.gif" alt="animated ball" height=90px width=90px>
	<img src="Images/competitii.png" alt="WeBall-Home">
	</section>
	<br>
	<nav class="meniu">
	
	<ul>
	
		<li>
			<a href="http://students.info.uaic.ro/~rares.nechita/weBall/index_admin.php">Administratori</a>
		</li>
		
		<li>
			<a href="http://students.info.uaic.ro/~rares.nechita/weBall/gestiune.php">Gestiune</a>
		</li>
		
		<li>
			<a href="creaza_competitie.php">Creaza competitie</a>
		</li>
		
		 <li>
        	 <a href = "http://students.info.uaic.ro/~rares.nechita/weBall/logout.php">Logout</a>
        </li>
		
	</ul>
	</nav>

	<div class="box">
<form action="" method="post" name="creaza_comp1">
        	<h1> 
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
               		<select name="sport">
                    	<?php echo get_all_sports();} ?>
                    </select><br>
                    
               <input type = "submit" value = " Continua "/><br />
                
            </h1>       
 	
</form>
</div>

</body>
</html>
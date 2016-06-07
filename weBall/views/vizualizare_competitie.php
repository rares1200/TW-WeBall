<?php

if($_COOKIE["user"]=="rares" || $_COOKIE["user"]=="bianca" || $_COOKIE["user"]=="sergiu"){
include("../config.php");

include("../admin_controller.php");

	if(isset($_GET['id_comp'])){
		$id_comp = $_GET['id_comp'];
	}else{
			
	}
	if(isset($_GET['id_comp']) && isset($_GET['actualizare_g'])){
		echo update_groups($_GET['id_comp']);
	}
	
	if(isset($_GET['id_comp']) && isset($_GET['actualizare_c'])){
		echo update_knockout($_GET['id_comp']);
	}
?>

<html>
<head>
<link href="Style.css" rel="stylesheet" type="text/css">
<title>Vizualizare Competitie</title>
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

<?php echo show_groups($_GET['id_comp']); ?> 

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

<h2> <?php echo show_knockout($id_comp);}?></h2>

</div>

</body>
</html>
<?php

if($_COOKIE["user"]=="rares" || $_COOKIE["user"]=="bianca" || $_COOKIE["user"]=="sergiu"){
include("../config.php");
include("../admin_controller.php");

	if(isset($_GET['id_comp']) && isset($_GET['grupa'])){
		$id_comp = $_GET['id_comp'];
		$grupa = $_GET['grupa'];
		$output_matches = get_matches_from_group($id_comp,$grupa);
	
	}
	
	if(isset($_GET['id_comp']) && isset($_GET['actualizeaza']) && isset($_GET['grupa'])){
		$id_comp = $_GET['id_comp'];
		$grupa = $_GET['grupa'];
		echo update_group($id_comp,$grupa);	
	}
?>

<html>
<head>
<link href="Style.css" rel="stylesheet" type="text/css">
<title>Competitii</title>
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

<?php echo $output_matches; ?>
<form>
	<input type = "hidden" name = "actualizeaza" value = "a"/>
    <input type = "hidden" name = "id_comp" value = "<?php echo $id_comp;?>"/>
    <input type = "hidden" name = "grupa" value = "<?php echo $grupa;}?>"/>
 	<input type="submit" value="Actualizeaza grupa"/><br>
</form>

</div>
</body>
</html>
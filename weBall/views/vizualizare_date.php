<?php
include("../config.php");
include("../admin_controller.php");
if($_COOKIE["user"]=="rares" || $_COOKIE["user"]=="bianca" || $_COOKIE["user"]=="sergiu"){


?>

<html>
<head>
<title>Competitii</title>
<link href="Style.css" rel="stylesheet" type="text/css">
</head>
<body>

<section class="title">
   	<img src="Images/minge.gif" alt="animated ball" height=90px width=90px>
	<img src="Images/competitii.png" alt="WeBall-Home">
	</section>

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
	
<?php echo get_all_competitions();}?>




	</div>

</body>
</html>





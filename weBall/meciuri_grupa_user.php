<?php

include("client_controller.php");

$id_comp = $_GET['id_comp'];
$grupa = $_GET['grupa'];

if(isset($_GET['id_comp']) && isset($_GET['actualizeaza']) && isset($_GET['grupa'])){
		$id_comp = $_GET['id_comp'];
		$grupa = $_GET['grupa'];
		echo update_group_user($id_comp,$grupa);	
	}

?>

<html>
<head>
 <link href="Style.css" rel="stylesheet" type="text/css">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<title>
	Meciuri grupa
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
<?php echo get_matches_from_group_user($id_comp,$grupa);?>
<br>
<form>
	<input type = "hidden" name = "actualizeaza" value = "a"/>
    <input type = "hidden" name = "id_comp" value = "<?php echo $id_comp;?>"/>
    <input type = "hidden" name = "grupa" value = "<?php echo $grupa;?>"/>
 	<input type="submit" value="Actualizeaza grupa"/><br>
</form>

</div>
</body>
</html>
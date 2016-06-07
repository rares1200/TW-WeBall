<?php
//include('session.php');
include("client_controller.php");
if(!isset($_COOKIE['user'])){
	
	echo "Trebuie sa fii logat pentru a vedea competitiile tale<br><a href=	\"login.php\">Log In</a>"; 	
}else{
echo "Welcome ".$_COOKIE['user']."<br>";
echo "<a href=\"logout.php\">Logout</a>";

if(isset($_POST['creaza_comp'])){
	header("location:creaza_competitie_user.php");
}


	
?>

<html>
<head>
 <link href="Style.css" rel="stylesheet" type="text/css">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<title>
	Competitiile mele
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

<form action="" method="post">
<label>Echipa</label>
<input type="text" name="comp_name"/>
<input type="submit" name="search" value="Cauta"/>

<form action="" method="post">
<input type="submit" name="creaza_comp" value="Creaza competitie"/>
</form>

<br>

<?php
	if(!isset($_POST['search'])){
	 	echo get_user_competitions($_COOKIE['user']);
	}else{
		if(!isset($_POST['comp_name']) || empty($_POST['comp_name'])){
			echo "Nu ati introdus niciun nume";
			echo get_user_competitions($_COOKIE['user']);	
		}else{
			//echo $_POST['comp_name'];
			echo get_search_comp($_POST['comp_name'],"private");
		}	
	}
}?>
</div>
</body>
</html>
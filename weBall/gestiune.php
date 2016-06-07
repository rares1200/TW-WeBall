<?php

include('config.php');
include("admin_controller.php");
if($_COOKIE['user']=="rares" || $_COOKIE['user']=="bianca" || $_COOKIE['user']=="sergiu"){
	
if(isset($_GET['nume_echipa']) && isset($_GET['sport'])){

	$nume = $_GET['nume_echipa'];
	$id_sport = $_GET['sport'];
	$query = "INSERT INTO echipe(nume,sport) VALUES('$nume','$id_sport')";
	if(!mysqli_query($db,$query)){
			echo $query."<br>"; //DEVELOPMENTAL 	
		}
		else{
			header("location:http://students.info.uaic.ro/~rares.nechita/weBall/gestiune.php");
		}
	
	
}

if(isset($_GET['cauta_echipa'])){
	
	$echipa = $_GET['cauta_echipa'];
	
	$query = "SELECT id,nume FROM echipe WHERE nume LIKE '%$echipa%'";
	$res = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
		echo $row['id']."-".$row['nume']."<br>";
	}
}

if(isset($_GET['id_echipa'])){
	$id_echipa = $_GET['id_echipa'];
	$query = "DELETE FROM echipe WHERE id='$id_echipa'";
	if(!mysqli_query($db,$query)){
		echo $query."<br>"; //DEVELOPMENTAL 	
	}
	else{
		header("location:http://students.info.uaic.ro/~rares.nechita/weBall/gestiune.php");
	}
}

if(isset($_GET['id_comp'])){
	$id_comp = $_GET['id_comp'];
	$query = "DELETE FROM competitii_test WHERE id='$id_comp'";
	if(!mysqli_query($db,$query)){
		echo $query."<br>"; //DEVELOPMENTAL 	
	}
	else{
		header("location:http://students.info.uaic.ro/~rares.nechita/weBall/gestiune.php");
	}
}

if(isset($_GET['new_sport'])){
	$sport = $_GET['new_sport'];
	
	$query = "INSERT INTO sporturi(denumire) VALUES('$sport')";
	if(!mysqli_query($db,$query)){
		echo $query."<br>"; //DEVELOPMENTAL 	
	}
	else{
		header("location:http://students.info.uaic.ro/~rares.nechita/weBall/gestiune.php");
	}
}



?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="Style.css" rel="stylesheet" type="text/css">
<title>Gestiune</title>
</head>
<body>

<section class="title">
   	<img src="Images/minge.gif" alt="animated ball" height=90px width=90px>
	<img src="Images/gestiune.png" alt="WeBall-Home">
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
			<a href="http://students.info.uaic.ro/~rares.nechita/weBall/views/creaza_competitie.php">Creaza competitie</a>
		</li>
		
		 <li>
        	 <a href = "http://students.info.uaic.ro/~rares.nechita/weBall/logout.php">Logout</a>
        </li>
		
	</ul>
	</nav>

	<div class="box">
	<p> Adauga echipa</p>
    <form>
    	<label>Nume</label>
        <input type="text" name="nume_echipa"/>
        <label>Sport</label>
        
        <select name="sport">
        	<?php echo get_all_sports();?>
        </select>
    
    	<input type = "submit" value = " Adauga echipa "/><br />
    </form>
    
    <p> Afiseaza echipa </p>
    
    <form>
    	<label> Nume echipa</label>
        <input type="text" name= "cauta_echipa"/>
        <input type="submit" value="Afiseaza echipa"/>
    </form>
    
    <p> Sterge echipa </p>
    
    <form> 
    	<label> Id echipa </label>
        <input type="number" name = "id_echipa" />
        <input type="submit" value="Sterge echipa"/>
    </form>
    
    <p> Sterge competitie </p>
    
    <form>
    	<label> Id competitie </label>
        <input type="number" name = "id_comp" />
        <input type="submit" value="Sterge competitie"/>
    </form>
    
    <p> Adauga sport </p>
    <form>
    	<label>Nume sport</label>
        <input type="text" name = "new_sport"/>
        <input type="submit" value=" Adauga sport " /><br>   
    </form>
    
     <?php }
		else{
			//echo $_COOKIE["user"];
			header("location:index.php");	
		}?>
        </div>
</body>
</html>
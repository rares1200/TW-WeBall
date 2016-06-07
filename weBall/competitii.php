<?php

include("client_controller.php");
if(!isset($_GET['page'])){
	$page = 1;
}else{
	$page = $_GET['page'];
}
$count = get_competition_count();
//echo "PAGE:".$page;
?>

<html>
<head>
 <link href="Style.css" rel="stylesheet" type="text/css">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<title>
	Competitii
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
<label>Competitie:</label>
<input type="text" name="comp_name"/>
<input type="submit" name="search" value="Cauta"/>

</form>
<?php


	if(!isset($_POST['search'])){
 		echo get_competitions($page);
	$output = get_competitions($page);
	if(!empty($output)){
			for($i=$_GET['page'];$i<=$count/50;$i++)
				if(($i-1)>0){
					echo "<a href=\"http://students.info.uaic.ro/~rares.nechita/weBall/competitii.php?page=".($i-1)."\">".($i-1)."</a>"."  ";
				}
			for($i=$_GET['page'];$i<=$count/50;$i++) 
				echo "<a href=\"http://students.info.uaic.ro/~rares.nechita/weBall/competitii.php?page=".($i+1)."\">".($i+1)."</a>"."  ";
			}
	}else{
		if(!isset($_POST['comp_name']) || empty($_POST['comp_name'])){
			echo "Nu ati introdus niciun nume";
			echo get_competitions($page);		
		}else{
			//echo $_POST['comp_name'];
			echo get_search_comp($_POST['comp_name'],"public");
		}
	}
	
	
	?>
    </div>	        

</body>
</html>
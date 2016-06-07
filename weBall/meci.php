<?php

include("client_controller.php");

	if(isset($_GET['id_meci']) && isset($_GET['echipa1']) && isset($_GET['echipa2'])){
		$id_meci = $_GET['id_meci'];
		$echipa1 = $_GET['echipa1'];
		$echipa2 = $_GET['echipa2'];
		$id_comp = $_GET['id_comp'];
		//echo get_comments($id_meci);
	}
	//echo "<table>".get_comments($id_meci)."</table>";
	if(isset($_POST['send_comment'])){
		if(!isset($_POST['user']) || empty($_POST['user'])){
			echo "Introduceti un nume";
		}else if(!isset($_POST['comment'])||empty($_POST['comment'])){
			echo "Introduceti mesajul";	
		}else{
			add_comment($id_meci,$_POST['user'],$_POST['comment']);	
			header("location:http://students.info.uaic.ro/~rares.nechita/weBall/meci.php?id_comp=".$id_comp."&id_meci=".$id_meci."&echipa1=".$echipa1."&echipa2=".$echipa2);
		}
	}
		

?>

<html>
<head>
 <link href="Style.css" rel="stylesheet" type="text/css">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<title>
	Meci
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

<table class="tabel">
<br>
<?php
	echo get_match_date($id_meci);
	 echo get_match_header($id_meci);
	echo get_events($id_meci,$echipa1,$echipa2); ?>
</table>
	
<br>
<br>
<table class="tabel">
<tr><td>

<form action="" method="post">
	<label>Nume</label><br>
    <input type="text" name="user"/><br>
    <label>Comentariu</label><br>
    <textarea name="comment" rows="5" cols="70"></textarea>
    <input type = "hidden" name = "send_comment" value = "a"/>
    <br>
    <input type = "submit" value = " Trimite comentariul "/><br />
</form>
</td></tr></table>

<br>
<br>

<?php 
	//echo $_COOKIE[$id_meci];
	if($_COOKIE[$id_meci]==1){
		echo get_poll_results($id_meci);
	}else{
		echo get_poll($id_meci);
	}?>

<br>
<table class="tabel">

<?php echo get_comments($id_meci);?>



</table>
</div>
</body>
</html>
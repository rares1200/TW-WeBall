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
			header("location:http://students.info.uaic.ro/~rares.nechita/weBall/meci_user.php?id_comp=".$id_comp."&id_meci=".$id_meci."&echipa1=".$echipa1."&echipa2=".$echipa2);
		}
	}
		

?>

<html>
<head><title>Meci</title>
</head>
<body>
<table border="1">
<?php
	echo get_match_date($id_meci);
	 echo get_match_header($id_meci);
	echo get_events($id_meci,$echipa1,$echipa2); ?>
</table>
<br>
<br>
<table border="1">
<tr><td>

<form action="" method="post">
	<label>Nume</label>
    <input type="text" name="user"/><br>
    <label>Comentariu</label><br>
    <textarea name="comment" rows="5" cols="200"></textarea>
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
<table border="1">

<?php echo get_comments($id_meci);?>

</table>
</body>
</html>
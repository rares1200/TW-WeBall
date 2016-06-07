<?php
include('client_controller.php');
include('config.php');
	
	if(isset($_POST['submit']) && isset($_POST['r']) && isset($_POST['id_meci'])){
		
		$query  = "SELECT id_competitie,echipa1,echipa2 FROM meciuri WHERE id = '".$_POST['id_meci']."'"; 
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$id_comp = $row['id_competitie'];
			$e1 = $row['echipa1'];
			$e2 = $row['echipa2'];
		}
		if(vote($_POST['r'],$_POST['id_meci'])){
			setcookie($_POST['id_meci'],'1',time() + (86400*3650));
			header("location:meci.php?id_comp=".$id_comp."&id_meci=".$_POST['id_meci']."&echipa1=".$e1."&echipa2=".$e2);
		}
		
			
	}


?>
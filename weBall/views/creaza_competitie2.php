<?php
if($_COOKIE["user"]=="rares" || $_COOKIE["user"]=="bianca" || $_COOKIE["user"]=="sergiu"){
include("../config.php");
include("../admin_controller.php");
$nr_echipe = $_GET['nr_echipe'];
$nume_competitie = $_GET['nume_competitie'];
$nr_echipe_calif = $_GET['nr_echipe_calif'];
$id_sport = $_GET['sport'];

if(isset($_POST['echipa1'])){
	$check = true;
	for($i=1;$i<=$nr_echipe;$i++){
		$post_param = "echipa".$i;
		if(!$_POST[$post_param]){
			echo "NOT OK NOT POST";
			$check=false;
		}
	}
	for($i=1;$i<=$nr_echipe-1;$i++)
		for($j=2;$j<$nr_echipe;$j++)
			if($i!=$j){
				$post_param1 = "echipa".$i;
				$post_param2 = "echipa".$j;
				//echo $i." ->".$j;
				//echo $_POST[$post_param]." ".$_POST[$post_param2]."<br>";
				if($_POST[$post_param] == $_POST[$post_param2]){
					echo "NOT OK"."<br>";	
					$check=false;
				}

			}
	if($check){
		$query = "INSERT INTO competitii_test(nume,nr_echipe,id_sport,nr_echipe_calificate) VALUES('$nume_competitie',$nr_echipe,$id_sport, $nr_echipe_calif)";
		
		if(!mysqli_query($db,$query))
			echo $query."<br>";
		else
			echo "INSERARE CU SUCCES!!!<br>";
			
		$id_comp = get_comp_ID($db);
		$grupa = "A";
		for($i=1;$i<=$nr_echipe;$i+=4){
				$post_param1 = "echipa".$i;
				$post_param2 = "echipa".($i+1);
				$post_param3 = "echipa".($i+2);
				$post_param4 = "echipa".($i+3);
				$echipa1 = $_POST[$post_param1];
				$echipa2 = $_POST[$post_param2];
				$echipa3 = $_POST[$post_param3];
				$echipa4 = $_POST[$post_param4];
				echo $echipa1." ".$echipa2." ".$echipa3." ".$echipa4."<br>";
				if($i==5)
					$grupa = "B";
				if($i==9)
					$grupa = "C";
				if($i==13)
					$grupa = "D";
				if($i==17)
					$grupa = "E";
				if($i==21)
					$grupa = "F";
				if($i==25)
					$grupa = "G";
				if($i==29)
					$grupa = "H";
				
				
				$query = "INSERT INTO echipe_participante (id_competitie,nume,faza_competitie,grupa) VALUES ('$id_comp','$echipa1','G','$grupa')";
				if(!mysqli_query($db,$query))
					echo $query."<br>";
				else
					echo "INSERARE CU SUCCES!!!<br>";
					
					
					
				$query = "INSERT INTO echipe_participante (id_competitie,nume,faza_competitie,grupa) VALUES ('$id_comp','$echipa2','G','$grupa')";
				if(!mysqli_query($db,$query))
					echo $query."<br>";
				else
					echo "INSERARE CU SUCCES!!!<br>";
					
				$query = "INSERT INTO echipe_participante (id_competitie,nume,faza_competitie,grupa) VALUES ('$id_comp','$echipa3','G','$grupa')";
				if(!mysqli_query($db,$query))
					echo $query."<br>";
				else
					echo "INSERARE CU SUCCES!!!<br>";
				
				
				$query = "INSERT INTO echipe_participante (id_competitie,nume,faza_competitie,grupa) VALUES ('$id_comp','$echipa4','G','$grupa')";
				if(!mysqli_query($db,$query))
					echo $query."<br>";
				else
					echo "INSERARE CU SUCCES!!!<br>";
					
					
				//inserare meciuri
				
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa1','$echipa2',-1,-1,'G','$grupa')";
					if(!mysqli_query($db,$query))
						echo $query."<br>";
					else
						echo "INSERARE CU SUCCES!!!<br>";	
						
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa1','$echipa3',-1,-1,'G','$grupa')";
					if(!mysqli_query($db,$query))
						echo $query."<br>";
					else
						echo "INSERARE CU SUCCES!!!<br>";
						
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa1','$echipa4',-1,-1,'G','$grupa')";
					if(!mysqli_query($db,$query))
						echo $query."<br>";
					else
						echo "INSERARE CU SUCCES!!!<br>";
						
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa2','$echipa3',-1,-1,'G','$grupa')";
					if(!mysqli_query($db,$query))
						echo $query."<br>";
					else
						echo "INSERARE CU SUCCES!!!<br>";
					
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa2','$echipa4',-1,-1,'G','$grupa')";
					if(!mysqli_query($db,$query))
						echo $query."<br>";
					else
						echo "INSERARE CU SUCCES!!!<br>";
						
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa3','$echipa4',-1,-1,'G','$grupa')";
					if(!mysqli_query($db,$query))
						echo $query."<br>";
					else
						echo "INSERARE CU SUCCES!!!<br>";	
					
				if($i==1){
					if($nr_echipe/4*$nr_echipe_calif==16){ 
						echo "16";
						for($j=1;$j<=8;$j++){
							$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie) 				                                                           VALUES ('$id_comp','','',-1,-1,'O".$j."')";
							$status = execute_query($db,$query);	
						}
					}
					if($nr_echipe/4*$nr_echipe_calif==8){
						echo "8";
						for($j=1;$j<=4;$j++){
							$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie) 				                                                           VALUES ('$id_comp','','',-1,-1,'S".$j."')";
							$status = execute_query($db,$query);
						}
					}
					if($nr_echipe/4*$nr_echipe_calif==4){
						echo "4";
						for($j=1;$j<=2;$j++){
							$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie) 				                                                           VALUES ('$id_comp','','',-1,-1,'SF".$j."')";
							$status = execute_query($db,$query);	
						}
					}
					
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie) 				                                                           VALUES ('$id_comp','','',-1,-1,'FIN')";
						$status = execute_query($db,$query);
					
				}
				
				//meciuri inserate
				
				
											
		}
	}
	$query = "SELECT id,faza_competitie FROM meciuri ORDER BY id_competitie='$id_comp'";
				$result = mysqli_query($db,$query);
				while($rowe = mysqli_fetch_array($result,MYSQLI_ASSOC)){
						$id_meci = $rowe['id'];
						$faza = $rowe['faza_competitie'];
						if($faza != "G"){
							$new_query = "UPDATE competitii_test SET ".$faza."='".$id_meci."' WHERE id='$id_comp'";
							if(!mysqli_query($db,$new_query))
								echo $new_query."<br>";
							else
								echo "UPDATE MECI CU SUCCES!!!<br>";
						}
				}
}


?>



<html>
<head>
<link href="Style.css" rel="stylesheet" type="text/css">
<title>Creaza competitie</title>
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

<form action="" method="post" name="creaza_comp2">
        	<h1>Echipe participante:<br />
            	<?php for($i=1;$i<=$nr_echipe;$i++){
                		echo "Echipa ".$i.": ".get_all_teams($i,$id_sport)."<br>"; 
                  }}?>
                   <input type = "submit" value = " Creaza competitie "/><br />
                 <br>
            </h1>       

</form>

</div>
</body>
</html>
<?php
include("config.php");
$nr_echipe = $_GET['nr_echipe'];
$nume_competitie = $_GET['nume_competitie'];
$nr_echipe_calif = $_GET['nr_echipe_calif'];
$id_sport = $_GET['sport'];

$GLOBALS['conn'] = $db;
	function execute_query($db,$query){
		if(!mysqli_query($db,$query)){
			//echo $query."<br>"; //DEVELOPMENTAL 
			return false;	
		}
		else{
			//echo "QUERY EXECUTAT CU SUCCES!!!<br>";
			return true;
		}	
	}
	
	function make_safe($param){
	
		$safe_param = mysqli_real_escape_string($GLOBALS['conn'],$param);
		$safe_param = htmlentities($safe_param);
		return $safe_param;
		
	}

function getCompIDUser($db){
			$query = "SELECT id FROM competitii_test ORDER BY id desc";
			$res = mysqli_query($db,$query);
			while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
					$id_comp = $row['id'];
					break;
			}
			return $id_comp;
	}

if(isset($_POST['echipa1'])){
	$check = true;
	for($i=1;$i<=$nr_echipe;$i++){
		$post_param = "echipa".$i;
		if(!$_POST[$post_param]){
			echo "Echipele sunt identice";
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
					echo "Echipele sunt identice<br>";
					$check=false;
				}

			}
	if($check){
		
		$query = "INSERT INTO competitii_test(nume,nr_echipe,id_sport,nr_echipe_calificate) VALUES('$nume_competitie',$nr_echipe,'$id_sport', $nr_echipe_calif)";
		//echo $query;
		if(execute_query($db,$query)){
			echo "Competitie creata cu succes";	
		}else{
			echo "Competitia nu a fost creata";	
		}
			
		$id_comp = getCompIDUser($db);
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
				//echo $echipa1." ".$echipa2." ".$echipa3." ".$echipa4."<br>";
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
				if(!mysqli_query($db,$query)){echo "A aparut o eroare a crearea competitiei";}
					//echo $query."<br>";
				else{
						
				}
					//echo "INSERARE CU SUCCES!!!<br>";
					
					
					
				$query = "INSERT INTO echipe_participante (id_competitie,nume,faza_competitie,grupa) VALUES ('$id_comp','$echipa2','G','$grupa')";
				if(!mysqli_query($db,$query)){echo "A aparut o eroare a crearea competitiei";}
					//echo $query."<br>";
				else{
						
				}
					
				$query = "INSERT INTO echipe_participante (id_competitie,nume,faza_competitie,grupa) VALUES ('$id_comp','$echipa3','G','$grupa')";
				if(!mysqli_query($db,$query)){echo "A aparut o eroare a crearea competitiei";}
					//echo $query."<br>";
				else{
						
				}
				
				
				$query = "INSERT INTO echipe_participante (id_competitie,nume,faza_competitie,grupa) VALUES ('$id_comp','$echipa4','G','$grupa')";
				if(!mysqli_query($db,$query)){echo "A aparut o eroare a crearea competitiei";}
					//echo $query."<br>";
				else{
						
				}
					
					
				//inserare meciuri
				
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa1','$echipa2',-1,-1,'G','$grupa')";
					if(!mysqli_query($db,$query)){echo "A aparut o eroare a crearea competitiei";}
					//echo $query."<br>";
				else{
						
				}
						
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa1','$echipa3',-1,-1,'G','$grupa')";
					if(!mysqli_query($db,$query)){echo "A aparut o eroare a crearea competitiei";}
					//echo $query."<br>";
				else{
						
				}
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa1','$echipa4',-1,-1,'G','$grupa')";
					if(!mysqli_query($db,$query)){echo "A aparut o eroare a crearea competitiei";}
					//echo $query."<br>";
				else{
						
				}
						
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa2','$echipa3',-1,-1,'G','$grupa')";
					if(!mysqli_query($db,$query)){echo "A aparut o eroare a crearea competitiei";}
					//echo $query."<br>";
				else{
						
				}
					
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa2','$echipa4',-1,-1,'G','$grupa')";
					if(!mysqli_query($db,$query)){echo "A aparut o eroare a crearea competitiei";}
					//echo $query."<br>";
				else{
						
				}
						
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa3','$echipa4',-1,-1,'G','$grupa')";
					if(!mysqli_query($db,$query)){echo "A aparut o eroare a crearea competitiei";}
					//echo $query."<br>";
				else{
						
				}
					
				if($i==1){
					if($nr_echipe/4*$nr_echipe_calif==16){ 
						//echo "16";
						for($j=1;$j<=8;$j++){
							$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie) 				                                                           VALUES ('$id_comp','','',-1,-1,'O".$j."')";
							$status = execute_query($db,$query);	
						}
					}
					if($nr_echipe/4*$nr_echipe_calif==8){
						//echo "8";
						for($j=1;$j<=4;$j++){
							$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie) 				                                                           VALUES ('$id_comp','','',-1,-1,'S".$j."')";
							$status = execute_query($db,$query);
						}
					}
					if($nr_echipe/4*$nr_echipe_calif==4){
						//echo "4";
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
							if(!mysqli_query($db,$new_query)){echo "A aparut o eroare a crearea competitiei";}
					//echo $query."<br>";
							else{
									
							}
						}
				}
}


?>



<html>
<head>
 <link href="Style.css" rel="stylesheet" type="text/css">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<title>
	Creaza competitie
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


<form action="" method="post" name="creaza_comp2">
        	<p>Echipe participante:<br />
            	<?php for($i=1;$i<=$nr_echipe-1;$i++){
                		echo "<input type=\"text\" name=\"echipa".$i."\"/><br>"; 
                  }
				  	echo "<input type=\"hidden\" name=\"echipa".$nr_echipe."\" value=\"".$_COOKIE["user"]."\"/ ><br>";
				  ?>
                   <input type = "submit" value = " Creaza competitie "/><br />
                 <br>
            </p>       

</form>

</div>

</body>
</html>
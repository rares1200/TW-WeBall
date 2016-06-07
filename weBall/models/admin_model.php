<?php

include('../config.php');
include('functions.php');
$GLOBALS['conn']=$db;
	// FUNCTIE CARE PREIA TOATE COMPETITIILE SUB FORMA DE TABELE
	function getAllCompetitions($db){
		$query = "SELECT * FROM competitii_test ORDER BY id desc"; 
		$res = mysqli_query($db,$query);
		
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
				$output .="<a href=\"vizualizare_competitie.php?id_comp=".$row['id']."\">";
				$output .="<table class=\"tabel_user\">";
				$output .="<tr><td>ID</td><td>Nume</td><td>Numar echipe</td><td>Numar echipe calificate</td>";
				$output .="<tr>";
				$output .="<td>".$row['id']."</td>";
				$output .="<td>".$row['nume']."</td>";
				$output .="<td>".$row['nr_echipe']."</td>";
				$output .="<td>".$row['nr_echipe_calificate']."</td>";
				$output .="</tr>";
				$output .="</table></a>";
				$output .="<br>";
		}
		
		return $output;
	}

	// FUNCTIE CARE RETURNEAZA CASTIGATORUL UNUI MECI
	function get_winner($db,$id_comp,$faza){
		
		$id_comp = make_safe($id_comp);
		$faza = make_safe($faza);
	
		$query = "SELECT ".$faza." FROM competitii_test WHERE id='$id_comp'";
		////echo $query;
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$id_meci = $row[$faza];	
		}
		////echo $id_meci;
		$query = "SELECT * FROM meciuri WHERE id='$id_meci'";
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$gol1 = $row['goluri_echipa1'];	
			$gol2 = $row['goluri_echipa2'];
			if($gol1>$gol2){
				////echo $row['echipa1'];
				return $row['echipa1'];
			}
			else if($gol2>$gol1){
				////echo $row['echipa2'];
				return $row['echipa2'];
			}
		} 
		return " ";
	}
	
	
	function showGroups($db,$id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM competitii_test WHERE id = '$id_comp'";
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$nr_echipe = $row['nr_echipe'];
			$echipe_calif = $row['nr_echipe_calificate'];
			
		}
		////echo $nr_echipe." ".$echipe_calif."<br>";
		
		$query = "SELECT * FROM echipe_participante WHERE id_competitie = '$id_comp' ORDER BY grupa,puncte DESC";
		$res = mysqli_query($db,$query);
		$group_change = "A";
		$pos = 1;
		$output .= "<a href =\"meciuri_grupa.php?id_comp=".$id_comp."&grupa=A\">";
		$output .="<table class=\"tabel\"><tr><td>Grupa A</td><td>Echipa</td><td>MJ</td><td>V</td><td>E</td><td>I</td><td>G</td><td>pct</td><tr>";
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
				$grupa = $row['grupa'];
				if($grupa!=$group_change){
					$output .="</table></a><br>";	
					$output .= "<a href = \"meciuri_grupa.php?id_comp=".$id_comp."&grupa=".$grupa."\">";
					$output .="<table class=\"tabel\"><tr><td>Grupa".$row['grupa']."</td><td>Echipa</td><td>MJ</td><td>V</td><td>E</td><td>I</td><td>G</td><td>pct</td><tr>";
					$pos=1;
					$group_change = $grupa;
				}
				$meciuri_jucate = $row['victorii'] + $row['egaluri'] + $row['infrangeri'];
				$output .="<tr>";
				$output .="<td>".$pos."</td>";
				$output .="<td>".$row['nume']."</td>";
				$output .="<td>".($row['victorii'] + $row['egaluri'] + $row['infrangeri'])."</td>";
				$output .="<td>".$row['victorii']."</td>";
				$output .="<td>".$row['egaluri']."</td>";
				$output .="<td>".$row['infrangeri']."</td>";
				$output .="<td>".($row['goluri_marcate']-$row['goluri_primite'])."</td>";
				$output .="<td>".$row['puncte']."</td>";
				$output .="<tr>";
				$pos++;
	
		}
		$output .="</table></a>";	
		return $output;
	}
	
	function showKnockout($db,$id_comp){
		
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM competitii_test WHERE id='$id_comp'";
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$echipe_calif = $row['nr_echipe_calificate'];
			$nr_echipe = $row['nr_echipe'];
		}
		if($nr_echipe/4*$echipe_calif==16){
			$output_k = "<p class=\"stage\">Optimi</p><br>";	
			$output_k .= get_optimi($db,$id_comp)."<br><br>";
			$output_k .=  "<p class=\"stage\">Sferturi</p><br>";
			$output_k .=  get_sferturi($db,$id_comp)."<br><br>";
			$output_k .=  "<p class=\"stage\">Semnifinale</p><br>";
			$output_k .=  get_semifinale($db,$id_comp)."<br><br>";
			$output_k .=  "<p class=\"stage\">Finala</p><br>";
			$output_k .=  get_finala($db,$id_comp)."<br>";
		}else if($nr_echipe/4*$echipe_calif==8){
				$output_k ="<p class=\"stage\">Sferturi</p><br>";
				$output_k .= get_sferturi($db,$id_comp)."<br><br>";
				$output_k .= "<p class=\"stage\">Semnifinale</p><br>";
				$output_k .= get_semifinale($db,$id_comp)."<br><br>";
				$output_k .= "<p class=\"stage\">Finala</p><br>";
				$output_k .= get_finala($db,$id_comp)."<br>";
			}else if($nr_echipe/4*$echipe_calif==4){
				$output_k .= "<p class=\"stage\">Semnifinale</p><br>";
				$output_k .= get_semifinale($db,$id_comp)."<br><br>";
				$output_k .= "<p class=\"stage\">Finala</p><br>";
				$output_k .= get_finala($db,$id_comp)."<br>";
			} else if($nr_echipe/4*$echipe_calif==2){
				$output_k .= "<p class=\"stage\">Finala</p><br>";
				$output_k .= get_finala($db,$id_comp)."<br>";	
			} 
			
			return $output_k;
		
	}
	//FUNCTIE CARE ACTUALIZEAZA GRUPA
	
	function updateCompetitionGroups($db,$id_comp){
		
		$id_comp = make_safe($id_comp);
		$status = true;
		$query = "SELECT * FROM competitii_test WHERE id='$id_comp'";
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$echipe_calif = $row['nr_echipe_calificate'];	
		}
		$query = "SELECT * FROM echipe_participante WHERE id_competitie = '$id_comp' ORDER BY grupa,puncte DESC";
		$res = mysqli_query($db,$query);
		$index=1;
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			if($echipe_calif==1){
				if($index%4==1){
					$query = "UPDATE competitii_test SET ".($index%4).$row['grupa']."='".$row['nume']."' WHERE id='$id_comp'";
					if(!mysqli_query($db,$query)){
						//echo $query."<br>"; // DEVELOPMENTAL
						$status = false;
					}
					else{
						$link = "location:http://students.info.uaic.ro/~rares.nechita/weBall/views/vizualizare_competitie.php?id_comp=".$_GET['id_comp'];
						header($link);
					}	
				}
			}else if($echipe_calif==2){
				if($index%4==1 || $index%4==2){
					$query = "UPDATE competitii_test SET ".($index%4).$row['grupa']."='".$row['nume']."' WHERE id='$id_comp'";
					if(!mysqli_query($db,$query)){
						//echo $query."<br>"; // DEVELOPMENTAL
						$status = false;
					}
					else{
						//$link = "location:http://students.info.uaic.ro/~rares.nechita/weBall/views/actualizeaza_meci.php?id_meci=".$id_meci."&echipa1=".$echipa1."&echipa2=".$echipa2;
					////echo $link;
						//echo "INSERARE CU SUCCES!!!<br>";
						//header($link);
					}	
				}
				
			
			}
			$index++;
		}
		return $status;
		
	}
	
	function updateCompetitionKnockout($db,$id_comp){
		
		$id_comp = make_safe($id_comp);
		$status = true;
		$query = "SELECT * FROM competitii_test WHERE id='$id_comp'";
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$echipe_calif = $row['nr_echipe_calificate'];
			$nr_echipe = $row['nr_echipe'];
			if($nr_echipe/4*$echipe_calif==1){
				$query = "UPDATE competitii_test SET FIN='".$row['nume']."' WHERE id='$id_comp'";
					$status = execute_query($db,$query);
			}else if($nr_echipe/4*$echipe_calif==2){
				if($echipe_calif==1){
					$query = "UPDATE meciuri SET echipa1='".$row['1A']."',echipa2='".$row['1B']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='FIN'";
					
					$status = execute_query($db,$query);
					
				}else{
					if($echipe_calif==2){
					$query = "UPDATE meciuri SET echipa1='".$row['1A']."',echipa2='".$row['2A']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='FIN'";
					
					$status = execute_query($db,$query);
					
					}
				}}
				else if($nr_echipe/4*$echipe_calif==4){
					if($echipe_calif==1){
						
						$query = "UPDATE meciuri SET echipa1='".$row['1A']."',echipa2='".$row['1C']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF1'";
						
						$status = execute_query($db,$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['1B']."',echipa2='".$row['1D']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF2'";
	
						$status = execute_query($db,$query);
						
						$finalista1 = get_winner($db,$id_comp,"SF1");
						$finalista2 = get_winner($db,$id_comp,"SF2");
						
						$query = "UPDATE meciuri SET echipa1='".$finalista1."',echipa2='".$finalista2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='FIN'";
	
						$status = execute_query($db,$query);
						
					
				}else if($echipe_calif==2){
					
						
						
						//
						$query = "UPDATE meciuri SET echipa1='".$row['1A']."',echipa2='".$row['2B']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF1'";
						
						$status = execute_query($db,$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['2A']."',echipa2='".$row['1B']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF2'";
	
						$status = execute_query($db,$query);
						
						$finalista1 = get_winner($db,$id_comp,"SF1");
						$finalista2 = get_winner($db,$id_comp,"SF2");
						
						$query = "UPDATE meciuri SET echipa1='".$finalista1."',echipa2='".$finalista2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='FIN'";
	
						$status = execute_query($db,$query);
				}
			}
			else if($nr_echipe/4*$echipe_calif==8){
					if($echipe_calif==1){
						$query = "UPDATE meciuri SET echipa1='".$row['1A']."',echipa2='".$row['1C']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S1'";
						
						$status = execute_query($db,$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['1E']."',echipa2='".$row['1G']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S2'";
	
						$status = execute_query($db,$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['1B']."',echipa2='".$row['1D']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S3'";
	
						$status = execute_query($db,$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['1F']."',echipa2='".$row['1H']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S4'";
	
						$status = execute_query($db,$query);
						
					
					
				}else if($echipe_calif==2){
					$query = "UPDATE meciuri SET echipa1='".$row['1A']."',echipa2='".$row['2B']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S1'";
						
						$status = execute_query($db,$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['1C']."',echipa2='".$row['2D']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S2'";
	
						$status = execute_query($db,$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['1B']."',echipa2='".$row['2A']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S3'";
	
						$status = execute_query($db,$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['1D']."',echipa2='".$row['2C']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S4'";
	
						$status = execute_query($db,$query);
						
				}
				$sf1_1 = get_winner($db,$id_comp,"S1");
				$sf1_2 = get_winner($db,$id_comp,"S2");
				$sf2_1 = get_winner($db,$id_comp,"S3");
				$sf2_2 = get_winner($db,$id_comp,"S4");
				$query = "UPDATE meciuri SET echipa1='".$sf1_1."',echipa2='".$sf1_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF1'";
						
				$status = execute_query($db,$query);
						
				$query = "UPDATE meciuri SET echipa1='".$sf2_1."',echipa2='".$sf2_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF2'";
	
				$status = execute_query($db,$query);
						
				$finalista1 = get_winner($db,$id_comp,"SF1");
				$finalista2 = get_winner($db,$id_comp,"SF2");
						
				$query = "UPDATE meciuri SET echipa1='".$finalista1."',echipa2='".$finalista2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='FIN'";
	
				$status = execute_query($db,$query);
				
				
				
				
			}else if($nr_echipe/4*$echipe_calif==16){
				
				$query = "UPDATE meciuri SET echipa1='".$row['1A']."',echipa2='".$row['2B']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O1'";
				$status = execute_query($db,$query);
				
				$query = "UPDATE meciuri SET echipa1='".$row['1C']."',echipa2='".$row['2D']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O2'";
				$status = execute_query($db,$query);
				
				$query = "UPDATE meciuri SET echipa1='".$row['1E']."',echipa2='".$row['2F']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O3'";
				$status = execute_query($db,$query);
				
				$query = "UPDATE meciuri SET echipa1='".$row['1G']."',echipa2='".$row['2H']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O4'";
				$status = execute_query($db,$query);
				
				$query = "UPDATE meciuri SET echipa1='".$row['1B']."',echipa2='".$row['2A']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O5'";
				$status = execute_query($db,$query);
				
				$query = "UPDATE meciuri SET echipa1='".$row['1D']."',echipa2='".$row['2C']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O6'";
				$status = execute_query($db,$query);
				
				$query = "UPDATE meciuri SET echipa1='".$row['1F']."',echipa2='".$row['2E']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O7'";
				$status = execute_query($db,$query);
				
				$query = "UPDATE meciuri SET echipa1='".$row['1H']."',echipa2='".$row['2G']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O8'";
				$status = execute_query($db,$query);
			
			
				$s1_1 = get_winner($db,$id_comp,"O1");
				$s1_2 = get_winner($db,$id_comp,"O2");
				
				$s2_1 = get_winner($db,$id_comp,"O3");
				$s2_2 = get_winner($db,$id_comp,"O4");
				
				$s3_1 = get_winner($db,$id_comp,"O5");
				$s3_2 = get_winner($db,$id_comp,"O6");
				
				$s4_1 = get_winner($db,$id_comp,"O7");
				$s4_2 = get_winner($db,$id_comp,"O8");
				
				$query = "UPDATE meciuri SET echipa1='".$s1_1."',echipa2='".$s1_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S1'";
				$status = execute_query($db,$query);	
				
				$query = "UPDATE meciuri SET echipa1='".$s2_1."',echipa2='".$s2_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S2'";
				$status = execute_query($db,$query);	
				
				$query = "UPDATE meciuri SET echipa1='".$s3_1."',echipa2='".$s3_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S3'";
				$status = execute_query($db,$query);	
				
				$query = "UPDATE meciuri SET echipa1='".$s4_1."',echipa2='".$s4_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S4'";
				$status = execute_query($db,$query);			
				
				$sf1_1 = get_winner($db,$id_comp,"S1");
				$sf1_2 = get_winner($db,$id_comp,"S2");
				$sf2_1 = get_winner($db,$id_comp,"S3");
				$sf2_2 = get_winner($db,$id_comp,"S4");
				$query = "UPDATE meciuri SET echipa1='".$sf1_1."',echipa2='".$sf1_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF1'";
						
				$status = execute_query($db,$query);
						
				$query = "UPDATE meciuri SET echipa1='".$sf2_1."',echipa2='".$sf2_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF2'";
	
				$status = execute_query($db,$query);
						
				$finalista1 = get_winner($db,$id_comp,"SF1");
				$finalista2 = get_winner($db,$id_comp,"SF2");
						
				$query = "UPDATE meciuri SET echipa1='".$finalista1."',echipa2='".$finalista2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='FIN'";
	
				$status = execute_query($db,$query);
			
			}

		}
		
		return $status;
	}
	// FUNCTIE CARE RETURNEAZA MECIURILE DIN OPTIMI
	function get_optimi($db,$id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND faza_competitie IN ('O1','O2','O3','O4','O5','O6','O7','O8')";
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output_optimi .= "<a href = \"actualizeaza_meci.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$row['echipa1']."&echipa2=".$row['echipa2']."\"><table class=\"tabel\"><tr>";
			$output_optimi .= "<td>".$row['echipa1']."</td>";
			$echipa1 = $row['echipa1'];
			$echipa2 = $row['echipa2'];
			if($row['goluri_echipa1']==-1){
				$gol1 = " ";		
				$gol2 = " ";
			}else{
				$gol1 = $row['goluri_echipa1'];
				$gol2 = $row['goluri_echipa2'];
			}
			$output_optimi .= "<td>".$gol1."</td>";
			$output_optimi .= "<td> - </td>";
			$output_optimi .= "<td>".$gol2."</td>";
			$output_optimi .= "<td>".$row['echipa2']."</td>";
			$output_optimi .= "</tr></table><br></a>";
		}	
		return $output_optimi;
	}
	
	// FUNCTIE CARE RETURNEAZA MECIURILE DIN SFERTURI
	function get_sferturi($db,$id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND faza_competitie IN ('S1','S2','S3','S4')";
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output_sferturi .= "<a href = \"actualizeaza_meci.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$row['echipa1']."&echipa2=".$row['echipa2']."\"><table class=\"tabel\"><tr>";
			$output_sferturi .= "<td>".$row['echipa1']."</td>";
			$echipa1 = $row['echipa1'];
			$echipa2 = $row['echipa2'];
			if($row['goluri_echipa1']==-1){
				$gol1 = " ";		
				$gol2 = " ";
			}else{
				$gol1 = $row['goluri_echipa1'];
				$gol2 = $row['goluri_echipa2'];
			}
			$output_sferturi .= "<td>".$gol1."</td>";
			$output_sferturi .= "<td> - </td>";
			$output_sferturi .= "<td>".$gol2."</td>";
			$output_sferturi .= "<td>".$row['echipa2']."</td>";
			$output_sferturi .= "</tr></table><br></a>";
		}	
		return $output_sferturi;
	}
	
	// FUNCTIE CARE RETURNEAZA MECIURILE DIN SEMIFINALE
	function get_semifinale($db,$id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND faza_competitie IN ('SF1','SF2')";
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output_semifinale .= "<a href = \"actualizeaza_meci.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$row['echipa1']."&echipa2=".$row['echipa2']."\"><table class=\"tabel\"><tr>";
			$output_semifinale .= "<td>".$row['echipa1']."</td>";
			$echipa1 = $row['echipa1'];
			$echipa2 = $row['echipa2'];
			if($row['goluri_echipa1']==-1){
				$gol1 = " ";		
				$gol2 = " ";
			}else{
				$gol1 = $row['goluri_echipa1'];
				$gol2 = $row['goluri_echipa2'];
			}
			$output_semifinale .= "<td>".$gol1."</td>";
			$output_semifinale .= "<td> - </td>";
			$output_semifinale .= "<td>".$gol2."</td>";
			$output_semifinale .= "<td>".$row['echipa2']."</td>";
			$output_semifinale .= "</tr></table><br></a>";
		}	
		return $output_semifinale;
	}
	
	// FUNCTIE CARE RETURNEAZA MECIURILE DIN FINALA
	function get_finala($db,$id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND faza_competitie IN ('FIN')";
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output_finala .= "<a href = \"actualizeaza_meci.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$row['echipa1']."&echipa2=".$row['echipa2']."\"><table class=\"tabel\"><tr>";
			$output_finala .= "<td>".$row['echipa1']."</td>";
			$echipa1 = $row['echipa1'];
			$echipa2 = $row['echipa2'];
			if($row['goluri_echipa1']==-1){ 
				$gol1 = " ";		
				$gol2 = " ";
			}else{
				$gol1 = $row['goluri_echipa1'];
				$gol2 = $row['goluri_echipa2'];
			}
			$output_finala .= "<td>".$gol1."</td>";
			$output_finala .= "<td> - </td>";
			$output_finala .= "<td>".$gol2."</td>";
			$output_finala .= "<td>".$row['echipa2']."</td>";
			$output_finala .= "</tr></table><br></a>";
		}	
		return $output_finala;
	}
	
	// FUNCTIE CARE AFISEAZA TOATE MECIURILE DINTR-O GRUPA
	function getMatchesFromGroup($db,$id_comp,$grupa){
	
		$id_comp = make_safe($id_comp);
		$grupa = make_safe($grupa);
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND grupa='$grupa'";
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output .= "<a href = \"actualizeaza_meci.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$row['echipa1']."&echipa2=".$row['echipa2']."\"><table class=\"tabel\"><tr>";
			$output .= "<td>".$row['echipa1']."</td>";
			$echipa1 = $row['echipa1'];
			$echipa2 = $row['echipa2'];
			if($row['goluri_echipa1']==-1){
				$gol1 = " ";		 
				$gol2 = " ";
			}else{
				$gol1 = $row['goluri_echipa1'];
				$gol2 = $row['goluri_echipa2'];
			}
			$output .= "<td>".$gol1."</td>";
			$output .= "<td> - </td>";
			$output .= "<td>".$gol2."</td>";
			$output .= "<td>".$row['echipa2']."</td>";
			$output .= "</tr></table><br></a>";
		}
		return $output;
	}
	function updateGroup($db,$id_comp,$grupa){
		
		$id_comp = make_safe($id_comp);
		$grupa = make_safe($grupa);
		$status = true;
		$query = "UPDATE echipe_participante SET victorii=0,egaluri=0,infrangeri=0,puncte=0,goluri_marcate=0, goluri_primite=0 WHERE id_competitie = '$id_comp' AND grupa='$grupa'";
		$status = execute_query($db,$query);
	
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND grupa='$grupa'";
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$echipa1 = $row['echipa1'];
			$echipa2 = $row['echipa2'];
			if($row['goluri_echipa1']==-1){
				$gol1 = " ";		
				$gol2 = " ";
			}else{
				$gol1 = $row['goluri_echipa1'];
				$gol2 = $row['goluri_echipa2'];
				$query = "SELECT * FROM echipe_participante WHERE id_competitie = '$id_comp' AND nume='$echipa1'";
				$result = mysqli_query($db,$query);
				while($rowe = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					$victorii1 = $rowe['victorii'];
					$egaluri1 = $rowe['egaluri'];
					$infrangeri1 = $rowe['infrangeri'];
					$goluri_marcate1 = $rowe['goluri_marcate'];
					$goluri_primite1 = $rowe['goluri_primite'];
					$puncte1 = $rowe['puncte'];
				}
				
				$query = "SELECT * FROM echipe_participante WHERE id_competitie = '$id_comp' AND nume='$echipa2'";
				$result = mysqli_query($db,$query);
				while($rowe = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					$victorii2 = $rowe['victorii'];
					$egaluri2 = $rowe['egaluri'];
					$infrangeri2 = $rowe['infrangeri'];
					$goluri_marcate2 = $rowe['goluri_marcate'];
					$goluri_primite2 = $rowe['goluri_primite'];
					$puncte2 = $rowe['puncte'];
				}
				if($gol1 > $gol2){	
				
				//ECHIPA 1 ESTE CASTIGATOARE
				
					////echo $echipa1." ".$gol1." - ".$gol2." ".$echipa2."<br>";
					////echo "ECHIPA1:".$victorii1." ".$puncte1."<br>";
					////echo "ECHIPA2:".$victorii2." ".$puncte2."<br>";
					$query = "UPDATE echipe_participante SET victorii='".($victorii1+1)."',puncte='".($puncte1 + 3)."',goluri_marcate='".($goluri_marcate1+$gol1)."' , goluri_primite='".($goluri_primite1+$gol2)."' WHERE id_competitie = '$id_comp' AND nume='$echipa1'";
					$status = execute_query($db,$query);
						
					$query = "UPDATE echipe_participante SET infrangeri='".($infrangeri2+1)."',goluri_marcate='".($goluri_marcate2+$gol2)."',goluri_primite='".($goluri_primite2+$gol1)."' WHERE id_competitie = '$id_comp' AND nume='$echipa2'";
					$status = execute_query($db,$query);
						
								
				}else if($gol1<$gol2){
					////echo $echipa1." ".$gol1." - ".$gol2." ".$echipa2."<br>";
					////echo "ECHIPA1:".$victorii1." ".$puncte1."<br>";
					////echo "ECHIPA2:".$victorii2." ".$puncte2."<br>";
					//ECHIPA 2 ESTE CASTIGATOARE
					$query = "UPDATE echipe_participante SET victorii='".($victorii2+1)."',puncte='".($puncte2 + 3)."',goluri_marcate='".($goluri_marcate2+$gol2)."' , goluri_primite='".($goluri_primite2+$gol1)."' WHERE id_competitie = '$id_comp' AND nume='$echipa2'";
					$status = execute_query($db,$query);
					
					$query = "UPDATE echipe_participante SET infrangeri='".($infrangeri1+1)."',goluri_marcate='".($goluri_marcate1+$gol1)."' , goluri_primite='".($goluri_primite1 + $gol2)."' WHERE id_competitie = '$id_comp' AND nume='$echipa1'";
					$status = execute_query($db,$query);
						
				}else{
					//EGALITATE
					//echo $echipa1." ".$gol1." - ".$gol2." ".$echipa2."<br>";
					//echo "ECHIPA1:".$victorii1." ".$puncte1."<br>";
					//echo "ECHIPA2:".$victorii2." ".$puncte2."<br>";
					$query = "UPDATE echipe_participante SET egaluri='".($egaluri1+1)."',puncte='".($puncte1 + 1)."',goluri_marcate='".($goluri_marcate1+$gol1)."' , goluri_primite='".($goluri_primite1+$gol2)."' WHERE id_competitie = '$id_comp' AND nume='$echipa1'";
					
					$status = execute_query($db,$query);
					
					$query = "UPDATE echipe_participante SET egaluri='".($egaluri2+1)."',puncte='".($puncte2 + 1)."',goluri_marcate='".($goluri_marcate2+$gol2)."' , goluri_primite='".($goluri_primite2+$gol1)."' WHERE id_competitie = '$id_comp' AND nume='$echipa2'";
					$status = execute_query($db,$query);
				}
			}
		}
		return $status;
	}


	function get_sporturi($db){
		$query = "SELECT * FROM sporturi";
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$dd_sporturi .="<option value=\"".$row['id']."\">".$row['denumire']."</option>";
		
		}
		return $dd_sporturi;	
	}
	
	function getTeamsCount($db,$id_sport){
		
		$id_sport = make_safe($id_sport);
		$query = "SELECT count(id) as 'count' FROM echipe WHERE sport='$id_sport'";
		$res = mysqli_query($db,$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$count = $row['count'];	
		}
		return $count;
}

function getAllTeams($db,$name,$id_sport){
	
		$id_sport = make_safe($id_sport);
		$name = make_safe($name);
		$query = "SELECT nume FROM echipe WHERE sport = '$id_sport' ORDER BY nume ";
		$res = mysqli_query($db,$query);
		$output = "<select name=\"echipa".$name."\">";
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output .="<option value=\"".$row['nume']."\">".$row['nume']."</option>";
		}
		$output .="</select>";
		return $output;
		
}

function getIdEchipa($db,$nume){
	
	$nume = make_safe($nume);
	$query = "SELECT id FROM echipe WHERE nume='$nume'";
	$res = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$id_echipa = $row['id'];
	}
	return $id_echipa;
}

function getCompetitionId($db){
	$query = "SELECT id FROM competitii_test ORDER BY id desc";
	$res = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$id_comp = $row['id'];
			break;
	}
	return $id_comp;
}

function createCompetition($db,$nume_competitie,$nr_echipe,$id_sport,$nr_echipe_calif){
	
		$nume_competitie = make_safe($nume_competitie);
		$nr_echipe = make_safe($nr_echipe);
		$id_sport = makes_safe($id_sport);
		$nr_echipe_calif = make_safe($nr_echipe_calif);
		
		$status = true;
		$query = "INSERT INTO competitii_test(nume,nr_echipe,id_sport,nr_echipe_calificate) VALUES('$nume_competitie',$nr_echipe,$id_sport, $nr_echipe_calif)";
		
		$status = execute_query($db,$query);
			
		$id_comp = getCompetitionId($db);
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
				$status = execute_query($db,$query);
					
					
					
				$query = "INSERT INTO echipe_participante (id_competitie,nume,faza_competitie,grupa) VALUES ('$id_comp','$echipa2','G','$grupa')";
				$status = execute_query($db,$query);
					
				$query = "INSERT INTO echipe_participante (id_competitie,nume,faza_competitie,grupa) VALUES ('$id_comp','$echipa3','G','$grupa')";
				$status = execute_query($db,$query);
				
				
				$query = "INSERT INTO echipe_participante (id_competitie,nume,faza_competitie,grupa) VALUES ('$id_comp','$echipa4','G','$grupa')";
				$status = execute_query($db,$query);
					
					
				//inserare meciuri
				
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa1','$echipa2',-1,-1,'G','$grupa')";
					$status = execute_query($db,$query);
						
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa1','$echipa3',-1,-1,'G','$grupa')";
					$status = execute_query($db,$query);
						
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa1','$echipa4',-1,-1,'G','$grupa')";
					$status = execute_query($db,$query);
						
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa2','$echipa3',-1,-1,'G','$grupa')";
					$status = execute_query($db,$query);
					
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa2','$echipa4',-1,-1,'G','$grupa')";
					$status = execute_query($db,$query);
						
					$query = "INSERT INTO meciuri (id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,grupa) 				                                                           VALUES ('$id_comp','$echipa3','$echipa4',-1,-1,'G','$grupa')";
					$status = execute_query($db,$query);
					
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
							if(!mysqli_query($db,$new_query)){
								//echo $new_query."<br>";
								$status = false;	
							}
							else{}
								//echo "UPDATE MECI CU SUCCES!!!<br>";
	}
	return $status;
}

function addEvent($db,$id_meci,$echipa,$event,$jucator,$minut,$echipa1,$echipa2){
	
	$id_meci = make_safe($id_meci);
	$echipa = make_safe($echipa);
	$event = make_safe($event);
	$jucator = make_safe($jucator);
	$minut = make_safe($minut);
	$echipa1 = make_safe($echipa1);
	$echipa2 = make_safe($echipa2);
	
	$query = "INSERT INTO evenimente(id_meci,echipa,eveniment,jucator1,minut) VALUES('$id_meci','$echipa','$event','$jucator','$minut')";
	////echo $query;
		if(!mysqli_query($db,$query))
			echo $query."<br>";
		else{
			$link = "location:http://students.info.uaic.ro/~rares.nechita/weBall/views/actualizeaza_meci.php?id_meci=".$id_meci."&echipa1=".$echipa1."&echipa2=".$echipa2;
		//echo $link;
			//echo "INSERARE CU SUCCES!!!<br>";
			header($link);
		}
	
}

function updateScore($db,$scor1,$scor2,$id_meci){

	$scor1 = make_safe($scor1);
	$scor2 = make_safe($scor2);
	$id_meci = make_safe($id_meci);
	
	$query = "UPDATE meciuri SET goluri_echipa1='$scor1',goluri_echipa2='$scor2' WHERE id='$id_meci'";
		
	return execute_query($db,$query);
		
}

function deleteEvent($db,$event_id,$id_meci,$echipa1,$echipa2){
	
	$event_id = make_safe($event_id);
	$id_meci = make_safe($id_meci);
	$echipa1 = make_safe($echipa1);
	$echipa2 = make_safe($echipa2);
	
	$status = true;
	$query = "DELETE FROM evenimente WHERE id='$event_id'";
		
	if(!mysqli_query($db,$query)){
		$status = false;
		//echo $query."<br>";
	}
	else{
		$link = "location:http://students.info.uaic.ro/~rares.nechita/weBall/views/actualizeaza_meci.php?id_meci=".$id_meci."&echipa1=".$echipa1."&echipa2=".$echipa2;
		//echo "STERGERE CU SUCCES!!!<br>";
		header($link);
	
	}
	return $status;
}

function updateDate($db,$id_meci,$echipa1,$echipa2,$data){
	
	$id_meci = make_safe($id_meci);
	$echipa1 = make_safe($echipa1);
	$echipa2 = make_safe($echipa2);
	$data = make_safe($data);
	
	$status = true;
	$date = str_replace('/', '-', $data);
	$newformat = date('Y-m-d', strtotime($date));
	
	$query = "UPDATE meciuri SET data = '$newformat' WHERE id='$id_meci'";
		
	if(!mysqli_query($db,$query)){
		//echo $query."<br>";
		$status = false;	
	}
	else{
		$link = "location:http://students.info.uaic.ro/~rares.nechita/weBall/views/actualizeaza_meci.php?id_meci=".$id_meci."&echipa1=".$echipa1."&echipa2=".$echipa2;
		//echo "UPDATE CU SUCCES!!!<br>";
		header($link);
	
	}
	
	return $status;
}

function get_table_header($db,$id_meci){
	
	$id_meci = make_safe($id_meci);
	$query = "SELECT * FROM meciuri WHERE id='$id_meci'";
	////echo $query;
	$res = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
		$e1 = $row['echipa1'];
		$e2 = $row['echipa2'];
		$gol_e1 = $row['goluri_echipa1'];
		$gol_e2 = $row['goluri_echipa2'];
	}
	$table_header = "<tr><td></td><td>".$e1."</td><td>".$gol_e1."<td> - </td><td>".$gol_e2."</td><td>".$e2."</td><td></td></tr>";
	return $table_header;
}

function get_events($db,$id_meci,$e1,$e2){
	
	$id_meci = make_safe($id_meci);
	$e1 = make_safe($e1);
	$e2 = make_safe($e2);
	
	$query = "SELECT * FROM evenimente WHERE id_meci='$id_meci' order by minut"; 
	////echo $query;
	$res = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
		$echipa = $row['echipa'];
		$eveniment = $row['eveniment'];
		$jucator = $row['jucator1'];
		$minut = $row['minut'];
		if($echipa==$e1){
			$events.= "<tr><td>".$minut."'</td><td>".$eveniment." - ".$jucator."<td>".$row['id']."<td></td>   <td></td></td><td></td><td></td></tr>";
		}else{
			$events.= "<tr><td></td><td><td><td></td>   <td>".$row['id']."</td><td>".$eveniment." - ".$jucator."</td><td>".$minut."'</td></tr>";

		}
	}
	
	return $events;
	
}

function get_match_date($db,$id_meci){
	
	$id_meci = make_safe($id_meci);
	
	$query = "SELECT data FROM meciuri WHERE id='$id_meci'"; 
	////echo $query;
	$res = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
		$data = $row['data'];
	}
	
	return "<p id=\"date_match\"> Data:".$data."</p>";
}
	
	
	function createPoll($id_meci,$q,$q1,$q2,$q3){
		
		$id_meci = make_safe($id_meci);
		$q = make_safe($q);
		$q1 = make_safe($q1);
		$q2 = make_safe($q2);
		$q3 = make_safe($q3);
		$query = "SELECT count(id) as 'count' FROM poll WHERE id_meci='".$id_meci."'";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$count = $row['count'];
		}
		if($count>0){
			return "2";	
		}
		$query = "INSERT INTO poll(id_meci,intrebare,raspuns1,raspuns2,raspuns3,vot1,vot2,vot3) VALUES('$id_meci','$q','$q1','$q2','$q3',0,0,0)";
		return execute_query($GLOBALS['conn'],$query);		
	}
	
?>




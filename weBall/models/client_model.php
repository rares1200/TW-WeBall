<?php

include("../config.php");
include("functions.php");


$GLOBALS['conn'] = $db;

	function getCompetitions($page){
		$page = make_safe($page);
		$page = $page*30-30;
		$query .= "SELECT * FROM competitii_test WHERE private=0 ORDER BY id desc";  
		$query .= " LIMIT ".$page.",10";
		//echo $query;
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
				$output .="<a href=\"competitie.php?id_comp=".$row['id']."&page=".$page."\">";
				$output .="<table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\">";
				$output .="<tr><td>Nume</td><td>Numar echipe</td><td>Numar echipe calificate</td></tr>";
				$output .="<tr>";
				$output .="<td>".$row['nume']."</td>";
				$output .="<td>".$row['nr_echipe']."</td>";
				$output .="<td>".$row['nr_echipe_calificate']."</td>";
				$output .="</tr>";
				$output .="</table></a>";
				$output .="<br>";
		}
		
		return $output;
		
	}
	
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
	
	function getCountCompetitions(){
		
		$query = "SELECT count(id) as 'count' FROM competitii_test WHERE private = 0 ORDER BY id desc";  
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			return $row['count'];	
		}
		
	}
	
	
	function showGroups($id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM competitii_test WHERE id = '$id_comp' and private = 0";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$nr_echipe = $row['nr_echipe'];
			$echipe_calif = $row['nr_echipe_calificate'];
			
		}
		////echo $nr_echipe." ".$echipe_calif."<br>";
		
		$query = "SELECT * FROM echipe_participante WHERE id_competitie = '$id_comp' ORDER BY grupa,puncte DESC";
		$res = mysqli_query($GLOBALS['conn'],$query);
		$group_change = "A";
		$pos = 1;
		$output .= "<a href =\"meciuri_grupa.php?id_comp=".$id_comp."&grupa=A\">";
		$output .="<table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\"><tr><td>Grupa A</td><td>Echipa</td><td>MJ</td><td>V</td><td>E</td><td>I</td><td>G</td><td>pct</td><tr>";
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
				$grupa = $row['grupa'];
				if($grupa!=$group_change){
					$output .="</table></a><br>";	
					$output .= "<a href = \"meciuri_grupa.php?id_comp=".$id_comp."&grupa=".$grupa."\">";
					$output .="<table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\"><tr><td>Grupa".$row['grupa']."</td><td>Echipa</td><td>MJ</td><td>V</td><td>E</td><td>I</td><td>G</td><td>pct</td><tr>";
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
	
	function showGroupsHTML($id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM competitii_test WHERE id = '$id_comp'";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$nr_echipe = $row['nr_echipe'];
			$echipe_calif = $row['nr_echipe_calificate'];
			
		}
		////echo $nr_echipe." ".$echipe_calif."<br>";
		
		$query = "SELECT * FROM echipe_participante WHERE id_competitie = '$id_comp' ORDER BY grupa,puncte DESC";
		$res = mysqli_query($GLOBALS['conn'],$query);
		$group_change = "A";
		$pos = 1;
		$output .="Grupa A		Echipa   MJ  V		E   I   G     pct<br>";
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
				$grupa = $row['grupa'];
				if($grupa!=$group_change){	
					$output .= "Grupa".$row['grupa']."          Echipa   MJ  V		E   I   G     pct<br>";
					$pos=1;
					$group_change = $grupa;
				}
				$meciuri_jucate = $row['victorii'] + $row['egaluri'] + $row['infrangeri'];
				$output .=$pos."	";
				$output .=$row['nume']."	";
				$output .=($row['victorii'] + $row['egaluri'] + $row['infrangeri'])."	";
				$output .=$row['victorii']."	";
				$output .=$row['egaluri']."	";
				$output .=$row['infrangeri']."	";
				$output .=($row['goluri_marcate']-$row['goluri_primite'])."	";
				$output .=$row['puncte']."</td>";
				$output .="<br>";
				$pos++;
	
		}	
		return $output;
	}
	
	function showKnockout($id_comp){
		
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM competitii_test WHERE id='$id_comp'";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$echipe_calif = $row['nr_echipe_calificate'];
			$nr_echipe = $row['nr_echipe'];
		}
		if($nr_echipe/4*$echipe_calif==16){
			$output_k = "<p class=\"stage\">Optimi</p><br>";	
			$output_k .= get_optimi($id_comp)."<br><br>";
			$output_k .=  "<p class=\"stage\">Sferturi</p><br>";
			$output_k .=  get_sferturi($id_comp)."<br><br>";
			$output_k .=  "<p class=\"stage\">Semnifinale</p><br>";
			$output_k .=  get_semifinale($id_comp)."<br><br>";
			$output_k .=  "<p class=\"stage\">Finala</p><br>";
			$output_k .=  get_finala($id_comp)."<br>";
		}else if($nr_echipe/4*$echipe_calif==8){
				$output_k = "<p class=\"stage\">Sferturi</p><br>";
				$output_k .= get_sferturi($id_comp)."<br><br>";
				$output_k .= "<p class=\"stage\">Semnifinale</p><br>";
				$output_k .= get_semifinale($id_comp)."<br><br>";
				$output_k .= "<p class=\"stage\">Finala</p><br>";
				$output_k .= get_finala($id_comp)."<br>";
			}else if($nr_echipe/4*$echipe_calif==4){
				$output_k .= "<p class=\"stage\">Semnifinale</p><br>";
				$output_k .= get_semifinale($id_comp)."<br><br>";
				$output_k .= "<p class=\"stage\">Finala</p><br>";
				$output_k .= get_finala($id_comp)."<br>";
			} else if($nr_echipe/4*$echipe_calif==2){
				$output_k .= "<p class=\"stage\">Finala</p><br>";
				$output_k .= get_finala($id_comp)."<br>";	
			} 
			
			return $output_k;
		
	}
	
	
	function get_optimi($id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND faza_competitie IN ('O1','O2','O3','O4','O5','O6','O7','O8')";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$echipa1 = $row['echipa1'];
			$echipa2 = $row['echipa2'];
			if(is_null($echipa1)|| empty($echipa1)){
				$echipa1="TBD";
			}
			if(is_null($echipa2) || empty($echipa2)){
				$echipa2="TBD";	
			}
			$output_optimi .= "<a href = \"meci.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$echipa1."&echipa2=".$echipa2."\"><table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\"><tr>";
			$output_optimi .= "<td>".$echipa1."</td>";
			
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
			$output_optimi .= "<td>".$echipa2."</td>";
			$output_optimi .= "</tr></table><br></a>";
		}	
		return $output_optimi;
	}
	
	// FUNCTIE CARE RETURNEAZA MECIURILE DIN SFERTURI
	function get_sferturi($id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND faza_competitie IN ('S1','S2','S3','S4')";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output_sferturi .="<a href = \"meci.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$row['echipa1']."&echipa2=".$row['echipa2']."\"><table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\"><tr>";
			
			$echipa1 = $row['echipa1'];
			$echipa2 = $row['echipa2'];
			if(is_null($echipa1)|| empty($echipa1)){
				$echipa1="TBD";
			}
			if(is_null($echipa2) || empty($echipa2)){
				$echipa2="TBD";	
			}
			
			if($row['goluri_echipa1']==-1){
				$gol1 = " ";		
				$gol2 = " ";
			}else{
				$gol1 = $row['goluri_echipa1'];
				$gol2 = $row['goluri_echipa2'];
			}
			$output_sferturi .= "<td>".$echipa1."</td>";
			$output_sferturi .= "<td>".$gol1."</td>";
			$output_sferturi .= "<td> - </td>";
			$output_sferturi .= "<td>".$gol2."</td>";
			$output_sferturi .= "<td>".$echipa2."</td>";
			$output_sferturi .= "</tr></table><br></a>";
		}	
		return $output_sferturi;
	}
	
	// FUNCTIE CARE RETURNEAZA MECIURILE DIN SEMIFINALE
	function get_semifinale($id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND faza_competitie IN ('SF1','SF2')";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output_semifinale .= "<a href = \"meci.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$row['echipa1']."&echipa2=".$row['echipa2']."\"><table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\"><tr>";
			
			$echipa1 = $row['echipa1'];
			$echipa2 = $row['echipa2'];
			if(is_null($echipa1)|| empty($echipa1)){
				$echipa1="TBD";
			}
			if(is_null($echipa2) || empty($echipa2)){
				$echipa2="TBD";	
			}
			
			if($row['goluri_echipa1']==-1){
				$gol1 = " ";		
				$gol2 = " ";
			}else{
				$gol1 = $row['goluri_echipa1'];
				$gol2 = $row['goluri_echipa2'];
			}
			$output_semifinale .= "<td>".$echipa1."</td>";
			$output_semifinale .= "<td>".$gol1."</td>";
			$output_semifinale .= "<td> - </td>";
			$output_semifinale .= "<td>".$gol2."</td>";
			$output_semifinale .= "<td>".$echipa2."</td>";
			$output_semifinale .= "</tr></table><br></a>";
		}	
		return $output_semifinale;
	}
	
	// FUNCTIE CARE RETURNEAZA MECIURILE DIN FINALA
	function get_finala($id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND faza_competitie IN ('FIN')";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output_finala .= "<a href = \"meci.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$row['echipa1']."&echipa2=".$row['echipa2']."\"><table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\"><tr>";
			
			$echipa1 = $row['echipa1'];
			$echipa2 = $row['echipa2'];
			if(is_null($echipa1)|| empty($echipa1)){
				$echipa1="TBD";
			}
			if(is_null($echipa2) || empty($echipa2)){
				$echipa2="TBD";	
			}
			if($row['goluri_echipa1']==-1){ 
				$gol1 = " ";		
				$gol2 = " ";
			}else{
				$gol1 = $row['goluri_echipa1'];
				$gol2 = $row['goluri_echipa2'];
			}
			$output_finala .= "<td>".$echipa1."</td>";
			$output_finala .= "<td>".$gol1."</td>";
			$output_finala .= "<td> - </td>";
			$output_finala .= "<td>".$gol2."</td>";
			$output_finala .= "<td>".$echipa2."</td>";
			$output_finala .= "</tr></table><br></a>";
		}	
		return $output_finala;
	}

	function getMatchesFromGroup($id_comp,$grupa){
	
		$id_comp = make_safe($id_comp); 
		$grupa = make_safe($grupa);
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND grupa='$grupa'";
		$res = mysqli_query($GLOBALS['conn'],$query);
		$output = "<br>";
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output .= "<a href = \"meci.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$row['echipa1']."&echipa2=".$row['echipa2']."\"><table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\"><tr>";
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
			$output .= "</tr></table></a>";
			//echo $output;
		}
		return $output;
	}
	
	function getTableHeader($id_meci){
	
	$id_meci = make_safe($id_meci);
		$query = "SELECT * FROM meciuri WHERE id='$id_meci'";
		////echo $query;
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$e1 = $row['echipa1'];
			$e2 = $row['echipa2'];
			$gol_e1 = $row['goluri_echipa1'];
			$gol_e2 = $row['goluri_echipa2'];
		}
		if($gol_e1==-1){
			$gol_e1="";
			$gol_e2="";	
		}
		$table_header = "<tr><td></td><td>".$e1."</td><td>".$gol_e1."<td> - </td><td>".$gol_e2."</td><td>".$e2."</td><td></td></tr>";
		return $table_header;
}

	function getEvents($id_meci,$e1,$e2){
	
		$id_meci = make_safe($id_meci);
		$e1 = make_safe($e1);
		$e2 = make_safe($e2);
		
		$query = "SELECT * FROM evenimente WHERE id_meci='$id_meci' order by minut"; 
		////echo $query;
		$res = mysqli_query($GLOBALS['conn'],$query);
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

function getMatchDate($id_meci){
	
	$id_meci = make_safe($id_meci);
	
	$query = "SELECT data FROM meciuri WHERE id='$id_meci'"; 
	////echo $query;
	$res = mysqli_query($GLOBALS['conn'],$query);
	while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
		$data = $row['data'];
	}
	if($data == "0000-00-00"){
		$data = "TBA";
	}
	return "Data:".$data;
}

function addComment($id_meci,$user,$comment){
	
	$id_meci = make_safe($id_meci);
	$user = make_safe($user);
	$comment = make_safe($comment);
	
	$query = "INSERT INTO comments(match_id,user,comment) VALUES ('$id_meci','$user','$comment')";
	return execute_query($GLOBALS['conn'],$query);
	
}

function getComments($id_meci){
	
	$id_meci = make_safe($id_meci);
	$query = "SELECT * FROM comments WHERE match_id='$id_meci' ORDER BY id DESC";
	$res = mysqli_query($GLOBALS['conn'],$query);
	while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
		$output .= "<tr><td>User:".$row['user']."</td><td></td></tr><tr><td></td><td>".$row['comment']."</td></tr>";
	}
	
	return $output;
	
}
 

function searchMatch($gazda,$oaspete,$scor1,$scor2,$data,$arbitru,$cota_v1,$cota_egal,$cota_v2,$page){
	
	$gazda = set_search($gazda);
	$oaspete = set_search($oaspete);
	$scor1 = set_search($scor1);
	$scor2 = set_search($scor2);
	$data = set_search($data);
	$arbitru = set_search($arbitru);
	$cota_v1 = set_search($cota_v1);
	$cota_v2 = set_search($cota_v2);
	$cota_egal = set_search($cota_egal);
	
$query = "SELECT * FROM istoric_meciuri WHERE 1 = 1 ";
//echo "page:".$page."<br>";
$number = 0;
if(!empty($gazda)) {
    $query .= " and echipa1 LIKE '%".make_safe($gazda)."%' ";
    $number++;
}

if(!empty($oaspete)) {
    $query .= " and echipa2 LIKE '%".make_safe($oaspete)."%' ";
    $number++;
}

if(!empty($scor1)) {
    $query .= " and goluri_echipa1 = ".make_safe($scor1)." ";
    $number++;
}

if(!empty($scor2)) {
    $query .= " and goluri_echipa2 = ".make_safe($scor2)." ";
    $number++;
}

if(!empty($data)) {
    $query .= " and data = ".make_safe($data)." ";
    $number++;
}

if(!empty($arbitru)) {
    $query .= " and arbitru LIKE '%".make_safe($arbitru)."%' ";
    $number++;
}

if(!empty($cota_v1)) {
    $query .= " and cota_v1 = ".make_safe($cota_v1)." ";
    $number++;
}

if(!empty($cota_v2)) {
    $query .= " and cota_v2 = ".make_safe($cota_v2)." ";
    $number++;
}

if(!empty($cota_egal)) {
    $query .= " and cota_egal = ".make_safe($cota_egal)." ";
    $number++;
	}
	
	$page = $page*50-50;
if($number>0) {
	$query .= " LIMIT ".$page.",50";
} else {
    $query = "SELECT * FROM istoric_meciuri LIMIT ".$page." ,50";
}

//echo $query;

	//echo $page." ";
	$res = mysqli_query($GLOBALS['conn'],$query);
	while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
		$output_result .="<tr><td>".$row['data']."</td><td>".$row['echipa1']."</td><td>".$row['goluri_echipa1']." - ".$row['goluri_echipa2']."</td><td>"
		.$row['echipa2']."</td><td>".$row['arbitru']."</td><td>".$row['cota_v1']."</td><td>".$row['cota_egal']."</td><td>".$row['cota_v2']."</td></tr>";
	}	
	return $output_result;
}

function searchCount($gazda,$oaspete,$scor1,$scor2,$data,$arbitru,$cota_v1,$cota_egal,$cota_v2){
	
	$gazda = set_search($gazda);
	$oaspete = set_search($oaspete);
	$scor1 = set_search($scor1);
	$scor2 = set_search($scor2);
	$data = set_search($data);
	$arbitru = set_search($arbitru);
	$cota_v1 = set_search($cota_v1);
	$cota_v2 = set_search($cota_v2);
	$cota_egal = set_search($cota_egal);
	
$query = "SELECT count(id) as 'count' FROM istoric_meciuri WHERE 1 = 1 ";
//echo "page:".$page."<br>";
$number = 0;
if(!empty($gazda)) {
    $query .= " and echipa1 LIKE '%".make_safe($gazda)."%' ";
    $number++;
}

if(!empty($oaspete)) {
    $query .= " and echipa2 LIKE '%".make_safe($oaspete)."%' ";
    $number++;
}

if(!empty($scor1)) {
    $query .= " and goluri_echipa1 = ".make_safe($scor1)." ";
    $number++;
}

if(!empty($scor2)) {
    $query .= " and goluri_echipa2 = ".make_safe($scor2)." ";
    $number++;
}

if(!empty($data)) {
    $query .= " and data = ".make_safe($data)." ";
    $number++;
}

if(!empty($arbitru)) {
    $query .= " and arbitru LIKE '%".make_safe($arbitru)."%' ";
    $number++;
}

if(!empty($cota_v1)) {
    $query .= " and cota_v1 = ".make_safe($cota_v1)." ";
    $number++;
}

if(!empty($cota_v2)) {
    $query .= " and cota_v2 = ".make_safe($cota_v2)." ";
    $number++;
}

if(!empty($cota_egal)) {
    $query .= " and cota_egal = ".make_safe($cota_egal)." ";
    $number++;
	}
if($number==0){
    $query = "SELECT count(id) as 'count' FROM istoric_meciuri";
}


	//echo $page." ";
	$res = mysqli_query($GLOBALS['conn'],$query);
	while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
		$count = $row['count'];
	}	
	return $count;
}

	function getPoll($id_meci){
		$id_meci = make_safe($id_meci);
		
		$query = "SELECT * from poll  WHERE id_meci='$id_meci'";
		$res = mysqli_query($GLOBALS['conn'],$query);
		
		
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			
			$output .= $row['intrebare']."<br>";
			$output .= "<form method=\"POST\"action=\"vote.php\">";
			$output .= "<input type=\"radio\" name=\"r\" value=\"A\">".$row['raspuns1']."<br>";
			$output .= "<input type=\"radio\" name=\"r\" value=\"B\">".$row['raspuns2']."<br>";
			$output .= "<input type=\"radio\" name=\"r\" value=\"C\">".$row['raspuns3']."<br>";
			$output .= "<input type=\"hidden\" name=\"id_meci\" value=\"".$id_meci."\"/>";
			$output .= "<input type=\"submit\" name=\"submit\" value=\"Voteaza\"/><br>";

				
		}
		$output .="</form>";
		return $output;
	}

	function poolVote($answer,$id_meci){
		
		$answer = make_safe($answer);
		$id_meci = make_safe($id_meci);
		if($answer=="A"){
			$query = "SELECT vot1 FROM poll WHERE id_meci=".$id_meci;	
		}else if($answer=="B"){
			$query = "SELECT vot2 FROM poll WHERE id_meci=".$id_meci;	
		}else if($answer=="C"){
			$query = "SELECT vot3 FROM poll WHERE id_meci=".$id_meci;	
		}
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			if($answer=="A"){
				$vot = $row['vot1']+1;
				$query = "UPDATE poll SET vot1 = '".$vot."' WHERE id_meci='".$id_meci."'";	
			}else if($answer=="B"){
				$vot = $row['vot2']+1;
				$query = "UPDATE poll SET vot2 = '".$vot."' WHERE id_meci='".$id_meci."'";	
			}else if($answer=="C"){
				$vot = $row['vot3']+1;
				$query = "UPDATE poll SET vot3 = '".$vot."' WHERE id_meci='".$id_meci."'";	
			}
				
		}
		return execute_query($GLOBALS['conn'],$query);
		
	}
	
	function getPoolResultsA($id_meci){
		$id_meci = make_safe($id_meci);
		
		$query = "SELECT vot1 FROM poll WHERE id_meci='".$id_meci."'";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			return $row['vot1'];	
		}
	}
	
	function getPoolResultsB($id_meci){
		$id_meci = make_safe($id_meci);
		
		$query = "SELECT vot2 FROM poll WHERE id_meci='".$id_meci."'";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			return $row['vot2'];	
		}
	}
	
	function getPoolResultsC($id_meci){
		$id_meci = make_safe($id_meci);
		
		$query = "SELECT vot3 FROM poll WHERE id_meci='".$id_meci."'";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			return $row['vot3'];	
		}
	}
	
	function getPollResults($id_meci){
		
		
		$id_meci = make_safe($id_meci);
		
		

		$answerA = getPoolResultsA($id_meci);
		$answerB = getPoolResultsB($id_meci);
		$answerC = getPoolResultsC($id_meci);
		
		$imgWidthA = $answerA;
		$imgWidthB = $answerB;
		$imgWidthC = $answerC;
		
		$totalP = $answerA + $answerB + $answerC;
		
		$percentA = (($answerA * 100) / $totalP);
		$percentA = floor($percentA);
		
		$percentB = (($answerB * 100) / $totalP);
		$percentB = floor($percentB);
		
		$percentC = (($answerC * 100) / $totalP);
		$percentC = floor($percentC);
		
		$imgWidthA = $percentA * 2;
		$imgWidthB = $percentB * 2;
		$imgWidthC = $percentC * 2;
		
		$imgHeight = $imgHeight = '10';


		$imgTagA = "<img src = 'red.jpg' height = " . $imgHeight . " width = " . $imgWidthA. ">";
		$imgTagB = "<img src = 'red.jpg' height = " . $imgHeight . " width = " . $imgWidthB . ">";
		$imgTagC = "<img src = 'red.jpg' height = " . $imgHeight . " width = " . $imgWidthC . ">";
		
		$query = "SELECT intrebare,raspuns1,raspuns2,raspuns3 FROM poll WHERE id_meci = '".$id_meci."'";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output .= $row['intrebare']."<br>";	
			$output .= $imgTagA." ".$percentA."% ".$row['raspuns1']."<br>";
			$output .= $imgTagB." ".$percentB."% ".$row['raspuns2']."<br>";
			$output .= $imgTagC." ".$percentC."% ".$row['raspuns3']."<br>";
		}
		
		return $output;
	}
	
	function forgotPass($email){
		
		$email = make_safe($email);
		$query = "SELECT email,parola FROM users WHERE email='".$email."'";
		$res = mysqli_query($GLOBALS['conn'],$query);
		$count = mysqli_num_rows($res);
		
		if($count == 1){
			while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
				$parola = $row['parola'];
			}
			$msg = "Parola dumneavoastra este:".$parola.". Daca nu ati solicitat schimbarea parolei ignorati acest e-mail".
			$msg = wordwrap($msg,70);
			mail($email,"Recuperare parola",$msg);
			$response = "A fost trimis un e-mail cu parola dumneavoastra";	
		}else{
			$response = "Adresa de e-mail este invalida";	
		}
		return $response;
	}
	
	function getUserCompetitions($user){
		$user = make_safe($user);
		$query .= "SELECT c.id,c.nume,c.nr_echipe,c.id_sport,c.nr_echipe_calificate FROM competitii_test as c JOIN echipe_participante as e ON c.id=e.id_competitie WHERE e.nume='".$user."'";
		//echo $query;
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
				$output .="<a href=\"competitie_user.php?id_comp=".$row['id']."\">";
				$output .="<table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\">";
				$output .="<tr style=\"border:#666666 solid 2px;\"><td>Nume</td><td>Numar echipe</td><td>Numar echipe calificate</td><td>Sport</td>";
				$output .="<tr>";
				$output .="<td>".$row['nume']."</td>";
				$output .="<td>".$row['nr_echipe']."</td>";
				$output .="<td>".$row['nr_echipe_calificate']."</td>";
				$output .="<td>".$row['id_sport']."</td>";
				$output .="</tr>";
				$output .="</table></a>";
		}
		
		return $output;
		
	}
	
	function showGroupsUser($id_comp){ 
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM competitii_test WHERE id = '$id_comp' and private=1";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$nr_echipe = $row['nr_echipe'];
			$echipe_calif = $row['nr_echipe_calificate'];
			
		}
		////echo $nr_echipe." ".$echipe_calif."<br>";
		
		$query = "SELECT * FROM echipe_participante WHERE id_competitie = '$id_comp' ORDER BY grupa,puncte DESC";
		$res = mysqli_query($GLOBALS['conn'],$query);
		$group_change = "A";
		$pos = 1;
		$output .= "<a href =\"meciuri_grupa_user.php?id_comp=".$id_comp."&grupa=A\">";
		$output .="<table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\"><tr><td>Grupa A</td><td>Echipa</td><td>MJ</td><td>V</td><td>E</td><td>I</td><td>G</td><td>pct</td><tr>";
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
				$grupa = $row['grupa'];
				if($grupa!=$group_change){
					$output .="</table></a><br>";	
					$output .= "<a href = \"meciuri_grupa_user.php?id_comp=".$id_comp."&grupa=".$grupa."\">";
					$output .="<table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\"><tr><td>Grupa".$row['grupa']."</td><td>Echipa</td><td>MJ</td><td>V</td><td>E</td><td>I</td><td>G</td><td>pct</td><tr>";
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
	
	function showKnockoutUser($id_comp){
		
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM competitii_test WHERE id='$id_comp' and private=1";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$echipe_calif = $row['nr_echipe_calificate'];
			$nr_echipe = $row['nr_echipe'];
		}
		if($nr_echipe/4*$echipe_calif==16){
			$output_k = "Optimi<br>";	
			$output_k .= get_optimi_user($id_comp)."<br><br>";
			$output_k .=  "Sferturi<br>";
			$output_k .=  get_sferturi($id_comp)."<br><br>";
			$output_k .=  "Semnifinale<br>";
			$output_k .=  get_semifinale_user($id_comp)."<br><br>";
			$output_k .=  "Finala<br>";
			$output_k .=  get_finala_user($id_comp)."<br>";
		}else if($nr_echipe/4*$echipe_calif==8){
				$output_k = "Sferturi<br>";
				$output_k .= get_sferturi_user($id_comp)."<br><br>";
				$output_k .= "Semnifinale<br>";
				$output_k .= get_semifinale_user($id_comp)."<br><br>";
				$output_k .= "Finala<br>";
				$output_k .= get_finala_user($id_comp)."<br>";
			}else if($nr_echipe/4*$echipe_calif==4){
				$output_k .= "Semnifinale<br>";
				$output_k .= get_semifinale_user($id_comp)."<br><br>";
				$output_k .= "Finala<br>";
				$output_k .= get_finala_user($id_comp)."<br>";
			} else if($nr_echipe/4*$echipe_calif==2){
				$output_k .= "Finala<br>";
				$output_k .= get_finala_user($id_comp)."<br>";	
			} 
			
			return $output_k;
		
	}
	
	

	function getMatchesFromGroupUser($id_comp,$grupa){
	
		$id_comp = make_safe($id_comp); 
		$grupa = make_safe($grupa); 
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND grupa='$grupa'";
		$res = mysqli_query($GLOBALS['conn'],$query);
		$output = "<br>";
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output .= "<a href = \"http://students.info.uaic.ro/~rares.nechita/weBall/views/actualizeaza_meci.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$row['echipa1']."&echipa2=".$row['echipa2']."\"><table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\"><tr>";
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
			$output .= "</tr></table></a>";
			//echo $output;
		}
		return $output;
	}
	
	
	function updateCompetitionGroupsUser($id_comp){
		
		$id_comp = make_safe($id_comp);
		$status = true;
		$query = "SELECT * FROM competitii_test WHERE id='$id_comp' and private =1";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$echipe_calif = $row['nr_echipe_calificate'];	
		}
		$query = "SELECT * FROM echipe_participante WHERE id_competitie = '$id_comp' ORDER BY grupa,puncte DESC";
		$res = mysqli_query($GLOBALS['conn'],$query);
		$index=1;
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			if($echipe_calif==1){
				if($index%4==1){
					$query = "UPDATE competitii_test SET ".($index%4).$row['grupa']."='".$row['nume']."' WHERE id='$id_comp'";
					if(!mysqli_query($GLOBALS['conn'],$query)){
						//echo $query."<br>"; // DEVELOPMENTAL
						$status = false;
					}
					else{
						$link = "location:http://students.info.uaic.ro/~rares.nechita/weBall/competitie_user.php?id_comp=".$_GET['id_comp'];
						header($link);
					}	
				}
			}else if($echipe_calif==2){
				if($index%4==1 || $index%4==2){
					$query = "UPDATE competitii_test SET ".($index%4).$row['grupa']."='".$row['nume']."' WHERE id='$id_comp'";
					if(!mysqli_query($GLOBALS['conn'],$query)){
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
	
	function updateCompetitionKnockoutUser($id_comp){
		
		$id_comp = make_safe($id_comp);
		$status = true;
		$query = "SELECT * FROM competitii_test WHERE id='$id_comp' and private=1";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$echipe_calif = $row['nr_echipe_calificate'];
			$nr_echipe = $row['nr_echipe'];
			if($nr_echipe/4*$echipe_calif==1){
				$query = "UPDATE competitii_test SET FIN='".$row['nume']."' WHERE id='$id_comp'";
					$status = execute_query($GLOBALS['conn'],$query);
			}else if($nr_echipe/4*$echipe_calif==2){
				if($echipe_calif==1){
					$query = "UPDATE meciuri SET echipa1='".$row['1A']."',echipa2='".$row['1B']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='FIN'";
					
					$status = execute_query($GLOBALS['conn'],$query);
					
				}else{
					$query = "UPDATE meciuri SET echipa1='".$row['1A']."',echipa2='".$row['2A']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='FIN'";
					
					$status = execute_query($GLOBALS['conn'],$query);
				}
			}
				else if($nr_echipe/4*$echipe_calif==4){
					if($echipe_calif==1){
						
						$query = "UPDATE meciuri SET echipa1='".$row['1A']."',echipa2='".$row['1C']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF1'";
						
						$status = execute_query($GLOBALS['conn'],$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['1B']."',echipa2='".$row['1D']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF2'";
	
						$status = execute_query($GLOBALS['conn'],$query);
						
						$finalista1 = get_winner($GLOBALS['conn'],$id_comp,"SF1");
						$finalista2 = get_winner($GLOBALS['conn'],$id_comp,"SF2");
						
						$query = "UPDATE meciuri SET echipa1='".$finalista1."',echipa2='".$finalista2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='FIN'";
	
						$status = execute_query($GLOBALS['conn'],$query);
						
					
				}else if($echipe_calif==2){
					
						
						
						//
						$query = "UPDATE meciuri SET echipa1='".$row['1A']."',echipa2='".$row['2B']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF1'";
						
						$status = execute_query($GLOBALS['conn'],$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['2A']."',echipa2='".$row['1B']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF2'";
	
						$status = execute_query($GLOBALS['conn'],$query);
						
						$finalista1 = get_winner($GLOBALS['conn'],$id_comp,"SF1");
						$finalista2 = get_winner($GLOBALS['conn'],$id_comp,"SF2");
						
						$query = "UPDATE meciuri SET echipa1='".$finalista1."',echipa2='".$finalista2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='FIN'";
	
						$status = execute_query($GLOBALS['conn'],$query);
				}
			}
			else if($nr_echipe/4*$echipe_calif==8){
					if($echipe_calif==1){
						$query = "UPDATE meciuri SET echipa1='".$row['1A']."',echipa2='".$row['1C']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S1'";
						
						$status = execute_query($GLOBALS['conn'],$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['1E']."',echipa2='".$row['1G']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S2'";
	
						$status = execute_query($GLOBALS['conn'],$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['1B']."',echipa2='".$row['1D']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S3'";
	
						$status = execute_query($GLOBALS['conn'],$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['1F']."',echipa2='".$row['1H']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S4'";
	
						$status = execute_query($GLOBALS['conn'],$query);
						
					
					
				}else if($echipe_calif==2){
					$query = "UPDATE meciuri SET echipa1='".$row['1A']."',echipa2='".$row['2B']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S1'";
						
						$status = execute_query($GLOBALS['conn'],$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['1C']."',echipa2='".$row['2D']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S2'";
	
						$status = execute_query($GLOBALS['conn'],$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['1B']."',echipa2='".$row['2A']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S3'";
	
						$status = execute_query($GLOBALS['conn'],$query);
						
						$query = "UPDATE meciuri SET echipa1='".$row['1D']."',echipa2='".$row['2C']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S4'";
	
						$status = execute_query($GLOBALS['conn'],$query);
						
				}
				$sf1_1 = get_winner($GLOBALS['conn'],$id_comp,"S1");
				$sf1_2 = get_winner($GLOBALS['conn'],$id_comp,"S2");
				$sf2_1 = get_winner($GLOBALS['conn'],$id_comp,"S3");
				$sf2_2 = get_winner($GLOBALS['conn'],$id_comp,"S4");
				$query = "UPDATE meciuri SET echipa1='".$sf1_1."',echipa2='".$sf1_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF1'";
						
				$status = execute_query($GLOBALS['conn'],$query);
						
				$query = "UPDATE meciuri SET echipa1='".$sf2_1."',echipa2='".$sf2_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF2'";
	
				$status = execute_query($GLOBALS['conn'],$query);
						
				$finalista1 = get_winner($GLOBALS['conn'],$id_comp,"SF1");
				$finalista2 = get_winner($GLOBALS['conn'],$id_comp,"SF2");
						
				$query = "UPDATE meciuri SET echipa1='".$finalista1."',echipa2='".$finalista2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='FIN'";
	
				$status = execute_query($GLOBALS['conn'],$query);
				
				
				
				
			}else if($nr_echipe/4*$echipe_calif==16){
				
				$query = "UPDATE meciuri SET echipa1='".$row['1A']."',echipa2='".$row['2B']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O1'";
				$status = execute_query($GLOBALS['conn'],$query);
				
				$query = "UPDATE meciuri SET echipa1='".$row['1C']."',echipa2='".$row['2D']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O2'";
				$status = execute_query($GLOBALS['conn'],$query);
				
				$query = "UPDATE meciuri SET echipa1='".$row['1E']."',echipa2='".$row['2F']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O3'";
				$status = execute_query($GLOBALS['conn'],$query);
				
				$query = "UPDATE meciuri SET echipa1='".$row['1G']."',echipa2='".$row['2H']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O4'";
				$status = execute_query($GLOBALS['conn'],$query);
				
				$query = "UPDATE meciuri SET echipa1='".$row['1B']."',echipa2='".$row['2A']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O5'";
				$status = execute_query($GLOBALS['conn'],$query);
				
				$query = "UPDATE meciuri SET echipa1='".$row['1D']."',echipa2='".$row['2C']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O6'";
				$status = execute_query($GLOBALS['conn'],$query);
				
				$query = "UPDATE meciuri SET echipa1='".$row['1F']."',echipa2='".$row['2E']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O7'";
				$status = execute_query($GLOBALS['conn'],$query);
				
				$query = "UPDATE meciuri SET echipa1='".$row['1H']."',echipa2='".$row['2G']."'  WHERE id_competitie = '$id_comp' AND faza_competitie='O8'";
				$status = execute_query($GLOBALS['conn'],$query);
			
			
				$s1_1 = get_winner($GLOBALS['conn'],$id_comp,"O1");
				$s1_2 = get_winner($GLOBALS['conn'],$id_comp,"O2");
				
				$s2_1 = get_winner($GLOBALS['conn'],$id_comp,"O3");
				$s2_2 = get_winner($GLOBALS['conn'],$id_comp,"O4");
				
				$s3_1 = get_winner($GLOBALS['conn'],$id_comp,"O5");
				$s3_2 = get_winner($GLOBALS['conn'],$id_comp,"O6");
				
				$s4_1 = get_winner($GLOBALS['conn'],$id_comp,"O7");
				$s4_2 = get_winner($GLOBALS['conn'],$id_comp,"O8");
				
				$query = "UPDATE meciuri SET echipa1='".$s1_1."',echipa2='".$s1_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S1'";
				$status = execute_query($GLOBALS['conn'],$query);	
				
				$query = "UPDATE meciuri SET echipa1='".$s2_1."',echipa2='".$s2_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S2'";
				$status = execute_query($GLOBALS['conn'],$query);	
				
				$query = "UPDATE meciuri SET echipa1='".$s3_1."',echipa2='".$s3_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S3'";
				$status = execute_query($GLOBALS['conn'],$query);	
				
				$query = "UPDATE meciuri SET echipa1='".$s4_1."',echipa2='".$s4_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='S4'";
				$status = execute_query($GLOBALS['conn'],$query);			
				
				$sf1_1 = get_winner($GLOBALS['conn'],$id_comp,"S1");
				$sf1_2 = get_winner($GLOBALS['conn'],$id_comp,"S2");
				$sf2_1 = get_winner($GLOBALS['conn'],$id_comp,"S3");
				$sf2_2 = get_winner($GLOBALS['conn'],$id_comp,"S4");
				$query = "UPDATE meciuri SET echipa1='".$sf1_1."',echipa2='".$sf1_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF1'";
						
				$status = execute_query($GLOBALS['conn'],$query);
						
				$query = "UPDATE meciuri SET echipa1='".$sf2_1."',echipa2='".$sf2_2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='SF2'";
	
				$status = execute_query($GLOBALS['conn'],$query);
						
				$finalista1 = get_winner($GLOBALS['conn'],$id_comp,"SF1");
				$finalista2 = get_winner($GLOBALS['conn'],$id_comp,"SF2");
						
				$query = "UPDATE meciuri SET echipa1='".$finalista1."',echipa2='".$finalista2."'  WHERE id_competitie = '$id_comp' AND faza_competitie='FIN'";
	
				$status = execute_query($GLOBALS['conn'],$query);
			
			}

		}
		
		return $status;
	}
	
	function getCompIDUser(){
			$query = "SELECT id FROM competitii_test ORDER BY id desc";
			$res = mysqli_query($GLOBALS['conn'],$query); 
			while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
					$id_comp = $row['id'];
					break;
			}
			return $id_comp;
	}
	
	function updateGroupUser($id_comp,$grupa){
		
		$id_comp = make_safe($id_comp);
		$grupa = make_safe($grupa);
		$status = true;
		$query = "UPDATE echipe_participante SET victorii=0,egaluri=0,infrangeri=0,puncte=0,goluri_marcate=0, goluri_primite=0 WHERE id_competitie = '$id_comp' AND grupa='$grupa'";
		$status = execute_query($GLOBALS['conn'],$query);
	
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND grupa='$grupa'";
		$res = mysqli_query($GLOBALS['conn'],$query);
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
				$result = mysqli_query($GLOBALS['conn'],$query);
				while($rowe = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					$victorii1 = $rowe['victorii'];
					$egaluri1 = $rowe['egaluri'];
					$infrangeri1 = $rowe['infrangeri'];
					$goluri_marcate1 = $rowe['goluri_marcate'];
					$goluri_primite1 = $rowe['goluri_primite'];
					$puncte1 = $rowe['puncte'];
				}
				
				$query = "SELECT * FROM echipe_participante WHERE id_competitie = '$id_comp' AND nume='$echipa2'";
				$result = mysqli_query($GLOBALS['conn'],$query);
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
					$status = execute_query($GLOBALS['conn'],$query);
						
					$query = "UPDATE echipe_participante SET infrangeri='".($infrangeri2+1)."',goluri_marcate='".($goluri_marcate2+$gol2)."',goluri_primite='".($goluri_primite2+$gol1)."' WHERE id_competitie = '$id_comp' AND nume='$echipa2'";
					$status = execute_query($GLOBALS['conn'],$query);
						
								
				}else if($gol1<$gol2){
					////echo $echipa1." ".$gol1." - ".$gol2." ".$echipa2."<br>";
					////echo "ECHIPA1:".$victorii1." ".$puncte1."<br>";
					////echo "ECHIPA2:".$victorii2." ".$puncte2."<br>";
					//ECHIPA 2 ESTE CASTIGATOARE
					$query = "UPDATE echipe_participante SET victorii='".($victorii2+1)."',puncte='".($puncte2 + 3)."',goluri_marcate='".($goluri_marcate2+$gol2)."' , goluri_primite='".($goluri_primite2+$gol1)."' WHERE id_competitie = '$id_comp' AND nume='$echipa2'";
					$status = execute_query($GLOBALS['conn'],$query);
					
					$query = "UPDATE echipe_participante SET infrangeri='".($infrangeri1+1)."',goluri_marcate='".($goluri_marcate1+$gol1)."' , goluri_primite='".($goluri_primite1 + $gol2)."' WHERE id_competitie = '$id_comp' AND nume='$echipa1'";
					$status = execute_query($GLOBALS['conn'],$query);
						
				}else{
					//EGALITATE
					//echo $echipa1." ".$gol1." - ".$gol2." ".$echipa2."<br>";
					//echo "ECHIPA1:".$victorii1." ".$puncte1."<br>";
					//echo "ECHIPA2:".$victorii2." ".$puncte2."<br>";
					$query = "UPDATE echipe_participante SET egaluri='".($egaluri1+1)."',puncte='".($puncte1 + 1)."',goluri_marcate='".($goluri_marcate1+$gol1)."' , goluri_primite='".($goluri_primite1+$gol2)."' WHERE id_competitie = '$id_comp' AND nume='$echipa1'";
					
					$status = execute_query($GLOBALS['conn'],$query);
					
					$query = "UPDATE echipe_participante SET egaluri='".($egaluri2+1)."',puncte='".($puncte2 + 1)."',goluri_marcate='".($goluri_marcate2+$gol2)."' , goluri_primite='".($goluri_primite2+$gol1)."' WHERE id_competitie = '$id_comp' AND nume='$echipa2'";
					$status = execute_query($GLOBALS['conn'],$query);
				}
			}
		}
		return $status;
	}
	
	
	function get_optimi_user($id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND faza_competitie IN ('O1','O2','O3','O4','O5','O6','O7','O8')";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$echipa1 = $row['echipa1'];
			$echipa2 = $row['echipa2'];
			if(is_null($echipa1)|| empty($echipa1)){
				$echipa1="TBD";
			}
			if(is_null($echipa2) || empty($echipa2)){
				$echipa2="TBD";	
			}
			$output_optimi .= "<a href = \"http://students.info.uaic.ro/~rares.nechita/weBall/views/actualizeaza_meci.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$echipa1."&echipa2=".$echipa2."\"><table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\"><tr>";
			$output_optimi .= "<td>".$echipa1."</td>";
			
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
			$output_optimi .= "<td>".$echipa2."</td>";
			$output_optimi .= "</tr></table><br></a>";
		}	
		return $output_optimi;
	}
	
	// FUNCTIE CARE RETURNEAZA MECIURILE DIN SFERTURI
	function get_sferturi_user($id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND faza_competitie IN ('S1','S2','S3','S4')";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output_sferturi .="<a href = \"http://students.info.uaic.ro/~rares.nechita/weBall/views/actualizeaza_meci.php.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$row['echipa1']."&echipa2=".$row['echipa2']."\"><table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\"><tr>";
			
			$echipa1 = $row['echipa1'];
			$echipa2 = $row['echipa2'];
			if(is_null($echipa1)|| empty($echipa1)){
				$echipa1="TBD";
			}
			if(is_null($echipa2) || empty($echipa2)){
				$echipa2="TBD";	
			}
			
			if($row['goluri_echipa1']==-1){
				$gol1 = " ";		
				$gol2 = " ";
			}else{
				$gol1 = $row['goluri_echipa1'];
				$gol2 = $row['goluri_echipa2'];
			}
			$output_sferturi .= "<td>".$echipa1."</td>";
			$output_sferturi .= "<td>".$gol1."</td>";
			$output_sferturi .= "<td> - </td>";
			$output_sferturi .= "<td>".$gol2."</td>";
			$output_sferturi .= "<td>".$echipa2."</td>";
			$output_sferturi .= "</tr></table><br></a>";
		}	
		return $output_sferturi;
	}
	
	// FUNCTIE CARE RETURNEAZA MECIURILE DIN SEMIFINALE
	function get_semifinale_user($id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND faza_competitie IN ('SF1','SF2')";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output_semifinale .= "<a href = \"http://students.info.uaic.ro/~rares.nechita/weBall/views/actualizeaza_meci.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$row['echipa1']."&echipa2=".$row['echipa2']."\"><table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\"><tr>";
			
			$echipa1 = $row['echipa1'];
			$echipa2 = $row['echipa2'];
			if(is_null($echipa1)|| empty($echipa1)){
				$echipa1="TBD";
			}
			if(is_null($echipa2) || empty($echipa2)){
				$echipa2="TBD";	
			}
			
			if($row['goluri_echipa1']==-1){
				$gol1 = " ";		
				$gol2 = " ";
			}else{
				$gol1 = $row['goluri_echipa1'];
				$gol2 = $row['goluri_echipa2'];
			}
			$output_semifinale .= "<td>".$echipa1."</td>";
			$output_semifinale .= "<td>".$gol1."</td>";
			$output_semifinale .= "<td> - </td>";
			$output_semifinale .= "<td>".$gol2."</td>";
			$output_semifinale .= "<td>".$echipa2."</td>";
			$output_semifinale .= "</tr></table><br></a>";
		}	
		return $output_semifinale;
	}
	
	// FUNCTIE CARE RETURNEAZA MECIURILE DIN FINALA
	function get_finala_user($id_comp){
	
		$id_comp = make_safe($id_comp);
		$query = "SELECT * FROM meciuri WHERE id_competitie = '$id_comp' AND faza_competitie IN ('FIN')";
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output_finala .= "<a href = \"http://students.info.uaic.ro/~rares.nechita/weBall/views/actualizeaza_meci.php?id_comp=".$id_comp."&id_meci=".$row['id']."&echipa1=".$row['echipa1']."&echipa2=".$row['echipa2']."\"><table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\"><tr>";
			
			$echipa1 = $row['echipa1'];
			$echipa2 = $row['echipa2'];
			if(is_null($echipa1)|| empty($echipa1)){
				$echipa1="TBD";
			}
			if(is_null($echipa2) || empty($echipa2)){
				$echipa2="TBD";	
			}
			if($row['goluri_echipa1']==-1){ 
				$gol1 = " ";		
				$gol2 = " ";
			}else{
				$gol1 = $row['goluri_echipa1'];
				$gol2 = $row['goluri_echipa2'];
			}
			$output_finala .= "<td>".$echipa1."</td>";
			$output_finala .= "<td>".$gol1."</td>";
			$output_finala .= "<td> - </td>";
			$output_finala .= "<td>".$gol2."</td>";
			$output_finala .= "<td>".$echipa2."</td>";
			$output_finala .= "</tr></table><br></a>";
		}	
		return $output_finala;
	}
	
	function getSearchCompetition($comp_name,$type){
		
		$comp_name = make_safe($comp_name);
		$comp_name = set_search($comp_name);
		$type = make_safe($type);
		if($type=="public"){
			$query = "SELECT * FROM competitii_test WHERE nume LIKE '%$comp_name%' AND private = 0";
		}else{
			$query = "SELECT * FROM competitii_test WHERE nume LIKE '%$comp_name%' AND private = 1";
		}
		$res = mysqli_query($GLOBALS['conn'],$query);
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$output .="<a href=\"competitie.php?id_comp=".$row['id']."&page=".$page."\">";
				$output .="<table style=\"margin:auto;color:#0088FF;
	text-align:center;
	border: thin solid #CCC;\">";
				$output .="<tr style=\"border:#666666 solid 2px;\"><td>Nume</td><td>Numar echipe</td><td>Numar echipe calificate</td>";
				$output .="<tr>";
				$output .="<td>".$row['nume']."</td>";
				$output .="<td>".$row['nr_echipe']."</td>";
				$output .="<td>".$row['nr_echipe_calificate']."</td>";
				$output .="</tr>";
				$output .="</table></a>";
		}
		
		return $output;
			
	}
	
	
?>
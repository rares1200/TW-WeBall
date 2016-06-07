<?php
include('config.php');
include('client_controller.php');



if(isset($_GET['search'])){
		$output = get_match_search($_GET['gazda'],$_GET['oaspete'],$_GET['scor1'],$_GET['scor2'],$_GET['data'],$_GET['arbitru'],$_GET['cota_v1'],$_GET['cota_egal'],$_GET['cota_v2'],$_GET['page']);
		$count = get_match_count($_GET['gazda'],$_GET['oaspete'],$_GET['scor1'],$_GET['scor2'],$_GET['data'],$_GET['arbitru'],$_GET['cota_v1'],$_GET['cota_egal'],$_GET['cota_v2']);
}

if(isset($_GET['page'])){
		$output = get_match_search($_GET['gazda'],$_GET['oaspete'],$_GET['scor1'],$_GET['scor2'],$_GET['data'],$_GET['arbitru'],$_GET['cota_v1'],$_GET['cota_egal'],$_GET['cota_v2'],$_GET['page']);
		$count = get_match_count($_GET['gazda'],$_GET['oaspete'],$_GET['scor1'],$_GET['scor2'],$_GET['data'],$_GET['arbitru'],$_GET['cota_v1'],$_GET['cota_egal'],$_GET['cota_v2']);
}

	/*
}
$query = "SELECT *
FROM istoric_meciuri
WHERE 1 = 1 ";
//below used for testing can be remove
//$_GET['name'] = 'test';
//$_GET['car'] = 'test2';
//$_GET['type'] = 'test3';
$number = 0;
if(!empty($_GET['gazda'])) {
    $query .= " and echipa1 LIKE '%".make_safe($db,$_GET['gazda'])."%' ";
    $number++;
}

if(!empty($_GET['oaspete'])) {
    $query .= " and echipa2 LIKE '%".make_safe($db,$_GET['oaspete'])."%' ";
    $number++;
}

if(!empty($_GET['scor1'])) {
    $query .= " and goluri_echipa1 = ".make_safe($db,$_GET['scor1'])." ";
    $number++;
}

if(!empty($_GET['scor2'])) {
    $query .= " and goluri_echipa2 = ".make_safe($db,$_GET['scor2'])." ";
    $number++;
}

if(!empty($_GET['data'])) {
    $query .= " and data = ".make_safe($db,$_GET['data'])." ";
    $number++;
}

if(!empty($_GET['arbitru'])) {
    $query .= " and arbitru LIKE '%".make_safe($db,$_GET['arbitru'])."%' ";
    $number++;
}

if(!empty($_GET['cota_v1'])) {
    $query .= " and cota_v1 = ".make_safe($db,$_GET['cota_v1'])." ";
    $number++;
}

if(!empty($_GET['cota_v2'])) {
    $query .= " and cota_v2 = ".make_safe($db,$_GET['cota_v2'])." ";
    $number++;
}

if(!empty($_GET['cota_egal'])) {
    $query .= " and cota_egal = ".make_safe($db,$_GET['cota_egal'])." ";
    $number++;
	}
if($number>0) {
	$query .= " LIMIT 0,500";
} else {
    $query = "SELECT * FROM istoric_meciuri LIMIT 0,500";
}

if(isset($_GET['search'])){
	$res = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
		$output_result .="<tr><td>".$row['data']."</td><td>".$row['echipa1']."</td><td>".$row['goluri_echipa1']." - ".$row['goluri_echipa2']."</td><td>"
		.$row['echipa2']."</td><td>".$row['arbitru']."</td><td>".$row['cota_v1']."</td><td>".$row['cota_egal']."</td><td>".$row['cota_v2']."</td></tr>";
	}
}*/
?>

<html>
<head>
 <link href="Style.css" rel="stylesheet" type="text/css">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<title>
	Home
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
<form>

	<label>Gazda</label>
    <input type="text" name="gazda"/>
    <label>Oaspete</label>
    <input type="text" name="oaspete"/> <br><br>
    <label>Scor</label>
    <input type="number" name="scor1"/>
    <input type="number" name="scor2"/>
    <label>Data</label>
    <input type="date" name="data"/><br><br>
	<label>Arbitru</label>
    <input type="text" name="arbitru"/>
    <label>Cota victorie gazda</label>
    <input type="number" step="any" name="cota_v1" /><br><br>
    <label>Cota egal</label>
    <input type="number" step="any" name="cota_egal"/>
   <label>Cota victorie oaspete</label>
    <input type="number" step="any" name="cota_v2" />
    <input type="hidden" name="page" value="1"/>
    <input type="hidden" name = "search" />
    <input type="submit" value="Cauta"/>
</form>
<br>
<table class="tabel">
<tr><td>Data</td><td>Gazda</td><td>Rezultat</td><td>Oaspete</td><td>Arbitru</td><td>Cota victorie gazda</td><td>Cota egal</td>
<td>Cota victorie oaspete</td></tr>
<?php echo $output;?>
</table>
<?php 
		if(!empty($output)){
			for($i=$_GET['page'];$i<=$count/50;$i++)
				if(($i-1)>0){
					echo "<a href=\"http://students.info.uaic.ro/~rares.nechita/weBall/?gazda=".$_GET['gazda']."&oaspete=".$_GET['oaspete']."&scor1=".$_GET['scor1']."&scor2=".$_GET['scor2']."&data=".$_GET['data']."&arbitru=".$_GET['arbitru']."&cota_v1=".$_GET['cota_v1']."&cota_egal=".$_GET['cota_egal']."&cota_v2=".$_GET['cota_v2']."&page=".($i-1)."\">".($i-1)."</a>"."  ";
				}
			for($i=$_GET['page'];$i<=$count/50;$i++) 
				echo "<a href=\"http://students.info.uaic.ro/~rares.nechita/weBall/?gazda=".$_GET['gazda']."&oaspete=".$_GET['oaspete']."&scor1=".$_GET['scor1']."&scor2=".$_GET['scor2']."&data=".$_GET['data']."&arbitru=".$_GET['arbitru']."&cota_v1=".$_GET['cota_v1']."&cota_egal=".$_GET['cota_egal']."&cota_v2=".$_GET['cota_v2']."&page=".($i+1)."\">".($i+1)."</a>"."  ";}?>
         


</div>		 
</body>
</html>


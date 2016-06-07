<?php

include("config.php");
header('Content-type: text/xml');

$id_comp = $_POST['id_comp'];
$query = 'SELECT * FROM echipe_participante WHERE id_competitie = '.$id_comp.' ORDER BY grupa,puncte DESC';

$result = mysqli_query($db,$query);

/*while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		
}*/


?>


<feed xml:lang="en-US" xmlns="http://www.w3.org/2005/Atom"> 
  			<title>Grupele competitiei</title> 
			<subtitle>Grupele competitiei</subtitle>
 			<link href="http://www.students.info.uaic.ro/~rares.nechita/weBall/atom.php" rel="self"/> 
  			<author> 
				<name>Rares</name>
				<email>rares1200@gmail.com</email>
			</author>
			<id>tag:WeBall:http://www.students.info.uaic.ro/~rares.nechita/weBall/atom.php</id> 
 

			<?php
				$i = 0;
				while($row = mysql_fetch_array($result))
				  {
				  if ($i > 0) {
				  	echo "</entry>";
				  }
				  $articleDate = $row['posted'];
				  $articleDateRfc3339 = date3339(strtotime($articleDate));
				  echo "<entry>";
				  echo "<id_comp>";
				  echo $row['id_competitie'];
				  echo "</title>";
				  echo "<link type='text/html' href='http://students.info.uaic.ro/~rares.nechita/weBall/competitie.php?id_comp=".$row['id_competitie']."'/>";
				    echo "<name>";
				    echo $row['nume'];
				    echo "</name>";
					echo "<wins>";
					echo $row['victorii'];
					echo "</wins>";
					echo "<draws>";
					echo $row['egaluri'];
					echo "</draws>";
					echo "<loses>";
					echo $row['infrangeri'];
					echo "</loses>";
					echo "<goals_scored>";
					echo $row['goluri_marcate'];
					echo "</goals_scored>";
					echo "<goals_conceded>";
					echo $row['goluri_primite'];
					echo "</goals_conceded>";
					echo "<competition_round>";
					echo $row['faza_competitie'];
					echo "</competition_round>";
					echo "<group>";
					echo $row['grupa'];
					echo "</group>";
					echo "<points>";
					echo $row['puncte'];
					echo "</points>";
				  $i++;
				}			
			?>
			</entry>
		</feed>
	
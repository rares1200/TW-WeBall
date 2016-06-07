<?php

include('session.php');
function write_from_csv_to_pl($filename,$db){
	$row = 1;
		$first =true;
		$succes = true;
		if (($handle = fopen("E0.csv", "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {
			$num = count($data);
			//echo "<p> $num fields in line $row: <br /></p>\n";
			$row++;
			/*for ($c=0; $c < $num; $c++) {
				echo $data[$c] . "<br />\n";
			}*/
			if(!$first){
			/*  echo $data[1] . ",";
				echo $data[2] . ",";
				echo $data[3] . ",";
				echo $data[4] . ",";
				echo $data[5] . ",";
				echo $data[10] . ",";
				echo $data[24] . ",";
				echo $data[25] . ",";
				echo $data[26] . "<br>";*/
				$date = strtotime($data[1]);
				$newformat = date('Y-m-d',$date);
				//echo $newformat."<br>";
				if(!mysqli_query($db,"INSERT INTO istoric_meciuri(data,echipa1,echipa2,
						goluri_echipa1,goluri_echipa2,arbitru,cota_v1,cota_egal,cota_v2) VALUES('$newformat','$data[2]','$data[3]',
						$data[4],$data[5],'$data[10]','$data[24]','$data[25]','$data[26]')"))
						$succes = false;
						

			}
			$first = false;
			
		  }
		  fclose($handle);
		}
	if($succes)
		echo "INSERARE CU SUCCES!!!";
	else
		echo "INSERARE NEREUSITA!";
}


function write_from_csv_to_roe($filename,$db){
	$row = 1;
		$first =true;
		$succes = true;
		if (($handle = fopen("E0.csv", "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			//echo "<p> $num fields in line $row: <br /></p>\n";
			$row++;
			/*for ($c=0; $c < $num; $c++) {
				echo $data[$c] . "<br />\n";
			}*/
			if(!$first){
			/*  echo $data[1] . ",";
				echo $data[2] . ",";
				echo $data[3] . ",";
				echo $data[4] . ",";
				echo $data[5] . ",";
				echo $data[10] . ",";
				echo $data[24] . ",";
				echo $data[25] . ",";
				echo $data[26] . "<br>";*/
				$date = strtotime($data[1]);
				$newformat = date('Y-m-d',$date);
				if(!mysqli_query($db,"INSERT INTO istoric_meciuri(data,echipa1,echipa2,
						goluri_echipa1,goluri_echipa2,cota_v1,cota_egal,cota_v2) VALUES($newformat,'$data[2]','$data[3]',
						$data[4],$data[5],$data[22],$data[23],$data[24])"))
							$succes = false;
						

			}
			$first = false;
			
		  }
		  fclose($handle);
		}
	if($succes)
		echo "INSERARE CU SUCCES!!!";
	else
		echo "INSERARE NEREUSITA!";
}

write_from_csv_to_pl("E0.csv",$db);


?>
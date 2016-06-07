<?php

include('http://students.info.uaic.ro/~rares.nechita/weBall/session.php');
header('Content-type: text/html; charset=utf-8');
	$reqPrefs['http']['method'] = 'GET';
	$reqPrefs['http']['header'] = 'X-Auth-Token: 879e9ddeebb14b83ac2bf7596a81651b';
	$stream_context = stream_context_create($reqPrefs);
	$names="Echipe"."<br>";
	for($i=1;$i<10;$i++){
		$url = "http://api.football-data.org/v1/teams/".$i;
		$response = file_get_contents($url, false, $stream_context);
		$teams_array = json_decode($response,true);
		
		$name = $teams_array['name'];
		$value = $teams_array['squadMarketValue'];
		$logo = $teams_array['crestUrl'];
		$query = "INSERT INTO teams(nume,val_piata,link_logo,sport) VALUES('$name','$value','$logo','fotbal')";
		
		$succes = true;
		if(!mysqli_query($db,$query))
				$succes = false;
		if($succes)
			echo "INSERARE CU SUCCES!!!";
		else
			echo $query;
		
		echo $name.'<br>';
		echo $value.'<br>';
		echo $logo.'<br>';
	}
	
	
?>
<?php

include('config.php');
include('models/functions.php');
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=grupe.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
$id_comp = $_GET['id_comp'];
$id_comp = make_safe($id_comp);
// output the column headings
fputcsv($output, array('id', 'id_competitie', 'nume','victorii','egaluri','infrangeri','goluri_marcate','goluri_primite','faza_competitie','grupa','puncte'));

// fetch the data
$res = mysqli_query($db,'SELECT * FROM echipe_participante WHERE id_competitie = '.$id_comp.' ORDER BY grupa,puncte DESC');

// loop over the rows, outputting them
while($row = mysqli_fetch_array($res,MYSQLI_ASSOC))
	fputcsv($output, $row);

?>
<?php



include('config.php');
include('models/functions.php');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=knockout.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
$id_comp = $_GET['id_comp'];
$id_comp = make_safe($id_comp);
// output the column headings
fputcsv($output, array('id', 'id_competitie', 'echipa1','echipa2','goluri_echipa1','goluri_echipa2','faza_competitie','data'));

// fetch the data
$query = "SELECT id,id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,data FROM meciuri WHERE id_competitie = '".$id_comp."' AND faza_competitie!='G'";
$res = mysqli_query($db,$query);

// loop over the rows, outputting them
while($row = mysqli_fetch_array($res,MYSQLI_ASSOC))
	fputcsv($output, $row);



?>
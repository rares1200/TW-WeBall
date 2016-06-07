<?

include('config.php');
include('models/functions.php');

header('Content-Type: application/json');
$id_comp = $_GET['id_comp'];
$id_comp = make_safe($id_comp);

$query = "SELECT id,id_competitie,echipa1,echipa2,goluri_echipa1,goluri_echipa2,faza_competitie,data FROM meciuri WHERE id_competitie = '".$id_comp."' AND faza_competitie!='G'";
$res = mysqli_query($db,$query);

while($row = mysqli_fetch_array($res,MYSQLI_ASSOC))
	$posts[] = $row;
	
echo json_encode($posts);


?>
<?

include('config.php');
include('models/functions.php');

header('Content-Type: application/json');
$id_comp = $_GET['id_comp'];
$id_comp = make_safe($id_comp);

$query = "SELECT * FROM echipe_participante WHERE id_competitie = ".$id_comp." ORDER BY grupa,puncte DESC";
$res = mysqli_query($db,$query);

while($row = mysqli_fetch_array($res,MYSQLI_ASSOC))
	$posts[] = $row;
	
echo json_encode($posts);


?>
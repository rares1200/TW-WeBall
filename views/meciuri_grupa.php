<?php

if($_COOKIE["user"]=="rares" || $_COOKIE["user"]=="bianca" || $_COOKIE["user"]=="sergiu"){
include("../config.php");
include("../admin_controller.php");

	if(isset($_GET['id_comp']) && isset($_GET['grupa'])){
		$id_comp = $_GET['id_comp'];
		$grupa = $_GET['grupa'];
		$output_matches = get_matches_from_group($id_comp,$grupa);
	
	}
	
	if(isset($_GET['id_comp']) && isset($_GET['actualizeaza']) && isset($_GET['grupa'])){
		$id_comp = $_GET['id_comp'];
		$grupa = $_GET['grupa'];
		echo update_group($id_comp,$grupa);	
	}
?>

<html>
<body>

<?php echo $output_matches; ?>
<form>
	<input type = "hidden" name = "actualizeaza" value = "a"/>
    <input type = "hidden" name = "id_comp" value = "<?php echo $id_comp;?>"/>
    <input type = "hidden" name = "grupa" value = "<?php echo $grupa;}?>"/>
 	<input type="submit" value="Actualizeaza grupa"/><br>
</form>


</body>
</html>
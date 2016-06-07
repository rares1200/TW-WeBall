<?php

if($_COOKIE["user"]=="rares" || $_COOKIE["user"]=="bianca" || $_COOKIE["user"]=="sergiu"){
include("../config.php");

include("../admin_controller.php");

	if(isset($_GET['id_comp'])){
		$id_comp = $_GET['id_comp'];
	}else{
			
	}
	if(isset($_GET['id_comp']) && isset($_GET['actualizare_g'])){
		echo update_groups($_GET['id_comp']);
	}
	
	if(isset($_GET['id_comp']) && isset($_GET['actualizare_c'])){
		echo update_knockout($_GET['id_comp']);
	}
?>

<html>
<body>

<?php echo show_groups($_GET['id_comp']); ?> 

<form><br />
	<input type="hidden" name="id_comp" value="<?php echo $id_comp ?>"/>
    <input type="hidden" name="actualizare_g" value="a"/>
    <input type="submit" value="Actualizare grupa"/>
</form>
	
<form>

	<input type="hidden" name="id_comp" value="<?php echo $id_comp ?>"/>
    <input type="hidden" name="actualizare_c" value="a"/>
    <input type="submit" value="Actualizare competitie"/>

</form>

<p> <?php echo show_knockout($id_comp);}?></p>

</body>
</html>
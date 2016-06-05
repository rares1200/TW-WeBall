<?php

if($_COOKIE["user"]=="rares" || $_COOKIE["user"]=="bianca" || $_COOKIE["user"]=="sergiu"){
include("../config.php");
include("../admin_controller.php");

	if(isset($_GET['id_meci']) && isset($_GET['echipa1']) && isset($_GET['echipa2'])){
		$id_meci = $_GET['id_meci'];
		$echipa1 = $_GET['echipa1'];
		$echipa2 = $_GET['echipa2'];
	}
	if(isset($_GET['echipa']) && isset($_GET['eveniment']) && isset($_GET['jucator']) && isset($_GET['minut'])){
	
		$echipa = $_GET['echipa'];
		$event = $_GET['eveniment'];
		$jucator = $_GET['jucator'];
		$minut = $_GET['minut']; 
		$id_meci = $_GET['id_meci'];
		$echipa1 = $_GET['echipa1'];
		$echipa2 = $_GET['echipa2'];
		
		echo add_event($id_meci,$echipa,$event,$jucator,$minut,$echipa1,$echipa2);
			
		
	}

	if(isset($_GET['scor1']) && isset($_GET['scor2']) && isset($_GET['id_meci'])){
		$scor1=$_GET['scor1'];
		$scor2=$_GET['scor2'];
		$id_meci=$_GET['id_meci'];
		echo update_score($scor1,$scor2,$id_meci);
		
	}

	if(isset($_GET['id_meci']) && isset($_GET['echipa1']) && isset($_GET['echipa2']) && isset($_GET['ev_id'])){
		$id_meci = $_GET['id_meci'];
		$echipa1 = $_GET['echipa1'];
		$echipa2 = $_GET['echipa2'];
		$event_id = $_GET['ev_id'];
		
		echo delete_event($event_id,$id_meci,$echipa1,$echipa2);
		
	}

	if(isset($_GET['id_meci']) && isset($_GET['echipa1']) && isset($_GET['echipa2']) && isset($_GET['data'])){
		$id_meci = $_GET['id_meci'];
		$echipa1 = $_GET['echipa1'];
		$echipa2 = $_GET['echipa2'];
		$data = $_GET['data'];
	
		echo update_date($id_meci,$echipa1,$echipa2,$data);
		
	}
	
	if(isset($_GET['c_poll']) && isset($_GET['q']) && isset($_GET['r1'])  && isset($_GET['r2'])  && isset($_GET['r3'])){
		$link = "location:http://students.info.uaic.ro/~rares.nechita/weBall/views/actualizeaza_meci.php?id_meci=".$id_meci."&echipa1=".$echipa1."&echipa2=".$echipa2;
		//echo "UPDATE CU SUCCES!!!<br>";
		//header($link);
		echo $id_meci;
		echo create_poll($id_meci,$_GET['q'],$_GET['r1'],$_GET['r2'],$_GET['r3']);
		
		
	}
?>

<html>
<head>
<title>Actualizeaza meci</title>
</head>
<body>




<form>

	<label>Echipa:</label>
    	<select name = "echipa">
        	<option value="<?php echo $echipa1;?>"><?php echo $echipa1;?></option>
            <option value="<?php echo $echipa2;?>"><?php echo $echipa2;?></option>
 	    </select>
        <label>Eveniment:</label>
        <input type = "text" name = "eveniment" />
        <label>Jucator:</label>
        <input type = "text" name = "jucator" />
        <label>Minut:</label>
        <input type = "text" name = "minut"/>
        &nbsp&nbsp&nbsp&nbsp&nbsp
        <input type = "hidden" name = "id_meci" value = "<?php echo $id_meci;?>"/>
        <input type = "hidden" name = "echipa1" value = "<?php echo $echipa1;?>"/>
        <input type = "hidden" name = "echipa2" value = "<?php echo $echipa2;?>"/>
        <input type = "submit" value = " Adauga eveniment "/><br />
                 <br>
</form>
<br>

<form>
<label>Id eveniment</label>
    <input type="number" name="ev_id"/>
    <input type = "hidden" name = "id_meci" value = "<?php echo $id_meci;?>"/>
    <input type = "hidden" name = "echipa1" value = "<?php echo $echipa1;?>"/>
    <input type = "hidden" name = "echipa2" value = "<?php echo $echipa2;?>"/>
    <input type = "submit" value = " Sterge eveniment "/><br />

</form>
<br>

    
<form>

	<label> Data:</label>
    	<input type="text" name="data"/>
        <input type = "hidden" name = "id_meci" value = "<?php echo $id_meci;?>"/>
        <input type = "hidden" name = "echipa1" value = "<?php echo $echipa1;?>"/>
        <input type = "hidden" name = "echipa2" value = "<?php echo $echipa2;?>"/>
       	<input type="submit" value="Adauga data"/><br>
</form>

<form>
	<label> Scor:</label>
    <input type="number" name="scor1"/>
    <input type="number" name="scor2"/>
    <input type = "hidden" name = "id_meci" value = "<?php echo $id_meci;?>"/>
    <input type = "hidden" name = "echipa1" value = "<?php echo $echipa1;?>"/>
    <input type = "hidden" name = "echipa2" value = "<?php echo $echipa2;?>"/>
    <input type = "hidden" name = "id_comp" value = "<?php echo $id_comp;?>"/>
 	<input type="submit" value="Adauga scor"/><br>
</form>

<table border="1">

<?php
		echo get_date_match($id_meci);
		echo get_table_match_header($id_meci);
		echo get_match_events($id_meci,$echipa1,$echipa2);	

 ?>
<table>
<br>
<form>
	<label> Intrebare: </label>
    <input type="text" name = "q"/>
    <br><br>
    <label> Raspuns 1 </label>
    <input type="text" name="r1"/>
    <label> Raspuns 2 </label>
    <input type="text" name="r2"/>
    <label> Raspuns 3 </label>
    <input type="text" name="r3"/>
    <input type = "hidden" name = "id_meci" value = "<?php echo $id_meci;?>"/>
    <input type = "hidden" name = "echipa1" value = "<?php echo $echipa1;?>"/>
    <input type = "hidden" name = "echipa2" value = "<?php echo $echipa2;}?>"/>
    <input type="hidden" name="c_poll"/><br><br>
    <input type="submit" value="Creaza poll"/><br>

</form>
</body>
</html>
<?php
include("../config.php");
 
$GLOBALS['conn'] = $db;
	function execute_query($db,$query){
		if(!mysqli_query($db,$query)){
			//echo $query."<br>"; //DEVELOPMENTAL 
			return false;	
		}
		else{
			//echo "QUERY EXECUTAT CU SUCCES!!!<br>";
			return true;
		}	
	}
	
	function make_safe($param){
	
		$safe_param = mysqli_real_escape_string($GLOBALS['conn'],$param);
		$safe_param = htmlentities($safe_param);
		return $safe_param;
		
	}
	
	function set_search($text){
	
		str_replace("%","",$text);
		str_replace("$","",$text);
		return $text;
	}
	
	

?>
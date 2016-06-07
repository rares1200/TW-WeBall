<?php

if($_COOKIE['user']=="rares" || $_COOKIE['user']=="bianca" || $_COOKIE['user']=="sergiu"){
	include('config.php');
$list = mysqli_query($db,"select email from users WHERE type=1");
$create_list = "<h1 style=\"position:absolute;
			bottom:30%;\">Admin Page</h1><br>";
$create_list .= "<ul>";
while($row = mysqli_fetch_array($list,MYSQLI_ASSOC)){
	if($row['email']=='bianca')
		$create_list.= "<a href=http://students.info.uaic.ro/~elena.paraschiv/ id='link'><li id='admin_list'>".ucfirst($row['email'])."</li></a><br>";
	if($row['email']=='sergiu')
		$create_list.= "<a href=http://students.info.uaic.ro/~costel.atodiresei/ id='link'><li id='admin_list'>".ucfirst($row['email'])."</li></a><br>";
	if($row['email']=='rares')
		$create_list.= "<a href=http://students.info.uaic.ro/~rares.nechita/ id='link'><li id='admin_list'>".ucfirst($row['email'])."</li></a><br>";

}
$create_list .= "</ul>";
?>
<html>
   
   <head>
      <title>Welcome </title>
	  <link href="Style.css" rel="stylesheet" type="text/css">
   </head>
   
   <body>
      
        <nav class="meniu">

	<ul style="position:">
	
		<li>
			<a href="http://students.info.uaic.ro/~rares.nechita/weBall/index_admin.php">Administratori</a>
		</li>
		<li>
			<a href="http://students.info.uaic.ro/~rares.nechita/weBall/views/vizualizare_date.php">Actualizare Competitie</a>
		</li>
		<li>
			<a href="http://students.info.uaic.ro/~rares.nechita/weBall/gestiune.php">Gestiune</a>
		</li>
		
		<li>
			<a href="creaza_competitie.php">Creaza competitie</a>
		</li>
		
		 <li>
        	 <a href = "http://students.info.uaic.ro/~rares.nechita/weBall/logout.php">Logout</a>
        </li>
	</ul>
	
</nav><br><br><br><br>
<br><br><br><br>
	 <h1>Welcome <?php echo $_COOKIE['user']; ?></h1> 
     <h1>Admin Page</h1>
   </body>
   <?php }
		else{
			//echo $_COOKIE["user"];
			header("location:index.php");	
		}?>
</html>
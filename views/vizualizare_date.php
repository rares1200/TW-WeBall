<?php
include("../config.php");
include("../admin_controller.php");
if($_COOKIE["user"]=="rares" || $_COOKIE["user"]=="bianca" || $_COOKIE["user"]=="sergiu"){


?>

<html>
<head>
<title>Competitii</title>
</head>
<body>
<?php echo get_all_competitions();}?>
</body>
</html>





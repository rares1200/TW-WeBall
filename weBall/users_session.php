<?
include('config.php'); 
   session_start();

   $user_check = $_SESSION['login_users'];
   setcookie("user",$user_check,time() + (86400 * 3650));//10 ani
   $ses_sql = mysqli_query($db,"select username from users where username = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = ucfirst($row['username']);
   
   if(!isset($_SESSION['login_user'])){
      header("location:http://students.info.uaic.ro/~rares.nechita/weBall/user_login.php");
   }
?>
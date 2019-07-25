<?php
include'connection.php';
session_start();

if($_SESSION['email']!='')
{
   $e=$_SESSION['email'];
   $sql="update infotab2 set active=0 where email='$e'";
   if(mysqli_query($conn, $sql)){
   	session_destroy();
   	header("Location:index.php");
   }
}
else
{
	header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Signin - APDCL</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
	<link rel="stylesheet" href="css/signin.css">
</head> 
<body>
<div class="signin-wrapper card card--shadow center-block">
<form class="form-signin" method="post">
<h2 class="form-signin-heading">Login</h2>
<?php
if(isset($_GET['err'])){
echo "<div class='alert alert--danger text-center'>".$_GET['err']."</div>" ; 
}
else if (isset($_GET['suc'])) {
	echo "<div class='alert alert-success text-center'>".$_GET['suc']."</div>" ;
}
?>
<label>Email Address</label>
<input type="email" class="form-control" name="email" required>
<label>Password</label>
<input type="password" class="form-control" name="pass" placeholder="" required="" />
<input class="btn btn-primary  btn-lg btn-block" type="submit" name="submit" value="Login">
</form>
<br>
<h6 class="text-center">New user?</h6>
<a href="signup.php" class="btn btn-block btn-lg btn--secondary">Sign up Here</a>
</div>
</body>
</html>
<?php
include'connection.php';
session_start();
if(isset($_POST['submit']))
{
	function IsActive($email,$conn)
	{
		$aquery="select active from infotab2 where email='$email'";
		//echo $query;
		$aresult=mysqli_query($conn,$aquery);
		$arow=mysqli_fetch_assoc($aresult);
		if($arow["active"]==0)
			{
				return false;
			}
		else return true;
	}
	if(IsActive($_POST['email'],$conn))
	{
		header("Location:index.php?err=".urlencode("Already SignIn"));
		exit();
	}
	$e=$_POST['email'];
	$p=$_POST['pass'];
	$query="select * from infotab2 where email='$e' and pass='$p'";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	$count = mysqli_num_rows($result);
  	$row = mysqli_fetch_assoc($result);
  	if($count==1){
  		$_SESSION['email']=$e;
  		$sql1="update infotab2 set active=1 where email='$e'";
  		if(mysqli_query($conn,$sql1)) {
  		 	header("Location:report.php");
  		}
  		else
  		{
  			 //echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
  		}
  	}
  	else
    header("Location:index.php?err=".urlencode("You have entered Invalid Email or Password."));
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>SignUp - APDCL</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
	<link rel="stylesheet" href="css/signin.css">
</head>
<body>
<div class="signin-wrapper card card--shadow center-block">
<form class="form-signin" method="post">
<h2 class="form-signin-heading">Register</h2>
<?php
if(isset($_GET['err'])){
echo "<div class='alert alert--danger text-center'>".$_GET['err']."</div>" ; 
}
?>
<label>Name</label>
<input type="text" class="form-control" name="name" required>
<label>Address</label>
<input type="text" class="form-control" name="address" placeholder="City Name" required>
<label>Email</label>
<input type="email" class="form-control" name="email" required>
<label>Date of Birth</label>
<input type="date" class="form-control" name="dob" required>
<label>Password</label>
<input type="password" class="form-control" name="pass" required>
<br>

<input class="btn btn-primary  btn-lg btn-block" type="submit" name="submit" value="Signup">
</form>
<br>
<h6 class="text-center">Already Registered?</h6>
<a href="index.php" class="btn btn-block btn-lg btn--secondary">Login Here</a>
</div>
</body>
</html>

<?php
include'connection.php';
if(isset($_POST['submit']))
{
	function IsUnique($email,$conn)
	{
		$query="select * from infotab2 where email='$email'";
		echo $query;
		$result=mysqli_query($conn,$query);
		$rowctr=mysqli_num_rows($result);
		if($rowctr>0)
			{
				return false;
			}
		else return true;
	}
	
	if(strlen($_POST['pass'])<8)
	{
		header("Location:signup.php?err=".urlencode("The password must be 8 character long"));
		exit();
	}
	else if(!IsUnique($_POST['email'],$conn))
	{
		header("Location:signup.php?err=".urlencode("The email is already registered"));
		exit();
	}
	else
	{
		$n=$_POST['name'];
		$a=$_POST['address'];
		$e=$_POST['email'];
		$d=$_POST['dob'];
		$p=$_POST['pass'];
		$r=date('Y-m-d', strtotime($d . ' +30 years'));

		$sql1="insert into infotab1 values('$n','$a','$d')";
		if(mysqli_query($conn,$sql1)) {
		$sql2="insert into infotab2 values('$e','$p','$r',0)";
		{
			if(mysqli_query($conn,$sql2)) {

			header("Location:index.php?suc=".urlencode("Account Created. Login Now"));
			}
		}
		}
		else
		{
			    echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);

		}

	}
}
?>

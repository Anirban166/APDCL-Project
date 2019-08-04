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
  		if(mysqli_query($conn,$sql1)) 
		{
  		 	header("Location:report.php");
  		}
  		else
  		{
  			 //echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
  		}
  	}
  	else
    {
     
     header("Location:index.php?err=".urlencode("You have entered Invalid Email or Password."));
    
     $result = mysqli_query($conn,"SELECT * FROM registered_users WHERE email='" . $_POST["email"] . "'");
	$count  = mysqli_num_rows($result);
	if($count>0) 
        {
		// generate OTP
		$otp = rand(100000,999999);
		// Send OTP
		require_once("mail_function.php");
		$mail_status = sendOTP($_POST["email"],$otp);
		
		if($mail_status == 1) 
                {
			$result = mysqli_query($conn,"INSERT INTO otp_expiry(otp,is_expired,create_at) VALUES ('" . $otp . "', 0, '" . date("Y-m-d H:i:s"). "')");
			$current_id = mysqli_insert_id($conn);
			if(!empty($current_id)) 
                        {
				$success=1;
			}
	        }
	}
         else 
        {
		$error_message = "Email does not exist!";
	}
     
       if(!empty($_POST["submit_otp"])) 
       {
	$result = mysqli_query($conn,"SELECT * FROM otp_expiry WHERE otp='" . $_POST["otp"] . "' AND is_expired!=1 AND NOW() <= DATE_ADD(create_at, INTERVAL 24 HOUR)");
	$count  = mysqli_num_rows($result);
	if(!empty($count)) 
        {
		$result = mysqli_query($conn,"UPDATE otp_expiry SET is_expired = 1 WHERE otp = '" . $_POST["otp"] . "'");
		$success = 2;	
	} 
        else 
        {
		$success =1;
		$error_message = "Invalid OTP!";
	}
	
       }
       
       <html>
       <head>
       <style>
      .login-input 
       {
	border: #CCC 1px solid;
        padding: 10px 20px;
	border-radius:4px;
       }
       .btnSubmit 
       {
	padding: 10px 20px;
        background: #2c7ac5;
        border: #d1e8ff 1px solid;
        color: #FFF;
	border-radius:4px;
        }
        </style>
        </head>
        <body>

       <?php
	
        <form name="frmUser" method="post" action="">
	<div class="tblLogin">
		<?php 
			if(!empty($success == 1)) 
			{ 
		?>
		<div class="tableheader">Enter OTP</div>
		<p>Check your email for the OTP</p>
			
		<div class="tablerow">
			<input type="text" name="otp" placeholder="One Time Password" class="login-input" required>
		</div>
		<div class="tableheader"><input type="submit" name="submit_otp" value="Submit" class="btnSubmit"></div>
		<?php 
			} 
			else if ($success == 2) 
			{
        ?>
		<>Welcome, you have successfully logged in.</p>
		<?php
			}
			else 
			{
		?>
		
		<div class="tableheader">Enter Your Login Email</div>
		<div class="tablerow"><input type="text" name="email" placeholder="Email" class="login-input" required></div>
		<div class="tableheader"><input type="submit" name="submit_email" value="Submit" class="btnSubmit"></div>
		<?php 
			}
		?>
     	</div>
        </form>
        </body></html>

    }
}
?>

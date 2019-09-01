<?php
session_start();
if($_SESSION['email']=='') 
{
   header("Location:index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Generate Report - APDCL</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/signin.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-mr navbar-dark fixed-top bg-dark">
	 <a class="navbar-brand" href="">Generate Report</a>
   <a class="btn btn-info my-2 my-sm-0" href="logout.php">LogOut</a>
</nav>
<div class="signin-wrapper card card--shadow center-block">
<form class="form-signin" method="post">
<h2 class="form-signin-heading">Generate Report</h2><br>
<p><input type="checkbox" name="choice[]" value="Name"> Name</p>
<p><input type="checkbox" name="choice[]" value="Address"> Address</p>
<p><input type="checkbox" name="choice[]" value="Email" /> Email</p>
<p><input type="checkbox" name="choice[]" value="DOB" /> Date of Birth</p>
<p><input type="checkbox" name="choice[]" value="DOR" /> Date of Retirement</p>
<p><input type="submit" name="submit" class="btn btn-primary  btn-lg btn-block" value="Generate"></p>
</form>
</div>
<div class="datatables">
<?php
include'connection.php';
echo "<table id='my-example' class='display'><thead>";
if(isset($_POST["submit"]))
         {
          if(!empty($_POST["choice"])){
          	foreach($_POST["choice"] as $choice)
            {
             echo '<th>'.$choice.'</th>';
         	}
         	echo " </thead><tbody>";
         	
         	 $getselectClub = implode(",",$_POST['choice']);
         	 $sql = "SELECT $getselectClub FROM infotab2 INNER JOIN infotab1 WHERE active=1";
         	 $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
         	 if (mysqli_num_rows($result) > 0) {
         	 	
         	 	while($row = mysqli_fetch_assoc($result)) {
         	 		echo"<tr>";
         	 		foreach ($row as $row ) {
         	 			echo "<td>$row</td>";
         	 		}
         	 		echo"</tr>";
         	 	}

         	 
         	}
          
           echo"<tbody></table>";
          }
      }
?>
<script type="text/javascript">
   $(document).ready(function() {
            $('#my-example').DataTable();
        } );
</script> 

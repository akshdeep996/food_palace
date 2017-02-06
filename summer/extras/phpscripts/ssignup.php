<?php
session_start();

date_default_timezone_set('Asia/Kolkata');
require '../includes/conx.php';
if(isset($_GET['checkusername'])) {
	$username = mysqli_real_escape_string($db,$_GET['checkusername']);
	$query = "SELECT * FROM users where username = '$username'";
	//echo "$username, $query";
	$result = mysqli_query($db,$query);
	//if(!$result) echo mysqli_error($db);
	if(mysqli_num_rows($result) == 0 )
		 echo "available";
	 else echo "not available";
	 exit(0);
	
	
}
if(isset($_GET["username"]) ) { 
   
   
   $username = mysqli_real_escape_string($db,$_GET['username']);
   $email = mysqli_real_escape_string($db,$_GET['email']);
   $password = md5(mysqli_real_escape_string($db,$_GET['pass1']));
   $fname = mysqli_real_escape_string($db,$_GET['fname']);
   $lname = mysqli_real_escape_string($db,$_GET['lname']);
   $sex = mysqli_real_escape_string($db,$_GET['sex']);
   $rquestion = mysqli_real_escape_string($db,$_GET['rquestion']);
   $ranswer = mysqli_real_escape_string($db,$_GET['ranswer']);
   $dob = mysqli_real_escape_string($db,$_GET['dob']);
   $jdate =mysqli_real_escape_string($db,date('Y-m-d H:i:s'));
   //echo $dob;
   $query = "INSERT INTO users values ('$username','$dob','$password','$fname','$lname','$jdate','$jdate','$sex','$email','$rquestion','$ranswer' )";
   $query1 = "INSERT INTO settings(username,signature, block_count,filter_count,locktype,locktime,locktime_start,locktime_ends,failed_attempts) values ('$username','',0,0,'0','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0)";
   // echo $query . '<br/><br/>';
	$result = mysqli_query($db,$query);
	if(!$result) echo mysqli_error($db);
	$result1 = mysqli_query($db,$query1);
	if($result && $result1) { 
	   echo "done";
	}else {
	   echo mysqli_error($db); 
      echo "error";  
	}
	
	exit();
	
}


?>
<?php
session_start();
require '../includes/conx.php';
	if(isset($_GET['submit'])) {	
		$query = "SELECT * FROM users where username='".mysqli_real_escape_string($db,$_GET['username']) . "'";
		$result = mysqli_query($db,$query);
		if(mysqli_num_rows($result) > 0) {		
		  $username = mysqli_real_escape_string($db,$_GET['username']);
		  $row = mysqli_fetch_array($result);
		  if($username === $row['username']) {
			  $query1 = "SELECT rquestion FROM users where username='$username'";
		      $result1 = mysqli_query($db,$query1);
			  if($result1)
			  {
				  $row1 = mysqli_fetch_array($result1);
				  echo $row1['rquestion'];
				  exit(0);
			  }
		  exit();
		  }
		   
    }
	else {
		     echo "invalid_username"; exit();
	     }
	}	
	
	
	if(isset($_GET['forgot2'])) {
		$username= $_GET['username'];
		$dob= $_GET['dob'];
		$rquestion= $_GET['rquestion'];
		$ranswer= $_GET['ranswer'];
		//echo "$username:$dob:$rquestion:$ranswer";
		
		$query = "SELECT * FROM users where username='$username' AND DOB= '$dob' AND rquestion='$rquestion' AND ranswer='$ranswer'";
		$result = mysqli_query($db,$query);
		$row = mysqli_fetch_array($result);
		
		if($dob === $row['DOB'] && $ranswer === $row['ranswer']) {		
		  $row = mysqli_fetch_array($result);
		  echo "$username:$dob:$rquestion:$ranswer";
		  
		  exit(0);
		 }
		   
      
	else {
		     echo "NO_DATABASE_FOR_THIS_USER"; exit();
	     }
	}
	
	if(isset($_GET['forgot3'])) {
		$username= $_GET['username'];
		$dob= $_GET['dob'];
		$rquestion= $_GET['rquestion'];
		$ranswer= $_GET['ranswer'];
		$pass= $_GET['pass'];
		
		echo "<br/>$username:$dob:$rquestion:$ranswer:$pass";
		$epass = md5($pass);
		echo "<br/>".$epass;
		$query = "UPDATE users SET password='$epass' where username='$username' AND DOB= '$dob' AND rquestion='$rquestion' AND ranswer='$ranswer'";
		$result = mysqli_query($db,$query);
		
		if(!$result) {echo "invalid_username"; echo mysqli_error($db); exit(0); }		

		  echo "yes";
		  
		  exit(0);
		 
	} 
      
	
	
	
	
	
?>
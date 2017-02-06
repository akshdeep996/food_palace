<?php
session_start();
	date_default_timezone_set('Asia/Kolkata');
if(isset($_SESSION["username"])) {
	header('Location:../dashboard.php');
	echo "sesstion set";
	exit(0);
}
 
	
	if(isset($_GET['username'])) {
		require '../includes/conx.php';
		$query = "SELECT * FROM users where username='".mysqli_real_escape_string($db,$_GET['username']) . "'";
		$result = mysqli_query($db,$query);
		if(mysqli_num_rows($result) > 0) {		
		  $pass1 = mysqli_real_escape_string($db,$_GET['pass1']);
		  $row = mysqli_fetch_array($result);
		  $username = $_GET['username'];
		  if(md5($pass1) === $row['password']) {
			  $date=date('Y-m-d H:i:s');
			  /// checking for locks
			  $query="SELECT * FROM settings where username='$username'";
		      $result = mysqli_query($db,$query);
		      if(!$result) { mysqli_error($db); echo "Error";   exit(0);}
			  $row = mysqli_fetch_array($result);
			  $locktype = $row['locktype'];
			  switch($locktype) {
				  case 1 : $timelock = 15; break;
				  case 2 : $timelock = 30; break;
				  case 3 : $timelock = 120; break;
				 default : $timelock = 0; break;
			  }
			  $locktime_ends = $row['locktime_ends'];
			  
			  if($locktime_ends >= $date) {
				  if($locktype) echo "<br/>Your account is locked for <b>$timelock</b> minutes.<br/> Please try after <b>$locktime_ends</b>";
				  exit(0);
			  }
              			  
			  /// checking for locks ends
          $query="UPDATE users SET last_login='$date' where username='$username'";
		  $result2 = mysqli_query($db,$query);
		  if(!$result2) { mysqli_error($db); echo "Error";   exit(0);}
				$query = "UPDATE settings SET locktype='0', locktime='0000-00-0 00:00:00', locktime_start='0000-00-0 00:00:00', locktime_ends='0000-00-0 00:00:00', failed_attempts='0' where username='$username'";
			    $result = mysqli_query($db,$query);
 				///if(!$result) { echo "ERROR in updating"; echo mysqli_error($db); exit(0);}
				
				echo "login_yes";
		        $_SESSION['username'] = $_GET['username'];	        
				exit(0);
		  } else {       /// failed attempt, calculate locktype and locktime(s)
			  $query="UPDATE settings SET failed_attempts=failed_attempts+1 where username='$username'";
			  $result = mysqli_query($db,$query);
			  if(!$result) { echo mysqli_error($db);}
			  else {
				  $query = "SELECT * FROM settings WHERE username='$username'";
				  $result = mysqli_query($db,$query);
				  //if(!$result) {echo "$query <br/>"; echo mysqli_error($db);}
				  //else {
					  //echo "<br/>$query executed <br/>";
					  $row=mysqli_fetch_array($result);
					  $failed_attempts = $row['failed_attempts'];
					  switch(true){
						  case ($failed_attempts >=3 &&  $failed_attempts <5) : 
						            $locktype = 1; $locktime = date('Y-m-d') . " 00:15:00"; 
									$locktime_start = date('Y-m-d H:i:s');
									$currentlock = strtotime($locktime_start);
					                $endtime = $currentlock+(60*15);
									$timelock = 15;
					                $locktime_ends = date('Y-m-d H-i-s', $endtime);
					  
									break;
                          case ($failed_attempts >=5 &&  $failed_attempts <7) : 
						            $locktype = 2; $locktime = date('Y-m-d') . " 00:30:00"; 
									$locktime_start = date('Y-m-d H:i:s');
									$currentlock = strtotime($locktime_start);
					                $endtime = $currentlock+(60*30);
					                $locktime_ends = date('Y-m-d H-i-s', $endtime);
					                $timelock = 30;
									break;
                          case $failed_attempts >=7 : 
						            $locktype = 3; $locktime = date('Y-m-d') . " 02:00:00"; 
									$locktime_start = date('Y-m-d H:i:s');
									$currentlock = strtotime($locktime_start);
					                $endtime = $currentlock+(60*120);
					                $locktime_ends = date('Y-m-d H-i-s', $endtime);
					                $timelock = 120;
									break;
                          default : $locktype=0; $locktime = '0000-00-00 00:00:00'; 
						            $locktime_start = '0000-00-00 00:00:00';
                                    $locktime_ends = '0000-00-00 00:00:00';									 
									break;
					  }
					  
					  echo "<br/>Total Number of failed attempts from last succesful login : $failed_attempts"; 
					  //echo "<br/>Lock time : $locktime, locktime starts : $locktime_start, locktime_ends:  $locktime_ends";
					  if($locktype) echo "<br/>Your account is locked for <b>$timelock</b> minutes, Please try after <b>$locktime_ends</b>";
					  
					  
					  $query = "UPDATE settings SET locktype='$locktype', locktime='$locktime', locktime_start='$locktime_start', locktime_ends = '$locktime_ends' where username='$username'";
					  $result = mysqli_query($db,$query);
					  //if($result) { echo "<br/>Account locked for $locktime"; }
					  //else {"<br/>error in $query";  echo mysqli_error($db);  }
				  //} echo "<br/> LIne 49";
			  }
			  //echo "<br/>Invalid Password"; exit(0);
		  } 
	} else {
		echo "Invalid Username/Password";
		exit();
	}
	}
	 else echo "nothing is here for you! Get lost";
	
	?>
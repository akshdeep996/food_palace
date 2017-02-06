<?php
if(isset($_SESSION['username']))
            $username = $_SESSION['username'];
if(isset($_GET['newfilter'])) {
	
	$username = mysqli_real_escape_string($db,$_GET['username']);
	$filtertype = mysqli_real_escape_string($db,$_GET['filtertype']);
	$filtercontent = mysqli_real_escape_string($db,$_GET['filtercontent']);
	if($username !== $_SESSION['username'] ) {
		
		echo 'Invalid request';
		exit(0);
	}
	else {
	   echo $username ."<br/> " . $filtertype . "   " . $filtercontent ;
	     $query = "INSERT INTO filters(fid,username,filtertype,content) VALUES ('','$username','$filtertype', '$filtercontent')";
		  echo "<br> Inserting filter";
		  $result = mysqli_query($db,$query);
          if($result === true) {
			  $query = "UPDATE settings SET filter_count = filter_count+1 where username='$username'";
			  echo "<br> Updating settings";
			  $result = mysqli_query($db,$query);
			  if($result === true) {
				 echo "Filtered and updated";
                 exit(0);				 
			  }else {echo mysqli_error($db);
                echo "<br> Failed updation";	
                 echo mysqli_error($db);				 
			  exit(0);  }
		  }else {		  
	      echo "<br> failed inserting filter in block table";
		  echo mysqli_error($db);
	      exit(0);
		  }
	   }
    
	
	
	exit(0);
}

if(isset($_GET['unfilter'])) {
	
	$username = mysqli_real_escape_string($db,$_GET['username']);
	$ft = mysqli_real_escape_string($db,$_GET['ft']);
	$fc = mysqli_real_escape_string($db,$_GET['fc']);
	if($username !== $_SESSION['username'] ) {
		echo $username . $_SESSION['username'];
		echo 'Invalid request';
		exit(0);
	}
	else {	
	if($ft = 'Filter by body') $ft = '2';
      else $ft = '1';	
	$username = mysqli_real_escape_string($db,$_GET['username']);
	//echo $username ."<br/> " . $ft . "   " . $fc ;
	   $query = "SELECT * FROM filters WHERE username='$username' AND filtertype='$ft' AND content='$fc'";
		//echo "<br> fetching filter";
		$result = mysqli_query($db,$query);
		//if(!$result) { echo mysqli_error($db); exit(0);}
        if($result) {
			  $row = mysqli_fetch_array($result);
		      $fid = $row['fid'];
			  //print_r($row);
			//  echo "Got filter id $fid, updating settings<br/>";
			  $query = "DELETE FROM filters WHERE fid='$fid'";
			  $result = mysqli_query($db, $query);
			 // if(!$result) { echo mysqli_error($db); exit(0);}
			  
			  $query = "UPDATE settings SET filter_count = filter_count-1 where username='$username'";
			 // echo "<br> Updating settings";
			  $result = mysqli_query($db,$query);
			  if($result === true) {
				 echo "Unfiltered and updated"; ;
                 exit(0);				 
			  }else {  //echo mysqli_error($db);
                       //echo "<br> Failed unfiltration";	
                       //echo mysqli_error($db);				 
			           exit(0);
				   }
		  }
		    else {		  
	        //  echo "<br> failed removal filter in block table";
		     // echo mysqli_error($db);
	          exit(0);
		       }   
		  exit(0);
    
}
exit(0);
}

if(isset($_GET['newsignature'])) {
	
	$username = mysqli_real_escape_string($db,$_GET['username']);
	//echo $_GET['signature']. "<br/>";
	$signature = mysqli_real_escape_string($db,$_GET['signature']) ;
	//echo "$signature <br/>";
	if($username !== $_SESSION['username'] ) {
		
		echo 'Invalid request';
		exit(0);
	}
	else {
	   echo $username ."<br/> " . $signature ;
	     	  $query = "UPDATE settings SET signature = '$signature' where username='$username'";
			  //echo "<br> Updating settings";
			  $result = mysqli_query($db,$query);
			  if($result === true) {
				 echo "Updated";
                 exit(0);				 
			  }else {
                //echo "<br> Failed updation";	
                //echo mysqli_error($db);				 
			  exit(0);  }
		  }
	exit(0);
}

if(isset($_GET['unblock'])) {
	
	$username = mysqli_real_escape_string($db,$_GET['username']);
	$block = mysqli_real_escape_string($db,$_GET['blockusername']);
	if($username !== $_SESSION['username']) {
		echo 'Invalid request';
		exit(0);
	}
	else {
	   //echo "DELETING";
	   $query = "DELETE FROM blocked_user where username='$username' AND blocked_username='$block'";
       $result = mysqli_query($db,$query);
        if($result) {
			//echo "DROPPED";
			$query = "UPDATE settings SET block_count = block_count-1 where username='$username'";
			$result = mysqli_query($db,$query);
			if($result){
				echo "yes";
				exit(0);
			}else {
				//echo "Error in updating settings". mysqli_error($db);
				exit(0);
			}	
		}
        else {
			//echo "Error in deleting from block table".mysqli_error($db);
			exit(0);
		}		
	   exit(0);
	}
	echo "Invalid operation";
	exit(0);
}

if(isset($_GET['newblock'])) {
	
	$username = mysqli_real_escape_string($db,$_GET['username']);
	$block = mysqli_real_escape_string($db,$_GET['blockusername']);
	if($username !== $_SESSION['username'] || $block == '') {
		
		echo 'Invalid request';
		exit(0);
	}
	else {
	   echo $username ."<br/> " . $block;
	   $query = "SELECT * FROM users where username = '$block'";
	   echo "<br> Searching username";
	   $result = mysqli_query($db,$query);
	   if(mysqli_fetch_array($result) > 0) {
		  $query = "INSERT INTO blocked_user(username,blocked_username) VALUES ('$username', '$block')";
		  echo "<br> Inserting username";
		  $result = mysqli_query($db,$query);
          if($result === true) {
			  $query = "UPDATE settings SET block_count = block_count+1 where username='$username'";
			  echo "<br> Updating settings";
			  $result = mysqli_query($db,$query);
			  if($result === true) {
				 echo "   Blocked and updated";
                 exit(0);				 
			  }else {echo mysqli_error($db);
                 echo "<br> Failed updation";	
                 echo mysqli_error($db);				 
			  exit(0);  }
		  }else {		  
	      echo "<br> failed inserting username in block table";
		  echo mysqli_error($db);
	      exit(0);
		  }
	   }
	else { echo mysqli_error($db); echo "   Invalid username"; exit(0); }
    }
	exit(0);
}

if(isset($_GET['type'])) {
	echo $_GET['type'];
	if($_GET['type'] == 'recovery') {
 	  $username = $_SESSION['username'];
	  $rquestion = mysqli_real_escape_string($db,$_GET['rquestion']);
	  $ranswer = mysqli_real_escape_string($db,$_GET['ranswer']);
	  $password = mysqli_real_escape_string($db,$_GET['password']);
	  
	if($username !== $_SESSION['username']) {
		echo 'Invalid request';
		exit(0);
	}
	else {
		$password = md5($password);
		$query = "SELECT * from users where username='$username' AND password = '$password'";
		$result = mysqli_query($db,$query);
		if(mysqli_num_rows($result) == 1) {
	    //echo $username ."<br/> " . $rquestion . $ranswer . $password;
	   $query = "UPDATE users SET rquestion='$rquestion', ranswer='$ranswer'  where username = '$username' AND password = '$password'";
	   $result = mysqli_query($db,$query);
	   if($result) {
		         echo "updated recovery";exit(0);
	   } 
        else	{   
                 echo mysqli_error($db);				 
			  exit(0);  }
		}	  
		  
	   }
	
	exit(0);
    }
	
	if($_GET['type'] == 'password') {
 	  $username =$_SESSION['username'];
	  $pass1 = mysqli_real_escape_string($db,$_GET['pass1']);
	  
	  $password = mysqli_real_escape_string($db,$_GET['password']);
	  
	if($username !== $_SESSION['username']) {
		echo 'Invalid request';
		exit(0);
	}
	else {
		
		$password = md5($password);
	     $pass1 = md5($pass1);
		 echo $username ."<br/> " . $pass1 ."<br/>" . $password;
	   $query = "SELECT * from users where username='$username' AND password = '$password'";
		$result = mysqli_query($db,$query);
		if(mysqli_num_rows($result) == 1) {
	    
	       $query = "UPDATE users SET password='$pass1' where username = '$username' AND password = '$password'";
	       $result = mysqli_query($db,$query);
	       if($result) {
		         echo "updated password";exit(0);
	         } 
            else	{   
                  echo mysqli_error($db);				 
			  exit(0);  }
		}
		  
	   }
	exit(0);
    }
	exit(0);
}


?>
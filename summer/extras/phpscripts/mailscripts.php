<?php
session_start();
require '../includes/conx.php';
if(isset($_GET['inboxtrash']))  { /// move message to trash, query from receiver : inbox to  Trash

	$sender = mysqli_real_escape_string($db,$_GET['sender']);
	$bid = mysqli_real_escape_string($db,$_GET['bid']);
	$time = mysqli_real_escape_string($db,$_GET['time']);
	$subject = mysqli_real_escape_string($db,$_GET['sub']);
	$rec = mysqli_real_escape_string($db,$_GET['rec']);
	//require 'includes/conx.php';
	$query = "SELECT *  FROM message WHERE reciever='$rec' AND sender='$sender' AND subject='$subject' AND datetime = '$time' AND body_id='$bid' ";
	$result = mysqli_query($db,$query);

	if(!$result) {
		echo "<br/>error<br/>";
		//echo mysqli_error($db);
		exit(1);
	}

	else {

		$row = mysqli_fetch_array($result);
		$mid = $row['m_id'];
		//echo "done! $bid<br/>";
		$query = "UPDATE message  SET recieve_type='T' WHERE m_id = $mid";
		//$query = "select * from mbody where body_id=$bid";
		$result = mysqli_query($db, $query);
		if(!$result) {
			//echo mysqli_error($db);
		}
	else  {  echo 'deleted'; }

	}
exit(0);
	}

if(isset($_GET['markinboxread']))
{ /// mark message as read, query from receiver : inbox
	$sender = mysqli_real_escape_string($db,$_GET['sender']);
	$bid = mysqli_real_escape_string($db,$_GET['bid']);
	$time = mysqli_real_escape_string($db,$_GET['time']);
	$subject = mysqli_real_escape_string($db,$_GET['sub']);
	$rec = mysqli_real_escape_string($db,$_GET['rec']);
	$class=mysqli_real_escape_string($db,$_GET['class']);

	//echo "$sender : $bid : $time : $subject : $rec";
	$query = "SELECT *  FROM message WHERE reciever='$rec' AND sender='$sender' AND subject='$subject' AND datetime = '$time' AND body_id='$bid' ";
	$result = mysqli_query($db,$query);
	//echo "executing $query <br/>";
	if(!$result) {
		echo "<br/>error<br/>";
		//echo mysqli_error($db);
		exit(1);
	}

	else {

		$row = mysqli_fetch_array($result);
		echo  "<div style='padding-left:130px' id='messagecontent'>FROM : <b>".htmlspecialchars_decode($row['sender'])."</b>";
		echo  "<br/>TO : <b><div id='$class".'reciever'."'>".htmlspecialchars_decode($row['reciever'])."</div></b>";
		echo  "<br/>Date Time : <b><div id='$class".'datetime'."'>".htmlspecialchars_decode($row['datetime'])."</div></b>";
		echo  "<br/>Subject : <b><div id='$class".'subject'."'>".htmlspecialchars_decode($row['subject'])."</div></b>";
		$mid = $row['m_id'];
		//echo "done! $bid<br/>";
		$query = "UPDATE message  SET reciever_seen='1' WHERE m_id = '$mid'";
		$query2 = "select * from mbody where body_id=$bid";
		$result = mysqli_query($db, $query2);
		if(!$result) {
			//echo mysqli_error($db);
		}
	    else  {

			 $row = mysqli_fetch_array($result);
			 //echo "<br/>$query2 executed";
			 $query2 = "SELECT * from settings where username = '$sender'";
			 $result2 = mysqli_query($db,$query2);
			 $row2 = mysqli_fetch_array($result2);

             echo  "<br/>Message : <br/><div  id='$class".'body'."' >".htmlspecialchars_decode($row['body']). "<br/>" . htmlspecialchars_decode($row2['signature'])."</div>";
			 echo <<<"here"


  <a class='$class' style="background:#00ffcc;text-align:right; " onclick="forward(this.className,'$sender')" >Forward</a>
  <a class='$class' style="background:#00ffcc;text-align:right; " onclick="reply(this.className, '$sender')" >Reply</a>	</div>

here;

      $result = mysqli_query($db,$query);


		  }
	}
exit(0);
	}


if(isset($_GET['trashbody']))
{ /// fetch message body , query from reciever : trashbox
	$sender = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sender']));     /// this is sender
	$bid = htmlspecialchars(mysqli_real_escape_string($db,$_GET['bid']));
	$time = htmlspecialchars(mysqli_real_escape_string($db,$_GET['time']));
	$subject = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sub']));
	$rec = htmlspecialchars(mysqli_real_escape_string($db,$_GET['rec']));            /// this is reciever
	       //  echo "<br/> Sender : $sender";
	        // echo "<br/> Rec : $rec";
	        // echo "<br/> Subject : $subject";
	        // echo "<br/> Time : $time";
	        // echo "<br/> BID : $bid";
	if($rec !== $_SESSION['username']) {echo "INVALID REQUEST"; exit(0);}
	//require 'includes/conx.php';
	$query = "SELECT *  FROM message WHERE sender='$sender' AND reciever='$rec' AND subject='$subject' AND datetime = '$time' AND body_id='$bid' ";
	$result = mysqli_query($db,$query);
	if(!$result) {
		echo "<br/>error<br/>";
		//echo mysqli_error($db);
		exit(1);
	}
	else {
		$row = mysqli_fetch_array($result);
		echo  "<div style='padding:2px;padding-left:130px'>FROM : <b>".htmlspecialchars_decode($row['sender'])."</b>";
		echo  "<br/>TO : <b>".htmlspecialchars_decode($row['reciever'])."</b>";
		echo  "<br/>Date Time : <b>".htmlspecialchars_decode($row['datetime'])."</b>";
		echo  "<br/>Subject : <b>".htmlspecialchars_decode($row['subject'])."</b>";
		$mid = $row['m_id'];
		$query2 = "select * from mbody where body_id=$bid";
		$result = mysqli_query($db, $query2);
		if(!$result) {
			echo mysqli_error($db);
		}
	    else  {
			 $row = mysqli_fetch_array($result);
			 $query2 = "SELECT * from settings where username = '$sender'";
			 $result2 = mysqli_query($db,$query2);
			 $row2 = mysqli_fetch_array($result2);

             echo  "<br/>Message : <br/><b><div >".htmlspecialchars_decode($row['body']). "<br/>" . htmlspecialchars_decode($row2['signature'])."</div></b>";

		}
	}
exit(0);
	}

if(isset($_GET['trashdelete']))
{ /// delete message , query from reciever : trashbox
	$sender = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sender']));     /// this is sender
	$bid = htmlspecialchars(mysqli_real_escape_string($db,$_GET['bid']));
	$time = htmlspecialchars(mysqli_real_escape_string($db,$_GET['time']));
	$subject = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sub']));
	$rec = htmlspecialchars(mysqli_real_escape_string($db,$_GET['rec']));            /// this is reciever
	        echo "<br/> Sender : $sender";
	         echo "<br/> Rec : $rec";
	         echo "<br/> Subject : $subject";
	         echo "<br/> Time : $time";
	         echo "<br/> BID : $bid";
	if($rec !== $_SESSION['username']) {echo "INVALID REQUEST"; exit(0);}
	//require 'includes/conx.php';
	$query = "SELECT *  FROM message WHERE sender='$sender' AND reciever='$rec' AND subject='$subject' AND datetime = '$time' AND body_id='$bid' ";
	$result = mysqli_query($db,$query);
	if(!$result) {
		echo "<br/>error<br/>";
		//echo mysqli_error($db);
		exit(1);
	}
	else {
		$row = mysqli_fetch_array($result);
		$mid = $row['m_id'];
		$query2 = "UPDATE message SET reciever_delete='1' where m_id=$mid";
		$result = mysqli_query($db, $query2);
		if(!$result) {
			echo mysqli_error($db);
		exit();
		}
	}
exit(0);
	}

if(isset($_GET['draftbody']))
{ /// fetch message body , query from sender : sentbox
	$rec = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sender']));     /// this is reciever
	$bid = htmlspecialchars(mysqli_real_escape_string($db,$_GET['bid']));
	$time = htmlspecialchars(mysqli_real_escape_string($db,$_GET['time']));
	$subject = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sub']));
	$sender = htmlspecialchars(mysqli_real_escape_string($db,$_GET['rec']));            /// this is sender

	if($sender !== $_SESSION['username']) {echo "INVALID REQUEST"; exit(0);}
	//require 'includes/conx.php';
	$query = "SELECT *  FROM message WHERE sender='$sender' AND reciever='$rec' AND subject='$subject' AND datetime = '$time' AND body_id='$bid' ";
	$result = mysqli_query($db,$query);
	if(!$result) {
		echo "<br/>error<br/>";
		//echo mysqli_error($db);
		exit(1);
	}
	else {
		$row = mysqli_fetch_array($result);
		echo  "<div style='padding:2px;padding-left:130px'>FROM : <b>".htmlspecialchars_decode($row['sender'])."</b>";
		echo  "<br/>TO : <b>".htmlspecialchars_decode($row['reciever'])."</b>";
		echo  "<br/>Date Time : <b>".htmlspecialchars_decode($row['datetime'])."</b>";
		echo  "<br/>Subject : <b>".htmlspecialchars_decode($row['subject'])."</b>";
		$mid = $row['m_id'];
		$query2 = "select * from mbody where body_id=$bid";
		$result = mysqli_query($db, $query2);
		if(!$result) {
			echo mysqli_error($db);
		}
	    else  {
			 $row = mysqli_fetch_array($result);
             $query2 = "SELECT * from settings where username = '$sender'";
			 $result2 = mysqli_query($db,$query2);
			 $row2 = mysqli_fetch_array($result2);

             echo  "<br/>Message : <br/><b><div >".htmlspecialchars_decode($row['body']). "<br/>" . htmlspecialchars_decode($row2['signature'])."</div></b>";

		}
	}
exit(0);
	}

if(isset($_GET['draftdelete']))
{ ///delete message, query from sender : From draft to delete.

	$sender = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sender']));
	$bid = htmlspecialchars(mysqli_real_escape_string($db,$_GET['bid']));
	$time = htmlspecialchars(mysqli_real_escape_string($db,$_GET['time']));
	$subject = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sub']));
	$rec = htmlspecialchars(mysqli_real_escape_string($db,$_GET['rec']));
	if($sender !== $_SESSION['username']) {echo "INVALID REQUEST"; exit(0);}
	$query = "SELECT *  FROM message WHERE reciever='$rec' AND sender='$sender' AND sender_type='D' AND subject='$subject'  AND body_id = '$bid' ";
	$result = mysqli_query($db,$query);

	if(!$result) {
		echo "<br/>error<br/>";
		//echo "<br/>mid not found";
		//echo mysqli_error($db);
		exit(1);
	}

	if(mysqli_num_rows($result) >= 0) {

		$row = mysqli_fetch_array($result);
		$mid = $row['m_id'];
		//echo "<pre>";print_r($row);echo"</pre>";
		//echo "Found! $mid<br/> deleting message";
		$query = "DELETE FROM message   WHERE m_id = '$mid'";
		$result = mysqli_query($db, $query);
		if(!$result) {
			echo "<br/>error in deleting";
			echo mysqli_error($db);
			exit(0);
		}
	   echo "Deleted";

	}
	exit(0);
}

if(isset($_GET['draftsend']))
{ ///send message, query from sender : From draft to inbox.

	$sender = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sender']));
	$bid = htmlspecialchars(mysqli_real_escape_string($db,$_GET['bid']));
	$time = htmlspecialchars(mysqli_real_escape_string($db,$_GET['time']));
	$subject = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sub']));
	$rec = htmlspecialchars(mysqli_real_escape_string($db,$_GET['rec']));
	if($sender !== $_SESSION['username']) {echo "INVALID REQUEST"; exit(0);}
	//echo "$sender : $bid : $time : $subject : $rec";

	$query = "SELECT *  FROM message WHERE reciever='$rec' AND sender='$sender' AND sender_type='D' AND subject='$subject'  AND body_id = '$bid' ";
	$result = mysqli_query($db,$query);

	if(!$result) {
		echo "<br/>error<br/>";
		//echo "<br/>mid not found";
		echo mysqli_error($db);
		exit(1);
	}

	//foreach ($result as $row) { print_r($row);} echo "<br/>";

	if(mysqli_num_rows($result) > 0) {
		//echo "<br/>$mid<br/>";
		$row = mysqli_fetch_array($result);
		$mid = $row['m_id'];
		//print_r($row);
		//echo "Found! $mid<br/> sending message";
		$query = "UPDATE message  SET sender_type='ST'  WHERE m_id = '$mid'";
		$result = mysqli_query($db, $query);
		if(!$result) {
			echo "<br/>error in sending";

			echo mysqli_error($db);
			exit(0);
		}
	   echo "Message Sent";

	}
	exit(0);
}

if(isset($_GET['fetchsentbody']))
{ /// fetch message body , query from sender : sentbox
	$sender = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sender']));     /// this is reciever
	$bid = htmlspecialchars(mysqli_real_escape_string($db,$_GET['bid']));
	$time = htmlspecialchars(mysqli_real_escape_string($db,$_GET['time']));
	$subject = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sub']));
	$rec = htmlspecialchars(mysqli_real_escape_string($db,$_GET['rec']));            /// this is sender
	if($rec !== $_SESSION['username']) {echo "INVALID REQUEST"; exit(0);}
	//require 'includes/conx.php';
	$query = "SELECT *  FROM message WHERE sender='$rec' AND reciever='$sender' AND subject='$subject' AND datetime = '$time' AND body_id='$bid' ";
	$result = mysqli_query($db,$query);

	if(!$result) {
		echo "<br/>error<br/>";
		echo mysqli_error($db);
		exit(1);
	}

	else {

		$row = mysqli_fetch_array($result);
		echo  "<div style='padding:2px;padding-left:130px'>FROM : <b>".htmlspecialchars_decode($row['sender'])."</b>";
		echo  "<br/>TO : <b>".htmlspecialchars_decode($row['reciever'])."</b>";
		echo  "<br/>Date Time : <b>".htmlspecialchars_decode($row['datetime'])."</b>";
		echo  "<br/>Subject : <b>".htmlspecialchars_decode($row['subject'])."</b>";
		//echo "<br/>$response executed";
		$mid = $row['m_id'];
		//echo "done! $bid<br/>";
		//$query = "UPDATE message  SET reciever_seen='1' WHERE m_id = $mid";
		$query2 = "select * from mbody where body_id=$bid";
		$result = mysqli_query($db, $query2);
		if(!$result) {
			echo mysqli_error($db);
		}
	    else  {

			 $row = mysqli_fetch_array($result);
			 //echo "<br/>$query2 executed";
             $query2 = "SELECT * from settings where username = '$rec'";
			 $result2 = mysqli_query($db,$query2);
			 $row2 = mysqli_fetch_array($result2);

             echo  "<br/>Message : <br/><b><div >".htmlspecialchars_decode($row['body']). "<br/>" . htmlspecialchars_decode($row2['signature'])."</div></b>";
             //$result  = mysqli_query($db,$query);
			 //if(!$result) {echo mysqli_error($db); exit();}
	         //echo "<br/>$query executed";
		}
	}
exit(0);
	}

if(isset($_GET['sentdelete']))
{ /// delete message  , query from sender : sentbox
	$sender = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sender']));
	$bid = htmlspecialchars(mysqli_real_escape_string($db,$_GET['bid']));
	$time = htmlspecialchars(mysqli_real_escape_string($db,$_GET['time']));
	$subject = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sub']));
	$rec = htmlspecialchars(mysqli_real_escape_string($db,$_GET['rec']));
	if($rec !== $_SESSION['username']) {echo "INVALID REQUEST"; exit(0);}
	//require 'includes/conx.php';
	$query = "SELECT *  FROM message WHERE sender='$rec' AND reciever='$sender' AND subject='$subject' AND datetime = '$time' AND body_id='$bid' ";
	$result = mysqli_query($db,$query);

	if(!$result) {
		echo "<br/>error<br/>";
		echo mysqli_error($db);
		exit(1);
	}

	else {

		$row = mysqli_fetch_array($result);
		$mid = $row['m_id'];
		$query = "UPDATE message  SET sender_delete='1' WHERE m_id = $mid";

		$result = mysqli_query($db, $query);
		if(!$result) {
			//echo mysqli_error($db);
		}
	    else  {
	        echo "Deleted";
		}
	}
exit(0);

	}

if(isset($_GET['spamdelete']))
{ /// delete message, query from receiver : spambox

	$sender = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sender']));
	$bid = htmlspecialchars(mysqli_real_escape_string($db,$_GET['bid']));
	$time = htmlspecialchars(mysqli_real_escape_string($db,$_GET['time']));
	$subject = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sub']));
	$rec = htmlspecialchars(mysqli_real_escape_string($db,$_GET['rec']));
	$query = "SELECT *  FROM message WHERE reciever='$rec' AND sender='$sender' AND subject='$subject' AND datetime = '$time' AND recieve_type='SP' AND body_id='$bid' ";
	$result = mysqli_query($db,$query);

	if(!$result) {
		echo "<br/>error<br/>";
		echo mysqli_error($db);
		exit(1);
	}

	else {

		$row = mysqli_fetch_array($result);
		$mid = $row['m_id'];

		$query = "UPDATE message SET reciever_delete='1' WHERE m_id = $mid";

		$result = mysqli_query($db, $query);
		if(!$result) {
			echo mysqli_error($db);
		}
	else  {  echo 'deleted'; }

	}
exit(0);
	}



if(isset($_GET['markspamread']))
{ /// fetch message, query from receiver : spambox
	$sender = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sender']));
	$bid = htmlspecialchars(mysqli_real_escape_string($db,$_GET['bid']));
	$time = htmlspecialchars(mysqli_real_escape_string($db,$_GET['time']));
	$subject = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sub']));
	$rec = $htmlspecialchars(mysqli_real_escape_string($db,$_GET['rec']));
	//require 'includes/conx.php';
	$query = "SELECT *  FROM message WHERE reciever='$rec' AND sender='$sender' AND subject='$subject' AND datetime = '$time' AND body_id='$bid' ";
	$result = mysqli_query($db,$query);

	if(!$result) {
		echo "<br/>error<br/>";
		echo mysqli_error($db);
		exit(1);
	}

	else {

		$row = mysqli_fetch_array($result);
		echo  "<div style='padding:2px;padding-left:130px'>FROM : <b>".htmlspecialchars_decode($row['sender'])."</b>";
		echo  "<br/>TO : <b>".htmlspecialchars_decode($row['reciever'])."</b>";
		echo  "<br/>Date Time : <b>".htmlspecialchars_decode($row['datetime'])."</b>";
		echo  "<br/>Subject : <b>".htmlspecialchars_decode($row['subject'])."</b>";
		//echo "<br/>$response executed";
		$mid = $row['m_id'];
		//echo "done! $bid<br/>";
		$query = "UPDATE message  SET reciever_seen='1' WHERE m_id = $mid";
		$query2 = "select * from mbody where body_id=$bid";
		$result = mysqli_query($db, $query2);
		if(!$result) {
			echo mysqli_error($db);
		}
	    else  {

			 $row = mysqli_fetch_array($result);
			$query2 = "SELECT * from settings where username = '$sender'";
			 $result2 = mysqli_query($db,$query2);
			 $row2 = mysqli_fetch_array($result2);

             echo  "<br/>Message : <br/><b><div >".htmlspecialchars_decode($row['body']). "<br/>" . htmlspecialchars_decode($row2['signature'])."</div></b>";

			 		}
	}
exit(0);
	}


if(isset($_GET['sendsubmit'])) {

   require '../includes/conx.php';
	 echo '<pre>';
	 print_r($_SESSION);
echo '</pre>';
	 $sender = $_SESSION['username'];

   $sendTo = htmlspecialchars(mysqli_real_escape_string($db,$_GET['sendTo']));
   $subject = htmlspecialchars(mysqli_real_escape_string($db,$_GET['subject']));
   $body = htmlspecialchars(mysqli_real_escape_string($db,$_GET['body']));
   $type =   htmlspecialchars(mysqli_real_escape_string($db,$_GET['type']));

$search_user = "SELECT * FROM `users` WHERE username = '" . $sendTo. "'";
// echo $search_user;
$loc = "I";
$filtered = 0;
echo "$body<br/>";
   $result = mysqli_query($db,$search_user);
  //  echo "<br/> Searching receiver";
	if(mysqli_num_rows($result) == 1) {   /// if username exists
	      $datetime = date('Y-m-d H:i:s');
	      echo "<br/> Receiver Found";
          /*  checking for destination box, spam or not	 */
		    $sql = "SELECT * FROM filters where username='$sendTo'";
			$result = mysqli_query($db,$sql);
	        // echo mysqli_num_rows($result);
			if($result){  echo "<BR/> succcess"; }
			else {mysqli_error($db); exit(0);}
			foreach($result AS $row){
				$content = $row['content'];
              if(substr($body, 0 ,strlen($content) ) ) {
			   if (strpos(strtolower($body), $row['content']) !== false ) {
			      $loc = "SP";
			       $filtered = "1";
				}
			 }
			}


		  /*  checking ends	 */

		  /*  searching whether receiver has blocked this user or not */
		  //echo "SEnder = $sender, sendTo = $sendTo <br/>";

		   $query = "SELECT * FROM blocked_user where username='$sendTo' AND blocked_username='$sender'";
		   $result = mysqli_query($db,$query);
		   if(!$result) { echo "Error"; /*mysqli_error($db); */exit(0);}
		   if(mysqli_fetch_array($result ) > 0) {
			  echo "<br/> $sendTo is blocking you!";
              exit(0);
		   }else { /*echo "your can sent this message<br/>"; */}
		  /* search ends  */
		   $search_body = "SELECT *  FROM mbody where body  ='" . $body . "'";
		  $result = mysqli_query($db, $search_body);
		  // echo "<br/>Searching for message body in database ";
		  //if(!$result) { echo "<br/>Error!: from searching existing body <br/>" . mysqli_error($db); exit(0); }
		  if(mysqli_num_rows($result) == 1) {
			  // echo "<br/> Body exists inserting message with reference of that message";
			  $bid = mysqli_fetch_array($result);
			  $bid = $bid['body_id'];       /// getting message body id

			   $insert_message = "INSERT INTO message(m_id, sender, reciever,datetime, reciever_seen, body_id, subject, sender_delete, reciever_delete, attach_count, thread_id, filtered, recieve_type, sender_type)
			   VALUES (' ', '$sender' , '$sendTo' ,'$datetime', '0' , $bid , '$subject' , '0', '0' ,0 , 1 , '$filtered' , '$loc' , '$type' )";

			  $result = mysqli_query($db, $insert_message);    /// inserting message
			  // if(!$result) { echo "<br/>Error!: from inserting message with existing body <br/>" . mysqli_error($db); exit(0); } /// if error, end
			  // echo "<br/>Successfully sent from existing body";   /// success

		  } ///end of inserting message from existing body

		  else {
		      // echo "<br/>Insert new body";
			  $insert_body = "INSERT INTO mbody(`body`) values ('$body')";
				// echo $insert_body;
			  $result = mysqli_query($db,$insert_body); /// inserting the body first
			  if(!$result) {
				  //  echo "<br/>From inserting message with new body <br/>";        /// if error end
				   echo mysqli_error($db);
			    }
			  else {
			      //  echo "<br/> Body inserted, searching for Body id";
 			      $search_body = "SELECT *  FROM mbody where body  = '$body'";
		          $result = mysqli_query($db, $search_body);       /// get the body id
			      if(!$result){ echo "<br/>From searching fresh existing body <br/>" . mysqli_error($db); exit(0); }
		          // echo "<br/> Body ID found";
				  if(mysqli_num_rows($result) == 1) {
			        $bid = mysqli_fetch_array($result);
			        $bid = $bid['body_id'];
				    $sender = $_SESSION['username'];
					// echo "<br/> Inserting message with new body";
			        $insert_message = "INSERT INTO message(sender, reciever,datetime, reciever_seen, body_id, subject, sender_delete, reciever_delete, attach_count, thread_id, filtered, recieve_type, sender_type)
				    VALUES ('$sender' , '$sendTo' ,'$datetime', '0' , $bid , '$subject' , '0', '0' ,0 , 1 , '$filtered' , '$loc' , '$type' )";
						echo $insert_message;
					$result = mysqli_query($db, $insert_message);
					if(!$result) { echo "<br/>Error !: from inserting message with new body " . mysqli_error($db);  exit(0); } //error in inserting mes with new body, end
			         echo "<br/>Successfully sent from new body ENJOY"; /// else success
                    }   /// end of if new body id was found
		        }/// end of if body is successfully inserted
	        }/// end of inserting new body
	//echo "<br/>Username found";
	} /// end os username exists
	else {
	  //echo mysqli_error($db);
      echo "<br/>No pagal exists";
	}
	exit();
}


?>

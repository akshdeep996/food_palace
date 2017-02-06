<?php

session_start();


if(isset($_GET['logout'])) {
		echo "you are successfully logged out!";
		session_unset();
		session_destroy();
		//header('Location:index.html');
		exit();
	}	
	else echo "nothing to do....";
	
?>
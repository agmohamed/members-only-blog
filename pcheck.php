<?php
	session_start();

	$email=$_POST['email'];
	$password=$_POST['password'];
	
	//$email="agmohamed519@gmail.com";
	//$password='123456';
	
	$mysqli= new $mysqli('localhost:81','root','root','perfect_cup');
	
	if($mysqli->connect_error){
		die('Error '.$mysqli->connect_errno.' '.$mysqli->error);
	}
	$query="SELECT * FROM members WHERE email='$email'";
	
	$result= mysqli_query($mysqli,$query);
	$num_row= mysqli_num_rows($result);
	$row=mysqli_fetch_array($result);
	
	if($num_row >= 1){
		if(password_verify($password,$row['password'])) {
			$_SESSION['login'] = $row['id'];
			$_SESSION['fname'] = $row{'fname'};
			$_SESSION['lname'] = $row['lname'];
			echo 'true';
		}
		else{
			echo 'false';
		}
	}else{
		echo 'false';
	}

?>
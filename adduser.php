<?php
session_start();

//open a new connection to mysqli server
//$mysqli -> new mysqli(host, username, password, dbname, port, socket)
//$con = mysqli_connect("localhost","my_user","my_password","my_db");
//$mysqli= new mysqli('localhost:81','root','root','perfect_cup');

$mysqli= mysqli_connect("localhost:81","root","root","perfect_cup");
//check connection

if(mysqli->connect_error){
	die('Error : '.$mysqli->connect_error );
}


$fname= mysqli_real_escape_string($mysqli,$_POST['fname']);
$lname=mysqli_real_escape_string($mysqli,$_POST['lname']);
$email=mysqli_real_escape_string($mysqli,$_POST['email']);
$password=mysqli_real_escape_string($mysqli,$_POST['password']);


//validation

if (strlen($fname) < 2) {
    echo 'fname';
} elseif (strlen($lname) < 2) {
    echo 'lname';
} elseif (strlen($email) <= 4) {
    echo 'eshort';
}elseif(filter_var($email,FILTER_VALIDATE_EMAIL) === false){
	echo 'eformat';
}elseif(strlen($password) <=4){
	echo 'pshort';
}
//validation
else{
	//password ENCRYPT
	$spassword=password_hash($password,PASSWORD_BCRYPT,array('cost'=>12));
	
	$query = "SELECT * FROM members WHERE email='$email'";
	$result = mysqli_query($mysqli,$query) or die(mysqli_error());
	$num_row = mysqli_num_rows($result);
	$row = mysqli_fetch_error($result);
	
	if($num_row <1 ){
		$insert_row = $mysqli->query("INSERT INTO members(fname,lname,email,password) VALUES ('$fname','$lname','$email','$spassword')");
		if($insert_row){
			$_SESSION['login']=$mysqli->insert_id;
			$_SESSION['fname']=$fname;
			$_SESSION['lname']=$lname;
			
			echo 'true';
		}
	}else{
		echo 'false';
	}
}


?>
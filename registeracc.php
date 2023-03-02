<?php
	require_once("head.php");
	include ('conn.php');
	$database='vibe';
	@$mysqli=new mysqli($host,$user,$password,$database);

	if (mysqli_connect_errno())
	{
		echo 'Could not connect to database: '.mysqli_connect_error();
		exit;
	}

	$name=$_POST['name'];
	$password1=(!empty($_POST['password1'])?MD5($_POST['password1']):'');
	$password2=(!empty($_POST['password2'])?MD5($_POST['password2']):'');
	$phone=$_POST['phone'];
	$email=$_POST['email'];
	$address=$_POST['address'];
	$zipcode=$_POST['zipcode'];

	if(!empty($password1) && !empty($password2)){
		if($password1!=$password2){
			$errpw1="Password does not match.";
			$errpw2="Password does not match.";
		}else{
			$password=$password1;
		}
	}else{
		if(empty($password1) || empty($password2)){
			if(empty($password1)){
				$errpw1="Password cannot be empty.";
			}else if(empty($password2)){
				$errpw2="Please confirm your password.";
			}
		}
	}

	if(empty($name)){
		$errname="Name cannot be empty.";
	}
	if(empty($phone)){
		$errphone="Phone cannot be empty.";
	}else{
		if(!preg_match("/^[0][1][0-9][1-9][0-9]{6,7}$/",$phone)){
			$errphone="Invalid handphone number<br>";
		}
	}
	if(empty($email)){
		$erremail="Email cannot be empty.";
	}
	if(empty($address)){
		$erraddress="Address cannot be empty.";
	}
	if(empty($zipcode)){
		$errzipcode="Zipcode cannot be empty.";
	}else{
		if(!preg_match("/^[0-9]{5}$/",$zipcode)){
			$errzipcode="Invalid zipcode<br>";
		}
	}
	if(!empty($errpw1)||!empty($errpw2)||!empty($errname)||!empty($erremail)||!empty($errphone)||!empty($erraddress)||!empty($errzipcode)){
		require('Registation.php');
		exit();
	}else{
		$query='INSERT INTO `memberacc` (`mbid`, `username`, `password`, `phone`, `email`, `address`, `zipcode`) 
			VALUES (NULL, "'.$name.'", "'.$password.'", "'.$phone.'", "'.$email.'", "'.$address.'", "'.$zipcode.'")';
		$result=$mysqli->query($query);

		if($result==false){
			echo 'Invalid query: '.$mysqli->error;
			exit();
		}else{
			echo 'Welcome '.$name.'! <a href="login.php">Login here</a>.<br>';
			echo 'Your new memberacc ID is '.$mysqli->insert_id;
		}
		$mysqli->close();
	}
?>
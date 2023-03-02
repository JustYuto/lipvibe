<?php
	require_once('session.php');
	require_once('head.php');
	include('conn.php');
	
	$database='vibe';
	@$mysqli=new mysqli($host, $user, $password, $database);
	
	if (mysqli_connect_errno())
	{
		echo 'Could not connect to database: '.mysqli_connect_error();
		exit;
	}
	
	$email=$_POST['email'];
	$pw=MD5($_POST['password']);
	if(isset($_POST['adminlogin'])){
		$query="select * from adminlogin where email='".$email."'";
	}else{
		$query="select * from memberacc where email='".$email."'";
	}

	$result=$mysqli->query($query);
	$row=$result->fetch_array();
	
	if($result){
		if($row['password']==$pw){
			if(isset($_POST['adminlogin'])){
				$_SESSION["user"] = "admin";
			}else{
				$_SESSION["user"] = $row['mbid'];
				$query='UPDATE `visitor` SET `counter` = (select counter from visitor where vid=1)+1 WHERE `visitor`.`vid` = 1';
				$result=$mysqli->query($query);
			}
			header('Location: index.php');
		}else{
			echo '<br><br>&emsp;Invalid username/password <a href="login.php">Try again.</a>';
		}
	}
	$mysqli->close();
?>
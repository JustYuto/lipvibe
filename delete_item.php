<html>
<head>
</head>

<body>
	<?php
		include ('conn.php');
		$database='vibe';
		@$mysqli=new mysqli($host,$user,$password,$database);

		if (mysqli_connect_errno())
		{
		  echo 'Could not connect to database. Error: '.mysqli_connect_error();
		  exit;
		}
		
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$query="DELETE FROM `product` WHERE `product`.`pid` = ".$id;
			$result=$mysqli->query($query);
			if($result){
				header('Location: index.php');
			}else{
				echo 'Invalid query: '.$mysqli->error;
				echo 'Delete failed. <a href="index.php">Home</a>';
			}
		}
		$mysqli->close();
	?>
</body>
</html>
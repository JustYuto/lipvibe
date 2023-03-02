<?php
	include ('conn.php');
	$database='vibe';
	@$mysqli=new mysqli($host,$user,$password,$database);
	
	if (mysqli_connect_errno()){
		echo "Could not connect to database. Error: ".mysqli_connect_error();
		exit();
	}
	
	if (isset($_POST["updatestatus"])){
		if($_POST['status']=='Delivered'){
			$query="update member_order set dateDelivered = current_timestamp(), status='".$_POST['status']."' where oid=".$_POST['oid'];
		}else{
			$query="update member_order set status='".$_POST['status']."' where oid=".$_POST['oid'];
		}
		
		if(($result=$mysqli->query($query))==false){
			echo "Invalid query: ".$mysqli->error;
		}else{
			header("location: Handle_Order.php");
		}
	}
?>
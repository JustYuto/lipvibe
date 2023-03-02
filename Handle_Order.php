<?php
	include ('validation.php');
	include ('navbar.php');
	include ('conn.php');
	$database='vibe';
	@$mysqli=new mysqli($host,$user,$password,$database);
	
	if (mysqli_connect_errno()){
		echo "Could not connect to database. Error: ".mysqli_connect_error();
		exit();
	}
?>
<html>
<head>
	<?php
		require_once("head.php");
	?>
</head>
<body>
	<div class="body">
<?php
	if(isset($_POST['oid'])){
		if($_SESSION['user']=='admin'){
			$query="select * from member_order where oid=".$_POST['oid'];
		}else{
			$query="select * from member_order where mbid=".$_SESSION['user']." and oid=".$_POST['oid'];
		}
		$result=$mysqli->query($query);
		if (!$result){
			echo "<br>Invalid query: ".$mysqli->error;
			exit();
		}
		$row=$result->fetch_array();
		$numrow=$result->num_rows;
		if($numrow>0){
			$i=0;
			if($i%3==0){
				echo '<br><div class="container">
						<div class="row">';	
			}
			echo '<div class="borderline card col-sm-4 text-center">
					<br><h4>Order ID: '.$row["oid"].'</h4>';
					if($_SESSION['user']=='admin'){
						echo 'Member ID: '.$row["mbid"].'<br>';
					}
					echo 'Purchase on: '.$row['datePurchase'].'<br>
					Delivered on: '.($row['dateDelivered']==null?"within 3 working days":$row['dateDelivered']).'<br>
					Status: '.$row['status'].'<br><br>
					<form action="ViewOrder.php" method="post">
						<input type="hidden" name="orderid" value="'.$row['oid'].'">
						<input type="hidden" name="mbid" value="'.$row['mbid'].'">
						<input type="hidden" name="status" value="'.$row['status'].'">
						<input type="submit" class="btn btn-primary btn-sm" name="submit" value="View">
					</form>
				</div>';
				$i++;
				if($i%3==0 || $i==$numrow){
					echo '</div>
						</div>';
				}
		}else{
			echo '<h5>No order found</h5><br>';
		}
	}else{
		if(isset($_SESSION['user'])){
			$status=['Pending','Processing','Delivered'];
			$query=[];
			for($i=0;$i<count($status);$i++){
				$query[$i]="SELECT * FROM member_order 
							WHERE status='".$status[$i]."' ".($_SESSION['user']!='admin'?'AND mbid="'.$_SESSION["user"].'"':'')."";
			}
		}else{
			header("location: login.php");
		}
	
		$result1=$mysqli->query($query[0]);
		$result2=$mysqli->query($query[1]);
		$result3=$mysqli->query($query[2]);
	
		if ($result1==false){
			echo "<br>Invalid query0: ".$mysqli->error;
			exit();
		}
		if ($result2==false){
			echo "<br>Invalid query1: ".$mysqli->error;
			exit();
		}
		if ($result3==false){
			echo "<br>Invalid query2: ".$mysqli->error;
			exit();
		}
	
		$numrow=$result1->num_rows;
		$numrow2=$result2->num_rows;
		$numrow3=$result3->num_rows;
	
		$i=0;
		echo '<h2>Pending Order: </h2>';
		while($row=$result1->fetch_array()){
			if($i%3==0){
				echo '<br><div class="container">
						<div class="row">';	
			}
			echo '<div class="borderline card col-sm-4 text-center">
					<br><h4>Order ID: '.$row["oid"].'</h4>';
					if($_SESSION['user']=='admin'){
						echo 'Member ID: '.$row["mbid"].'<br>';
					}
					echo 'Purchase on: '.$row['datePurchase'].'<br>
					Delivered on: '.($row['dateDelivered']==null?"within 3 working days":$row['dateDelivered']).'<br>
					Status: '.$row['status'].'<br><br>
					<form class="text-left" action="ViewOrder.php" method="post">
						<input type="hidden" name="orderid" value="'.$row['oid'].'">
						<input type="hidden" name="mbid" value="'.$row['mbid'].'">
						<input type="hidden" name="status" value="'.$row['status'].'">
						<input type="submit" class="btn btn-primary btn-sm" name="submit" value="View">
					</form>
				</div>';
				$i++;
				if($i%3==0 || $i==$numrow){
					echo '</div>
						</div>';
				}
		}
		if($numrow<1){
			echo '<div style="margin:5%">No pending order</div><br>';
		}
	?>
	<hr><br><h2>Processing Order: </h2>
	<?php
		$i=0;
		while($row2=$result2->fetch_array()){
			if($i%3==0){
				echo '<br><div class="container">
						<div class="row">';	
			}
			echo '<div class="borderline card col-sm-4 text-center">
					<br><h4>Order ID:'.$row2["oid"].'</h4>';
					if($_SESSION['user']=='admin'){
						echo 'Member ID: '.$row2["mbid"].'<br>';
					}
					echo 'Purchase on: '.$row2['datePurchase'].'<br>
					Delivered on: '.($row2['dateDelivered']==null?"within 3 working days":$row2['dateDelivered']).'<br>
					Status: '.$row2['status'].'<br><br>
					<form class="text-left" action="ViewOrder.php" method="post">
						<input type="hidden" name="orderid" value="'.$row2['oid'].'">
						<input type="hidden" name="mbid" value="'.$row2['mbid'].'">
						<input type="hidden" name="status" value="'.$row2['status'].'">
						<input type="submit" class="btn btn-primary btn-sm" name="submit" value="View">
					</form>
				</div>';
				$i++;
				if($i%3==0 || $i==$numrow2){
					echo '</div>
						</div>';
				}
		}
		if($numrow2<1){
			echo '<div style="margin:5%">No processing order</div><br>';
		}
	?>
	<hr><br><h2>Delivered Order: </h2>
	<?php
		$i=0;
		while($row3=$result3->fetch_array()){
			if($i%3==0){
				echo '<br><div class="container">
						<div class="row">';	
			}
			echo '<div class="card borderline col-sm-4 text-center">
					<br><h4>Order ID:'.$row3["oid"].'</h4>';
					if($_SESSION['user']=='admin'){
						echo 'Member ID: '.$row3["mbid"].'<br>';
					}
					echo 'Purchase on: '.$row3['datePurchase'].'<br>
					Delivered on: '.($row3['dateDelivered']==null?"within 3 working days":$row3['dateDelivered']).'<br>
					Status: '.$row3['status'].'<br><br>
					<form class="text-left" action="ViewOrder.php" method="post">
						<input type="hidden" name="orderid" value="'.$row3['oid'].'">
						<input type="hidden" name="mbid" value="'.$row3['mbid'].'">
						<input type="hidden" name="status" value="'.$row3['status'].'">
						<input type="submit" class="btn btn-primary btn-sm" name="submit" value="View">
					</form>
				</div>';
				$i++;
				if($i%3==0){
					echo '</div>
						</div>';
				}
		}
		if($numrow3<1){
			echo '<div style="margin:5%">No delivered order</div><br>';
		}
	}
?>
	</div>
</body>
</html>
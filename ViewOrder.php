<?php
	require_once('validation.php');
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
		if(isset($_POST['orderid'])){
			$oid=$_POST['orderid'];
			$query1="SELECT mo.oid,mo.datePurchase,mo.dateDelivered,mo.status,mo.mbid,
							ro.pid,ro.qty,ro.totalprice,
							p.pname,p.pimg,p.price
					FROM member_order mo
					LEFT JOIN order_record ro ON mo.oid = ro.oid
					LEFT JOIN product p ON ro.pid = p.pid
					WHERE ro.oid = ".$oid;
			$result1=$mysqli->query($query1);
			
			if ($result1==false){
				echo "Invalid query: ".$mysqli->error;
				exit();
			}
			
			$directory="upload";
			$totalprice=0;
			echo '<div class="body">';
			echo '<h1 class="center">Order ID: '.$oid;
			if($_SESSION['user']=='admin'){
				echo '<form action="UpdateOrderdetail.php" method="post">
						<select class="custom-select" name="status" style="width:30%">';
							echo '<option  style="width:30%" value="Pending" '.($_POST['status']=='Pending'?"selected":"").'>Pending</option>
								<option  style="width:30%" value="Processing" '.($_POST['status']=='Processing'?"selected":"").'>Processing</option>
								<option  style="width:30%" value="Delivered" '.($_POST['status']=='Delivered'?"selected":"").'>Delivered</option>';
				echo '</select>
						<input type="hidden" name="oid" value="'.$oid.'">
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
								update
							</button>
							<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLongTitle">Update</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button name="updatestatus" class="btn btn-primary btn-sm"  value="updatestatus">UPDATE</button>
										</div>
									</div>
								</div>
							</div>
						</form>';
			}else{
				echo ' ('.$_POST['status'].')<br>';
			}
			echo '</h1><br>';

			while($row1=$result1->fetch_array()){
				$mbid=$row1['mbid'];
				echo '<br><br><div class="container">
					<div class="row">
					<div class="col-sm-3"><img class="img-fluid mx-auto d-block" src="'.$directory.'/'.$row1['pimg'].'"></div>
					<div class="col-sm-6 text-left">
						<h3>'.$row1['pname'].'</h3>';
						if($_SESSION['user']=='admin'){
							echo 'Member ID: '.$row1['mbid'].'<br>';
						}
						echo '<br>
								Quantity: '.$row1['qty'].' x RM'.$row1['price'].'<br>
								Purchase on: '.$row1['datePurchase'].'<br>
								Delivered on: '.($row1['dateDelivered']==null?"within 3 working days":$row1['dateDelivered']).'<br>';
								$totalprice+=$row1['totalprice'];
								echo '</div>
								<div class="col-sm-3">
									<h5 style="padding: 70px 0;text-align: center;">
										Total: RM'.$row1['totalprice'].'
									</h5>';
					echo "<br></div></div></div>";
			}
			?>
	<?php
		$query2="select * from memberacc where mbid=".$mbid;
		$result2=$mysqli->query($query2);
		$row2=$result2->fetch_array();
	?>
		<div class="container noline text-right">
			<h4>Total Price: RM<?php echo $totalprice;?></h4>
		</div>
		<hr>
		<div class="text-left">
			<h4>Shipping details: </h4>
			<p>Recipient Name: <?php echo $row2['username'];?></p>
			<p>Phone number: <?php echo $row2['phone'];?></p>
			<p>E-mail: <?php echo $row2['email'];?></p>
			<p>Address: <?php echo '<br>'.$row2['address'].'<br>'.$row2['zipcode'];?></p>
			<form action='Handle_Order.php'>
				<input type='submit' class='btn btn-primary btn-sm' style='display:inline-block; text-align:center;' value='Back'>
			</form>
		</div>
	<?php
		}
	?>
	</div>
	</div>
	</div>
</body>
</html>
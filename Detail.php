<head>
	<?php
        require_once("head.php");
	?>
</head>
<?php
	require_once("session.php");
	require_once('navbar.php');
	include('conn.php');
    $database='vibe';
    @$mysqli=new mysqli($host,$user,$password,$database);

    if (mysqli_connect_errno())
    {
      echo 'Could not connect to database. Error: '.mysqli_connect_error();
      exit;
	}
	
	if(isset($_POST['pid2'])){
		$pid=$_POST['pid2'];
	}else{
		$pid=$_POST['id'];
	}
    $query='select * from product where pid='.$pid;
    $result=$mysqli->query($query);
    $row=$result->fetch_array();
    $directory='upload';
	echo '<br>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6"><img class="img-fluid mx-auto d-block" src="'.$directory.'/'.$row['pimg'].'"></div>
				<div class="col-sm-5"><br><br><br>
					<h1>'.$row['pname'].'</h1><br>
					<p class="lead">Product price: RM'.$row['price'].'</p>
					<form action="processcart.php" method="post">
					<p>'.$row['stock'].' units left</p>
					<input type="number" class="form-control border border-dark" name="qty" value="1" min="0" max="100" step="1"><br><br>';
					if(isset($_SESSION["user"]) && $_SESSION["user"]=='admin'){
						echo '</form><form action="add_item.php" method="post">';
						echo '<button class="btn btn-dark" type="submit" name="id" value="'.$row['pid'].'">EDIT</button>';
						echo '</form>';
					}else{
						echo '<br><input type="submit" name="addtocart" class="btn btn-dark" value="Add to Cart">
								<input type="hidden" name="pid" value="'.$row['pid'].'">
								<input type="hidden" name="color" value="'.$row['color'].'">';
						echo '</form>';
					}
				?>
				</div>
			</div>
		</div>
		<br><br><br>
		<div id="accordion">
			<div class="card">
				<div class="card-header" id="headingOne">
					<h5 class="mb-0">
						<button class="btn btn-link nav-link active" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							<h4>Product information</h4>
						</button>
					</h5>
				</div>
				<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
					<div class="card-body">
						<p class="lead"><?php echo $row['description']; ?></p>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header" id="headingTwo">
					<h5 class="mb-0">
						<button class="btn btn-link nav-link active collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							<h4>Shipping</h4>
						</button>
					</h5>
				</div>
				<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
					<div class="card-body">
						<p class="lead">Standard Delivery:</p>
						<p class="lead">West: Rm8 <br> East: Rm10</p>
						<p class="lead">Delivery within 5days. Any 2 item will be provide free delivering</p>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header" id="headingThree">
					<h5 class="mb-0">
						<button class="btn btn-link nav-link active collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
							<h4>Product Return</h4>
						</button>
					</h5>
				</div>
				<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
					<div class="card-body">
						<p class="lead">Return by post:</p>
						<p class="lead">
						To restore a buy made through the site, portable or application, you can make your own 
						courses of action through any postal tranvibeer to our profits place. We suggest you 
						utilize one who can give you a "Testament of Posting" as, until the bundle contacts us, 
						its your obligation. If you don't mind observe that walk-ins won't be engaged at the profits community.
						</p>
						<p class="lead">
							VIBE Make Up Lab - KL:<br>
							Cheras, 56000 Kuala Lumpur, <br>
							Federal Territory of Kuala Lumpur
						</p>
					</div>
				</div>
			</div>
		</div>
		<br><br><br>
		<?php
			$query2='select category from product where pid='.$pid;
			$result2=$mysqli->query($query2);
			$row2=$result2->fetch_array();
			$category=$row2['category'];
			
			if(!$result2){
				echo 'Invalid query: '.$mysqli->error;
        		exit();
			}

			$query3='SELECT DISTINCT pid,pimg,pname,price FROM product 
					WHERE NOT pid='.$pid.' 
					AND category='.$category.' 
					ORDER BY RAND()';
			$result3=$mysqli->query($query3);
			$numrow3=$result3->num_rows;
			if(!$result3){
				echo 'Invalid query: '.$mysqli->error;
        		exit();
			}else if($numrow3<1){
				echo '<h5 class="centerwithspace">No similar products</h5>';
				exit();
			}else if($numrow3>0){
				echo '<h5 class="center">Similar products: </h5>';
			}
			$i=1;
			echo '<div class="container">
					<div class="row">';
			while($row3=$result3->fetch_array()){
		?>
        		<div class="card mb-2 col-sm-4">
					<div class="card-body">
						<img class="img-fluid" src="<?php echo $directory.'/'.$row3['pimg'];?>">
					</div>
					<div class="card-body">
						<p class="card-text"><?php echo $row3['pname'];?></p>
					</div>
					<div class="card-body">
						<p class="card-text">RM<?php echo $row3['price'];?></p>
					</div>
					<div class="card-body">
						<form style="display:inline" action="Detail.php" method="post">
							<button class="btn btn-danger btn-sm"  name="pid2" value="<?php echo $row3['pid'];?>">VIEW</button>
						</form>
						<form style="display:inline" action="add_item.php" method="post">
							<?php
								if(isset($_SESSION["user"]) && $_SESSION["user"]=='admin'){
									echo '<button class="btn btn-primary btn-sm" name="id" value="'.$row3['pid'].'">EDIT</button>';
								}
							?>
						</form>
					</div>
				</div>
<?php
		$i++;
		if($i==4){
			echo '</div></div>';
			break;
		}
	}
	$mysqli->close();
?>
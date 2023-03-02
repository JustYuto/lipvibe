<html>
<?php
	require_once("validation.php");
?>
<head>
	<?php
		require_once('head.php');
	?>
</head>
<body>

<?php
	include('navbar.php');
	include('conn.php');
    $database='vibe';
    @$mysqli=new mysqli($host,$user,$password,$database);

    if (mysqli_connect_errno())
    {
      echo 'Could not connect to database. Error: '.mysqli_connect_error();
      exit;
	}

    if($_SESSION['user']=='admin' && !isset($_POST['mbid']) && !isset($_POST['searchmbid'])){
		$query="select * from memberacc";
	}else if($_SESSION['user']!='admin' ){
		$query = "select * from memberacc WHERE mbid=".$_SESSION['user'];
		if(isset($_POST['save'])){
			$username = $_POST['name'];
			$phone=$_POST['phone'];
			$email = $_POST['email'];
			$street = $_POST['address'];
			$zipcode = $_POST['zipcode'];
		}
	}else if(isset($_POST['mbid'])){
		$query = "select * from memberacc WHERE mbid=".$_POST['mbid'];
	}else if(isset($_POST['searchmbid'])){
		$query = "select * from memberacc WHERE mbid=".$_POST['searchmbid'];
	}
	
	$result=$mysqli->query($query);
	$numrow=$result->num_rows;
	echo '<div class="body">';
	if($_SESSION['user']=='admin' && !isset($_POST['mbid'])){
		if($numrow<1){
			echo '<h5>No record found.</h5>';
			exit();
		}
		echo '<div class="container">
				<div class="row">
					<div class="col">
						Member ID
					</div>
					<div class="col">
						Email
					</div>
					<div class="col">
						Action
					</div>
				</div>
			</div>';
	}
	 while($row=$result->fetch_array()){
		if($_SESSION['user']=='admin' && !isset($_POST['mbid'])){
			echo '<div class="container">
					<div class="row body">
						<div class="col">
							'.$row['mbid'].'
						</div>
						<div class="col">
							'.$row['email'].'
						</div>
						<div class="col">
							<form action='.$_SERVER["PHP_SELF"].' method="post">
								<input type="hidden" name="mbid" value="'.$row['mbid'].'">
								<input type="submit" class="btn btn-primary btn-sm button" name="view" value="VIEW">
							</form>
						</div>
					</div>
				</div>';
		}else if(isset($_SESSION['user']) && isset($_POST['mbid']) || $_SESSION['user']!='admin'){
			echo '<form action="Edit_Account.php" method="post">';
				if($_SESSION['user']=='admin'){
					echo '<br><h1>Member ID: '.$row['mbid'].'</h1>';
				}
				echo'<div class="row form-group '.(isset($errname)?"has-danger":"").'">
						<div class="col-sm-4">Name: </div>
						<div class="col-sm-8"><input type="text" class="form-control '.(isset($errname)?"is-invalid":"").'" name="name" value="'.(isset($username)?$username:$row["username"]).'" '.($_SESSION['user']=='admin'?"disabled":"").'>';
						if(isset($errname)){
							echo '<div class="invalid-feedback">'.$errname.'</div></div>';
						}else{
							echo '</div>';
						}
						echo '</div>';
					if($_SESSION['user']!='admin'){
						echo '<input type="hidden" name="oripw" value="'.$row['password'].'">';
						echo '<div class="row form-group '.(isset($errnewpw)?"has-danger":"").'">
								<div class="col-sm-4">New Password:(original password is required) </div>
								<div class="col-sm-8"><input type="password" class="form-control '.(isset($errnewpw)?"is-invalid":"").'" name="newpassword">';
								if(isset($errnewpw)){
									echo '<div class="invalid-feedback">'.$errnewpw.'</div></div>';
								}else{
									echo '</div>';
								}
								echo'</div>';
						echo '<div class="row form-group '.(isset($erroripw)?"has-danger":"").'">
								<div class="col-sm-4">Original Password:</div>
								<div class="col-sm-8"><input type="password" class="form-control '.(isset($erroripw)?"is-invalid":"").'"  name="oripassword">';
								if(isset($erroripw)){
									echo '<div class="invalid-feedback">'.$erroripw.'</div></div>';
								}else{
									echo '</div>';
								}
								echo'</div>';
					}
					echo '<div class="row form-group '.(isset($errphone)?"has-danger":"").'">
							<div class="col-sm-4">Phone number: </div>
							<div class="col-sm-8"><input type="text" class="form-control '.(isset($errphone)?"is-invalid":"").'"  name="phone" value="'.(isset($phone)?$phone:$row["phone"]).'" '.($_SESSION['user']=='admin'?"disabled":"").'>';
							if(isset($errphone)){
								echo '<div class="invalid-feedback">'.$errphone.'</div></div>';
							}else{
								echo '</div>';
							}
							echo'</div>';
					echo '<div class="row form-group '.(isset($erremail)?"has-danger":"").'">
							<div class="col-sm-4">Email: </div>
							<div class="col-sm-8"><input type="email" class="form-control '.(isset($erremail)?"is-invalid":"").'"  name="email" value="'.(isset($email)?$email:$row["email"]).'" '.($_SESSION['user']=='admin'?"disabled":"").'>';
							if(isset($erremail)){
								echo '<div class="invalid-feedback">'.$erremail.'</div></div>';
							}else{
								echo '</div>';
							}
							echo'</div>';
					echo '<div class="row form-group '.(isset($erraddress)?"has-danger":"").'">
							<div class="col-sm-4">Address: </div>
							<div class="col-sm-8"><input type="text" class="form-control '.(isset($erraddress)?"is-invalid":"").'"  name="address" value="'.(isset($address)?$address:$row["address"]).'" '.($_SESSION['user']=='admin'?"disabled":"").'>';
							if(isset($erraddress)){
								echo '<div class="invalid-feedback">'.$erraddress.'</div></div>';
							}else{
								echo '</div>';
							}
							echo'</div>';
					echo'<div class="row form-group '.(isset($errzipocode)?"has-danger":"").'">
							<div class="col-sm-4">Zipcode: </div>
							<div class="col-sm-8"><input type="text" class="form-control '.(isset($errzipcode)?"is-invalid":"").'"  name="zipcode" value="'.(isset($zipcode)?$zipcode:$row["zipcode"]).'" '.($_SESSION['user']=='admin'?"disabled":"").'>';
							if(isset($errzipcode)){
								echo '<div class="invalid-feedback">'.$errzipcode.'</div></div>';
							}else{
								echo '</div>';
							}
							echo'</div>';
					echo'<div class="row">
							<div class="col-sm-12">
								<input type="hidden" name="mbid" value="'.$row['mbid'].'">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
									'.($_SESSION['user']=='admin'?"Delete":"Save").'
								</button>

								<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLongTitle">'.($_SESSION['user']=='admin'?"Delete":"Save").'</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												'.($_SESSION['user']=='admin'?"Are you sure you want to delete this user account?":"Save the information?").'
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary" name="'.($_SESSION['user']=='admin'?"delete":"save").'">'.($_SESSION['user']=='admin'?"delete":"save").'</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>';
		}
		
	 } 
	 
    $mysqli->close();
?>
	</div>
</body>
</html>
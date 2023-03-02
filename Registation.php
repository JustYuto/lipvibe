<html>
<head>
	<?php
		require_once("head.php");
	?>
</head>
<body>
  <form action="registeracc.php" method='post'>
	<br><br><h2>Registration From</h2>
	<div class="row form-group <?php echo (isset($errname)?"has-danger":""); ?>">
		<div class="col-sm-4">Name: </div>
		<div class="col-sm-8"><input type="text" class="form-control <?php echo (isset($errname)?"is-invalid":"");?>" name="name" value="<?php echo (isset($name)?$name:''); ?>">
		<?php
			if(isset($errname)){
				echo '<div class="invalid-feedback">'.$errname.'</div></div>';
			}else{
				echo '</div>';
			}
		?>
	</div>
	<div class="row form-group <?php echo (isset($errpw1)?"has-danger":""); ?>">
		<div class="col-sm-4">Password: </div>
		<div class="col-sm-8"><input type="password" class="form-control <?php echo (isset($errpw1)?"is-invalid":"");?>" name="password1">
		<?php
			if(isset($errpw1)){
				echo '<div class="invalid-feedback">'.$errpw1.'</div></div>';
			}else{
				echo '</div>';
			}
		?>
	</div>
	<div class="row form-group <?php echo (isset($errpw2)?"has-danger":""); ?>">
		<div class="col-sm-4">Confirm password: </div>
		<div class="col-sm-8"><input type="password" class="form-control <?php echo (isset($errpw2)?"is-invalid":"");?>" name="password2">
		<?php
			if(isset($errpw2)){
				echo '<div class="invalid-feedback">'.$errpw2.'</div></div>';
			}else{
				echo '</div>';
			}
		?>
	</div>
	<div class="row form-group <?php echo (isset($errphone)?"has-danger":""); ?>">
		<div class="col-sm-4">Phone number: </div>
		<div class="col-sm-8"><input type="text" class="form-control <?php echo (isset($errphone)?"is-invalid":"");?>" name="phone" value="<?php echo (isset($phone)?$phone:''); ?>">
		<?php
			if(isset($errphone)){
				echo '<div class="invalid-feedback">'.$errphone.'</div></div>';
			}else{
				echo '</div>';
			}
		?>
	</div>
	<div class="row form-group <?php echo (isset($erremail)?"has-danger":""); ?>">
		<div class="col-sm-4">Email: </div>
		<div class="col-sm-8"><input type="email" class="form-control <?php echo (isset($erremail)?"is-invalid":"");?>" name="email" value="<?php echo (isset($email)?$email:''); ?>">
		<?php
			if(isset($erremail)){
				echo '<div class="invalid-feedback">'.$erremail.'</div></div>';
			}else{
				echo '</div>';
			}
		?>
	</div>
	<div class="row form-group <?php echo (isset($erraddress)?"has-danger":""); ?>">
		<div class="col-sm-4">Address: </div>
		<div class="col-sm-8"><input type="text" class="form-control <?php echo (isset($erraddress)?"is-invalid":"");?>" name="address" value="<?php echo (isset($address)?$address:''); ?>">
		<?php
			if(isset($erraddress)){
				echo '<div class="invalid-feedback">'.$erraddress.'</div></div>';
			}else{
				echo '</div>';
			}
		?>
	</div>
	<div class="row form-group <?php echo (isset($errzipcode)?"has-danger":""); ?>">
		<div class="col-sm-4">Zipcode: </div>
		<div class="col-sm-8"><input type="text" class="form-control <?php echo (isset($errzipcode)?"is-invalid":"");?>" name="zipcode" value="<?php echo (isset($zipcode)?$zipcode:''); ?>">
		<?php
			if(isset($errzipcode)){
				echo '<div class="invalid-feedback">'.$errzipcode.'</div></div>';
			}else{
				echo '</div>';
			}
		?>
	</div><br>
	<div class="row">
		<div class="col-sm-12">
			<input type="submit" class="btn btn-primary btn-sm button" name="reg_user" value="Register"></div>
		</div>
	</div>
  </form>
</body>
</html>
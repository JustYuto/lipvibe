<html>
<head>
	<?php
		require_once("head.php");
	?>
</head>
<body style="background-color:lightgrey">
	<div>
		<form class="loginform" action="login_process.php" method="POST">
			<h2>WELCOME TO FLEXIS</h2>
			<div class="form-group">
				<input type="email" class="form-control" name="email" placeholder="Employee ID *">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="password" placeholder="Password *">
			</div>
			<div class="form-group custom-control custom-checkbox text-left">
				<input type="checkbox" class="custom-control-input" id="adminlogintext" name="adminlogin" value="admin">
				<label class="custom-control-label" for="adminlogintext">Login as admin?</label>
			</div>
			<input type='submit' class='btn btn-primary btn-sm' name='submit' value='Sign in'><br><br>
			<p>Register as member <a href="Registation.php">Sign up</a></p>
		</form>
	</div>
	
</body>
</html>


<html>
<head>
	<?php
		require_once("head.php");
	?>
</head>
	
	<?php
		if(isset($_SESSION["user"]) && $_SESSION["user"]=='admin'){
			$acc="Accounts";
			$order="orders";
		}else{
			$acc="Profile";
			$order="order history";
		}

        if(isset($_POST['pnameorid'])){
            $pnameorid=$_POST['pnameorid'];
        }else{
            $pnameorid='';
		}
		if(isset($_POST["oid"])){
			$oid=trim($_POST["oid"]);
		}else{
			$oid="";
		}if(isset($_POST["searchmbid"])){
			$searchmbid=trim($_POST["searchmbid"]);
		}else{
			$searchmbid="";
		}
    ?>
    <body>
		<nav class="navbar center navbar-expand-lg navbar-dark bg-danger">
		  <a class="navbar-brand" href="index.php" style="color:white;font-size:20px;">FLEXIS<a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="navbar-collapse collapse" id="navbarColor01" style="">
			<ul class="navbar-nav mr-auto">
			  <li class="nav-item <?php echo ($_SERVER["PHP_SELF"]=="/vibe/index.php"? "active" : "");?>">
				<a class="nav-link" href="index.php">Home</a>
			  </li>
				<li class="nav-item <?php echo ($_SERVER["PHP_SELF"]=="/vibe/Profile.php"?"active":"");?>">
					<a class="nav-link" href="Profile.php"><?php echo $acc; ?></a>
				</li>
				<li class="nav-item <?php echo ($_SERVER["PHP_SELF"]=="/vibe/Handle_Order.php"? "active" : "");?>">
					<a class="nav-link" href="Handle_Order.php"><?php echo $order; ?></a>
				</li>
				
				<?php
					if(isset($_SESSION['user']) && $_SESSION['user']=='admin'){
						echo '<li class="nav-item '.($_SERVER["PHP_SELF"]=="/vibe/inform.php"? "active" : "").'">
								<a class="nav-link" href="inform.php">Inform</a>
							</li>';
						echo '<li class="nav-item '.($_SERVER["PHP_SELF"]=="/vibe/add_item.php"? "active" : "").'">
								<a class="nav-link" href="add_item.php">Add Products</a>
							</li>';
					}else{
						echo '<li class="nav-item '.($_SERVER["PHP_SELF"]=="/vibe/cart.php"? "active" : "").'">
								<a class="nav-link" href="cart.php">Cart</a>
							</li>';
					}
				?>
			</ul>
			<?php
				echo '<form class="form-inline my-2 my-lg-0">';
				if(isset($_SESSION["user"])){
					echo '<input type="submit" class="btn btn-secondary btn-sm border" formaction="logout.php" value="Sign Out">';
				}else{
					echo '<input type="submit" class="btn btn-secondary btn-sm border" formaction="login.php" value="Sign In">';
				}
				echo '</form>';
			?>

		  </div>
		</nav>
    </body>
</html>
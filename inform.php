<?php
    require_once('validation.php');
    include ('conn.php');
	include ('navbar.php');
	$database='vibe';
	@$mysqli=new mysqli($host,$user,$password,$database);
	
	if (mysqli_connect_errno()){
		echo "Could not connect to database. Error: ".mysqli_connect_error();
		exit();
    }
    
    if($_SESSION['user']!='admin'){
        header("location: login.php");
        exit();
    }
?>

<html>
	<head>
        <?php
            require_once("head.php");
        ?>
	</head>
<?php
    $query="select * from memberacc";
    $result=$mysqli->query($query);
    $numrow=$result->num_rows;

    $query2="select * from order_record";
    $result2=$mysqli->query($query2);
    $revenue=0;
    while($row2=$result2->fetch_array()){
        $revenue+=$row2['totalprice'];
    }

    $query3="select * from product";
    $result3=$mysqli->query($query3);
    $numrow3=$result3->num_rows;
?>
<body>
<br><br>
    <div class="container">
        <div class="row centerheight">
            <div class="col-sm">
                <a class="nodecoration" href="Profile.php"><div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="centertextheight">Total Members</h5>
                        <p class="card-text"><?php echo $numrow;?></p>
                    </div>
                </div></a>
            </div>
            <div class="col-sm">
                <a class="nodecoration" href="index.php"><div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="centertextheight">Total Products</h5>
                        <p class="card-text"><?php echo $numrow3;?></p>
                    </div>
                </div></a>
            </div>
            <div class="col-sm">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="centertextheight">Total Revenue</h5>
                        <p class="card-text" style="color:black;">RM<?php echo $revenue;?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
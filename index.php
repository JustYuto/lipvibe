<html>
<head>
    <?php
        require_once("head.php");
	?>
</head>
<?php
    require_once("session.php");
    include('navbar.php');
    include('conn.php');
    $database='vibe';
    @$mysqli=new mysqli($host,$user,$password,$database);

    if (mysqli_connect_errno())
    {
    echo 'Could not connect to database. Error: '.mysqli_connect_error();
    exit;
    }
?>
<body>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"  data-interval="2000">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
        </ol><br><br>
        <div class="carousel-inner">
        <div class="carousel-item active">
                <img class="d-block w-100" src="upload/pic4.jpg" alt="slide4">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="upload/pic1.jpg" alt="slide1">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="upload/pic2.jpg" alt="slide2">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="upload/pic3.jpg" alt="slide3">
            </div>
        </div>
    </div><br>
<?php
    if(isset($_POST['pnameorid'])){
    	$brandname='';
        $pnameorid=$_POST['pnameorid'];        
        if(is_numeric($pnameorid)){
            $id=$pnameorid;
            if($_SESSION['user']=='admin'){
                $query='select * from product where pid='.$id.'';
            }else{
                $query='select * from product where pname LIKE "%'.$id.'%"';
            }
        }else{
            $pname=$pnameorid;
            $pname2=explode(" ",$pname);
            $query='select * from product where pname LIKE "%'.$pname2[0].'%"';
            for($i=1;$i<count($pname2);$i++){
                $query.= 'AND pname LIKE "%'.$pname2[$i].'%"';
            }
        }
    }else{
        if(isset($_GET['brand'])){
            $brandname=$_GET['brand'];
            $query='select * from product where category='.$brandname;
        }else{
            $brandname='';
            $query='select * from product';
        }
    }    

    $query2="select * from category";
    $result2=$mysqli->query($query2);

    if($result2==false){
        echo 'Invalid query: '.$mysqli->error;
        exit();
    }
    echo '<br><ul class="nav justify-content-center nav-pills">
            <li class="nav-item">
                <a class="nav-link '.(isset($_GET['brand'])?"":"active").'" href="'.$_SERVER["PHP_SELF"].'">ALL</a>
            </li>';
    while($row2=$result2->fetch_array()){
        echo '<li class="nav-item">
                <a class="nav-link '.(($row2['cid']==$brandname)?"active":"").'" href="'.$_SERVER["PHP_SELF"].'?brand='.$row2["cid"].'">'.$row2["brand"].'</a>
            </li>';
    }
    echo '</ul>';

    $result=$mysqli->query($query);
    $numrow=$result->num_rows;

    if($result==false){
        echo 'Invalid query: '.$mysqli->error;
        exit();
    }else if($numrow==0){
        echo '<h5 class="centerwithspace">No record found</h5>';
        exit();
    }
?>
    <?php
        if(isset($_POST['page'])){
            $page=$_POST['page'];
        }else{
            $page=1;
        }
        $limit=6;
        $directory='upload';
        $i=0;
        $start=($page-1)*$limit;
        mysqli_data_seek($result,$start);

        while($row=$result->fetch_array()){
			if($i%3==0 || $i==$start){
                    echo '</br><div class="container">
					<div class="row">';
            }
            echo '<div class="card mb-2 col-sm-4">
                    <div class="card-body">
                        <img class="img-fluid" src="'.$directory.'/'.$row['pimg'].'">
                    </div>
					<div class="card-body">
						<p class="card-text">'.$row['pname'].'</p>
					</div>
					<div class="card-body">
						<p class="card-text">RM'.$row['price'].'</p> 
					</div>
					<div class="card-body">
						<form action="Detail.php" method="post">
							<button class="btn btn-danger centerwithspace btn-sm"  name="id" value="'.$row['pid'].'">ADD TO CART</button>
						</form>';
                        if(isset($_SESSION["user"]) && $_SESSION["user"]=='admin'){
                            echo '<form action="add_item.php" method="post">';
                            echo '<button class="btn btn-primary centerwithspace btn-sm" name="id" value="'.$row['pid'].'">EDIT</button>';
                            echo '</form>';
                        }
					echo '</div>
				</div>';
			$i++;
            if($i%3==0){
                echo '</div>
                    </div>';
            }
            if($i>=$limit){
                break;
            }
		}
		echo '<div class="container">
                <div class="row">';
		echo '<div class="text-left"></br>';
        echo '<p>Total items: '.$numrow.'</p>';
		
        $no=ceil($numrow/$limit);
        echo '<div><ul class="pagination">';
        for($i=1;$i<=$no;$i++){
            echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
            echo '<input type="hidden" name="pname" value="'.$pnameorid.'">';
            echo '<input type="hidden" name="page" value="'.$i.'">';
            echo '<li class="page-item '.($page==$i?"active":"").'"><input class="btn btn-primary btn-sm page-link" type="submit" name="submit" value="'.$i.'"></li></form>';
        }
        echo '</ul></div>';
        echo '</div>';

    $mysqli->close();
?>
</body>
</html>
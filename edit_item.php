<?php
    require_once("session.php");
?>
<html>
    <head>
        <?php
            require_once("head.php");
        ?>
    </head>
<?php
    include ('conn.php');
    $database='vibe';
    @$mysqli=new mysqli($host,$user,$password,$database);

    if (mysqli_connect_errno())
    {
      echo 'Could not connect to database. Error: '.mysqli_connect_error();
      exit;
    }

    $pname = $_POST['pname'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    if(empty($_POST['size'])){
        $sizestr='';
    }else{
        $sizestr=implode(",",$_POST['size']);
    }
    $color = $_POST['color'];
    $description = $_POST['description'];
    $brand = $_POST['brand'];

    if(!empty($_POST['currentpimg'])){
        $pimg=$_POST['currentpimg'];
    }else if(!empty($_FILES['pimg']['name'])){
        $pimg=$_FILES['pimg']['name'];
    }else{
        $errimg="Product image cannot be empty.";
    }

    if(empty($pname)){
		$errpname="Product name cannot be empty.";
    }
    if(empty($price)){
		$errprice="Product price cannot be empty.";
    }
    if(empty($stock)){
		$errstock="Product stock cannot be empty.";
	}
	if(empty($sizestr)){
		$errsize="Size cannot be empty.";
	}
	if(empty($color)){
		$errcolor="Color cannot be empty.";
	}
	if(empty($description)){
		$errdesc="Description cannot be empty.";
	}
	if(empty($brand)){
		$errbrand="Brand cannot be empty.";
    }
	if(!empty($errpname)||!empty($errprice)||!empty($errstock)||!empty($errsize)||!empty($errcolor)||!empty($errdesc)||!empty($errbrand)||!empty($errimg)){
        if(isset($_POST['save'])){
            $id = $_POST['pid'];
        }
        require('add_item.php');
		exit();
	}else{
        if(isset($_POST['add'])){
            if ($_FILES['pimg']['error']>0 && $_FILES['pimg']['error']!=4){
                echo 'Error:'.$_FILES['cimg']['error'];
                exit();
            }else if ($_FILES['pimg']['error']==0){
                if ($_FILES['pimg']['size']>307200){
                    echo 'File size too big';
                    exit();
                }else{ 
                    if (!($_FILES['pimg']['type']=='image/jpeg' || $_FILES['pimg']['type']=='image/jpg')){
                        echo 'Invalid file type';
                        exit();
                    }else{
                        $directory='upload';
                        if (!file_exists($directory)){
                            mkdir($directory);
                        }
                        if (!file_exists($directory.'/'.$_FILES['pimg']['name'])){
                            if(move_uploaded_file($_FILES['pimg']['tmp_name'], $directory.'/'.$_FILES['pimg']['name'])){
                            }else{
                                echo 'Image save unsuccessfully, please try again.';
                                exit();
                            }
                        }
                    }
                }
            }else if ($_FILES['pimg']['error']==4){
                echo 'Please upload an image';
                exit();
            }
        }

        if(isset($_POST['add'])){
            $query="INSERT INTO `product` (`pid`, `pname`, `price`, `stock`, `pimg`,`size`,`color`,`description`,`category`) 
                    VALUES (NULL, '".$pname."', '".$price."', '".$stock."', '".$pimg."','".$sizestr."','".$color."','".$description."','".$brand."')";
            $result=$mysqli->query($query);

            if($result==false){
                echo 'Invalid query: '.$mysqli->error;
                exit();
            }else{
                echo 'New product added successfully! <a href="index.php">Home</a><br>';
                echo 'The new product ID is '.$mysqli->insert_id;
            }
        }else if(isset($_POST['save'])){
            $id = $_POST['pid'];
            $query="UPDATE `product`
                    SET `pname` = '".$pname."',
                    `price` = '".$price."',
                    `stock` = '".$stock."',
                    `pimg` = '".$pimg."',
                    `size` = '".$sizestr."',
                    `color` = '".$color."',
                    `description` = '".$description."',
                    `category` = '".$brand."'
                    WHERE `product`.`pid` = ".$id;
            $result=$mysqli->query($query);
            if($result){
                header('Location: add_item.php');
            }else{
                echo 'Update failed. <a href="index.php">Home</a>';
                echo 'Invalid query: '.$mysqli->error;
            }
        }
    }

    $mysqli->close();
?>
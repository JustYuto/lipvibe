<?php
    require_once('session.php');
    include ('conn.php');
    $database='vibe';
    @$mysqli=new mysqli($host,$user,$password,$database);

    if (mysqli_connect_errno())
    {
      echo 'Could not connect to database. Error: '.mysqli_connect_error();
      exit;
    }

    if(isset($_SESSION['user']) && $_SESSION['user']!='admin'){
        if(isset($_POST['addtocart'])){
            $pid=$_POST['pid'];
            $color=$_POST['color'];
            $qty=$_POST['qty'];

            $query="INSERT INTO `cart`
                    VALUES (NULL, '".$pid."', '".$_SESSION['user']."', '".$qty."','".$color."')";
            $result=$mysqli->query($query);

            if($result==false){
                echo 'Invalid query: '.$mysqli->error;
                exit();
            }else{
                header("location: cart.php");
            }
        }else if(isset($_POST['checkout'])){
            $query='select * from cart where mbid='.$_SESSION['user'];
            $result=$mysqli->query($query);
            $query2='INSERT INTO `member_order`
                     VALUES (NULL, current_timestamp(),NULL,"Pending","'.$_SESSION['user'].'")';
            $result2=$mysqli->query($query2);
            if(!$result2){
                echo 'Invalid query: '.$mysqli->error;
                exit();
            }else{
                $newoid=$mysqli->insert_id;
                while($row=$result->fetch_array()){
                    $query3="select price from product where pid=".$row['pid'];
                    $result3=$mysqli->query($query3);
                    $row3=$result3->fetch_array();

                    $query4='INSERT INTO `order_record`   
                            VALUES ("'.$newoid.'", "'.$row['pid'].'","'.$row['qty'].'","'.($row['qty']*$row3['price']).'")';
                    $result4=$mysqli->query($query4);
                    if(!$result4){
                        echo 'Invalid query: '.$mysqli->error;
                        exit();
                    }
                    $pid=$row["pid"];
                    $minusqty=$row["qty"];
                    $query5='UPDATE `product` SET `stock` = ((select stock from product where pid='.$pid.')-'.$minusqty.') WHERE `product`.`pid` ='.$pid;
                    $result5=$mysqli->query($query5);
                    if(!$result5){
                        echo 'Invalid query: '.$mysqli->error;
                        exit();
                    }
                }
                $query5='delete from cart where mbid='.$_SESSION['user'];
                $result5=$mysqli->query($query5);
                if(!$result5){
                    echo 'Invalid query: '.$mysqli->error;
                    exit();
                }else{
                    header("location: Handle_Order.php");
                }
            }
        }else{
            if(isset($_POST['delete'])){
                $query='DELETE FROM `cart` WHERE `cart`.`cartid` = '.$_POST["delete"];
            }else if(isset($_POST['update'])){
                $qty=$_POST['qty'.$_POST["update"].''];
                $query='UPDATE `cart` SET `qty` = "'.$qty.'"
                        WHERE `cart`.`cartid` = '.$_POST["update"];
            }
            $result=$mysqli->query($query);
            if($result){
                header("location: cart.php");
            }else{
                echo 'Invalid query: '.$mysqli->error;
                exit();
            }
        }
    }else{
        header("location: login.php");
    }
?>
<?php
    include ('conn.php');
    require_once('validation.php');
    require_once('navbar.php');
    $database='vibe';
    @$mysqli=new mysqli($host,$user,$password,$database);

    if (mysqli_connect_errno())
    {
      echo 'Could not connect to database. Error: '.mysqli_connect_error();
      exit;
    }
?>
<head>
    <?php
        require_once("head.php");
	?>
</head>
<body>
    <br><br>
    <h1 class="center">My Cart</h1>
    <br><br>
    <form action="processcart.php" method="post">
<?php
    if(isset($_SESSION['user']) && $_SESSION['user']!='admin'){
        $query='select * from cart where mbid='.$_SESSION['user'];
        $result=$mysqli->query($query);
        $numrow=$result->num_rows;
        $sum=[];
        $a=0;
        if($numrow>0){
            while($row=$result->fetch_array()){
                $directory='upload';
                $query2='select * from product where pid='.$row['pid'];
                $result2=$mysqli->query($query2);
                $row2=$result2->fetch_array();
                echo '<div class="container">
                        <div class="row">
                            <div class="col-sm-3"><img class="img-fluid mx-auto d-block" src="'.$directory.'/'.$row2['pimg'].'"></div>
                            <div class="col-sm-6 text-left">
                                <h3>'.$row2['pname'].'</h3>
                                Quantity: <input type="number" class="form-control" style="width:30%" name="qty'.$row['cartid'].'" value="'.$row['qty'].'" min="0" max="100" step="1">
                                        x RM'.$row2["price"].'
                                <p><br>Color: '.$row['color'].'</p>
                            </div>';
                            $sum[$a]=$row2['price']*$row['qty'];
                            echo '<div class="col-sm-3"><h5 style="padding: 70px 0;text-align: center;">Subtotal: RM'.$sum[$a].'<h5>';
                            ?>     
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModalCenter<?php echo $a?>">
                                    update
                                </button>
                                <div class="modal noline fade" id="exampleModalCenter<?php echo $a?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog noline modal-dialog-centered" role="document">
                                        <div class="modal-content noline">
                                            <div class="modal-header noline">
                                                <h5 class="modal-title" id="exampleModalLongTitle">UPDATE</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body noline">
                                                Are you sure you want to update this product?
                                            </div>
                                            <div class="modal-footer noline">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" name='update' value="<?php echo $row['cartid'];?>" class="btn btn-primary">update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary btn-sm float-right" data-toggle="modal" data-target="#exampleModalCenter2<?php echo $a?>">
                                    delete
                                </button>
                                <div class="modal noline fade" id="exampleModalCenter2<?php echo $a?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog noline modal-dialog-centered" role="document">
                                        <div class="modal-content noline">
                                            <div class="modal-header noline">
                                                <h5 class="modal-title" id="exampleModalLongTitle">DELETE</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body noline">
                                                Are you sure you want to delete this product?
                                            </div>
                                            <div class="modal-footer noline">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" name='delete' value="<?php echo $row['cartid'];?>" class="btn btn-primary">delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                $a++;
                                echo '</div>
                                        </div><br>';
            }
        $totalprice=0;
        for($i=0;$i<count($sum);$i++){
            $totalprice+=$sum[$i];
        }
        echo '<br><div class="container noline text-right"><h4>Total Price: RM'.$totalprice.'</h4>
                    <input type="submit" class="btn btn-primary float-right" name="checkout" value="checkout">
                    </div>';
?>
    </form>
<?php
        }else{
            echo '<p style="margin:3%">Nothing in your cart.  ';
            echo 'Add now? <a href="index.php">Yes</a></p>';
        }
    }else{
        header("location: login.php");
    }
?>
</body>
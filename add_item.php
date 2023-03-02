<html>
<head>
    <?php
        require_once("head.php");
	?>
</head>
    <?php
        require_once("session.php");
        require_once("validation.php");
        include('navbar.php');
        include('conn.php');
        $database='vibe';
        @$mysqli=new mysqli($host,$user,$password,$database);

        if (mysqli_connect_errno())
        {
            echo 'Could not connect to database. Error: '.mysqli_connect_error();
            exit;
        }
        
        if($_SESSION['user']=='admin'){
            $query2='select * from category';
            $result2=$mysqli->query($query2);
            $directory='upload';

            if(isset($_POST['id'])){
                $id=$_POST['id'];
            }

            if(isset($id) && !isset($_POST['submit']) && !isset($_POST['save']) && !isset($_POST['newimg'])){
                $query='select * from product where pid='.$id;
                $result=$mysqli->query($query);
                $row=$result->fetch_array();

                $pname = $row['pname'];
                $price = $row['price'];
                $stock = $row['stock'];
                $pimg = $row['pimg'];
                $color = $row['color'];
                $description = $row['description'];
                $brand = $row['category'];
            }else if(isset($_POST['submit']) || isset($_POST['save']) || isset($_POST['newimg'])){
                $pname=$_POST['pname'];
                $price=$_POST['price'];
                $stock=$_POST['stock'];
                if(!empty($_POST['newimg'])){
                    $newpimg=$_POST['newimg'];
                }
                $color=$_POST['color'];
                $description=$_POST['description'];
                $brand=$_POST['brand'];
            }else if(!isset($_POST['add']) && !isset($_POST['save'])){
                $id='';
                $pname='';
                $price='';
                $stock='';
                $color='';
                $description='';
                $brand='';
            }
    ?>
    <body>
        <br><br>
        <h3 style="text-align:center;">Submit FWA REQUEST</h3><br>
        <form action="edit_item.php" id="addproduct" method="post" enctype="multipart/form-data" >
            <div class="row form-group <?php echo (isset($errpname)?"has-danger":""); ?>">
                <div class="col-sm-4">EmployeeID:  </div>
                <div class="col-sm-5">
                    <input type="hidden" name="pid" value="<?php echo $id;?>">
                    <input type="text" name="pname"  class="form-control <?php echo (isset($errpname)?"is-invalid":"");?>" value="<?php echo $pname;?>"><br>
                    <?php   
                        if(isset($errpname)){
                            echo '<div class="invalid-feedback">'.$errpname.'</div></div>';
                        }else{
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
            <div class="row form-group <?php echo (isset($errpname)?"has-danger":""); ?>">
                <div class="col-sm-4">Employee Name:  </div>
                <div class="col-sm-5">
                    <input type="hidden" name="pid" value="<?php echo $id;?>">
                    <input type="text" name="pname" class="form-control <?php echo (isset($errpname)?"is-invalid":"");?>" value="<?php echo $pname;?>"><br>
                    <?php
                        if(isset($errpname)){
                            echo '<div class="invalid-feedback">'.$errpname.'</div></div>';
                        }else{
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
            <div class="row form-group <?php echo (isset($errbrand)?"has-danger":""); ?>">
                <div class="col-sm-4">Work Type: </div>
                <div class="col-sm-5">
                    <select name="brand" class="custom-select <?php echo (isset($errbrand)?"is-invalid":"");?>">
                        <option value="">--Select Type--</option>
                        <?php
                            while($row2=$result2->fetch_array()){
                                echo '<option value="'.$row2['cid'].'" '.($row2['cid']==$brand?"selected":"").'>'.$row2['brand'].'</option>';
                            }
                        ?>
                    </select>
                    <?php
                        if(isset($errbrand)){
                            echo '<div class="invalid-feedback">'.$errbrand.'</div></div>';
                        }else{
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
            <div class="row form-group <?php echo (isset($errdesc)?"has-danger":""); ?>">
                <div class="col-sm-4">Description: </div>
                <div class="col-sm-5">
                    <textarea rows="4" cols="50" placeholder="Write your description here" class="form-control <?php echo (isset($errdesc)?"is-invalid":"");?>" name="description"><?php echo $description;?></textarea><br>
                    <?php
                        if(isset($errdesc)){
                            echo '<div class="invalid-feedback">'.$errdesc.'</div></div>';
                        }else{
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
            <div class="row form-group <?php echo (isset($errcolor)?"has-danger":""); ?>">
                <div class="col-sm-4">Reason: </div>
                <div class="col-sm-5">
                <textarea rows="4" cols="50" placeholder="Write your reason here" name="color" class="form-control <?php echo (isset($errcolor)?"is-invalid":"");?>" name="reason"></textarea><br>
                <?php
                    if(isset($errcolor)){
                        echo '<div class="invalid-feedback">'.$errcolor.'</div></div>';
                    }else{
                        echo '</div>';
                    }
                ?>
                </div>
            </div>            
            <div class="row">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
                        <?php echo (!isset($_POST['id']) && !isset($_POST['save'])?"submit":"save"); ?>
                    </button>

                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo (!isset($_POST['id'])&&!isset($_POST['save'])?"submit":"Save"); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <?php echo (!isset($_POST['id'])&&!isset($_POST['save'])?"submit":"Save"); ?> the information to this product?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="<?php echo (!isset($_POST['id'])&&!isset($_POST['save'])?"submit":"save"); ?>"><?php echo (!isset($_POST['id'])&&!isset($_POST['save'])?"submit":"Save"); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        if(isset($_POST['id']) || isset($_POST['save'])){
                            echo '<input type="hidden" name="eimg" value="'.$id.'">
                                    <input type="submit" class="btn btn-primary btn-sm" formaction="edit_item_Image.php" value="Edit image">
                                </form>';

                                echo '<form action="delete_item.php" method="post">
                                    <input type="hidden" name="id" value="'.$id.'">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter2">
                                        delete
                                    </button>';
                    ?>
                    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">DELETE</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this product?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                    <?php
                        }
                    ?>
                    <form>
                        <input type="submit" class="btn btn-primary btn-sm" formaction="index.php" value="cancle">
                    </form>
                </div>
            </div><br>
    <?php
        }
    ?>    
    </body>
</html>
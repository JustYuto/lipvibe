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
    echo '<div class="body">';
    echo '<form action="'.(isset($_POST['eimg'])?$_SERVER["PHP_SELF"]:"add_item.php").'" method="post"  enctype="multipart/form-data">
            <input type="hidden" name="'.(isset($_POST['eimg'])?"pid":"id").'" value="'.(isset($_POST['eimg'])?$_POST['eimg']:$_POST['pid']).'"> 
            <input type="hidden" name="pname" value="'.$_POST['pname'].'">
            <input type="hidden" name="price" value="'.$_POST['price'].'">
            <input type="hidden" name="stock" value="'.$_POST['stock'].'">
            <input type="hidden" name="color" value="'.$_POST['color'].'">
            <input type="hidden" name="description" value="'.$_POST['description'].'">
            <input type="hidden" name="brand" value="'.$_POST['brand'].'">
            <input type="hidden" name="esize" value="'.(isset($_POST['eimg'])?implode(",",$_POST['size']):$_POST['esize']).'">
            '.(isset($_POST['eimg'])?"<input type='file' name='newimg'><br><br>
                                    <input type='submit' name='editimg' class='btn btn-primary btn-sm'  value='Submit'>
                                    </form>":"<input type='hidden' name='newimg' value='".$_FILES['newimg']['name']."'>").'';
            
    if(isset($_FILES['newimg']['name'])){
        if ($_FILES['newimg']['error']>0 && $_FILES['newimg']['error']!=4){
            echo 'Error:'.$_FILES['newimg']['error'];
            exit();
        }else if ($_FILES['newimg']['error']==0){
            if ($_FILES['newimg']['size']>307200){
                echo 'File size too big';
                exit();
            }else{ 
                if (!($_FILES['newimg']['type']=='image/jpeg' || $_FILES['newimg']['type']=='image/jpg')){
                    echo 'Invalid file type';
                    exit();
                }else{
                    $directory='upload';
                    if (!file_exists($directory)){
                        mkdir($directory); 
                    }
                    if (!file_exists($directory.'/'.($_FILES['newimg']['name']))){
                        if(move_uploaded_file($_FILES['newimg']['tmp_name'], $directory.'/'.$_FILES['newimg']['name'])){
                            echo 'Image saved ';
                        }else{
                            echo 'Image save unsuccessfully, please try again.';
                            exit();
                        }
                    }
                    echo '<input type="submit" class="btn btn-primary btn-sm" value="Back">
                        </form>';
                }
            }
        }else if ($_FILES['newimg']['error']==4){
            echo 'Please upload an image';
            exit();
        }
        echo '</div>';
}
    $mysqli->close();
?>
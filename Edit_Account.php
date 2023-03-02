<html>
<?php
    require_once("validation.php");
?>
<body>
<?php
    include ('conn.php');
    $database='vibe';
    @$mysqli=new mysqli($host,$user,$password,$database);

    if (mysqli_connect_errno())
    {
      echo 'Could not connect to database. Error: '.mysqli_connect_error();
      exit;
    }

    if($_SESSION['user']!='admin'){
        $username = $_POST['name'];
        $newpassword = (!empty($_POST['newpassword'])?MD5($_POST['newpassword']):'');
        $oripassword = (!empty($_POST['oripassword'])?MD5($_POST['oripassword']):'');
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $zipcode = $_POST['zipcode'];

        if(!empty($newpassword) && !empty($oripassword)){
            if($_POST['oripw']!=$oripassword){
                $erroripw="Original password does not match.";
            }else{
                $password=$newpassword;
            }
        }else if(empty($newpassword) && empty($oripassword)){
            $password=$_POST['oripw'];
        }else{
            if(empty($oripassword) && !empty($newpassword)){
                $erroripw="Original password cannot be empty.";
            }else if(empty($newpassword) && !empty($oripassword)){
                $errnewpw="New password cannot be empty.";
            }
        }
        if(empty($username)){
            $errname="Name cannot be empty.";
        }
        if(empty($phone)){
            $errphone="Phone cannot be empty.";
        }else{
            if(!preg_match("/^[0][1][0-9][1-9][0-9]{6,7}$/",$phone)){
                $errphone="Invalid handphone number<br>";
            }
        }
        if(empty($email)){
            $erremail="Email cannot be empty.";
        }
        if(empty($address)){
            $erraddress="Address cannot be empty.";
        }
        else{
            if(!preg_match("/^[0-9]{5}$/",$zipcode)){
                $errzipcode="Invalid zipcode<br>";
            }
        }
        if(!empty($erroripw)||!empty($errnewpw)||!empty($errname)||!empty($erremail)||!empty($errphone)||!empty($erraddress)||!empty($errzipcode)){
            require('Profile.php');
            exit();
        }else{
            $query='UPDATE `memberacc` 
            SET `username` = "'.$username.'",
                `password` = "'.$password.'",
                `phone` = "'.$phone.'",
                `email` = "'.$email.'",
                `address` = "'.$address.'", 
                `zipcode` = "'.$zipcode.'" 
                WHERE `memberacc`.`mbid` = '.$_SESSION['user'];
            $result=$mysqli->query($query);

            if($result==false){
                echo 'Invalid query: '.$mysqli->error;
                exit();
            }else{
                echo 'Saved successfully';
                require('Profile.php');
                exit();
            }
        }
    }else if($_SESSION['user']=='admin'){
        if(isset($_POST['mbid'])){
			$id = $_POST['mbid'];
			$query="DELETE FROM `memberacc` WHERE `memberacc`.`mbid` = ".$id."";
			$result=$mysqli->query($query);
			if($result){
                header('Location: Profile.php');
			}else{
                echo 'Delete failed. <a href="Profile.php">Back</a>';
                exit();
			}
		}
    }
?>
</body>
</html>
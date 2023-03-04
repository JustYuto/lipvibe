<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "FlexIS";

$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
if($conn===FALSE)
{
	die("Connection error");
}

if($_SERVER["REQUEST_METHOD"]=="POST")
{
	$employeeid=$_POST["EmployeeID"];
    $password=$_POST["Password"];

    $sql="select * from employee where EmployeeID='".$employeeid."' AND Password='".$password."'";

    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_array($result))
    {
    if($row["position"]=="Employee")
    {
        header("location:employeeHome.php");
    }
    elseif($row["position"]=="Supervisor")
    {
        header("location:supervisorHome.php");
    }
    elseif($row["position"]=="HR Admin")
    {
        header("location:hrAdminHome.php");
    }
    else
    {
        echo "Invalid Employee ID or Password";
    }
}
}

?>


<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
<body>

<form action="#" method="POST">
    <div>
        <label>Employee ID</label>
        <input type="text" name="EmployeeID" required>
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="Password" required>
    </div>

    <div>
        <input type="submit" value="Login">
    </div>
   
    </form>

</body>
</html>

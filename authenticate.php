<?php
include "session.php";
$emailAddress=$_POST['emailAddress'];
$password=$_POST['password'];
$sessionId=password_hash($emailAddress,PASSWORD_DEFAULT);

         
$servername = "localhost";
$mysqlUsername = "example";
$mysqlPassword = "";
$database="UserDetails";

$connection = mysqli_connect($servername, $mysqlUsername, $mysqlPassword,$database);

if (!$connection) {
    die("Unable to load User Details - Connection failed: " . mysqli_connect_error());
}

$sql="SELECT emailAddress,password FROM user";

$user = mysqli_query($connection,$sql);
/*
*password_verify($password,$hash)
*@param string $password
*@param string $hash
*@return bool; -true password match and false password not match
*/
if(mysqli_num_rows($user) > 0){            
    while($row= mysqli_fetch_assoc($user)){
        if($row['emailAddress']==$emailAddress){
            $emailAddressExists=true;
            $passwordPresentInUser=(base64_decode($row['password'],false)==$password)?1:0;//password_verify($password,$row['password']);
            break;
        }
    }
}else{
    $emailAddressExists=false;
    $passwordPresentInUser=false;
}

if(($emailAddressExists && $passwordPresentInUser)&&($emailAddressExists!=0 && $passwordPresentInUser!=0)){
    $_SESSION['id']=(!isset($_SESSION['id']))?$sessionId:$_SESSION['id'];
    // echo 'success';
    header("Location:http://localhost/dashboard.php?Message=".urlencode("Login Successfull"));    
    exit();
}
else if(!($emailAddressExists) && !($passwordPresentInUser)){
    // echo "nu";
    header("Location:http://localhost/login.php?Message=".urlencode("You are new User. Register Now"));
    exit();
}
else if($emailAddressExists && !($passwordPresentInUser)){
    //echo "i2";
    header("Location:http://localhost/login.php?Message=".urlencode("Incorrect login details"));
    exit();
}
else{
   // echo "i1";
    header("Location:http://localhost/login.php?Message=".urlencode("Incorrect login details"));
    exit();
}

mysqli_close($connection);
error_log("debug.log");     
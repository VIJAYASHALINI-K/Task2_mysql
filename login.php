<?php
   include "session.php";
   if(isset($_SESSION['id'])){
        header("Location:http://localhost/dashboard.php");
    }
    // if(isset($_COOKIE['emailAddress'])){
    //     $emailAddresses=json_decode($_COOKIE['emailAddress'],true)
    //     if(isset($emailAddresses['$emailAddress'])){
    //         echo "cookie set";
    //         $passwordByCookies=$_COOKIE[$password];
    //     }
    //     else{
    //         echo "cookie not set";
    //         $emailAddress=$_POST['emailAddress'];
    //         $password=$_POST['password'];
    //         $expiration = time() + 86400;
    //         setcookie($emailAddress,$password,$expiration);
    //     }
    // }
    // else{
    //     echo "cookie not set";
    //     $emailAddress=$_POST['emailAddress'];
    //     $password=$_POST['password'];
    //     $expiration = time() + 86400;
    //     setcookie($emailAddress,$password,$expiration);
    // }
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="design.css">
    
    </head>
<body>
    <div class="container" id="loginContainer">
        <form method="POST" action="/authenticate.php">
            <fieldset>
                <legend>Log In</legend>   
                <label for="emailAddress">Email Address</label><br>
                <input type="email" id="emailAddress" name="emailAddress" required><br><br>
                <label for="password">Password</label><br>
                <input type="password" for="password" name="password"  value="<?php echo $passwordByCookies; ?>" required><br><br>
                <input type="submit" value="Log In"  id="logIn"><br><br>
                <span id="user">
                    <span id="newUserLabel">
                        <label>Don't have an account? </label>
                    </span>
                    <span id="newUserLink">
                        <a href="/index.php">Register Now</a><br><br>
                    </span>
                </span>
                </fieldset>
        </form>
    </div>
    <?php
        $Message = $_GET['Message'];
        echo '<h5 style="padding:5px;font-size: 20px;color:white;">'.$Message.'</h5>';
        error_log("debug.log");      
    ?>
</body>
</html>
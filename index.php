<?php
    include "session.php";
    /*
    *isset($variable)
    *@param mixed $var - variable of string or int or bool
    *@param mixed ..$vars)
    *@return bool
    */
    if(isset($_SESSION['id'])){
        header("Location:http://localhost/dashboard.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        *{
            text-align:center;
            background-color:rgb(34,9,44);
        }
        .container{
            margin:0 auto;
            max-width:800px;
            max-height:auto;
            color:white;
        }
        fieldset{
            margin:20px;
            padding:2px;
            background-color: rgb(34,34,34);
        }
        legend{
            font-size:28px;
        }
        label{
            margin-top:10px;
            padding:2px;
            font-size:24px;
            background-color:rgb(34,34,34);
        }
        input{
            margin-top:10px;
            padding:5px;
            font-size:16px;
            background-color:azure;
        }
        span{
            background-color:rgb(34,34,34);
            font-size:18px;
        }
        #register{
            padding:5px;
            font-size:24px;
            background-color:teal;
            border-radius:5px;
        }
        a{
            font-size:28px;
            text-decoration:none;
            background-color:rgb(34,34,34);
            font-weight:bold;
            color:rgb(190, 49, 68)
        } 
        input :focus{
            background-color:white;
        }      
    </style>
    <script>       
        $(document).ready(function() {
            $("#username").on( "blur", function() {
                var usernamePattern = /^[a-zA-Z]+$/;
                var username = $('#username').val();
                if (username.match(usernamePattern) && (username.length >= 3 && username.length <= 8)){
                    $('#usernameValidation').text('validated').css('color','green');
                }
                else if(username.length < 3 || username.length > 8){   
                    $('#usernameValidation').text('Enter username with minimum length of 3 and maximum length of 8').css('color','red');
                }
                else if(!(username.match(usernamePattern))){                
                    $('#usernameValidation').text('Please enter letters only!').css('color','red');
                }
                else{

                    $('#usernameValidation').text('Please enter letters only!').css('color','red');
                }
            });
        }); 
        $(document).ready(function() {
            $('#emailAddress').on("blur",function(){                
                var emailAddress = $('#emailAddress').val();
                var emailAddressPattern =  /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(emailAddress.match(emailAddressPattern) && emailAddress.length != 0) {
                    $('#emailAddressValidation').text('validated').css('color','green');
                }
                else{               
                    $('#emailAddressValidation').text('Please enter valid email address').css('color','red');      
                }
            });
        });
        
        $(document).ready(function(){
            $("#password").on('blur',function(){
                var password = $('#password').val();                
                var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*_])(?=.{6,12}$)/;
                if(password.match(passwordPattern) && (password.length>=8)){               
                    $('#passwordValidation').text('validated').css('color','green'); 
                    
                }
                else{
                    $('#passwordValidation').text('Please enter valid password').css('color','red');
                }
            });
        });
        
         $(document).ready(function(){
             $('#repeatPassword').on('keyup',function(){
                 if($('#password').val() == $('#repeatPassword').val()){
                     $('#repeatPasswordHint').text('validated').css('color','green');
                 }
                else{
                    $('#repeatPasswordHint').text('Match the password typed above').css('color','red');
                   
                }
             });
         });
    </script>
</head>
<body>
    <div class="container" >
        <form method="POST" action="">
            <fieldset>
                <legend >Registration</legend>
                <label for="username">Username</label><br>
                <input type="text" id="username" name="username"><br><span id="usernameValidation"></span><br><br>
                <label for="emailAddress">Email Address</label><br>
                <input type="email" id="emailAddress" name="emailAddress" required><br><span id="emailAddressValidation"></span><br><br>
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" required><br><span id="passwordValidation"></span><br>
                <span>(password must contain lowercase,uppercase,number and special character)</span><br><br>
                <label for="repeatPassword">Repeat password</label><br>
                <input type="password" id="repeatPassword" name="repeatPassword" required><br>
                <span id="repeatPasswordHint"></span><br><br>
                <input type="submit" value="Register" id="register"><br><br>
                <label>Have an account?</label><a href="/login.php">Login</a>
            </fieldset>
        </form>
    </div>
    
    <?php    
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username=$_POST['username'];
        $emailAddress=$_POST['emailAddress'];
        $password=$_POST['password'];
        /*
        password_hash($password,$algo)
        *@param string $password  - contains number(s),upperCaseLetter(s),lowerCaseLetter(s) and specialCharacter(s)
        *@param string $algo - as PASSWORD_DEFAULT used
        *@param array $options
        *@return string; - as 60 characters
        */
        //$passwordEncrypted=password_hash($password, PASSWORD_DEFAULT);
        $passwordEncrypted=base64_encode($password);
                
        $servername = "localhost";
        $mysqlUsername = "example";
        $mysqlPassword = "";
        $database="UserDetails";

        $connection = mysqli_connect($servername, $mysqlUsername, $mysqlPassword,$database);

        if (!$connection) {
            echo '<span style="padding:5px;font-size: 20px;color:white;">'.die("Unable to load User Details - Connection failed: " . mysqli_connect_error())."<br>";
        }
        else {
            echo '<span style="padding:5px;font-size: 20px;color:white;">'."DB connected<br>".'</span>'; 
        }
        $sql="SELECT emailAddress FROM user";

        $user = mysqli_query($connection,$sql);
        $emailAddressExists=false;
        if(mysqli_num_rows($user) > 0){            
            while($row= mysqli_fetch_assoc($user)){
                if($row['emailAddress']==$emailAddress){
                    // echo $row['emailAddress'];
                    $emailAddressExists=true;
                    break;
                }
            }
        }else{
            $emailAddressExists=false;
        }
        
        if($emailAddressExists){           
            echo '<span style="padding:5px;font-size: 20px;color:white;">'."You are already registerd. Try to login<br>".'</span>';
        }
        else{
        //      using prepared statement
        //     if($connection) {
        //     $registerUser=$connection->prepare("INSERT INTO user (username,emailAddress,password) VALUES (?,?,?)");
        //     $registerUser->bind_param("sss",$username,$emailAddress,$passwordEncrypted);

        //     $username=$username;
        //     $emailAddress=$emailAddress;
        //     $passwordEncrypted=$passwordEncrypted;
        //     $registerUser->execute();

        //     using quotes 
            $username=filter_var($username, FILTER_SANITIZE_STRING); 
            $emailAddress=filter_var($emailAddress, FILTER_SANITIZE_EMAIL);
            //$password=filter_var($password)
            $registerUser="INSERT INTO user (username,emailAddress,password) VALUES ('$username','$emailAddress','$passwordEncrypted')";
          
            if(mysqli_query($connection,$registerUser)){
                echo '<span style="padding:5px;font-size: 20px;color:white;">'."You are registered Successfully.".'</span>';
            }
            else{
                    echo '<span style="padding:5px;font-size: 20px;color:white;">'."Error: " . $registerUser . "<br>" . mysqli_error($connection).'</span>'; 
                }// header("Location:http://localhost/login.php?Message=".urlencode("You are registered Successfully as First User."));
                return json_encode(['success'=>true,'message'=>'user created successfully']);  
            }
        mysqli_close($connection);
    }
    ?>
    <?php    
        // $Message = $_GET['Message'];
        // echo $Message; 
        error_log("debug.log");    
    ?>
</body>
</html>
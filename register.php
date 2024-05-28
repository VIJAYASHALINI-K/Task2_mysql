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
<?php 
    $usernameCheck="";$passwordCheck="";$repeatPasswordCheck="";$emailAddressCheck="";
    $inputUserNameValidated=0;$inputEmailAddressValidated=0;
    $inputPasswordValidated=0;$inputRepeatPasswordValidated=0;
    $username=$_POST['username'];
    $emailAddress=$_POST['emailAddress'];
    $password=$_POST['password'];
    $repeatPassword=$_POST['repeatPassword'];
    if (empty($username)) {
        $usernameCheck='*username is required';
    } 
    else {
        if (preg_match("/^[a-zA-Z]+$/",$username)&& (strlen($username)>=3 && strlen($username)<=8)){
            $usernameCheck="validated";
            $inputUserNameValidated=1;
        }
        
        else{
           $usernameCheck="*Only letters allowed";
        }
    }
    
    if (empty($emailAddress)) {
        $emailAddressCheck="*Email is required";
    } 
    else {
        // $emailAddress=test_input($emailAddress);
        if (preg_match("/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/",$emailAddress)) {
            $emailAddressCheck="validated";
            $inputEmailAddressValidated=1;
        }
        else{
            $emailAddressCheck="*Invalid email format";   
        }
    }
    
    if (empty($password)) {
       $passwordCheck="*Password is required";
    } 
    else {
        if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",$password) && strlen($password)>=8){
            $passwordCheck="validated";
            $inputPasswordValidated=1;
        } 
        else{  
            $passwordCheck="*Invalid password";
        }   
    }
    if (empty($repeatPassword)) {
        $repeatPasswordCheck="*Repeat password is required";
    } 
    else {
        if ($repeatPassword!=$password ){
            $repeatPasswordCheck="*Repeat password must match the password typed above";
            } 
        else if($repeatPassword==$password && $passwordCheck=="validated"){
            $repeatPasswordCheck="validated";
            $inputRepeatPasswordValidated=1;
        }
        else{
           $repeatPasswordCheck="*Invalid" ;       
        }   
    }            
   // }
    
    if($inputUserNameValidated && $inputEmailAddressValidated && $inputPasswordValidated && $inputRepeatPasswordValidated){
        /*
        password_hash($password,$algo)
        *@param string $password  - contains number(s),upperCaseLetter(s),lowerCaseLetter(s) and specialCharacter(s)
        *@param string $algo - as PASSWORD_DEFAULT used
        *@param array $options
        *@return string; - as 60 characters
        */
        $passwordEncrypted=base64_encode($password);
                
        $servername = "localhost";
        $mysqlUsername = "example";
        $mysqlPassword = "";
        $database="UserDetails";

        $connection = mysqli_connect($servername, $mysqlUsername, $mysqlPassword,$database);

        if (!$connection) {
            // echo '<span style="padding:5px;font-size: 20px;color:white;">'.die("Unable to load User Details - Connection failed: " . mysqli_connect_error())."<br>";
            die("Unable to load User Details - Connection failed: " . mysqli_connect_error());
        
        }
        else {
            // echo '<span style="padding:5px;font-size: 20px;color:white;">'."DB connected<br>".'</span>'; 
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
        }
        else{
            $emailAddressExists=false;
        }
        // echo $emailAddressExists;
        $successfullMessage="";
        if($emailAddressExists){                           
            $successfullMessage="You are already registerd. Try to login.";
            /*
            json_encode($value, $flag)
            *@param mixed $value
            *@param int $flags -- here JSON_FORCE_OBJECT used
            *@return string|false -returns json encoded string if fails return false
            */
            $registrationDetails=json_encode(array("data"=>array("usernameCheck"=>$usernameCheck,"emailAddressCheck"=>$emailAddressCheck,"passwordCheck"=>$passwordCheck,"repeatPasswordCheck"=>$repeatPasswordCheck,"successfullMessage"=>$successfullMessage)),JSON_FORCE_OBJECT);
            echo $registrationDetails;
            
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
            $registerUser="INSERT INTO user (username,emailAddress,password) VALUES ('$username','$emailAddress','$passwordEncrypted')";
        
            if(mysqli_query($connection,$registerUser)){
                $successfullMessage="You are registered Successfully.";
                $registrationDetails=json_encode(array("data"=>array("usernameCheck"=>$usernameCheck,"emailAddressCheck"=>$emailAddressCheck,"passwordCheck"=>$passwordCheck,"repeatPasswordCheck"=>$repeatPasswordCheck,"successfullMessage"=>$successfullMessage)),JSON_FORCE_OBJECT);
                echo $registrationDetails;
            }
            else{
                $successfullMessage="Error: " . $registerUser . "<br>" . mysqli_error($connection); 
                $registrationDetails=json_encode(array("data"=>array("usernameCheck"=>$usernameCheck,"emailAddressCheck"=>$emailAddressCheck,"passwordCheck"=>$passwordCheck,"repeatPasswordCheck"=>$repeatPasswordCheck,"successfullMessage"=>$successfullMessage)),JSON_FORCE_OBJECT);
                echo $registrationDetails;
            }
            return json_encode(['success'=>true,'message'=>'user created successfully']);  
        }
        
        
        mysqli_close($connection);
    } 
    else{
        
        $successfullMessage="Enter valid inputs";
        $registrationDetails=json_encode(array("data"=>array("usernameCheck"=>$usernameCheck,"emailAddressCheck"=>$emailAddressCheck,"passwordCheck"=>$passwordCheck,"repeatPasswordCheck"=>$repeatPasswordCheck,"successfullMessage"=>$successfullMessage)),JSON_FORCE_OBJECT);
        echo $registrationDetails; 

    }
     
        error_log("debug.log");   
?>

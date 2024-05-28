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
            background-color:rgb(208, 217, 210);
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
            background-color:rgb(34,34,34);
            color:black;
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
            font-size:16px;
        }
        h3{
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
        $(document).ready(function(){
            $("#register").click(function(){
                $.ajax({
                    url: "register.php",
                    type: "post",  
                    data: $("form").serialize(),
                    /*
                    *JSON.parse(string, function)
                    *@param string
                    *@return Object
                    */               
                    success: function (results) { 
                        result=JSON.parse(results);
                        if(result.data.usernameCheck=="validated"){
                            $("#usernameCheck").html("&check;"+result.data.usernameCheck).css("color","green"); 
                        }
                        else{
                            $("#usernameCheck").html(result.data.usernameCheck).css("color","red"); 
                        }
                        if(result.data.emailAddressCheck=="validated"){
                            $("#emailAddressCheck").html("&check;"+result.data.emailAddressCheck).css("color","green"); 
                        }
                        else{
                            $("#emailAddressCheck").html(result.data.emailAddressCheck).css("color","red");                            
                        }
                        if(result.data.passwordCheck=="validated"){
                            $("#passwordCheck").html("&check;"+result.data.passwordCheck).css("color","green"); 
                        }
                        else{
                            $("#passwordCheck").html(result.data.passwordCheck).css("color","red");                              
                        }
                        if(result.data.repeatPasswordCheck=="validated"){
                            $("#repeatPasswordCheck").html("&check;"+result.data.repeatPasswordCheck).css("color","green"); 
                        }
                        else{
                            $("#repeatPasswordCheck").html(result.data.repeatPasswordCheck).css("color","red");                           
                        } 
                        if(result.data.successfullMessage!="Enter valid inputs"){
                            $("#registrationResult").html(result.data.successfullMessage).css("color","green"); 
                        }
                        else{
                            $("#registrationResult").html(result.data.successfullMessage).css("color","red"); ; 
                        }
                    },
                    error: function (error){ 
                        console.log('error'+error); 
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container" >
        <form form="registrationDetails">
            <fieldset>
                <legend >Registration</legend>
                <label for="username">Username</label><br>
                <input type="text" id="username" name="username" ><br>  
                <h3 id="usernameCheck"></h3><br>
                <label for="emailAddress">Email Address</label><br>
                <input type="email" id="emailAddress" name="emailAddress" ><br>
                <h3 id="emailAddressCheck"></h3><br>                    
                <label for="password">Password</label><br>    
                <input type="password" id="password" name="password" ><br> 
                <h3 id="passwordCheck"></h3><br>               
                <span>(password must contain lowercase,uppercase,number and special character)</span><br><br>
                <label for="repeatPassword">Repeat password</label><br>
                <input type="password" id="repeatPassword" name="repeatPassword"><br>  
                <h3 id="repeatPasswordCheck"></h3><br>                     
                <input type="button" value="Register" id="register"><br><br>
                <label>Have an account?</label><a href="/login.php">Login</a><br><br>
            </fieldset>
        </form>
        <h2 id="registrationResult" style="font-size:20px;"></h2>
    </div>
</body>
</html>


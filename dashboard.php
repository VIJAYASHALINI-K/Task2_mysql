<?php
    include "session.php";
    /*
    *header($header)
    *@param string $header - url path to page
    *@return void //nothing will be returned
    */
    if(!isset($_SESSION['id'])){
        header("Location:http://localhost/login.php");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        *{
            background-color:rgb(208, 217, 210);
            text-align:center;
            margin:20 auto;
        }
        .container{
            margin:10px;
        }
        #logout{
            font-size:20px;
            background-color:azure;
            border-radius:5px;
        }
        table, th, td {
            margin-left: auto;
            margin-right: auto;
            border: 1px solid black;
            border-collapse: collapse;
        }
        td,th{
            width: 150px;
            height: 10px;
        }
        
    </style>
    <script>
        setTimeout(function() {
            $("h4").fadeOut();
        }, 3000);
    </script>
</head>

<body>    
    <?php
        $Message= $_GET['Message'];
        echo '<br>';
       /*
        set_time_limit($seconds)
        *@param int $seconds - only display for this particular seconds
        *@return bool
        */
        // set_time_limit(3);
        // ini_set('max_execution_time', 3);
           // error_log("debug.log");      
    ?>
    <h4><?php echo '<span style="padding:2px;font-size: 20px;">'.$Message.'</span>';?></h4>
    <div class="container">
        <h1>Welcome</h1>
        <a href="logout.php"> Log Out</a><br><br>
        
        <form>
            <input type="search" id="searchUser" name="searchUser"><br><br>
            <input type="button" id="searchUserSubmit" value="Search User" name="searchUserSubmit"><br><br>
        </form>
        <table>
            <tbody id="displaySearchResult"> 
            </tbody> 
        </table>
        <div id="displayUser"> 
            <?php displayAllUser(); ?>
        </div>
       
    </div>
    <?php
        function displayAllUser(){
            $servername = "localhost";
            $mysqlUsername = "example";
            $mysqlPassword = "";
            $database="UserDetails";
            
            $connection = mysqli_connect($servername, $mysqlUsername, $mysqlPassword,$database);
            if(!$connection){
                die("Unable to load User Details - Connection failed: " . mysqli_connect_error());
            } 
            $sql="SELECT product.user_id, product.id,user.username, user.emailAddress, user.password, product.id, product.product_name, product.product_description FROM user RIGHT JOIN product ON user.id = product.user_id ORDER BY product.user_id";
            $result = mysqli_query($connection,$sql);
            echo "<br><br>";
            if($result->num_rows > 0) {
                echo "<table><tr><th>"."User id"."</th><th>"."Product id"."</th><th>"."Username"."</th><th> "."Email Address"."</th><th>"."Password"."</th><th>"."Product name"."</th><th>"."Product description"."</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<table><tr><td>".$row["user_id"]."</td><td>".$row["id"]."</td><td>".$row["username"]. "</td><td>". $row["emailAddress"]. "</td><td>" . $row["password"]."</td><td>".$row["product_name"]."</td><td>".$row["product_description"]."</td></tr>";
                }
                echo "</table>";
            }
            else {
                echo "Table is empty" . mysqli_error($connection);
            }
        }
    ?>
</body>
<script>
        $(document).ready(function(){
            $("#searchUserSubmit").click(function(){
                user=$("#searchUser").val();
                console.log("hello"+user+"!");
                if( user !=""){
                    console.log("ajax call");
                    $.ajax({
                        url:  "models.php",
                        type: "post",  
                        data: $("form").serialize(),
                        /*
                        *JSON.parse(string, function)
                        *@param string
                        *@return Object
                        */               
                        success: function (data) { 
                            result=JSON.parse(data);
                            // $("h3").text("user");
                            if(result!="User Not Found"){
                                $("#displayUser").empty();
                                $("#displaySearchResult").empty();
                                let userData = "";
                                userData += "<tr>";
                                userData += "<th >" + "User id" + "</th>";
                                userData += "<th>" + "Product id" + "</th>";
                                userData += "<th>" + "Username" + "</th>";
                                userData += "<th>" + "Email Address" + "</th>";
                                userData += "<th>" + "Password" + "</th>";
                                userData += "<th>" + "Product Name" + "</th>";
                                userData += "<th>" + "Product Description" + "</th>";
                                userData += "</tr> ";
                                for(let key in result) {
                                    userData += "<tr>";
                                    userData += "<td>" + result[ key ].user_id + "</td>";
                                    userData += "<td>" + result[ key ].id + "</td>";
                                    userData += "<td>" + result[ key ].username + "</td>";
                                    userData += "<td>" + result[ key ].emailAddress + "</td>";
                                    userData += "<td>" + result[ key ].password + "</td>";
                                    userData += "<td>" + result[ key ].product_name+ "</td>";
                                    userData += "<td>" + result[ key ].product_description+ "</td>";
                                    userData += "</tr> ";
                                }
                                $("#displaySearchResult").append(userData);
                            }
                            else{
                                $("#displayUser").empty();
                                $("#displaySearchResult").empty();
                                $("#displayUser").prepend(result);
                                $("#displayUser").append("<?php  displayAllUser(); ?>");
                            }
                        },
                        error: function (error){ 
                            console.log('error'+error); 
                        }
                    });
                }
                else{
                    $("#displayUser").empty();
                    $("#displaySearchResult").empty();
                    $("#displayUser").append("You didn't select any user");                    
                    $("#displayUser").append("<?php  displayAllUser(); ?>");
                }
            });
        });
    </script>
</html>
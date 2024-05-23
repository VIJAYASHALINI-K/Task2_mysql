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
    <style>
        *{
            background-color:lightsteelblue;
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
</head>

<body>    
    <?php
        $Message= $_GET['Message'];
        echo '<br>';
        echo '<span style="padding:2px;font-size: 20px;">'.$Message.'</span>';
        error_log("debug.log");      
    ?>
    <div class="container">
        <h1>Welcome</h1>
        <a href="logout.php"> Log Out</a>
    </div>
    <?php
        $servername = "localhost";
        $mysqlUsername = "example";
        $mysqlPassword = "";
        $database="UserDetails";
        
        $connection = mysqli_connect($servername, $mysqlUsername, $mysqlPassword,$database);
        
        if (!$connection) {
            die("Unable to load User Details - Connection failed: " . mysqli_connect_error());
        }
        
        // $sql="SELECT user.id, user.username, user.emailAddress, user.password, product.id, product.product_name, product.product_description FROM user RIGHT JOIN product ON user.id = product.user_id";
        $sql="SELECT product.id, product.user_id, user.username, user.emailAddress, user.password, product.product_name, product.product_description  FROM user RIGHT JOIN product ON user.id = product.user_id ORDER BY product.user_id";
    
        $result = mysqli_query($connection,$sql);
        if ($result->num_rows > 0) {
            echo "<table><tr><th>"."user id"."</th><th>"."Product id"."</th><th>"."Username"."</th><th> "."email Address"."</th><th>"."Password"."</th><th>"."Product name"."</th><th>"."Product description"."</th></tr>";

            while($row = $result->fetch_assoc()) {
                echo "<table><tr><td>".$row["user_id"]."</td><td>".$row['id']."</td><td>".$row["username"]. "</td><td>". $row["emailAddress"]. "</td><td>" . $row["password"]."</td><td>".$row["product_name"]."</td><td>".$row["product_description"]."</td></tr>";
            }

            echo "</table>";
        } 
      
       // echo "<table><tr><th>"."id"."</th><th>"."username"."</th><th> "."emailAddress"."</th><th>"."password"."</th><th>"."product_id"."</th><th>"."product_name"."</th><th>"."product_description"."</th></tr><br>";

        // if ($result->num_rows > 0) {
        //    // output data of each row
        //    while($row = $result->fetch_assoc()) {
        //      echo $row['id']." ".$row["username"]. " ". $row["emailAddress"]. " " . $row["password"]." ".$row["id"]." ".$row["product_name"]." ".$row["product_description"]."<br>";
        //    }
        //    //echo "values printed successfully";
        // } 
        
        // if($connection){
        // while($user_details= mysqli_fetch_array($result)){
        //     $user_purchased[]=$user_details;
        // }

        // $html = "<table><tr><th>".implode('</th><th>',array_keys($user_purchased[0])).'</th></tr>';
        // foreach($user_purchased as $details){
        //     $html .= "<tr><td>".implode('</td><td>',$details).'</td></tr>';
        // }
        // print $html.'</table>';
        // }
        else {
           echo "Error " . mysqli_error($connection);
        }
        mysqli_close($connection);

    ?>
     
</body>
</html>
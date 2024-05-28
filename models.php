<?php
    $servername = "localhost";
    $mysqlUsername = "example";
    $mysqlPassword = "";
    $database="UserDetails";
    
    $connection = mysqli_connect($servername, $mysqlUsername, $mysqlPassword,$database);
    if (!$connection) {
        die("Unable to load User Details - Connection failed: " . mysqli_connect_error());
    } 
    $showUser=$_POST['searchUser'];
    // if($showUser){
        // echo "User : $showUser<br><br>";
    $sql="SELECT id FROM user where username LIKE '$showUser%' AND id IN (SELECT user_id FROM product)";
    $result = mysqli_query($connection,$sql);
    // print_r( $result);
    if($result->num_rows > 0) {
        $sql1="SELECT product.user_id, product.id, user.username, user.emailAddress, user.password, product.product_name, product.product_description  FROM user RIGHT JOIN product ON user.id = product.user_id WHERE  user.username LIKE '$showUser%'";//ORDER BY product.user_id";
    }
    else{
        $sql1="SELECT id,username,emailAddress,password FROM user WHERE username LIKE '$showUser%'";
    }
    $result1 = mysqli_query($connection,$sql1);
    // print_r( $result1);
    $data = array();
    if($result1->num_rows > 0) {
        while($row = $result1->fetch_assoc()) {
            // print_r("hello");
            $temp = array();
            $temp['username'] = $row['username'];
            $temp['emailAddress'] = $row['emailAddress'];
            $temp['password'] = $row['password'];
            if($result->num_rows > 0) {
                $temp['user_id'] = $row['user_id'];
                $temp['id'] = $row['id'];
                $temp['product_name'] = $row['product_name'];
                $temp['product_description'] = $row['product_description'];
            }
            else{
                $temp['user_id'] = $row['id'];
                $temp['id'] = "-";                
                $temp['product_name'] = "-";
                $temp['product_description'] = "-";
            }               
            $data[] = $temp; 
            }
        echo json_encode($data);
        // echo "</table>";
    }
    else {
        echo json_encode("User Not Found");
    }

    // }
    // else{     
    // }
    mysqli_close($connection);  

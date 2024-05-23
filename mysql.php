<?php
$servername = "localhost";
$username = "example";
$password = "";
$database="user2";


// $conn = mysqli_connect($servername, $username, $password);
$conn = mysqli_connect($servername, $username, $password,$database);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully<br>";
// $sql="create database user2";
// $sql="create table user2(username varchar(15) not null,emailAddress varchar(20) primary key not null,password varchar(15) not null)";



// Create connection
// $conn = new mysqli($servername, $username, $password,$database);

// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }
//echo "Connected successfully";
// $sql =  "INSERT INTO user2 (username,emailAddress,password) VALUES('ABC','abc@example.com','abc111!A');"; 
// $sql =  "INSERT INTO user2 (username,emailAddress,password) VALUES('DEF','def@example.com','def111!D');"; 
// $sql .= "INSERT INTO user2 (username,emailAddress,password) VALUES('KLM','klm@example.com','klm111!K');"; 
// $sql .=  "INSERT INTO user2 (username,emailAddress,password) VALUES('XYZ','xyz@example.com','xyz111!X')"; 
 $sql = "SELECT username,emailAddress,password FROM user2";
// $sql = "SELECT username,emailAddress,password FROM User LIMIT 2";
// $sql = "SELECT username,emailAddress,password FROM User LIMIT 2 OFFSET 2";
// $sql = "SELECT username,emailAddress,password FROM User LIMIT 2,2'";

//$sql = "SELECT username,emailAddress,password FROM User ORDER BY username";
//$sql="Update  User set password='rqp111!R' where username='PQR'";
// $sql="Delete from User where username='KLM'";
// $stmt = $conn->prepare("INSERT INTO User (username,emailAddress, password) VALUES (?, ?, ?)");
// $stmt->bind_param("sss", $username,$emailAddress,$password);

// // set parameters and execute
// $username = "GHI";
// $emailAddress= "ghi@example.com";
// $password="ghi111!G";
// $stmt->execute();

// $username = "KLM";
// $emailAddress= "klm@example.com";
// $password="klm111!K";
// $stmt->execute();

// $username = "UVW";
// $emailAddress= "uvw@example.com";
// $password="uvw111!U";
// $stmt->execute();

// if($conn->query($sql)){
//   $last_id = $conn->insert_id;
//   echo "New record created successfully. Last inserted ID is: " . $last_id;
//     echo "<br>success";
// }
// else {
//     echo "Error " . mysqli_error($conn);
//  }
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//   // output data of each row
//   while($row = $result->fetch_assoc()) {
//     echo "username: " . $row["username"]. " - emailAddress: " . $row["emailAddress"]. " - password: " . $row["password"]. "<br>";
//   }
//   echo "values printed successfully";
// } else {
//   echo "Error " . mysqli_error($conn);
// }
$result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    echo "username: " . $row["username"]. " - emailAddress: " . $row["emailAddress"]. " - password: " . $row["password"]. "<br>";
  }
} else {
  echo "0 results";
}
// $conn->close();
if(mysqli_multi_query($conn,$sql)){
  echo "Database created successfully";
} else {
  echo "Error creating database: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
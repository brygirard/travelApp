<?php
 
 $myUser = $_POST['user'];
 $myPass = $_POST['pass'];
 
 
     
 //step1 - get database
 $servername = "127.0.0.1";
 $username = "root";
 $password = "";
 $database = "test";
 //Create Connection
 $conn = new mysqli($servername,$username,$password,$database);

 //Check Connection
 if ($conn->connect_error){
	die("Connection failed: ".$conn->connect_error);
 }

//Retrieve Records into database

$sql = "SELECT * 
	FROM `User`
  WHERE emailAddress = '$myUser' and passWord = '$myPass'
  ";

$result = $conn->query($sql);

while($row = mysqli_fetch_assoc($result))
    $return[] = $row; 
    
    
echo json_encode($return);

//close connection
$conn->close();
 
?>
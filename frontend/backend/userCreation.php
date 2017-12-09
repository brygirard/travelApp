<?php
//step1
require_once('database.php');
//declare vars and assign default values as blank
$ip_address = $firstname = $lastname = $emailaddress = $pwd = $origin_airport_id = $city = $country = $countryadmindistrict = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$ip_address =$_POST["IP_Address"];
	$firstname = clean_input($_POST["firstName"]); 
	$lastname = clean_input($_POST["lastName"]);
	$emailaddress = clean_input($_POST["emailAddress"]);
 	$pwd = clean_input($_POST["passWord"]);
 	$origin_airport_id = clean_input($_POST["origin_Airport_ID"]);
 	$city = clean_input($_POST["City"]);
 	$country = $_POST['Country'];
#	$countryadmindistrict = $_POST['CountryAdminDistrict']
	#echo "SUBMITTED INFORMATION:";
	#echo "<br>IP_Address: " .$_POST["IP_Address"];
	#echo "<br>First Name: " .$_POST["firstName"];
	#echo "<br>Last Name: " .$_POST["lastName"];
	#echo "<br>Email Address: " .$_POST["emailAddress"];
	#echo "<br>Password: " .$_POST["passWord"];
	#echo "<br>Origin Airport ID: " .$_POST["origin_Airport_ID"];
	#echo "<br>City: " .$_POST["City"];
	#echo "<br>Country: " .$_POST["Country"];
}
//clean sent data
function clean_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

//Insert Records into database
$sql = "INSERT INTO User (IP_Address, firstName, lastName, emailAddress,passWord,origin_Airport_ID, City,Country,CountryAdminDistrict)
VALUES ('$ip_address', '$firstname', '$lastname', '$emailaddress', '$pwd', '$origin_airport_id','$city','$country','$countryadmindistrict')";

//Check error state of insertion method
if($conn->query($sql) === TRUE){
	$result = "New user added!";
	echo json_encode($result);
}else{
	$result = "Error occurred while creation new user " . $conn->error; 
	echo json_encode($result);
	#echo "Error" .$sql . "<br>" . $conn->error;
}
//close connection
$conn->close();
?>


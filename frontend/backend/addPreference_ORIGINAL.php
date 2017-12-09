<?php
//step1
require_once('database.php');

//declare vars and assign default values as blank
$UserID = $Avg_Temp = $Avg_Rainfall = $Avg_Snowfall = $Lodging_Cost = $Meal_Cost = $Travel_Advisories = $Distance_To_Ocean = $Distance_To_Lake = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$UserID =clean_input($_POST["UserID"]);
	$Avg_Temp = clean_input($_POST["Avg_Temp"]);
	$Avg_Rainfall = clean_input($_POST["Avg_Rainfall"]); 
	$Avg_Snowfall = clean_input($_POST["Avg_Snowfall"]);
	$Lodging_Cost = clean_input($_POST["Lodging_Cost"]);
 	$Meal_Cost = clean_input($_POST["Meal_Cost"]);
 	$Travel_Advisories = clean_input($_POST["Travel_Advisories"]);
 	$Distance_To_Ocean = clean_input($_POST["Distance_To_Ocean"]);
 	$Distance_To_Lake = $_POST['Distance_To_Lake'];
	#echo "SUBMITTED INFORMATION:";
	#echo "<br>UserID: " .$_POST["UserID"];
        #echo "<br>Average Temp: " .$_POST["Avg_Temp"];
	#echo "<br>Average Rainfall: " .$_POST["Avg_Rainfall"];
	#echo "<br>Average Snowfall: " .$_POST["Avg_Snowfall"];
	#echo "<br>Lodging Cost: " .$_POST["Lodging_Cost"];
	#echo "<br>Meal Cost: " .$_POST["Meal_Cost"];
	#echo "<br>Travel Advisories: " .$_POST["Travel_Advisories"];
	#echo "<br>Distance To Ocean: " .$_POST["Distance_To_Ocean"];
	#echo "<br>Distance To Lake: " .$_POST["Distance_To_Lake"];
}
//clean sent data
function clean_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$query = "SELECT * FROM Preferences WHERE `UserID` = '".$UserID."' AND `Avg_Temp` = '".$Avg_Temp."' AND `Avg_Rainfall` = '".$Avg_Rainfall."' AND `Avg_Snowfall` = '".$Avg_Snowfall."' AND `Lodging_Cost` = '".$Lodging_Cost."' AND `Meal_Cost` = '".$Meal_Cost."' AND `Travel_Advisories` = '".$Travel_Advisories."' AND `Distance_To_Ocean` = '".$Distance_To_Ocean."' AND `Distance_To_Lake` = '".$Distance_To_Lake."'";

mysqli_query($conn,$query) or die('Error querying database.');
$q_result = mysqli_query($conn,$query);

#lif the preference has not been added,
if ($q_result->num_rows===0){
#if ($q_result==0){
        #advanced technique: prepared statement
if (!$stmt = $conn->prepare("INSERT INTO Preferences (UserID, Avg_Temp, Avg_Rainfall, Avg_Snowfall, Lodging_Cost, Meal_Cost, Travel_Advisories, Distance_To_Ocean, Distance_To_Lake) values (?,?,?,?,?,?,?,?,?)")){
	$result = "Prepare filed: (". $stmt->errno . ") " . $stmt->error; 
	echo json_encode($result);
}

if(!$stmt->bind_param("iiddiiidd",$UserID, $Avg_Temp,$Avg_Rainfall, $Avg_Snowfall, $Lodging_Cost,$Meal_Cost,$Travel_Advisories,$Distance_To_Ocean,$Distance_To_Lake)){
	$result = "Binding parameters failed: (" .$stmt->errno . ") " .$stmt->error;
	echo json_encode($result);
}

if(!$stmt->execute()){
	$result = "Execute failed: (" .$stmt->errno. ") " .$stmt->error;
}else{
	$result = "New preference added";
}
        //close connection
        $stmt->close();
}
else{
        $result = "A similar preference already exists";
}
echo json_encode($result);
//close connection
$conn->close();
?>

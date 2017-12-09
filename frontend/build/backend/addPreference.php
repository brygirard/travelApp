<?php
//step1
require_once('database.php');

//declare vars and assign default values as blank
$UserID = $Travel_Month = $MIN_Temp = $MAX_Temp = $MIN_Precipiation =$MAX_Precipitation = $MIN_Lodging_Cost = $MAX_Lodging_Cost = $MIN_Meal_Cost = $MAX_Meal_Cost = $Travel_Advisories = $MIN_Distance_To_Ocean = $MAX_Distance_To_Ocean = $MIN_Distance_To_Lake = $MAX_Distance_To_Lake = $Country = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$UserID =clean_input($_POST["UserID"]);
        $Travel_Month =clean_input($_POST["Travel_Month"]);
	$MIN_Temp = clean_input($_POST["MIN_Temp"]);
        $MAX_Temp = clean_input($_POST["MAX_Temp"]);
        $MIN_Precipiation = clean_input($_POST["MIN_Precipitation"]);
	$MAX_Precipiation = clean_input($_POST["MAX_Precipitation"]); 
	$MIN_Lodging_Cost = clean_input($_POST["MIN_Lodging_Cost"]);        
	$MAX_Lodging_Cost = clean_input($_POST["MAX_Lodging_Cost"]);
 	$MIN_Meal_Cost = clean_input($_POST["MIN_Meal_Cost"]);
        $MAX_Meal_Cost = clean_input($_POST["MAX_Meal_Cost"]);
 	$Travel_Advisories = clean_input($_POST["Travel_Advisories"]);
 	$MIN_Distance_To_Ocean = clean_input($_POST["MIN_Distance_To_Ocean"]);
        $MAX_Distance_To_Ocean = clean_input($_POST["MAX_Distance_To_Ocean"]);
        $MIN_Distance_To_Lake = $_POST['MIN_Distance_To_Lake'];
 	$MAX_Distance_To_Lake = $_POST['MAX_Distance_To_Lake'];
        $Country = $_POST['Country'];


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

$query = "SELECT * FROM Preferences WHERE `UserID` = '".$UserID. 
        "' AND `Travel_Month` = '".$Travel_Month.
	"' AND `MAX_Temp` = '".$MAX_Temp.
        "' AND `MIN_Temp` = '".$MIN_Temp.
	"' AND `MAX_Precipitation` = '".$MAX_Precipitation.
        "' AND `MIN_Precipitation` = '".$MIN_Precipitation.
        "' AND `MAX_Lodging_Cost` = '".$MAX_Lodging_Cost.
	"' AND `MIN_Lodging_Cost` = '".$MIN_Lodging_Cost.
        "' AND `MAX_Meal_Cost` = '".$MAX_Meal_Cost.
	"' AND `MIN_Meal_Cost` = '".$MIN_Meal_Cost.
	"' AND `Travel_Advisories` = '".$Travel_Advisories.
	"' AND `MAX_Distance_To_Ocean` = '".$MAX_Distance_To_Ocean.
        "' AND `MIN_Distance_To_Ocean` = '".$MIN_Distance_To_Ocean.
	"' AND `MAX_Distance_To_Lake` = '".$MAX_Distance_To_Lake.
        "' AND `MIN_Distance_To_Lake` = '".$MIN_Distance_To_Lake.
	"' AND `Country` = '".$Country."'";


mysqli_query($conn,$query) or die('Error querying database.');
$q_result = mysqli_query($conn,$query);

#lif the preference has not been added,
if ($q_result->num_rows===0){
#if ($q_result==0){
        #advanced technique: prepared statement
if (!$stmt = $conn->prepare("INSERT INTO Preferences (
	UserID, 
	Travel_Month, 
	MAX_Temp,
        MIN_Temp, 
	MAX_Precipitation, 
        MIN_Precipitation,
	MAX_Lodging_Cost,
        MIN_Lodging_Cost, 
	MAX_Meal_Cost, 
        MIN_Meal_Cost,
	Travel_Advisories, 
	MAX_Distance_To_Ocean,
        MIN_Distance_To_Ocean,
        MAX_Distance_To_Lake,
	MIN_Distance_To_Lake,
	Country) 
	values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")){
	$result = "Prepare filed: (". $stmt->errno . ") " . $stmt->error; 
	echo json_encode($result);
}

if(!$stmt->bind_param("isiiddiiiiidddds", 
			$UserID, 
			$Travel_Month
			$MAX_Temp,
			$MIN_Temp,
			$MAX_Precipitation, 
			$MIN_Precipitation, 
			$MAX_Lodging_Cost,
			$MIN_Lodging_Cost
			$MAX_Meal_Cost,
			$MIN_Meal_Cost,
			$Travel_Advisories,
			$MAX_Distance_To_Ocean,
                        $MIN_Distance_To_Ocean,
                        $MAX_Distance_To_Lake,
			$MIN_Distance_To_Lake,
			$Country)){
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

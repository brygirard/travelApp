<?php
	echo "test";
	return;
?>
<?php
//step1
require_once('database.php');
echo "test";
return;
//declare vars and assign default values as blank
$UserID = 
$orgAirport = 
$desAirport = 
$lodgeCostEstimate = 
$foodCostEstimate = 
$travelCostEstimate = 
$miscCostEstimate = 
$userLinks = 
$userScenarioRating = 
$UserDateStart = 
$UserDateEnd = "";
echo "test";
return;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	#$UserID =clean_input($_POST["UserID"]);
        #$orgAirport =clean_input($_POST["orgAirport"]);
	#$desAirport = clean_input($_POST["desAirport"]);
        #$lodgeCostEstimate = clean_input($_POST["lodgeCostEstimate"]);
        #$foodCostEstimate = clean_input($_POST["foodCostEstimate"]);
	#$travelCostEstimate = clean_input($_POST["travelCostEstimate"]); 
	#$miscCostEstimate = clean_input($_POST["miscCostEstimate"]);        
	#$userLinks = clean_input($_POST["userLinks"]);
 	#$userScenarioRating = clean_input($_POST["userScenarioRating"]);
        #$UserDateStart = clean_input($_POST["UserDateStart"]);
 	#$UserDateEnd = clean_input($_POST["UserDateEnd"]);


	echo "SUBMITTED INFORMATION:";
	#echo "<br>UserID: " .$_POST["UserID"];
        #echo "<br>Origination Aiport: " .$_POST["orgAirport"];
	#echo "<br>Destination Airport: " .$_POST["desAirport"];
	#echo "<br>Lodging Cost Estimate: " .$_POST["lodgeCostEstimate"];
	#echo "<br>Meal Cost Estimate: " .$_POST["foodCostEstimate"];
	#echo "<br>Travel Cost Estimate: " .$_POST["travelCostEstimate"];
	#echo "<br>Miscellaneous Cost Estimate: " .$_POST["miscCostEstimate"];
	#echo "<br>Notes and Links: " .$_POST["userLinks"];
	#echo "<br>User Scenario Rating: " .$_POST["userScenarioRating"];
        #echo "<br>Travel Start Date: " .$_POST["UserDateStart"];
        #echo "<br>Travel End Date: " .$_POST["userDateEnd"];


}
return; 
//clean sent data
function clean_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

#$query = "SELECT * FROM Preferences WHERE `UserID` = '".$UserID. 
#        "' AND `Travel_Month` = '".$Travel_Month.
#	"' AND `MAX_Temp` = '".$MAX_Temp.
 #       "' AND `MIN_Temp` = '".$MIN_Temp.
#	"' AND `MAX_Precipitation` = '".$MAX_Precipitation.
 #       "' AND `MIN_Precipitation` = '".$MIN_Precipitation.
  #      "' AND `MAX_Lodging_Cost` = '".$MAX_Lodging_Cost.
#	"' AND `MIN_Lodging_Cost` = '".$MIN_Lodging_Cost.
 #       "' AND `MAX_Meal_Cost` = '".$MAX_Meal_Cost.
#	"' AND `MIN_Meal_Cost` = '".$MIN_Meal_Cost.
#	"' AND `Travel_Advisories` = '".$Travel_Advisories.
#	"' AND `MAX_Distance_To_Ocean` = '".$MAX_Distance_To_Ocean.
 #       "' AND `MIN_Distance_To_Ocean` = '".$MIN_Distance_To_Ocean.
#	"' AND `MAX_Distance_To_Lake` = '".$MAX_Distance_To_Lake.
 #       "' AND `MIN_Distance_To_Lake` = '".$MIN_Distance_To_Lake.
#	"' AND `Country` = '".$Country."'";


#mysqli_query($conn,$query) or die('Error querying database.');
#$q_result = mysqli_query($conn,$query);

#lif the preference has not been added,
if ($q_result->num_rows===0){
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
}else{
        $result = "A similar preference already exists";
}
echo json_encode($result);
//close connection
$conn->close();
?>

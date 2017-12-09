<?php
//step1
require_once('database.php');

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

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $UserID =clean_input($_POST["UserID"]);
        $orgAirport =clean_input(substr($_POST["orgAirport"],0,3));
        $desAirport = clean_input(substr($_POST["desAirport"],0,3));
        $lodgeCostEstimate = clean_input($_POST["lodgeCostEstimate"]);
        $foodCostEstimate = clean_input($_POST["foodCostEstimate"]);
        $travelCostEstimate = clean_input($_POST["travelCostEstimate"]);
        $miscCostEstimate = clean_input($_POST["miscCostEstimate"]);
        $userLinks = clean_input($_POST["userLinks"]);
        $userScenarioRating = clean_input($_POST["userScenarioRating"]);
        $UserDateStart = clean_input($_POST["UserDateStart"]);
        $UserDateEnd = clean_input($_POST["UserDateEnd"]);

        #echo "SUBMITTED INFORMATION:";
       	#echo "<br>UserID: " .$UserID;
        #echo "<br>Origination Aiport: " .$orgAirport;
        #echo "<br>Destination Airport: " .$desAirport;
        #echo "<br>Lodging Cost Estimate: " .$lodgeCostEstimate;
        #echo "<br>Meal Cost Estimate: " .$foodCostEstimate;
        #echo "<br>Travel Cost Estimate: " .$travelCostEstimate;
        #echo "<br>Miscellaneous Cost Estimate: " .$miscCostEstimate;
        #echo "<br>Notes_and_ Links: " .$userLink;
        #echo "<br>User Scenario Rating: " .$userScenarioRating;
        #echo "<br>Travel Start Date: " .$UserDateStart;
        #echo "<br>Travel End Date: " .$UserDateEnd;
}

function clean_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
}
$query ="SELECT * FROM UserScenario WHERE `UserID` = '".$UserID.
        "' AND `orgAirport` = '".$orgAirport.
       	"' AND `desAirport` = '".$desAirport.
       	"' AND `lodgeCostEstimate` = '".$lodgeCostEstimate.
       	"' AND `foodCostEstimate` = '".$foodCostEstimate.
       	"' AND `travelCostEstimate` = '".$travelCostEstimate.
       	"' AND `userScenarioRating` = '".$userScenarioRating.
      	"' AND `UserDateStart` = '".$UserDateStart.
        "' AND `UserDateEnd` = '".$UserDateEnd."'";


mysqli_query($conn,$query) or die('Error querying database.');
$q_result = mysqli_query($conn,$query);
#echo "<br><br>".mysqli_num_rows($q_result) . " TEST";

#lif the preference has not been added,
if ($q_result->num_rows===0){
#if ($q_result==0){
        #advanced technique: prepared statement
if (!$stmt = $conn->prepare("INSERT INTO UserScenario (
        UserID,
        orgAirport,
        desAirport,
        lodgeCostEstimate,
        foodCostEstimate,
        travelCostEstimate,
        miscCostEstimate,
        userLinks,
        userScenarioRating,
        UserDateStart,
        UserDateEnd)
        values (?,?,?,?,?,?,?,?,?,?,?)")){
        $result = "Prepare filed: (". $stmt->errno . ") " . $stmt->error;
        echo json_encode($result);
}

if(!$stmt->bind_param("issddddsiss",$UserID, $orgAirport, $desAirport, $lodgeCostEstimate, $foodCostEstimate, $travelCostEstimate, $miscCostEstimate, $userLinks, $userScenarioRating, $UserDateStart, $UserDateEnd)){
        $result = "Binding parameters failed: (" .$stmt->errno . ") " .$stmt->error;
        echo json_encode($result);
}

if(!$stmt->execute()){
        $result = "Execute failed: (" .$stmt->errno. ") " .$stmt->error;
}else{
        $result = "New scenario added";
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
                   

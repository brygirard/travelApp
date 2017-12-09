<?php
//step1
require_once('database.php');

//declare vars and assign default values as blank
$UserID = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$UserID =clean_input($_POST["UserID"]);

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

$query = "SELECT * FROM Preferences WHERE `UserID` = '".$UserID."'";

mysqli_query($conn,$query) or die('Error querying database.');
$q_result = mysqli_query($conn,$query);

#lif the preference has not been added,
if ($q_result->num_rows===0){
	$result = "You have not created any preferences";
}else{
	displayResult($q_result);
	#$result = "New preference added";
}
   
#echo json_encode($result);
//close connection
$conn->close();
?>
<?php
function displayResult($result){
        echo "<br><br>";
        //check error state of query
        echo "<table border='1'>
		<tr><td>Travel_Month
                </td><td>MIN_Temp
                </td><td>MAX_Temp
                </td><td>MIN_Precipitation
                </td><td>MAX_Precipitation
                </td><td>MIN_Lodging_Cost
                </td><td>MAX_Lodging_Cost
                </td><td>MIN_Meal_Cost
                </td><td>MAX_Meal_Cost
                </td><td>Travel_Advisories
                </td><td>MIN_Distance_To_Ocean
                </td><td>MAX_Distance_To_Ocean
                </td><td>MIN_Distance_To_Lake
                </td><td>MAX_Distance_To_Lake";
        if($result->num_rows>0){
                while($row = mysqli_fetch_assoc($result)) {
                        $country = $row["official_name_en"];
                        $state = $row["Admin1_nameascii"];
                        $warning = $row["description4"];
                        $city = $row["asciiname"];

                        echo    "<tr><td>" . $row["Travel_Month"].
                                "</td><td>" .$row["MIN_Temp"].
                                "</td><td>" .$row["MAX_Temp"].
                                "</td><td>" .$row["MAX_Temp"].
                                "</td><td>" . $row["MIN_Precipitation"].
                                "</td><td>" . $row["MAX_Precipitation"].
                                "</td><td>" . $row["MIN_Lodging_Cost"].
                                "</td><td>" .$row["MAX_Lodging_Cost"].
                                "</td><td>" .$row["MIN_Meal_Cost"].
                              	"</td><td>" .$row["MAX_Meal_Cost"].
                              	"</td><td>" .$row["Travel_Advisories"].
                              	"</td><td>" .$row["MIN_Distance_To_Ocean"].
                              	"</td><td>" .$row["MAX_Distance_To_Ocean"].
                              	"</td><td>" .$row["MIN_Distance_To_Lake"].
                              	"</td><td>" .$row["MAX_Distance_To_Lake"].
				"<br>";
                }
        }else{
                echo "0 results";
                # echo "Error" .$sql . "<br>" . $conn->error;
        }
        echo "</table>";
}
?>

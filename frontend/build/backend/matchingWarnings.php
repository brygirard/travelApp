<?php
require_once('database.php');
//declare vars and assign default values as blank

$UserID = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $term =clean_input($_POST["Search_Term"]);
}

//clean sent data
function clean_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
}
echo "You searched for the following term: '".$term."'<br><br>";
$sql = "CALL search_travel_warnings2('".$term."')";
$result = mysqli_query($conn,$sql) or die('Error querying database.');
displayResult($result);

function displayResult($result){
        echo "<br><br>";
        //check error state of query
        echo "<table border='1'>
                <tr><td>Country
                </td><td>Warning Description
                </td></tr>";

        if($result->num_rows>0){
                while($row = mysqli_fetch_assoc($result)) {
                        $country = $row["title2"];
                        $description = $row["description4"];
                        echo    "<tr><td>" . $country.
                                "</td><td>" .$description.
                                 "<br>";
                }
        }else{
                echo "0 results";
                # echo "Error" .$sql . "<br>" . $conn->error;
        }
        echo "</table>";
}


?>

<?php


require_once('database.php');


$sql = "SELECT * FROM UserScenario
         WHERE UserId = 1;"


$result = mysqli_query($conn, $sql);

$ret = [];
while($row = mysqli_fetch_array($result)){

	$ret[] = $row;
}


echo json_encode($obj);








?>

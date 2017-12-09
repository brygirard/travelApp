<?php


 $term = $_POST['searchTerm'];
// $term = "Denver";
 $tol = 1;
$done = false;
$myCity = '';

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
 

 

function findMatch($term, $currNodeId, $tol, $wordList, $conn){
     //echo "At id $currNodeId<br/>";

     global $done;
     if($done){
	return;
     } 
     $ret = array();
     $sql = "SELECT * 
       FROM `searchTree`
       WHERE idSearchTree = $currNodeId;
     ";
     
     $result = mysqli_query($conn, $sql, MYSQLI_USE_RESULT);  //get the value of the current node
     if(!$result){
       die(mysqli_error($conn));
     }
     $row = mysqli_fetch_array($result);
     $value = $row['value'];
     mysqli_free_result($result); 
     
     
     $dist = levenshtein(strtolower($value), strtolower($term));
     //echo "At value $value<br/>";
     //echo "Distance is $dist<br/>";
     if($dist <=  $tol && !$done){ //if the distance is within tolerace, add it to the list
        //echo "Sending $value because distance was $dist<br/>";
	$done = true;
	global $myCity;
        $myCity  = $value;
     }
     $min = $dist - $tol; //iterate over children with dist b/w min and max
     $max = $dist + $tol;
     //echo "$min and $max <br/>";



	$sql = "SELECT * from searchTree
	WHERE distance >= $min and distance <= $max and idSearchTree IN(
	SELECT childID
	FROM searchTreeRelation
	WHERE parentID = $currNodeId
	)";

   
    $result = mysqli_query($conn, $sql, MYSQLI_USE_RESULT); //gets the children of the current node
     if(!$result){
       die(mysqli_error($conn));
     }


    $resultArray = array();
    while($row = mysqli_fetch_array($result)){
         $resultArray[] = $row;
    };
    mysqli_free_result($result); //done with that result, move on
    
    
    
    foreach($resultArray as $rows){
	$myRow = $rows['idsearchTree'];
        findMatch($term, $myRow, $tol, $wordList, $conn); //do the same thing with every child
    }

    return $ret; 




}

$list = array();
  $sql = "SELECT *   
       FROM Geonames_AdminTKP
       WHERE asciiname LIKE '$term%'
       ORDER BY population DESC;
     ";
     
  $result = mysqli_query($conn, $sql, MYSQLI_USE_RESULT);  //get the value of the current node

    $resultArray = array();
    while($row = mysqli_fetch_array($result)){
         $resultArray[] = $row;
    };
    if(sizeof($resultArray) != 0 &&  sizeof($resultArray) != 1){
       echo json_encode($resultArray);
       exit(1);
    }

mysqli_free_result($result); //done with that result, move on


$term = findMatch($term, 0, $tol, $list, $conn);



//   mysqli_free_result($result); 
   
  $sql = "SELECT * 
       FROM Geonames_AdminTKP
       WHERE asciiname = '$myCity';
     ";
     
     $result = mysqli_query($conn, $sql, MYSQLI_USE_RESULT);  //get the value of the current node

     if(!$result){
       die(mysqli_error($conn));
     }

    $resultArray = array();
    while($row = mysqli_fetch_array($result)){
         $resultArray[] = $row;
    };



echo json_encode($resultArray);


?>



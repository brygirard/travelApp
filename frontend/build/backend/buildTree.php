<?php

class node {
		var $id;
        var $value;
        var $dist;
 
        
        var $children = array();
        
         public function __construct($value, $dist, $id) {	
            $this->id = $id;
            $this->value = $value;
            $this->dist = $dist;
		}		
 
		public function hasNoChildren() {
		 	return(sizeof($this->children) == 0);
		}
        
        public function addChild($node){
            array_push($this->children, $node);
        }
        public function getChildDists(){
            $distances = array();
            foreach($this->children as $child){
                array_push($distances, $child->value);
            }
            return $distances;
        }
 
	}	 
    
    
  class BTree
{
    public $root; // the root node of our tree

    public function __construct() {
        $this->root = null;
    }

    public function isEmpty() {
        return $this->root === null;
    }
}

	


function insertWord($word, $root, $id){
    $dist = levenshtein($root->value, $word);
    //echo "Distance between $root->value and $word is $dist<br/>";
    if($root->hasNoChildren()){
        $newNode = new node($word, $dist, $id);
        $root->addChild($newNode);
        //echo "Inserted Node $newNode->value with Id $newNode->id and parent $root->value (Distance $newNode->dist)<br/>";
        return;
    }else{
        $children = $root->children;
        foreach($children as $child){
            if($child->dist == $dist){
                insertWord($word, $child, $id);
                return;
            }
        }
        
        $newNode = new node($word, $dist, $id);
        $root->addChild($newNode);
        //echo "Inserted Node $newNode->value with Id $newNode->id and parent $root->value (Distance $newNode->dist)<br/>";
    }
    
    
}

function buildTree($words){
    $tree = new BTree();
    $id = 0;
    foreach($words as $word){
        if($tree->root == NULL){
            $newNode = new node($word, -1, $id);
            $tree->root = $newNode;
            //echo "Inserted Node $newNode->value with Id $newNode->id (Distance $newNode->dist)<br/>";
        }else{
             insertWord($word, $tree->root, $id);
        }
        $id++;
    }
    return $tree;
}

function traverse($root, $conn){
    if($root->hasNoChildren()){
        //echo "$root->value<br/>";
    }else{
        foreach($root->children as $child){
	    if($root->id == 0){
		echo "Adding $child->value with $child->dist to db</br>";
      	    }
            addToDatabase($child, $conn);
            traverse($child, $conn);
        }
        
       //echo "$child->value<br/>"; 
    }
}

function addToDatabase($node, $conn){


    $sqlValue = $conn->real_escape_string($node->value);
    echo "String inserting $sqlValue"; 
    $sql = "INSERT INTO searchTree (idSearchTree, distance,value)
    VALUES ('$node->id', '$node->dist', '$sqlValue')";
        

   
    $result = mysqli_query($conn, $sql, MYSQLI_USE_RESULT);


    foreach($node->children as $child){
           $sql = "INSERT INTO searchTreeRelation (parentID, childID)
           VALUES ('$node->id', '$child->id')";

       $result = mysqli_query($conn, $sql, MYSQLI_USE_RESULT);
    }
    
}


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

$sql = "SELECT asciiname FROM Geonames_AdminTKP";
$result = mysqli_query($conn, $sql, MYSQLI_USE_RESULT);

if(!$result){
   die("Invaslid query" . mysql_error());

}

set_time_limit(0);


$words = array();

while($row = mysqli_fetch_array($result)){
   $words[] = $row['asciiname'];
}


echo "$words";



//$words = array("help" , "hell", "hello", "shell", "loop", "helps", "helper", "troop", "helpop");

echo "Building Tree <br/>";
$tree = buildTree($words);

foreach($tree->root->children as $child){
//	echo "$child->value distance $child->dist<br/>";
	
}


addtoDatabase($tree->root, $conn);
echo "Adding Tree to database <br/>";
traverse($tree->root, $conn);

mysqli_close($conn);
?>

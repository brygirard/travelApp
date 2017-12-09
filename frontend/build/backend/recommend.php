<?php
//step1
require_once('database.php');
//declare vars and assign default values as blank

$UserID = $Travel_Month = $MIN_Temp = $MAX_Temp = $MIN_Precipitation = $MAX_Precipitation = $MIN_Lodging_Cost = $MAX_Lodging_Cost = $MIN_Meal_Cost = $MAX_Meal_Cost = $Travel_Advisories = $MIN_Distance_To_Ocean = $MAX_Distance_To_Ocean = $MIN_Distance_To_Lake = $MAX_Distance_To_Lake = $Country = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $UserID =clean_input($_POST["UserID"]);
        $Travel_Month =clean_input($_POST["Travel_Month"]);
        $MIN_Temp = clean_input($_POST["MIN_Temp"]);
        $MAX_Temp = clean_input($_POST["MAX_Temp"]);
        $MIN_Precipitation = clean_input($_POST["MIN_Precipitation"]);
        $MAX_Precipitation = clean_input($_POST["MAX_Precipitation"]);
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
        echo "SUBMITTED INFORMATION:";
	echo "<br>Month: " .$_POST["Travel_Month"];
        echo "<br>Temperature: " .$_POST["MIN_Temp"] . " to " . $_POST["MAX_Temp"];
        echo "<br>Precipitation: " .$_POST["MIN_Precipitation"] . " to " . $_POST["MAX_Precipitation"];
        echo "<br>Lodging_Cost: " .$_POST["MIN_Lodging_Cost"];
        echo "<br>Meal_Cost: " .$_POST["MIN_Meal_Cost"];
        echo "<br>Travel_Advisories: " .$_POST["Travel_Advisories"];
        echo "<br>Distance_To_Ocean: " .$_POST["MIN_Distance_To_Ocean"]. " to ". $_POST["MAX_Distance_To_Ocean"];
        echo "<br>Distance_To_Lake: " .$_POST["MIN_Distance_To_Lake"]. " to " . $_POST["MAX_Distance_To_Lake"];
        echo "<br>Country: " .$_POST["Country"];
}

//clean sent data
function clean_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
}

$tempfieldname = getTemperatureFieldName($Travel_Month);

if($MIN_Temp != '' or  $MAX_Temp!=''){
#	$tempfieldname = getTemperatureFieldName($Travel_Month);	
	$Alias = "Avg_Temp";
	$sql = getInitialQuery($MIN_Temp, $MAX_Temp, $Alias, $tempfieldname);
}

$rainfieldname = getRainFieldName($Travel_Month);

if($MIN_Precipitation != '' and $MAX_Precipitation!=''){
#	$rainfieldname = getRainFieldName($Travel_Month);
	$Alias = "Avg_Precipitation";
	$sql = getInitialQuery($MIN_Precipitation, $MAX_Precipitation, $Alias, $rainfieldname,$sql);
}
$oceanfieldname = "CoastDist";

if($MIN_Distance_To_Ocean!='' and $MAX_Distance_To_Ocean!=''){
#	$fieldname = "CoastDist";
	$Alias = "CoastDist";
	$sql = getInitialQuery($MIN_Distance_To_Ocean, $MAX_Distance_To_Ocean, $Alias, $oceanfieldname,$sql);
}
$lakefieldname = "LakeDist";

if($MIN_Distance_To_Lake!='' and $MAX_Distance_To_Lake!=''){
        #$fieldname = "LakeDist";
	$Alias = "LakeDist";
        $sql = getInitialQuery($MIN_Distance_To_Lake, $MAX_Distance_To_Lake, $Alias, $lakefieldname,$sql);
}
$lodgefieldname = "Lodg";

if($MIN_Lodging_Cost!='' and $MAX_Lodging_Cost!=''){
        $lodgefieldname = "Lodg";
        $Alias = "Lodg";
        $sql = getInitialQuery($MIN_Lodging_Cost, $MAX_Lodging_Cost, $Alias, $lodgefieldname,$sql);
}
$mealfieldname = "MIE";

if($MIN_Meal_Cost!='' and $MAX_Meal_Cost!=''){
#        $mealfieldname = "MIE";
        $Alias = "MIE";
        $sql = getInitialQuery($MIN_Meal_Cost, $MAX_Meal_Csot, $Alias, $mealfieldname,$sql);
}


$sql = getAllFields($sql);
#$othersql = allFieldsWithDatahub($sql);
$sql = geonameIDFromDatahub($sql);
#echo $allsql. "<br><br>".$geosql;


$sql = filterTravelWarnings($sql, $Travel_Advisories);

if($Country!=''){
        $fieldname = "official_name_en";
       # $sql = getInitialQuery($MIN_Distance_To_Lake, $MAX_Distance_To_Lake, $fieldname,$sql)
	$sql = filterCountry($sql,$Country);
}
echo "<br><br>".$sql;
$result = mysqli_query($conn,$sql) or die('Error querying database.');

$obj = (object)[
        'data' => $result,
        'temp_field_name' => $tempfieldname,
        'precip_field_name' => $rainfieldname,
	'lodge_field_name'=> $lodgefieldname,
	'meal_field_name'=> $mealfieldname
];

displayResult($result,$tempfieldname,$rainfieldname,$lodgefieldname,$mealfieldname,$lakefieldname,$oceanfieldname, $Travel_Month);
//close connection
#echo "done";
$conn->close();
?> 

<?php

function filterTravelWarnings($innersql_1,$warning){
	#echo $warning;	

        $travel_warning_sql =   "SELECT `geonameid` ".
                                "FROM Geonames_AdminTKP g, countryTravelWarningFips t ".
                                "WHERE g.geonameid in (".$innersql_1.") AND t.FIPS = t.ns1_identifier AND t.ISO3166_1_Alpha_2 = g.countrycode3166";


	$no_warning_sql = 	"SELECT g.*,'' description4 ".
				"FROM Geonames_AdminTKP g, datahub_country d ".
				"WHERE g.geonameid in(".$innersql_1.") AND g.geonameid not in (".$travel_warning_sql.") AND d.ISO3166_1_Alpha_2 = g.countrycode3166";

	if($warning == '1' or $warning == 1){
        	$travel_warning_sql = 	"SELECT g.*, t.description4 ".
					"FROM Geonames_AdminTKP g, countryTravelWarningFips t ".
					"WHERE g.geonameid in (".$innersql_1.") AND t.FIPS = t.ns1_identifier AND t.ISO3166_1_Alpha_2 = g.countrycode3166";

		$completesql = $no_warning_sql. " UNION " .$travel_warning_sql;
		return $completesql;
	}else{
		return $no_warning_sql;
	}
#	return $innersql_1;	
	#return $travel_warning_sql;
}

function displayResult($result, $tempfieldname,$rainfieldname, $lodgefieldname, $mealfieldname,$lakefieldname,$oceanfieldname, $Travel_Month){
	echo "<br><br>";
	//check error state of query
	echo "<table border='1'>
		<tr><td>Month
		</td><td>Country
                </td><td>State
		</td><td>City
                </td><td>Avg Temp
                </td><td>Avg Rainfall
                </td><td>Avg Snowfall
                </td><td>Avg Lodging Cost
                </td><td>Avg Meal Cost
                </td><td>Distance to Ocean
                </td><td>Distance to Lake
                </td><td>Warning
                </td></tr>";

	if($result->num_rows>0){
        	while($row = mysqli_fetch_assoc($result)) {
                	$temp = $row[$tempfieldname];
			if($temp>0){
                		$rain = $row[$rainfieldname];
				$snow = 0;
			}else{
				$rain = 0;
				$snow = $row[$rainfieldname];
			}
			$country = $row["official_name_en"];
			$state = $row["Admin1_nameascii"];
			$warning = $row["description4"];
			$city = $row["asciiname"];
			$lodge = $row[$lodgefieldname];
			$meal = $row[$mealfieldname];
			$ocean = $row[$oceanfieldname];
			$lake = $row[$lakefieldname];
                	echo    "<tr><td>" . $Travel_Month.
                        	"</td><td>" .$country.
				"</td><td>" .$state.
				"</td><td>" .$city.
                        	"</td><td>" . $temp.
                        	"</td><td>" . $rain.
                        	"</td><td>" . $snow.
                                "</td><td>" . $lodge.
                                "</td><td>" . $meal.
                                "</td><td>" . $ocean.
                                "</td><td>" . $lake.

				"</td><td>" .$warning.
                       		 "<br>";
        	}
	}else{
        	echo "0 results";
       		# echo "Error" .$sql . "<br>" . $conn->error;
	}
	echo "</table>";
}
function filterCountry($innersql,$country){
	$sql = "Select * from (".$innersql.") a WHERE a.official_name_en = '".$country."'";
	return $sql;
}
function joinOnLodgingsMeals($innersql){
	$lodgingsql = 	"SELECT ".
				"G.asciiname, ".
				"G.longitude, ".
				"G.latitude, ".
				"G.Admin1_nameascii, ".
				"G.Admin2_nameascii, ".
				"C.COUNTRY, ".
				"C.LOCALITY_CITY, ".
				"C.STATE, ".
				"C.Destination, ".
				"C.County_Location, ".
				"C.Avg_Lodging, ".
				"C.Avg_MIE ".
			"FROM ".
				"Geonames_Admin G ".
			"JOIN ".
				"Combined_Lodging_Meals C ".
			"ON ".
				"(UPPER(G.Admin1_nameascii) = C.COUNTRY) ".
				"OR ".
				"(UPPER(G.asciiname) = C.LOCALITY_CITY) ".
				"OR ".
				"(G.countrycode3166 = 'US' ".
					"AND ".
				"G.asciiname = C.Destination) ".
				"OR ".
				"(G.countrycode3166 = 'US' ".
					"AND ".
				"G.Admin2_nameascii = LEFT(RTRIM(C.County_Location), LENGTH(C.County_Location) - 7))"; 
}
function allFieldsWithDatahub($innersql){	
	$sql = "SELECT a.* FROM datahub_country d, (".$innersql.") a WHERE d.ISO3166_1_Alpha_2 = a.countrycode3166";
	return $sql;
}

function geonameIDFromDatahub($innersql){
        $sql = "SELECT `geonameid` FROM datahub_country d, (".$innersql.") a WHERE d.ISO3166_1_Alpha_2 = a.countrycode3166";
        return $sql;
}

function getAllFields($innersql){
	$sql =  "SELECT * FROM Geonames_AdminTKP g WHERE g.geonameid in (".$innersql.")";
	return $sql;
}
function getInitialQuery($lLimit, $uLimit,$Alias, $field, $innersql = ""){
	$where = '';
	if($innersql == ""){
		if($uLimit != '' and $lLimit !=''){  
			$where = " WHERE `".$field."` <= ".$uLimit." AND `".$field."` >= ".$lLimit."";
		}elseif($uLimit !='' and $lLimit == ''){
			$where = " WHERE `".$field."` <= ".$uLimit."";
		}elseif($uLimit == '' and $lLimit!=''){
			$where = " WHERE `".$field."` >= ".$lLimit."";
		}
		$sql = "SELECT `geonameid` FROM Geonames_AdminTKP " . $where;
	}else{
                if($uLimit != '' and $lLimit !=''){
                	$where = " WHERE `".$field."` <= ".$uLimit." AND `".$field."` >= ".$lLimit." and `geonameid` in (".$innersql.")"; 
                }elseif($uLimit !='' and $lLimit == ''){
                       $where = " WHERE `".$field."` <= ".$uLimit." AND `geonameid` in (".$innersql.")";
                }elseif($uLimit == '' and $lLimit!=''){
			$where = " WHERE `".$field."` >= ".$lLimit." AND `geonameid` in (".$innersql.")";
                }
		$sql = "SELECT `geonameid` FROM Geonames_AdminTKP " .$where;
	}
	return $sql;
}

function getTemperatureFieldName($month){

	if($month=="January"){
        	$field = "wc2_0_2_5m_tavg_01";
       	}elseif($month=="February"){
                $field = "wc2_0_2_5m_tavg_02";
        }elseif($month=="March"){
                $field = "wc2_0_2_5m_tavg_03";
        }elseif($month=="April"){
                $field = "wc2_0_2_5m_tavg_04";
        }elseif($month=="May"){
                $field = "wc2_0_2_5m_tavg_05";
        }elseif($month=="June"){
                $field = "wc2_0_2_5m_tavg_06";
        }elseif($month=="July"){
                $field = "wc2_0_2_5m_tavg_07";
        }elseif($month=="August"){
                $field = "wc2_0_2_5m_tavg_08";
        }elseif($month=="September"){
                $field = "wc2_0_2_5m_tavg_09";
        }elseif($month=="October"){
                $field = "wc2_0_2_5m_tavg_10";
        }elseif($month=="November"){
                $field = "wc2_0_2_5m_tavg_11";
        }elseif($month=="December"){
                $field = "wc2_0_2_5m_tavg_12";
   	}
	return $field;
}

function getRainFieldName($month){
        if($month=="January"){
                $field = "wc2_0_2_5m_prec_01";
        }elseif($month=="February"){
                $field = "wc2_0_2_5m_prec_02";
        }elseif($month=="March"){
                $field = "wc2_0_2_5m_prec_03";
        }elseif($month=="April"){
                $field = "wc2_0_2_5m_prec_04";
        }elseif($month=="May"){
                $field = "wc2_0_2_5m_prec_05";
        }elseif($month=="June"){
                $field = "wc2_0_2_5m_prec_06";
        }elseif($month=="July"){
                $field = "wc2_0_2_5m_prec_07";
        }elseif($month=="August"){
                $field = "wc2_0_2_5m_prec_08";
        }elseif($month=="September"){
                $field = "wc2_0_2_5m_prec_09";
        }elseif($month=="October"){
                $field = "wc2_0_2_5m_prec_10";
        }elseif($month=="November"){
                $field = "wc2_0_2_5m_prec_11";
        }elseif($month=="December"){
                $field = "wc2_0_2_5m_prec_12";
        }
        return $field;
}
?>

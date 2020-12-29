<?php

# Created on 14-Feb-2019 18:18:44

//************************************************************
// PhotoFrameUpdatev01.php
// finds the new jpegs and adds them to the database
//**********************************************************
 require_once 'photoframeLocalConfigv01.php';
   //**********************************************
  // open the database
  //*************************************************
  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($connection->connect_error) die($connection->connect_error);
  echo "dbjpegs opened ok<br>";
//****************************************************
// select imported jpegs  that dont match existing ones
//************************************************

$sql="SELECT tbldirlistimport.jpegFilename FROM tbldirlistimport";
$sql=$sql." LEFT JOIN tbljpegs ON tbldirlistimport.jpegFilename = tbljpegs.jpegFilename ";
$sql=$sql." WHERE tbljpegs.jpegFilename IS Null";
//*****************************************************************
// access the result which should be the new records, if an error then die
//******************************************************************
if(!$result = $connection->query($sql)){
	echo "error reading the new pictures " . "<br>";
	echo $connection->error . "<br>";
	die("Exiting the program");
	}
$num    = $result->num_rows;
echo "The number of new pictures found is  : " . $num . "<br>";
//*process each record
while ($row = $result->fetch_assoc()){
		$newFileName = $row['jpegFilename'];
		$colName = 'jpegFilename';
		
		$sql="INSERT INTO tbljpegs (".$colName.") VALUES ('$newFileName')";
			if(!$insert = $connection->query($sql)){
			//*********** something has gone wrong with the insert
			echo "error inserting<br>";
			echo $connection->error . "<br>";
		}
		echo $row['jpegFilename']."added <br>";	
	}



?>

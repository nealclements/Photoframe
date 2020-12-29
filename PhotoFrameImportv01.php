<?php

# Created on 6th march

//************************************************************
// PhotoFrameImportv01.php
//  adds the jpegs in a text file  to the database
//**********************************************************
 require_once 'photoframeLocalConfigv01.php';
   //**********************************************
  // open the database
  //*************************************************
  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($connection->connect_error) die($connection->connect_error);
  echo "dbjpegs opened ok<br>";
 //***********************************************************
 //* delete the imports that are already there
 //********************************************************
  $sql="DELETE FROM tbldirlistimport";
  if(!$result = $connection->query($sql)){
	echo "error deleting the old import " . "<br>";
	echo $connection->error . "<br>";
	die("Exiting the program");
	}
echo "Deleted old imports successfully<br>";

//****************************************************
// import the text file into the table
//************************************************

$sql="LOAD DATA LOCAL INFILE'".$imageFolder."dirlist.txt' INTO TABLE tbldirlistimport";


//*****************************************************************
// process and deal with error
//******************************************************************
if(!$result = $connection->query($sql)){
	echo "error reading the new pictures " . "<br>";
	echo $connection->error . "<br>";
	die("Exiting the program");
	}
echo "Loaded successfully";


?>

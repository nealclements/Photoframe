<?php
//***********************************************
// Photoframe v05 26 feb 19
//  uses the vwunshownjpegs view to select unshown pictures then displays them
// and sets the date shown to today.  When all have been shown then a manual 
// reset will be required in version 1
//***********************************************
  require_once 'photoframeLocalConfigv01.php';
  $programName = $host."/photoframev05.php";
  $timeToDisplay = 20000;
  //**********************************************
  // open the database
  //*************************************************
  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($connection->connect_error) die($connection->connect_error);
  //echo "dbjpegs opened ok<br>";

//***************************************
// select the names that have not been shown yet
//************************************
$sql = "SELECT * FROM vwunshownjpegs";
//******************
//process sql results. if the server was badly shutdown then the table might be corrupt
//*********************
if(!$result = $connection->query($sql)){
	echo "error reading the pictures attempting a repair" . "<br>";
	echo $connection->error . "<br>";
	$sql = "REPAIR TABLE tbljpegs";
	$result = $connection->query($sql);
	die("try again");
	}
$num    = $result->num_rows;
//echo "records found for vwUnshownJpegs : " . $num . "<br>";
if ($num == 0 )  {
	echo "no unshown jpegs so doing a reset<br>";
	$sql = "UPDATE tbljpegs SET dateShown= NULL"; 
	$result = $connection->query($sql);
} 
//*******************
// select a single random record to display and encode any spaces
//****************
$sql = "select jpegID,jpegFilename from vwunshownjpegs order by rand() limit 1";
$result = $connection->query($sql);
$row = $result->fetch_assoc();
//echo "jpeg id-".$row['jpegID']."file-".$row['jpegFilename']."<br>";
$newFilename = $imageFolder.$row['jpegFilename'];
$spaceFilledFilename = str_replace(" ","%20",$newFilename);
$sql = "update tbljpegs set dateShown = CURDATE() where jpegID =".$row['jpegID'];
$result = $connection->query($sql);
//echo "update result =".$result->num_rows."<br>";
//******************************************************
//  HTML starts here
//******************************************************

echo <<<_END
<head>
<style>
        * {
            margin: 0;
            padding: 0;
        }
        .imgbox {
            display: grid;
            height: 100%;
        }
        .center-fit {
            max-width: 100%;
            max-height: 100vh;
            margin: auto;
        }
    </style>
</head>

<body>
<div class="imgbox">
    <img class="center-fit" src= $spaceFilledFilename alt=$spaceFilledFilename>
</div>

<script>
  setTimeout(function(){ location.replace("$programName"); }, $timeToDisplay);
</script>
	
</body>
_END;
?>

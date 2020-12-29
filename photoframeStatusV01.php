<?php
//***********************************************
// PhotoframeStatusv01 29/12/20
//  displays the number of jpegs to show and shown
//***********************************************
  require_once 'photoframeLocalConfigv01.php';
  $programName = $host."/photoframeStatusv01.php";
  $timeToDisplay = 20000;
  //**********************************************
  // open the database
  //*************************************************
  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($connection->connect_error) die($connection->connect_error);
  //echo "dbjpegs opened ok<br>";
//***************************************************************
//* classes go here
//***************************************************************
class clsJpegCollection {
	function getTotal() {
		$sql = "SELECT COUNT(jpegID) FROM tbljpegs";
		$result = $connection->query($sql);
		$row = $result->fetch_assoc();
		return $this->$row['COUNT(jpegID)'];
	}
}

$oJpegCollection = new clsJpegCollection();

echo "number of records".$oJpegCollection->getTotal()."<br>";
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
!-- <div class="imgbox">
    <img class="center-fit" src= $spaceFilledFilename alt=$spaceFilledFilename>
</div>

<script>
  setTimeout(function(){ location.replace("$programName"); }, $timeToDisplay);
</script>-->
	
</body>
_END;
?>

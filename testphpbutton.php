<?php
//***********************************************
// testbuttonphp
//  displays the number of jpegs to show and shown
//***********************************************
  require_once 'photoframeLocalConfigv01.php';
  $programName = $host."/photoframeStatusv01.php";
  $timeToDisplay = 20000;
  $total = array() ;
  $unshown = array();
  //**********************************************
  // open the database
  //*************************************************
  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($connection->connect_error) die($connection->connect_error);
  echo "dbjpegs opened ok 17:22<br>";
//***************************************************************
//* classes go here
//***************************************************************
class clsJpegCollection {
    public $totalJpegs;
    public $row;
    public $sql;
    public $result;
	function getTotal($connection) {
		$this->sql = "SELECT COUNT(jpegID) FROM tbljpegs";
		$this->result = $connection->query($this->sql);
		$this->row = $this->result->fetch_assoc();
		return $this->row['COUNT(jpegID)'];
	}
	function getUnShown($connection) {
		$this->sql = "SELECT COUNT(jpegID) FROM tbljpegs where dateshown is null";
		$this->result = $connection->query($this->sql);
		$this->row = $this->result->fetch_assoc();
		return $this->row['COUNT(jpegID)'];
	}
}

$oJpegCollection = new clsJpegCollection();
echo "oJpegCollection- created ok<br>";
$total[] = $oJpegCollection->getTotal($connection);
$unshown[] = $oJpegCollection->getUnShown($connection);
echo "total [0] = ".$total[0];
echo "unshown [0] = ".$unshown[0];
//echo "number of records".$oJpegCollection->getTotal($connection)."<br>";
echo <<<_END
<head>
</head>

<body>
<div>
    <button id="but1">$unshown[0]</button>
</div>

</body>
_END;
?>

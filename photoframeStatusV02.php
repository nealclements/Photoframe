<?php
//***********************************************
// PhotoframeStatusv02 29/12/20
//  displays the number of jpegs to show and shown
//***********************************************
  require_once 'photoframeLocalConfigv01.php';
  $programName = $host."/photoframev05.php";
  
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
//***************************************************************
//* php main routine
//***************************************************************
$oJpegCollection = new clsJpegCollection();
$total[] = $oJpegCollection->getTotal($connection);
$unshown[] = $oJpegCollection->getUnShown($connection);
$shown = $total[0] - $unshown[0];
//***************************************************************
//* html goes here
//***************************************************************
echo <<<_END
<head>
<style>
.flex-container {
  display: flex;
  background-color: #333;
  justify-content: center;
}

.flex-container > div {
  background-color: #f1f1f1;
  margin: 10px;
  padding: 20px;
  font-size: 30px;
}
.flex-container > button {
  background-color: #f1f1f1;
  margin: 10px;
  padding: 20px;
  font-size: 30px;
}
</style>
</head>

<!--****************************************************************************
* create and position the message boxes
****************************************************************************-->
<body>
<div class="flex-container">
  <div>Photoframe status page</div>
  </div>
<div class="flex-container">
  <div>Total</div>
  <div>Shown</div>
  <div>Unseen</div>  
</div>
<div class="flex-container">
  <div>$total[0]</div>
  <div>$shown</div>
  <div>$unshown[0]</div>  
</div>
<div class = "flex-container">
  <button id="butPhoto" onclick="openPhotos()" >Click me for Photos</button>
 </div>
 <!--****************************************************************************
* Javascript starts here
****************************************************************************-->
<script>
function openPhotos () {
	location.replace("$programName");
}
</script>
</body>

_END;
?>

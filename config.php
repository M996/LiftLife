<?php

$host = "localhost";
$username = "LIFTAdmin";
$dbpassword = "Liftingupfor7798";
$db_name = "liftdb";

$db = mysqli_connect($host, $username, $dbpassword, $db_name);
$connection_error = $db->connect_error;
if ($connection_error != null) {
  echo "There has been an Error. The Database cannot connect. Please seek Help.";
  exit();
}

?>

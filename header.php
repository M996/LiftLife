<!DOCTYPE html>

<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/header-style.css">
  <link rel="stylesheet" type="text/css" href="css/index-style.css">
  <link rel="stylesheet" type="text/css" href="css/create-account-style.css">
  <link rel="stylesheet" type="text/css" href="css/donate-style.css">
  <link rel="stylesheet" type="text/css" href="css/overview-style.css">
  <link rel="stylesheet" type="text/css" href="css/destination-select-style.css">
  <link rel="stylesheet" type="text/css" href="css/item-select-style.css">
  <link rel="stylesheet" type="text/css" href="css/logon-style.css">
  <link rel="stylesheet" type="text/css" href="css/administrator-panel-style.css">
  <link rel="stylesheet" type="text/css" href="css/administrator-panel-items-style.css">
  <link rel="stylesheet" type="text/css" href="css/aboutLIFT-style.css">
  <link rel="stylesheet" type="text/css" href="css/aboutLMWW-style.css">
</head>
<?php


function currenturl() {
$pageURL = 'http';
$pageURL .= "://";
if ($_SERVER["SERVER_PORT"] != "80") {
$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
} else {
$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}
return $pageURL;
}

$url = currenturl();
if ($url != 'http://localhost/Liftweb/logon.php') {
  session_start();
}


?>
<body>
  <div class="header-menu">
      <a href="index.php" class="homepage-button"><img src="src/images/logolmww.png"></a>
      <?php
      if (isset($_SESSION['church'])) {
        function churchDisplay() {
          require 'config.php';
          $current_church_ID = $_SESSION['church'];
          $SQL_Query_Church = "SELECT ChurchName FROM church WHERE ChurchID = $current_church_ID ";
          $display_church = mysqli_query($db, $SQL_Query_Church);
          $churchArray = mysqli_fetch_array($display_church);

          return $churchArray;
        }

        $churchNameHeaderArray = churchDisplay();
        $churchNameHeader = $churchNameHeaderArray['ChurchName'];


      echo '<h2 id="church-name-header">Your Church: <span id="full-name-church">' . $churchNameHeader . '</span></h2> ';
      }
      ?>
    <div class="header-navbar">
      <?php  if (isset($_SESSION['benID'])) {
        echo '<a href="visitcreate.php" class="blue-nav">View Visits</a>
      ';}?>
    </div>
    <div class="header-login">
      <?php if(isset($_SESSION['benID'])) {
        echo '<div class="dropdown">
            <button class="dropbtn">' . $_SESSION['fname'] .  '</button>
            <div class="dropdown-content">';
            if ($_SESSION['clearance'] == "SUPERADMIN") {
              echo '<a href="addchurch.php">Add a Church</a>';
            };
            if ($_SESSION['clearance'] == "ADMIN") {
              echo '<a href="addvolunteer.php">Add a Volunteer</a>';
              } else {
              };
              echo '<a href="addrecipient.php">Add a Recipient</a>
              <a href="visitcreate.php">Visitors Needed</a>
              <a href="viewvisit.php">Church Score</a>
              <a href="aboutLIFT.php">About LIFT</a>
              <a href="aboutLMWW.php">About Life Matters WorldWide</a>
              <a href="logout.php">Logout</a>';
              echo  '</div>
          </div>'; }; ?>

    </div>
  </div>

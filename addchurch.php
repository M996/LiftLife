<?php include 'header.php';

if ($_SESSION['clearance'] != "SUPERADMIN")
header("Location: http://localhost/Liftweb/index.php");

// This if statement will add a new church into the church table once the form below has been filled out. It will also add a Pastor for that Church.
if (isset($_POST['churchname']) && isset($_POST['pastorname']) && isset($_POST['pastoremail'])) {
    $churchname = addslashes($_POST['churchname']);
    if (isset($_POST['address'])) {
    $churchaddress = addslashes($_POST['address']);
  } else {
    $churchaddress = NULL;
  }

    $pastorphone = addslashes($_POST['pastorphone']);
    $pastoremail = addslashes($_POST['pastoremail']);
    $pastorname = addslashes($_POST['pastorname']);

    if (isset($_POST['coordname'])) {
    $coordname = addslashes($_POST['coordname']);
  } else {
    $coordname = NULL;
  }

    if (isset($_POST['coordemail'])) {
    $coordemail = addslashes($_POST['coordemail']);
  } else {
    $coordemail = NULL;
  }

    if (isset($_POST['coordphone'])) {
    $coordphone = $_POST['coordphone'];
  } else {
    $coordphone = NULL;
  }

    if (isset($_POST['churchwebsite'])) {
    $churchwebsite = addslashes($_POST['churchwebsite']);
  } else {
    $churchwebsite = NULL;
  }

    require 'config.php';
    $SQL_ADD_CHURCH = "INSERT INTO church VALUES (NULL, '$churchname', '$churchaddress', '$pastorname', '$coordname', '$pastoremail', '$coordemail', '$pastorphone', '$coordphone', '$churchwebsite', 'NoContact' );";
    global $db;
    mysqli_query($db, $SQL_ADD_CHURCH);

    echo '<h1 style="font-family: sans-serif; margin-left: 20%; ">A New Church has been Added! Go set the Admin Password on "Add Volunteer"!</h1>';

    $SQL_QUERY_NEWCHURCH = 'SELECT ChurchID FROM church ORDER BY ChurchID DESC';
    $newestChurch = mysqli_query($db, $SQL_QUERY_NEWCHURCH);
    $newestChurchArray = mysqli_fetch_array($newestChurch);
    $currentChurchID = array_values($newestChurchArray)[0];


    $_SESSION['church'] = $currentChurchID;

    $SQL_ADD_PASTOR = "INSERT INTO volunteer VALUES (NULL, '$currentChurchID', '$pastorname', 'Password1', 'ADMIN', '$churchaddress', '$pastoremail', 'Head of $churchname', '$pastorphone', 0 );";
    mysqli_query($db, $SQL_ADD_PASTOR);

    if ($coordname != NULL) {
      $SQL_ADD_COORDINATOR = "INSERT INTO volunteer VALUES (NULL, '$currentChurchID', '$coordname', 'Password1', 'ADMIN', '$churchaddress', '$coordemail', 'Coordinator of the LIFT program for $churchname', '$coordphone', 0 );";
      mysqli_query($db, $SQL_ADD_COORDINATOR);
    }


}
if (isset($_POST['switch'])) {
  $_SESSION['church'] = $_POST['switch'];
}


// This if statement is to deliver messages to the End User.
if (isset($_POST['congratsmessage'])) {
  echo '<h2 style="font-family: sans-serif; font-weight: bold; font-style: italic; margin: 8px; fon-size: 32px; margin-left: 40%;">' . $_POST['congratsmessage'] . '</h2>';
}


// Define the functions that we will use to display information about the visits to be conducted.
  function churchDisplayadd() {
    require 'config.php';
    $SQL_Query_Church = 'SELECT ChurchID, ChurchName, Address, Pastor, Coordinator, MainEmail, CoordEmail, Phone, CoordPhone, ChurchWeb, ChurchStatus FROM church ORDER BY ChurchStatus, ChurchName';
    $display_church = mysqli_query($db, $SQL_Query_Church);

    return $display_church;
  }

?>


<head>
<title>Add Churches to LIFT</title>
</head>

<div class="Administrator-container">
  <div class="admin-tab-div">
    <a href="visitcreate.php" class="admin-tab">Visitors Needed</a>
    <a href="addrecipient.php" class="admin-tab">Add Recipient</a>
    <?php
    if ($_SESSION['clearance'] === "ADMIN" || $_SESSION['clearance'] === "SUPERADMIN") {
      echo '<a href="addvolunteer.php" class="admin-tab">Add Champion</a>';
    }
    if ($_SESSION['clearance'] === "SUPERADMIN") {
      echo '<a href="addchurch.php" class="admin-tab" id="current-admin-tab">Add Church</a>';
    }
    ?>
  </div>
  <div class="admin-tab-div-backup">
    <a href="visitcreate.php" class="admin-tab-backup" id="admin-tab-backup">Visitors Needed</a>
    <a href="addrecipient.php" class="admin-tab-backup" id="admin-tab-backup">Add Recipient</a>
  </div>
  <div class="admin-tab-div-backup">
    <?php
    if ($_SESSION['clearance'] === "ADMIN" || $_SESSION['clearance'] === "SUPERADMIN") {
      echo '<a href="addvolunteer.php" class="admin-tab-backup" id="admin-tab-backup">Add Champion</a>';
    }
    if ($_SESSION['clearance'] === "SUPERADMIN") {
      echo '<a href="addchurch.php" class="admin-tab-backup" id="current-admin-tab-backup">Add Church</a>';
    }
    ?>
  </div>
  <form method="post" action="">
    <div class="admin-inputs">
      <input size="30" maxlength="64" type="text" name="churchname" placeholder="Church Name" class="admin-input"  required></input>
      <input size="30" maxlength="96" type="text" name="address" placeholder="Address" class="admin-input"></input>
      <input size="30" maxlength="64" type="text" name="pastorname" placeholder="Pastor Full Name" class="admin-input"  required></input>
      <input size="30" maxlength="64" type="text" name="coordname" placeholder="Coordinator Full Name" class="admin-input"></input>
      <input size="30" maxlength="64" type="email" name="pastoremail" placeholder="Pastor's Email" class="admin-input"  required></input>
      <input size="30" maxlength="64" type="email" name="coordemail" placeholder="Coordinator's Email" class="admin-input"></input>
      <input size="30" maxlength="12" type="phone" name="pastorphone" placeholder="123-456-7890 (Pastor)" class="admin-input"  required></input>
      <input size="30" maxlength="12" type="text" name="coordphone" placeholder="123-456-7890 (Coordinator)" class="admin-input"></input>
      <input size="30" maxlength="64" type="text" name="churchwebsite" placeholder="ChurchWebsite.com" class="admin-input"></input>
      <button type="submit" class="admin-add">Add</button>
    </div>
  </form>
  <div style="display: flex; justify-content: center; align-items: center;">
    <h5 style="margin: 4px 44px; font-family: sans-serif;">Using the Form above you can add a New Church to the list below, and keep tabs on them to track their progress as they switch
    over to our Website. All information pertaining to the Pastor of the Church is Mandatory, including the phone number and email, but Coordinator information is optional, if their is no Coordinator
   of the LIFT program for this church, simply leave the Coordinator information empty. Once a Church has been created, an account for both the Pastor and the Coordinator will be created, you will
  need to reset the passwords of these accounts, as the default password when a new account is created is simply "Password1" and is not considered Secure. Once you have added a New Church to the Website
  you will automatically start viewing the website from the perspective of that Church. To switch to the view of another Church, simply find the Church in the list below and click "Switch".</h5>
  </div>
  <div class="cruise-view-admin">
    <div class="view-column-admin" id="view-column-visit">
      <div class="admin-view-name">
        <h4 class="adminbar-title">Churches</h4>
      </div>
      <?php $rec_ob = churchDisplayadd();
      foreach ($rec_ob as $display) {
        $church = $display['ChurchName'];
        $address = $display['Address'];
        $pastor = $display['Pastor'];
        $coordinator = $display['Coordinator'];
        $phone = $display['Phone'];
        $email = $display['MainEmail'];
        $coordemail = $display['CoordEmail'];
        $coordphone = $display['CoordPhone'];
        $website = $display['ChurchWeb'];
        $status = $display['ChurchStatus'];
        $churchID = $display['ChurchID'];

        if ($status === "NoContact") {
          $fullstatus = '<span style="font-weight: bolder; color: black; font-size: 18px; padding: 1px; border: 2px solid black; border-radius: 4px;">No Contact</span>';
        } else if ($status === "NoInterest") {
          $fullstatus = '<span style="font-weight: bolder; color: red; font-size: 18px; padding: 1px; border: 2px solid red; border-radius: 4px;">Not Interested</span>';
        } else if ($status === "Interested") {
          $fullstatus = '<span style="font-weight: bolder; color: rgb(30,30,120); font-size: 18px; padding: 1px; border: 2px solid rgb(30,30,120); border-radius: 4px;">Interested</span>';
        } else if ($status === "Converting") {
          $fullstatus = '<span style="font-weight: bolder; color: gold; font-size: 18px; padding: 1px; border: 2px solid gold; border-radius: 4px;">Converting</span>';
        } else if ($status === "Active") {
          $fullstatus = '<span style="font-weight: bolder; color: rgb(40,150,65); font-size: 18px; padding: 1px; border: 2px solid rgb(40,150,65); border-radius: 4px;">Active</span>';
        }

          echo '<div class="display-column">
          <h6 class="admin-info-text" style="margin-top: 12px;">' . $church . '\'s leader is  ' . $pastor . '. They can be reached at <a href="tel:' . $phone . '">' . $phone . '</a> or emailed at: ' . $email . '. The building is located at ' . $address . '</h6>
          <h6 class="admin-info-text" style="margin-top: 12px;">' . $church . '\'s Coordinator for the Lift Program is ' . $coordinator . ' who can be reached at <a href="tel:' . $coordphone . '">' . $coordphone . '</a> or emailed at: ' . $coordemail . '.</h6>
          <h6 class="admin-info-text" style="margin-top: 12px;"><form method="post" action="">
          <input type="checkbox" value="' . $churchID . '" name="switch" style="font-family: sans-serif;">View Website as This Church</input>
          <button type="submit" method="post" class="account-login-button" style="margin-left: 14px;">Switch</button></form>
          The Status of this Church in our Database is currently: ' . $fullstatus . '</h6> <br>
          <h6 class="admin-info-text" style="margin-top: 12px;"><form method="post" action="correspondence.php">
          <input type="hidden" value="' . $churchID . '" name="viewchurch"></input>
          <button type="submit" method="post" class="account-login-button" style="margin-left: 14px;">View Correspondence</button></form></h6>
          <p style="display: flex;"><a href="' . $website . '" style="margin-right: 14px; margin-left: auto; font-family: sans-serif; font-size: 11px; font-weight: bolder;">' . $website . '</a></p>
          </div><div style="padding: 22px; background-color: grey; border: 3px solid black; border-radius: 8px; margin: 8px;"></div>';


      } ?>
    </div>
  </div>
</div>

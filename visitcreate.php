<?php include 'header.php';


// This if statement will add a new visit into the visit table once the form below has been filled out.
if (isset($_POST['purpose']) && isset($_POST['recipient']) && isset($_SESSION['clearance'])) {
  if ($_POST['recipient'] != 'none') {

  $add_purpose = addslashes($_POST['purpose']);
  $add_cat = addslashes($_POST['category']);
  $add_volunteer = addslashes($_POST['volunteeradd']);
  $add_recipient = addslashes($_POST['recipient']);
  $add_year = addslashes($_POST['year']);
  $add_month = addslashes($_POST['month']);
  $add_day = addslashes($_POST['day']);
  $add_time = addslashes($_POST['time']);
  $church = addslashes($_SESSION['church']);
  $volunteerID = $_SESSION['benID'];
  if (isset($_POST['notes']))
    $add_notes = addslashes($_POST['notes']);

  require 'config.php';
  $SQL_ADD_VISIT = "INSERT INTO visit VALUES (NULL, '$church', '$add_volunteer', '$add_recipient', '$add_purpose', '$add_cat', '$add_year', '$add_month', '$add_day', '$add_time', '0', '$add_notes');";
  global $db;
  mysqli_query($db, $SQL_ADD_VISIT);
  echo '<h1 style="font-family: sans-serif; margin-left: 40%; ">Visit Added!</h1>';

  } else {
    echo '<h1 style="font-family: sans-serif; margin-left: 40%; ">You must choose a Recipient</h1>';
  }
}


// This if statement is to deliver messages to the End User.
if (isset($_POST['congratsmessage'])) {
  echo '<h2 style="font-family: sans-serif; font-weight: bold; font-style: italic; margin: 8px; fon-size: 32px; margin-left: 40%;">' . $_POST['congratsmessage'] . '</h2>';
}


// Here we will allow volunteers to set themselves as the volunteers for visits if they click the "Confirm" button on the page below.
if (isset($_POST['volunteer'])) {
  $number = $_POST['volunteer'];
  $realID = $_POST['realID'];

  require 'config.php';
  $SQL_UPDATE_VISIT = "UPDATE visit SET Vol_ID = $number WHERE VisitID = $realID;";
  mysqli_query($db, $SQL_UPDATE_VISIT);
}

// This if statement will allow volunteers to check off their visits as being complete.
if (isset($_POST['taskcomplete'])) {
  $finished = $_POST['taskcomplete'];
  $realID = $_POST['realID'];

  require 'config.php';
  $SQL_UPDATE_VISIT = "UPDATE visit SET V_Complete = $finished WHERE VisitID = $realID;";
  mysqli_query($db, $SQL_UPDATE_VISIT);

  $SQL_BOOST_VOLUNTEER = 'SELECT V_Score FROM volunteer WHERE Vol_ID = "' . $_SESSION['benID'] . '"';
  $vscore = mysqli_query($db, $SQL_BOOST_VOLUNTEER);
  $vscore_array = mysqli_fetch_array($vscore);
  $current_vscore = $vscore_array['V_Score'];
  $newscore = $current_vscore + 1;

  $SQL_UPDATE_VSCORE = 'UPDATE volunteer SET V_Score = ' . $newscore . ' WHERE Vol_ID = "' . $_SESSION['benID'] . '"';
  mysqli_query($db, $SQL_UPDATE_VSCORE);
}


// This if statement allows ADMINS and SUPERADMINS to delete visits made by volunteers.
if (isset($_POST['delete'])) {
  if ($_POST['delete'] === 'yes') {
    $delID = $_POST['deleteID'];
    require 'config.php';
    $SQL_DELETE_VISIT = "DELETE FROM visit WHERE VisitID = $delID";
    mysqli_query($db, $SQL_DELETE_VISIT);

  }
}


// Define the functions that we will use to display information about the visits to be conducted.
  function visitDisplay() {
    require 'config.php';
    $SQL_Query_Visit = 'SELECT * FROM visit WHERE V_Complete = 0 AND ChurchID = "' . $_SESSION['church'] . '" ORDER BY V_Year, V_Month, V_Day, V_Time';
    $display_visit = mysqli_query($db, $SQL_Query_Visit);

    return $display_visit;
  }
  function volName($ID) {
    require 'config.php';
    $volID = $ID;
    $SQL_Query_Volunteer = 'SELECT V_Name FROM volunteer WHERE Vol_ID = "' . $volID . '"';
    $display_volunteer = mysqli_query($db, $SQL_Query_Volunteer);
    $display_volunteer_array = mysqli_fetch_array($display_volunteer);

    $name = $display_volunteer_array['V_Name'];
    return $name;
  }
  function volPhone($ID) {
    require 'config.php';
    $volID = $ID;
    $SQL_Query_Volunteer = 'SELECT V_Phone FROM volunteer WHERE Vol_ID = "' . $volID . '"';
    $display_volunteer = mysqli_query($db, $SQL_Query_Volunteer);
    $display_volunteer_array = mysqli_fetch_array($display_volunteer);

    $phone = $display_volunteer_array['V_Phone'];
    return $phone;
  }
  function recName($ID) {
    require 'config.php';
    $recID = $ID;
    $SQL_Query_Recipient = 'SELECT R_Name FROM recipient WHERE RecID = "' . $recID . '"';
    $display_recipient = mysqli_query($db, $SQL_Query_Recipient);
    $display_recipient_array = mysqli_fetch_array($display_recipient);

    $name = $display_recipient_array['R_Name'];
    return $name;
  }
  function recAddress($ID) {
    require 'config.php';
    $recID = $ID;
    $SQL_Query_Recipient = 'SELECT R_Address FROM recipient WHERE RecID = "' . $recID . '"';
    $display_recipient = mysqli_query($db, $SQL_Query_Recipient);
    $display_recipient_array = mysqli_fetch_array($display_recipient);

    $address = $display_recipient_array['R_Address'];
    return $address;
  }
  function recPhone($ID) {
    require 'config.php';
    $recID = $ID;
    $SQL_Query_Recipient = 'SELECT R_Phone FROM recipient WHERE RecID = "' . $recID . '"';
    $display_recipient = mysqli_query($db, $SQL_Query_Recipient);
    $display_recipient_array = mysqli_fetch_array($display_recipient);

    $phone = $display_recipient_array['R_Phone'];
    return $phone;
  }
?>

<head>
<title>Add Visits to LIFT</title>
</head>

<div class="Administrator-container">
  <div class="admin-tab-div">
    <a href="visitcreate.php" class="admin-tab" id="current-admin-tab">Visitors Needed</a>
    <a href="addrecipient.php" class="admin-tab">Add Recipient</a>
    <?php
    if ($_SESSION['clearance'] === "ADMIN" || $_SESSION['clearance'] === "SUPERADMIN") {
      echo '<a href="addvolunteer.php" class="admin-tab">Add Champion</a>';
    }
    if ($_SESSION['clearance'] === "SUPERADMIN") {
      echo '<a href="addchurch.php" class="admin-tab">Add Church</a>';
    }
    ?>
  </div>
  <div class="admin-tab-div-backup">
    <a href="visitcreate.php" class="admin-tab-backup" id="current-admin-tab-backup">Visitors Needed</a>
    <a href="addrecipient.php" class="admin-tab-backup" id="admin-tab-backup">Add Recipient</a>
  </div>
  <div class="admin-tab-div-backup">
    <?php
    if ($_SESSION['clearance'] === "ADMIN" || $_SESSION['clearance'] === "SUPERADMIN") {
      echo '<a href="addvolunteer.php" class="admin-tab-backup" id="admin-tab-backup">Add Champion</a>';
    }
    if ($_SESSION['clearance'] === "SUPERADMIN") {
      echo '<a href="addchurch.php" class="admin-tab-backup" id="admin-tab-backup">Add Church</a>';
    }
    ?>
  </div>
  <form method="post" action="">
    <div class="admin-inputs">
      <div style="display: block;">
        <label for="recipient" style="font-family: sans-serif; font-weight: bold; display: flex; justify-content: center; font-size: 16px;">Recipient</label>
        <select name="recipient" class="admin-input" id="right-size-admin" style="margin-bottom: 20px;" required>
          <option value="none">Choose Here</option>
          <?php
          require 'config.php';
          $churchID = $_SESSION['church'];

          $SQL_Query_Recipients = 'SELECT R_Name, RecID FROM recipient WHERE ChurchID = "' . $churchID . '"';
          $display_recipients = mysqli_query($db, $SQL_Query_Recipients);

          foreach ($display_recipients as $recipient) {
            $name = $recipient['R_Name'];
            $ID = $recipient['RecID'];
            echo '<option value="' . $ID . '">' . $name . '</option>';
          }
          ?>
        </select>
      </div>
      <input size="22" maxlength="32" type="text" name="purpose" placeholder="Purpose of Visit" class="admin-input"  required>
      <div>
      <label for="category" style="font-family: sans-serif; font-weight: bold; display: flex; justify-content: center; font-size: 16px;">Category</label>
      <select name="category" class="admin-input" id="right-size-admin" style="margin-bottom: 20px;" required>
        <option value="OTHER" selected>Other</option>
        <option value="RESPITE">Respite Care</option>
        <option value="MEAL">Meal or Food Preparation</option>
        <option value="FINANCIAL">Financial or Estate Planning</option>
        <option value="HOUSE">Housekeeping</option>
        <option value="YARD">Yard Work</option>
        <option value="TRANSPORT">Transportation</option>
        <option value="PET">Pet Care or Veterinary</option>
        <option value="SOCIAL">Social Visit</option>
      </select>
    </div>
      <select name="year" class="admin-input" id="right-size-admin" required>
        <option value="2019" selected>2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
        <option value="2022">2022</option>
        <option value="2023">2023</option>
        <option value="2024">2024</option>
        <option value="2025">2025</option>
        <option value="2026">2026</option>
        <option value="2027">2027</option>
        <option value="2028">2028</option>
        <option value="2029">2029</option>
        <option value="2030">2030</option>
      </select>
      <input style="display: none; visibility: hidden" name="church" value="<?php echo $_SESSION['church']; ?>"></input>
      <select name="month" class="admin-input" id="right-size-admin" required>
        <option value="1" selected>January</option>
        <option value="2">February</option>
        <option value="3">March</option>
        <option value="4">April</option>
        <option value="5">May</option>
        <option value="6">June</option>
        <option value="7">July</option>
        <option value="8">August</option>
        <option value="9">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
      </select>
      <select name="day" class="admin-input" id="right-size-admin" required>
        <option value="1" selected>1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
      </select>
      <select name="time" class="admin-input" id="right-size-admin" required>
        <option value="5:00am">5:00am</option>
        <option value="5:30am">5:30am</option>
        <option value="6:00am">6:00am</option>
        <option value="6:30am">6:30am</option>
        <option value="7:00am">7:00am</option>
        <option value="7:30am">7:30am</option>
        <option value="8:00am">8:00am</option>
        <option value="8:30am">8:30am</option>
        <option value="9:00am">9:00am</option>
        <option value="9:30am">9:30am</option>
        <option value="10:00am">10:00am</option>
        <option value="10:30am">10:30am</option>
        <option value="11:00am">11:00am</option>
        <option value="11:30am">11:30am</option>
        <option value="12:00pm" selected>12:00pm</option>
        <option value="12:30pm">12:30pm</option>
        <option value="1:00pm">1:00pm</option>
        <option value="1:30pm">1:30pm</option>
        <option value="2:00pm">2:00pm</option>
        <option value="2:30pm">2:30pm</option>
        <option value="3:00pm">3:00pm</option>
        <option value="3:30pm">3:30pm</option>
        <option value="4:00pm">4:00pm</option>
        <option value="4:30pm">4:30pm</option>
        <option value="5:00pm">5:00pm</option>
        <option value="5:30pm">5:30pm</option>
        <option value="6:00pm">6:00pm</option>
        <option value="6:30pm">6:30pm</option>
        <option value="7:00pm">7:00pm</option>
        <option value="7:30pm">7:30pm</option>
        <option value="8:00pm">8:00pm</option>
        <option value="8:30pm">8:30pm</option>
        <option value="9:00pm">9:00pm</option>
        <option value="9:30pm">9:30pm</option>
        <option value="10:00pm">10:00pm</option>
        <option value="10:30pm">10:30pm</option>
        <option value="11:00pm">11:00pm</option>
      </select>
      <div style="display: block;">
        <label for="volunteeradd" style="font-family: sans-serif; font-weight: bold; display: flex; justify-content: center; font-size: 16px;">Volunteer</label>
        <select name="volunteeradd" class="admin-input" id="right-size-admin" style="margin-bottom: 20px;" required>
          <option value="<?php echo $_SESSION['benID']; ?>">Myself</option>
          <option value="3" selected>Someone Else</option>
        </select>
      </div>
      <textarea rows="3" columns="40" name="notes" placeholder="Here is some important information for everyone to know!" class="admin-input"></textarea>
      <button type="submit" class="admin-add">Add</button>
    </div>
  </form>
  <div class="cruise-view-admin">
    <div class="view-column-admin" id="view-column-visit">
      <div class="admin-view-name">
        <h4 class="adminbar-title">Upcoming Visits</h4>
      </div>
      <?php $visit_ob = visitDisplay();
      foreach ($visit_ob as $display) {
        $month = $display['V_Month'];
        $day = $display['V_Day'];
        $time = $display['V_Time'];
        $purpose = $display['Purpose'];
        $realID = $display['VisitID'];
        $recID = $display['RecID'];
        $recname = recName($recID);
        $recAddress = recAddress($recID);
        $recPhone = recPhone($recID);
        $notes = $display['V_Notes'];
        $volID = $display['Vol_ID'];
        if ($volID == 3) {
          if ($_SESSION['clearance'] === 'ADMIN' || $_SESSION['clearance'] === 'SUPERADMIN') {
            echo '<form style="margin-left: 8px; margin-right: auto;" method="post">
            <input value="yes" name="delete" style="display: none; visibility: hidden;"></input>
            <input value="Visit Deleted From Database" name="congratsmessage" style="display: none; visibility: hidden;"></input>
            <input style="display: none; visibility: hidden;" value="' . $realID . '" name="deleteID"></input>
            <button type="submit" method="post" style="padding: 4px; background-color: red; margin: 2px;">Delete</button>
            </form>';
          }

          echo '<div style="display: flex;"><form style="margin-right: 8px; margin-left: auto;" method="post" action="visitcomments.php">
          <input style="display: none; visibility: hidden;" value="' . $realID . '" name="commentsID"></input>
          <button type="submit" method="post" style="padding: 4px; background-color: rgb(35,150,45); border-radius: 4px; margin: 2px; color: white;">Comments</button>
          </form></div>';


          echo '<div class="display-column">
          <h6 class="admin-info-text" style="margin-top: 12px;">' . $month .'/' . $day . '  ' . $time . '   -' . $purpose . ' . . .
          ||| . . .   ' . $recname . ' at ' . $recAddress . ' --- Call: <a href="tel:' . $recPhone . '">' . $recPhone . '</a> . . .
          ||| . . . A Volunteer is needed to help make this visit, Can <strong>you</strong> visit ' . $recname . ' on this date? <form method="post">
          <input type="checkbox" value="' . $_SESSION['benID'] . '" name="volunteer" style="border: 2px solid red; border-radius: 10px;">I Volunteer</input>
          <input style="display: none; visibility: hidden;" value="' . $realID . '" name="realID"></input>
          <button type="submit" method="post" class="account-login-button" style="margin-left: 14px;">Confirm</button>
          </form></h6>  <p style="font-size: 12px; font-family: sans-serif; font-weight: bold; margin-left: 6%;">Note: ' . $notes . ' </p></h6>
          </div><div style="padding: 22px; background-color: grey; border: 3px solid black; border-radius: 8px; margin: 8px;"></div>';
        } else {
          $volname = volName($volID);
          $volphone = volPhone($volID);

          if ($_SESSION['clearance'] === 'ADMIN' || $_SESSION['clearance'] === 'SUPERADMIN') {
            echo '<form style="margin-left: 8px; margin-right: auto;" method="post">
            <input value="yes" name="delete" style="display: none; visibility: hidden;"></input>
            <input value="Visit Deleted From Database" name="congratsmessage" style="display: none; visibility: hidden;"></input>
            <input style="display: none; visibility: hidden;" value="' . $realID . '" name="deleteID"></input>
            <button type="submit" method="post" style="padding: 4px; background-color: red; margin: 2px;">Delete</button>
            </form>';
          }

          echo '<div style="display: flex;"><form style="margin-right: 8px; margin-left: auto;" method="post" action="visitcomments.php">
          <input style="display: none; visibility: hidden;" value="' . $realID . '" name="commentsID"></input>
          <button type="submit" method="post" style="padding: 4px; background-color: rgb(35,150,45); border-radius: 4px; margin: 2px; color: white;">Comments</button>
          </form></div>';


        echo '<div class="display-column">
        <h6 class="admin-info-text" style="margin-top: 12px;">' . $month .'/' . $day . '  ' . $time . '   -' . $purpose . ' . . .
        ||| . . .   ' . $recname . ' at ' . $recAddress . ' --- Call: <a href="tel:' . $recPhone . '">' . $recPhone . '</a> . . .
        ||| . . . ' . $volname . ' is planning to make this visit, you can call them at: <a href="tel:' . $volphone . '">' . $volphone . '</a> . . .
        ||| . . . </h6>  <div style="display: flex;"><p style="font-size: 12px; font-family: sans-serif; font-weight: bold; margin-left: 6%; margin-right: 5%;">Note: ' . $notes . ' </p></h6>';
        if ($volID == $_SESSION['benID']) {
          echo '<p style="font-size: 12px; font-family: sans-serif; font-weight: bold; margin-right: 16px; margin-left: auto;">Have you done this visit yet?</p><form style="margin-right: 5%; border: 1px solid black; border-radius: 12px; margin-bottom: 4px;" method="post">
          <input type="checkbox" value="1" name="taskcomplete" style="border: 2px solid red; border-radius: 10px; padding: 2px; background-color: red;">Finished</input>
          <input style="display: none; visibility: hidden;" value="' . $realID . '" name="realID"></input>
          <input style="display: none; visibility: hidden;" value="Thank you for your Help! Your Visit has been Recorded and will be added to your Visit Count!" name="congratsmessage"></input>
          <button type="submit" method="post" class="account-login-button" style="margin-left: 12px;">Confirm</button>
          </form>';
        }
        echo '</div></div>
        <div style="padding: 22px; background-color: grey; border: 3px solid black; border-radius: 8px; margin: 8px;"></div>';}
      } ?>
    </div>
  </div>
</div>

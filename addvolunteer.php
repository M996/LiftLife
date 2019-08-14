<?php include 'header.php';

if ($_SESSION['clearance'] != "ADMIN" && $_SESSION['clearance'] != "SUPERADMIN")
header("Location: http://localhost/Liftweb/index.php");

// This if statement will add a new visit into the visit table once the form below has been filled out.
if (isset($_POST['fullname']) && isset($_POST['address']) && isset($_POST['password'])) {
  if ($_POST['password'] === $_POST['passwordre']) {
    $add_fullname = addslashes($_POST['fullname']);
    $add_address = addslashes($_POST['address']);
    $add_phone = addslashes($_POST['phone']);
    $add_email = addslashes($_POST['email']);
    $add_church = $_POST['ChurchID'];
    $add_clearance = $_POST['volclearance'];
    $add_password = addslashes($_POST['password']);
    if (isset($_POST['notes']))
      $add_notes = addslashes($_POST['notes']);

    require 'config.php';
    $SQL_ADD_VOLUNTEER = "INSERT INTO volunteer VALUES (NULL, '$add_church', '$add_fullname', '$add_password', '$add_clearance', '$add_address', '$add_email', '$add_notes', '$add_phone', 0 );";
    global $db;
    mysqli_query($db, $SQL_ADD_VOLUNTEER);
    echo '<h1 style="font-family: sans-serif; margin-left: 40%; ">A New Volunteer has been Added!</h1>';
  } else {
      echo '<h2 style="font-family: sans-serif; font-weight: bold; font-style: italic; margin: 8px; fon-size: 32px; margin-left: 40%;">Try Again: Passwords Do Not Match</h2>';
  }

}


// This if statement is to deliver messages to the End User.
if (isset($_POST['congratsmessage'])) {
  echo '<h2 style="font-family: sans-serif; font-weight: bold; font-style: italic; margin: 8px; fon-size: 32px; margin-left: 40%;">' . $_POST['congratsmessage'] . '</h2>';
}

if (isset($_POST['resetpassword'])) {
  if ($_POST['resetpassword'] === $_POST['resetpasswordre']) {
    $newpassword = $_POST['resetpassword'];
    $resetvolID = $_POST['volID'];
    require 'config.php';
    $SQL_UPDATE_PASSWORD = 'UPDATE volunteer SET V_Password = "' . $newpassword . '" WHERE Vol_ID = "' . $resetvolID . '"';
    mysqli_query($db, $SQL_UPDATE_PASSWORD);
  } else {
    echo '<h2 style="font-family: sans-serif; font-weight: bold; font-style: italic; margin: 8px; fon-size: 32px; margin-left: 40%;">Cannot Reset this Password, Passwords Do Not Match.</h2>';
  }
}

// This if statement allows ADMINS and SUPERADMINS to delete visits made by volunteers.
if (isset($_POST['delete'])) {
  if ($_POST['delete'] === 'yes') {
    $delID = $_POST['deleteID'];
    require 'config.php';
    $SQL_DELETE_RECIPIENT = "DELETE FROM volunteer WHERE Vol_ID = $delID";
    mysqli_query($db, $SQL_DELETE_RECIPIENT);

  }
}


// Define the functions that we will use to display information about the visits to be conducted.
  function volDisplay() {
    require 'config.php';
    $SQL_Query_Volunteer = 'SELECT Vol_ID, V_Name, V_Password, V_Clearance, V_Address, V_Email, V_Notes, V_Phone FROM volunteer WHERE ChurchID = "' . $_SESSION['church'] . '" ORDER BY V_Name';
    $display_volunteer = mysqli_query($db, $SQL_Query_Volunteer);

    return $display_volunteer;
  }

  function churchname() {
    require 'config.php';
    $SQL_Query_Church = 'SELECT ChurchName FROM church WHERE ChurchID = "' . $_SESSION['church'] . '"';
    $display_church = mysqli_query($db, $SQL_Query_Church);
    $church_name = mysqli_fetch_array($display_church);
    $churchcurrent = $church_name['ChurchName'];

    return $churchcurrent;
  }
?>
<head>
<title>Add Champions to LIFT</title>
</head>

<div class="Administrator-container">
  <div class="admin-tab-div">
    <a href="visitcreate.php" class="admin-tab">Visitors Needed</a>
    <a href="addrecipient.php" class="admin-tab">Add Recipient</a>
    <?php
    if ($_SESSION['clearance'] === "ADMIN" || $_SESSION['clearance'] === "SUPERADMIN") {
      echo '<a href="addvolunteer.php" class="admin-tab" id="current-admin-tab">Add Champion</a>';
    }
    if ($_SESSION['clearance'] === "SUPERADMIN") {
      echo '<a href="addchurch.php" class="admin-tab">Add Church</a>';
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
      echo '<a href="addvolunteer.php" class="admin-tab-backup" id="current-admin-tab-backup">Add Champion</a>';
    }
    if ($_SESSION['clearance'] === "SUPERADMIN") {
      echo '<a href="addchurch.php" class="admin-tab-backup" id="admin-tab-backup">Add Church</a>';
    }
    ?>
  </div>
  <form method="post" action="">
    <div class="admin-inputs">
      <input type="hidden" name="ChurchID" value="<?php echo $_SESSION['church']; ?>"></input>
      <input size="30" maxlength="64" type="text" name="fullname" placeholder="Full Name" class="admin-input"  required></input>
      <input size="30" maxlength="64" type="text" name="password" placeholder="Password" class="admin-input"  required></input>
      <input size="30" maxlength="64" type="text" name="passwordre" placeholder="Repeat Password" class="admin-input"  required></input>
      <select name="volclearance" class="admin-input" id="right-size-admin" required>
        <option value="VOLUNTEER" selected>Volunteer</option>
        <option value="ADMIN">ADMIN</option>
      </select>
      <input size="30" maxlength="96" type="text" name="address" placeholder="Address" class="admin-input"></input>
      <input size="30" maxlength="64" type="email" name="email" placeholder="Example@Email.com" class="admin-input"  required></input>
      <input size="30" maxlength="12" type="phone" name="phone" placeholder="123-456-7890" class="admin-input"  required></input>
      <textarea rows="3" columns="40" name="notes" placeholder="Here is some information about this Volunteer" class="admin-input"></textarea>
      <button type="submit" class="admin-add">Add</button>
    </div>
  </form>
  <div style="display: flex; justify-content: center; align-items: center;">
    <h5 style="margin: 4px 44px; font-family: sans-serif;">Using the controls above create a new Volunteer or Administrator for your Church's Lift Program. When setting the "Clearance" level of the new User,
    here is what you should know: A "Volunteer" can enter new recipients into the Database, and schedule new visits, and mark as finished the visits that they volunteer for. An "Administrator" can do everything
    that a Volunteer can do, but they can also delete scheduled visits, delete Recipients of Care from the program, and access this page to create new Volunteers. Only give "Administrator" clearance
    to people you want to have full control over your Database, and if you have any issues contact Life Matters WorldWide.</h5>
  </div>
  <div class="cruise-view-admin">
    <div class="view-column-admin" id="view-column-visit">
      <div class="admin-view-name">
        <h4 class="adminbar-title">Volunteers at <?php echo churchName(); ?></h4>
      </div>
      <?php $rec_ob = volDisplay();
      foreach ($rec_ob as $display) {
        $name = $display['V_Name'];
        $address = $display['V_Address'];
        $phone = $display['V_Phone'];
        $email = $display['V_Email'];
        $notes = $display['V_Notes'];
        $volID = $display['Vol_ID'];
        $clearance = $display['V_Clearance'];
        $password = $display['V_Password'];
        if ($volID == 3 || $volID == 11) {

        } else {


          echo '<form style="margin-left: 8px; margin-right: auto;" method="post">
          <input value="yes" name="delete" style="display: none; visibility: hidden;"></input>
          <input value="Volunteer as been Deleted from this Church" name="congratsmessage" style="display: none; visibility: hidden;"></input>
          <input style="display: none; visibility: hidden;" value="' . $volID . '" name="deleteID"></input>
          <button type="submit" method="post" style="padding: 4px; background-color: red; margin: 2px;">Delete</button>
          </form>';

          echo '<div class="display-column">
          <h6 class="admin-info-text" style="margin-top: 12px;">' . $name . ' lives at ' . $address . ' and is a Volunteer with our Church in the LIFT program. You can call this person at
          <a href="tel:' . $phone . '">' . $phone . '</a></h6> <h6 class="admin-info-text" style="margin-top: 12px;">Email: ' . $email . ' . . . ||| . . . Clearance Level: ' . $clearance . '
          . . . ||| . . . Password: ' . $password . ' <form method="post">
          <input type="hidden" name="volID" value="' . $volID . '"></input>
          <input size="18" maxlength="64" type="text" name="resetpassword" placeholder="New Password" class="admin-input"  required></input>
          <input size="18" maxlength="64" type="text" name="resetpasswordre" placeholder="Repeat New Password" class="admin-input"  required></input>
          <button type="submit" method="post" class="account-login-button" style="margin-left: 14px;">Reset</button>
          </form></h6>  <p style="font-size: 12px; font-family: sans-serif; font-weight: bold; margin-left: 6%;">Note: ' . $notes . ' </p></h6>
          </div><div style="padding: 22px; background-color: grey; border: 3px solid black; border-radius: 8px; margin: 8px;"></div>';
        }

      } ?>
    </div>
  </div>
</div>

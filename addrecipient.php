<?php include 'header.php';


// This if statement will add a new visit into the visit table once the form below has been filled out.
if (isset($_POST['fullname']) && isset($_POST['address'])) {


  $add_fullname = addslashes($_POST['fullname']);
  $add_address = addslashes($_POST['address']);
  $add_phone = addslashes($_POST['phone']);
  $add_email = addslashes($_POST['email']);
  $add_church = $_POST['ChurchID'];
  if (isset($_POST['notes']))
    $add_notes = addslashes($_POST['notes']);

  require 'config.php';
  $SQL_ADD_RECIPIENT = "INSERT INTO recipient VALUES (NULL, '$add_church', '$add_fullname', '$add_address', '$add_phone', '$add_email', '$add_notes');";
  global $db;
  mysqli_query($db, $SQL_ADD_RECIPIENT);
  echo '<h1 style="font-family: sans-serif; margin-left: 40%; ">A New Recipient has been Added!</h1>';
}


// This if statement is to deliver messages to the End User.
if (isset($_POST['congratsmessage'])) {
  echo '<h2 style="font-family: sans-serif; font-weight: bold; font-style: italic; margin: 8px; fon-size: 32px; margin-left: 40%;">' . $_POST['congratsmessage'] . '</h2>';
}



// This if statement allows ADMINS and SUPERADMINS to delete visits made by volunteers.
if (isset($_POST['delete'])) {
  if ($_POST['delete'] === 'yes') {
    $delID = $_POST['deleteID'];
    require 'config.php';
    $SQL_DELETE_RECIPIENT = "DELETE FROM recipient WHERE RecID = $delID";
    mysqli_query($db, $SQL_DELETE_RECIPIENT);

  }
}


// Define the functions that we will use to display information about the visits to be conducted.
  function recDisplay() {
    require 'config.php';
    $SQL_Query_Recipient = 'SELECT RecID, R_Name, R_Address, R_Phone, R_Email, R_Notes FROM recipient WHERE ChurchID = "' . $_SESSION['church'] . '" ORDER BY R_Name';
    $display_recipient = mysqli_query($db, $SQL_Query_Recipient);

    return $display_recipient;
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

<div class="Administrator-container">
  <div class="admin-tab-div">
    <a href="visitcreate.php" class="admin-tab">Visitors Needed</a>
    <a href="addrecipient.php" class="admin-tab" id="current-admin-tab">Add Recipient</a>
    <?php
    if ($_SESSION['clearance'] === "ADMIN" || $_SESSION['clearance'] === "SUPERADMIN") {
      echo '<a href="addvolunteer.php" class="admin-tab">Add Volunteer</a>';
    }
    if ($_SESSION['clearance'] === "SUPERADMIN") {
      echo '<a href="addchurch.php" class="admin-tab">Add Church</a>';
    }
    ?>
  </div>
  <div class="admin-tab-div-backup">
    <a href="visitcreate.php" class="admin-tab-backup" id="admin-tab-backup">Visitors Needed</a>
    <a href="addrecipient.php" class="admin-tab-backup" id="current-admin-tab-backup">Add Recipient</a>
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
      <input type="hidden" name="ChurchID" value="<?php echo $_SESSION['church']; ?>"></input>
      <input size="30" maxlength="64" type="text" name="fullname" placeholder="Full Name" class="admin-input"  required></input>
      <input size="30" maxlength="96" type="text" name="address" placeholder="Address" class="admin-input"  required></input>
      <input size="30" maxlength="12" type="phone" name="phone" placeholder="123-456-7890" class="admin-input"  required></input>
      <input size="30" maxlength="64" type="email" name="email" placeholder="Example@Email.com" class="admin-input"  required></input>
      <textarea rows="3" columns="40" name="notes" placeholder="Here is some information about this Recipient" class="admin-input"></textarea>
      <button type="submit" class="admin-add">Add</button>
    </div>
  </form>
  <div class="cruise-view-admin">
    <div class="view-column-admin" id="view-column-visit">
      <div class="admin-view-name">
        <h4 class="adminbar-title">Recipients of Care at <?php echo churchName(); ?></h4>
      </div>
      <?php $rec_ob = recDisplay();
      foreach ($rec_ob as $display) {
        $name = $display['R_Name'];
        $address = $display['R_Address'];
        $phone = $display['R_Phone'];
        $email = $display['R_Email'];
        $notes = $display['R_Notes'];
        if ($_SESSION['clearance'] === 'ADMIN' || $_SESSION['clearance'] === 'SUPERADMIN') {
          $recID = $display['RecID'];

          echo '<form style="margin-left: 8px; margin-right: auto;" method="post">
          <input value="yes" name="delete" style="display: none; visibility: hidden;"></input>
          <input value="Recipient Deleted From Database" name="congratsmessage" style="display: none; visibility: hidden;"></input>
          <input style="display: none; visibility: hidden;" value="' . $recID . '" name="deleteID"></input>
          <button type="submit" method="post" style="padding: 4px; background-color: red; margin: 2px;">Delete</button>
          </form>';
        }

          echo '<div class="display-column">
          <h6 class="admin-info-text" style="margin-top: 12px;">' . $name . ' lives at ' . $address . ' and is a Recipient of Care with our church in the LIFT program. You can call this person at
          <a href="tel:' . $phone . '">' . $phone . '</a> or email them at ' . $email . '</h6>  <p style="font-size: 12px; font-family: sans-serif; font-weight: bold; margin-left: 6%;">Note: ' . $notes . ' </p></h6>
          </div><div style="padding: 22px; background-color: grey; border: 3px solid black; border-radius: 8px; margin: 8px;"></div>';


      } ?>
    </div>
  </div>
</div>

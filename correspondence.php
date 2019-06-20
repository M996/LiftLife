<?php include 'header.php';

if ($_SESSION['clearance'] != "ADMIN" && $_SESSION['clearance'] != "SUPERADMIN")
header("Location: http://localhost/Liftweb/index.php");

// This if statement will add a new Correspondence and automatically date-stamp the correspondence when one is made.
if (isset($_POST['ChurchIDCorrespondence']) && isset($_POST['purpose']) && isset($_POST['typeofcorrespondence'])) {
    $churchIDcor = addslashes($_POST['ChurchIDCorrespondence']);
    $purpose = addslashes($_POST['purpose']);
    $typeofcorrespondence= addslashes($_POST['typeofcorrespondence']);

    if (isset($_POST['notes'])) {
      $correspondenceDescription = addslashes($_POST['notes']);
    }
    require 'config.php';
    $SQL_ADD_CORRESPONDENCE = "INSERT INTO correspondence VALUES (NULL, '$churchIDcor', '$purpose', '$typeofcorrespondence', CURRENT_TIMESTAMP, '$correspondenceDescription' );";
    global $db;
    mysqli_query($db, $SQL_ADD_CORRESPONDENCE);

    echo '<h1 style="font-family: sans-serif; margin-left: 30%;">Correspondences Updated</h1>';
}

if (isset($_POST['churchStatus'])) {
  $newstatus = $_POST['churchStatus'];
  $changeStatusID = $_POST['viewchurch'];
  require 'config.php';
  $SQL_UPDATE_STATUS = 'UPDATE church SET ChurchStatus = "' . $newstatus . '" WHERE ChurchID = "' . $changeStatusID . '"';
  mysqli_query($db, $SQL_UPDATE_STATUS);
}

// This if statement is to deliver messages to the End User.
if (isset($_POST['congratsmessage'])) {
  echo '<h2 style="font-family: sans-serif; font-weight: bold; font-style: italic; margin: 8px; fon-size: 32px; margin-left: 40%;">' . $_POST['congratsmessage'] . '</h2>';
}


// Define the functions that we will use to display information about the visits to be conducted.
  function churchDisplay() {
    require 'config.php';
    $current_church_ID = $_POST['viewchurch'];
    $SQL_Query_Church = "SELECT ChurchID, ChurchName, Address, Pastor, Coordinator, MainEmail, CoordEmail, Phone, CoordPhone, ChurchWeb, ChurchStatus FROM church WHERE ChurchID = $current_church_ID ";
    $display_church = mysqli_query($db, $SQL_Query_Church);
    $churchArray = mysqli_fetch_array($display_church);

    return $churchArray;
  }

  function correspondenceDisplay() {
    require 'config.php';
    $current_church_ID = $_POST['viewchurch'];
    $SQL_Query_Cor = "SELECT Purpose, Type_Cor, C_Date, C_Notes FROM correspondence WHERE ChurchID = $current_church_ID ORDER BY C_Date DESC ";
    $display_correspondence = mysqli_query($db, $SQL_Query_Cor);

    return $display_correspondence;
  }

  function correspondenceAmount() {
    require 'config.php';
    $current_church_ID = $_POST['viewchurch'];
    $SQL_Query_Cor_Number = "SELECT Cor_ID FROM correspondence WHERE ChurchID = $current_church_ID ";
    $correspondence_object = mysqli_query($db, $SQL_Query_Cor_Number);
    $corArray = mysqli_fetch_array($correspondence_object);

    return count($corArray);
  }

?>

<div class="Administrator-container">
  <div class="admin-tab-div">
    <a href="addchurch.php" class="admin-tab">Back</a>
  </div>
  <?php
  $churchDisplay = churchDisplay();
  $churchName = $churchDisplay['ChurchName'];
  $churchAddress = $churchDisplay['Address'];
  $Pastor = $churchDisplay['Pastor'];
  $Coordinator = $churchDisplay['Coordinator'];
  $pastorEmail = $churchDisplay['MainEmail'];
  $coordEmail = $churchDisplay['CoordEmail'];
  $pastorPhone = $churchDisplay['Phone'];
  $coordPhone = $churchDisplay['CoordPhone'];
  $Website = $churchDisplay['ChurchWeb'];
  $status = $churchDisplay['ChurchStatus'];
  $current_church_ID = $_POST['viewchurch'];

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

  $corNumber = correspondenceAmount();


  echo '<div class="display-column" style="display: flex; justify-content: center; align-items: center;">
  <h6 class="admin-info-text" style="margin-top: 12px; margin:">
  ' . $churchName . ' is currently: ' . $fullstatus . '
  </h6></div>
  <div class="display-column" style="display: flex; justify-content: center; align-items: center;">
  <h6 class="admin-info-text" style="margin-top: 12px;">
  <form method="post" action="">
  <div class="admin-inputs" style="border-bottom: none;">
  <button type="submit" class="admin-add" style="margin-bottom: 20px; padding: 8px;">Update</button>
  <select name="churchStatus" class="admin-input" id="right-size-admin" required>
    <option value="NoContact" selected>Not Contacted</option>
    <option value="Interested">Interested</option>
    <option value="Converting">Converting</option>
    <option value="Active">Active</option>
    <option value="NoInterest">Not Interested</option>
  </select>
  <input type="hidden" name="viewchurch" class="admin-input" value="' . $current_church_ID . '"  required></input>
  </div>
  </form>
  </h6></div>
  <div class="display-column" style="display: flex; justify-content: center; align-items: center;">
  <h6 class="admin-info-text" style="margin-top: 12px;">
  The Pastor or Head of ' . $churchName . ' is ' . $Pastor . '. ' . $Pastor . ' can be reached at <a href="' . $pastorPhone . '">' . $pastorPhone . '</a> or emailed at: ' . $pastorEmail . '. We have had X correspondence(s) with ' . $churchName . '
  </h6></div>
  <div class="display-column" style="display: flex; justify-content: center; align-items: center; border-bottom: solid 2px rgb(40,120,40);">
  <h6 class="admin-info-text" style="margin-top: 12px;">
  The Coordinator of the LIFT Program for ' . $churchName . ' is ' . $Coordinator . '. ' . $Coordinator . ' can be reached at <a href="' . $coordPhone . '">' . $coordPhone . '</a> or emailed at: ' . $coordEmail . '.
  </h6></div>

  <form method="post" action="">
  <div class="admin-inputs">
  <input type="hidden" name="viewchurch" class="admin-input" value="' . $current_church_ID . '"  required></input>
  <input type="hidden" name="ChurchIDCorrespondence" class="admin-input" value="' . $current_church_ID . '"  required></input>
  <input size="30" maxlength="50" type="text" name="purpose" placeholder="Purpose" class="admin-input" required></input>
  <select name="typeofcorrespondence" class="admin-input" id="right-size-admin" required>
    <option value="Email" selected>Email</option>
    <option value="Facebook">Facebook</option>
    <option value="Twitter">Twitter</option>
    <option value="LinkedIn">LinkedIn</option>
    <option value="InPerson">In Person</option>
    <option value="Text">Text Message</option>
    <option value="Phone">Phone Call</option>
  </select>
  <textarea rows="3" columns="40" name="notes" placeholder="Provide a Brief Description of the Exchange." class="admin-input"></textarea>
  <button type="submit" class="admin-add">Add</button>
  </div>
  </form>'
  ?>
  <div style="display: flex; justify-content: center; align-items: center;">
    <h5 style="margin: 4px 44px; font-family: sans-serif;">On this page you can set the new Status of each Church in our Database, record and view Correspondences with each Church, and provide
    important information for yourself to remember in the correspondences listed below. The "X" above will later give the total amount of Correspondences in the list, but that has not yet been implemented.</h5>
  </div>
  <div class="cruise-view-admin">
    <div class="view-column-admin" id="view-column-visit">
      <div class="admin-view-name">
        <h4 class="adminbar-title">Correspondences</h4>
      </div>
      <?php $rec_ob = correspondenceDisplay();
      foreach ($rec_ob as $display) {
        $purpose = $display['Purpose'];
        $type_correspondence = $display['Type_Cor'];
        $date = $display['C_Date'];
        $notes = $display['C_Notes'];

        if ($type_correspondence === "Facebook") {
          $type_correspondence = '<span style="color: rgb(10,2,80)">' . $type_correspondence . '</span>';
        } else if ($type_correspondence === "Email") {
          $type_correspondence = '<span style="color: rgb(255,140,40)">' . $type_correspondence . '</span>';
        } else if ($type_correspondence === "Twitter") {
          $type_correspondence = '<span style="color: rgb(0,230,170)">' . $type_correspondence . '</span>';
        } else if ($type_correspondence === "LinkedIn") {
          $type_correspondence = '<span style="color: rgb(0,30,190)">' . $type_correspondence . '</span>';
        } else if ($type_correspondence === "InPerson") {
          $type_correspondence = '<span style="color: rgb(210,10,80)">' . $type_correspondence . '</span>';
        } else if ($type_correspondence === "Text") {
          $type_correspondence = '<span style="color: black">' . $type_correspondence . '</span>';
        } else if ($type_correspondence === "Phone") {
          $type_correspondence = '<span style="color: rgb(245,245,235)">' . $type_correspondence . '</span>';
        }

          echo '<div class="display-column" style="display: block;">
          <div style="display: flex; align-items: center; justify-content: center;">
          <h6 class="admin-info-text" style="margin-top: 12px;">
          ' . $purpose . ' . . . | | | . . .  ' . $type_correspondence . ' . . . | | | . . .  <span style="border: 1px solid black; padding: 1px; border-radius: 4px;">' . $date . '</span></h6></div>
          <div style="display: flex; align-items: center; justify-content: center;font-family: sans-serif; font-size: 11px; font-weight: bolder;"
          <p>' . $notes . '</p></div>
          </div><div style="padding: 22px; background-color: grey; border: 3px solid black; border-radius: 8px; margin: 8px;"></div>';


      } ?>
    </div>
  </div>
</div>

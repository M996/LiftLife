<?php include 'header.php';

// This if statement will add a new Correspondence and automatically date-stamp the correspondence when one is made.
if (isset($_POST['commentsID']) && isset($_POST['comment'])) {
    $visitIDcomment = addslashes($_POST['commentsID']);
    $commentsanitized = addslashes($_POST['comment']);
    $userID = $_SESSION['benID'];

    require 'config.php';
    $SQL_ADD_COMMENT = "INSERT INTO visitcomments VALUES (NULL, '$visitIDcomment', '$userID', '$commentsanitized', CURRENT_DATE );";
    global $db;
    mysqli_query($db, $SQL_ADD_COMMENT);
    $SQL_ADD_COMMENT;

    echo '<h1 style="font-family: sans-serif; margin-left: 30%;">Comment Added!</h1>';
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
  function visitDisplay() {
    require 'config.php';
    $current_visit_ID = $_POST['commentsID'];
    $SQL_Query_Visit = "SELECT Vol_ID, RecID, Purpose, V_Year, V_Month, V_Day, V_Time, V_Notes FROM visit WHERE VisitID = $current_visit_ID ";
    $display_visit = mysqli_query($db, $SQL_Query_Visit);
    $visitArray = mysqli_fetch_array($display_visit);

    return $visitArray;
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

  function commentDisplay() {
    require 'config.php';
    $current_visit_ID = $_POST['commentsID'];
    $SQL_Query_Comment = "SELECT Vol_ID, Comment, Com_Date FROM visitcomments WHERE VisitID = $current_visit_ID ORDER BY CommentID DESC ";
    $display_Comment = mysqli_query($db, $SQL_Query_Comment);

    return $display_Comment;
  }

?>

<head>
<title>Comments</title>
</head>

<div class="Administrator-container">
  <div class="admin-tab-div">
    <a href="visitcreate.php" class="admin-tab">Back</a>
  </div>
  <?php
  $visitDisplay = visitDisplay();
  $visitPurpose = $visitDisplay['Purpose'];
  $visitYear = $visitDisplay['V_Year'];
  $visitMonth = $visitDisplay['V_Month'];
  $visitDay = $visitDisplay['V_Day'];
  $visitTime = $visitDisplay['V_Time'];
  $visitNotes = $visitDisplay['V_Notes'];


  $visitVolunteer = $visitDisplay['Vol_ID'];

  if ($visitVolunteer == 3) {
    $volunteerLine = '<h6 class="admin-info-text" style="margin-top: 12px; margin:">
      No one has Volunteered to Make this Visit. Leave a Comment Below to let people know if you are you available!
      </h6>';
  } else {
    $volName = volName($visitVolunteer);
    $volPhone = volPhone($visitVolunteer);
    $volunteerLine = '<h6 class="admin-info-text" style="margin-top: 12px; margin: 2px;">
    ' . $volName . ' is planning to make this Visit. You can call them to collaborate at <a href="tel:' . $volPhone . '">' . $volPhone . '</a>
    </h6>';
  }
  $visitRecipient = $visitDisplay['RecID'];
  $recName = recName($visitRecipient);
  $recAddress = recAddress($visitRecipient);
  $recPhone = recPhone($visitRecipient);




  echo '<div class="display-column" style="display: flex; justify-content: center; align-items: center;">
  ' . $volunteerLine . '
  </div>
  <div class="display-column" style="display: flex; justify-content: center; align-items: center;">
  <h6 class="admin-info-text" style="margin-top: 12px;">
  ' . $recName . ' lives at ' . $recAddress . ' and needs our Help with "' . $visitPurpose . '". You can call ' . $recName . ' at <a href="tel:' . $recPhone . '">' . $recPhone . '</a>
  </h6></div>
  <div class="display-column" style="display: flex; justify-content: center; align-items: center;">
  <h6 class="admin-info-text" style="margin-top: 12px;">
  The date for this visit is set at ' . $visitMonth . '/' . $visitDay . '/' . $visitYear . ' at ' . $visitTime . ' so ' . $recName . ' is hoping someone will be there around that time.
  </h6></div>
  <div class="display-column" style="display: flex; justify-content: center; align-items: center; border-bottom: solid 2px rgb(40,120,40);">
  <h6 class="admin-info-text" style="margin-top: 12px; font-size: 14px;">
  Notes: ' . $visitNotes . '
  </h6></div>

  <form method="post" action="">
  <div class="admin-inputs">
  <input type="hidden" name="commentsID" class="admin-input" value="' . $_POST['commentsID'] . '"  required></input>
  <textarea rows="5" columns="180" maxlength="1024" name="comment" placeholder="Leave a Comment about this Task." class="admin-input" required></textarea>
  <button type="submit" class="admin-add">Add</button>
  </div>
  </form>'
  ?>
  <div style="display: flex; justify-content: center; align-items: center;">
    <h5 style="margin: 4px 44px; font-family: sans-serif;">Leave a comment in the Box above and it will appear at the top of the Comment List below.</h5>
  </div>
  <div class="cruise-view-admin">
    <div class="view-column-admin" id="view-column-visit">
      <div class="admin-view-name">
        <h4 class="adminbar-title">Comments</h4>
      </div>
      <?php $rec_ob = commentDisplay();
      foreach ($rec_ob as $display) {
        $comment = $display['Comment'];
        $date = $display['Com_Date'];
        $volID = $display['Vol_ID'];
        $volName = volName($volID);

          echo '<div class="display-column" style="display: block;">
          <div style="display: flex;">
          <h6 class="admin-info-text" style="margin-top: 12px; margin-left: 10%;">
          <span style="color: rgb(35,150,45); margin-bottom: 18px;">' . $volName . ':</span> <br> <br>
          ' . $comment . '</h6></div>
          <div style="display: flex; font-family: sans-serif; font-size: 12px; font-weight: bolder;">
          <span style="border: 1px solid black; padding: 1px; border-radius: 4px; margin-left: 12%;">' . $date . '</span>
          </div>
          </div><div style="padding: 18px; background-color: grey; border: 3px solid black; border-radius: 8px; margin: 8px;"></div>';


      } ?>
    </div>
  </div>
</div>

<?php

session_start();

if (isset($_REQUEST['Email']) && isset ($_REQUEST['Password'])) {
  //set session variables
  $_SESSION['email'] = $_REQUEST['Email'];
  $_SESSION['password'] = $_REQUEST['Password'];

  require 'config.php';

  $SQLCheckForPass = 'SELECT Vol_ID, V_Name, V_Clearance, ChurchID FROM volunteer WHERE V_Email = "' . $_SESSION['email'] . '" AND V_Password= ' . '"' . $_SESSION['password'] . '"';
  $result = mysqli_query($db, $SQLCheckForPass);
  $row_count = $result->num_rows;
  $result = mysqli_fetch_array($result);

  if ($row_count == 1) {
    $_SESSION['benID'] = $result['Vol_ID'];
    $_SESSION['fname'] = $result['V_Name'];
    $_SESSION['clearance'] = $result['V_Clearance'];
    $_SESSION['church'] = $result['ChurchID'];
    header("Location: http://localhost/Liftweb/index.php");

  } else {
    // terminate user session if logon fails.
    $invalid = "Invalid Username or Password";

    unset($_SESSION['email']);
    unset($_SESSION['password']);
    session_destroy();
  }
}

include 'header.php';
?>

<head>
  <title>LIFT Database Login</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
  <div class="banner-homepage">
    <img src="src/images/bannerimage.jpg" class="banner-image-home" id="img-changer">
    <div class="field-container">
      <form name="login" action="" method="post">
        <fieldset class="fieldset-background">
          <legend><strong style="background-color: white; border-radius: 10px; padding: 4px;">Please Login to LIFT</strong></legend><br>
          <div id="feildgrid">
            <div id="row">
              <div id="fieldlabel">
                <label for="UserID"><strong style="background-color: white; border-radius: 10px; padding: 4px;">Email</strong></label>

              </div>
              <div id="fieldlabel">
                <input type="text" name="Email" size="30" id="UserID" class="account-form-input">

              </div>
              <div id="fieldlabel">
                <label for="Password"><strong style="background-color: white; border-radius: 10px; padding: 4px;">Password</strong></label>

              </div>
              <div id="fieldlabel">
                <input type="password" name="Password" size="30" id="Password" class="account-form-input">

              </div>
              <div id="fieldlabel">
                <h2 style="font-style: bolder; color: rgb(120,5,5); font-family: sans-serif;"><?php
                if (isset($invalid)) {
                  echo $invalid;
                }
                 ?></h2>
            </div>


          </div>
          <div id="buttongrid">
            <div id="row">
              <button type="submit" class="account-login-button">Login</button>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</body>

<script language="javascript" type="text/javascript">

$(window).resize(function() {
  if(window.innerWidth < 730){
      document.getElementById("img-changer").src = "src/images/bannerimage2.jpg";
  }
  if(window.innerWidth >= 730){
      document.getElementById("img-changer").src = "src/images/bannerimage.jpg";
  }
});

</script>

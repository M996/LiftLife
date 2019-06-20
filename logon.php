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
          echo '<h2> Invalid Email or Password </h2>';

        unset($_SESSION['email']);
        unset($_SESSION['password']);
        session_destroy();
    }
}

 include 'header.php';
?>

<body>
  <div class="banner-homepage">
    <img src="src/images/bannerimage.jpg" class="banner-image-home">
    </div>
    <form name="login" action="" method="post">
      <div class="field-container">
        <fieldset>
            <legend><strong>Please Login to LIFT</strong></legend><br>
            <div id="feildgrid">
                <div id="row">
                    <div id="fieldlabel">
                        <label for="UserID"><strong>Email</strong></label>

                    </div>
                    <div id="fieldlabel">
                        <input type="text" name="Email" size="30" id="UserID" class="account-form-input">

                    </div>
                    <div id="fieldlabel">
                        <label for="Password"><strong>Password</strong></label>

                    </div>
                    <div id="fieldlabel">
                        <input type="password" name="Password" size="30" id="Password" class="account-form-input">

                    </div>

                </div>


            </div>
            <div id="buttongrid">
                <div id="row">
                    <button type="submit" class="account-login-button">Login</button>
                  </div>
                </div>
            </div>
        </fieldset>
      </div>
    </form>
</body>

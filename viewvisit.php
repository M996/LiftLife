<?php include 'header.php';

// I am requesting that the RestID be set in order to trigger this if statement just to make sure as many conditions need to be met as possible, that is more secure. The ID by which
// volunteers are found is tied only to the Session variable of the user.
if ($_SESSION['clearance'] === "ADMIN" || $_SESSION['clearance'] === "SUPERADMIN") {


  if (isset($_POST['ResetID']) && isset($_POST['AdminResetOrder'])) {
    require 'config.php';

    $SQL_Update_Visits = 'UPDATE visit SET Counted = 1 WHERE ChurchID = "' . $_SESSION['church'] . '" AND V_Complete != 0 AND Counted = 0;';
    mysqli_query($db, $SQL_Update_Visits);

    $SQL_Query_Volunteer_ID = 'SELECT Vol_ID FROM volunteer WHERE ChurchID = "' . $_SESSION['church'] . '"';
    $vol_id = mysqli_query($db, $SQL_Query_Volunteer_ID);

    foreach ($vol_id as $vol) {
      $volid = $vol['Vol_ID'];
      $SQL_WIPE_SCORE = 'UPDATE volunteer SET V_Score = 0 WHERE Vol_ID = "' . $volid . '"';
      mysqli_query($db, $SQL_WIPE_SCORE);
    }
    echo '<h2 style="font-family: sans-serif; font-weight: bold; font-style: italic; margin: 8px; margin-left: 30%; color: red;">Score Wiped. This action Cannot be Undone.</h2>';
  }
}

function visitnumber() {
  require 'config.php';
  $SQL_Query_Volunteer_Score = 'SELECT V_Score FROM volunteer WHERE ChurchID = "' . $_SESSION['church'] . '"';
  $scoreVol = mysqli_query($db, $SQL_Query_Volunteer_Score);

  $totalScore = 0;

  foreach ($scoreVol as $score_object) {
    $score = $score_object['V_Score'];

    $totalScore += $score;
  }

  return $totalScore;
}

function respiteDisplay() {
  require 'config.php';
  $SQL_Query_Visit_Stats = 'SELECT COUNT(*) FROM visit WHERE ChurchID = "' . $_SESSION['church'] . '" AND V_Complete != 0 AND Counted = 0 AND Category = "RESPITE";';
  $visitObj = mysqli_query($db, $SQL_Query_Visit_Stats);
  $visitArray = mysqli_fetch_array($visitObj);

  return $visitArray[0];
}

function mealDisplay() {
  require 'config.php';
  $SQL_Query_Visit_Stats = 'SELECT COUNT(*) FROM visit WHERE ChurchID = "' . $_SESSION['church'] . '" AND V_Complete != 0 AND Counted = 0 AND Category = "MEAL";';
  $visitObj = mysqli_query($db, $SQL_Query_Visit_Stats);
  $visitArray = mysqli_fetch_array($visitObj);

  return $visitArray[0];
}

function financialDisplay() {
  require 'config.php';
  $SQL_Query_Visit_Stats = 'SELECT COUNT(*) FROM visit WHERE ChurchID = "' . $_SESSION['church'] . '" AND V_Complete != 0 AND Counted = 0 AND Category = "FINANCIAL";';
  $visitObj = mysqli_query($db, $SQL_Query_Visit_Stats);
  $visitArray = mysqli_fetch_array($visitObj);

  return $visitArray[0];
}

function houseDisplay() {
  require 'config.php';
  $SQL_Query_Visit_Stats = 'SELECT COUNT(*) FROM visit WHERE ChurchID = "' . $_SESSION['church'] . '" AND V_Complete != 0 AND Counted = 0 AND Category = "HOUSE";';
  $visitObj = mysqli_query($db, $SQL_Query_Visit_Stats);
  $visitArray = mysqli_fetch_array($visitObj);

  return $visitArray[0];
}

function yardDisplay() {
  require 'config.php';
  $SQL_Query_Visit_Stats = 'SELECT COUNT(*) FROM visit WHERE ChurchID = "' . $_SESSION['church'] . '" AND V_Complete != 0 AND Counted = 0 AND Category = "YARD";';
  $visitObj = mysqli_query($db, $SQL_Query_Visit_Stats);
  $visitArray = mysqli_fetch_array($visitObj);

  return $visitArray[0];
}

function transportDisplay() {
  require 'config.php';
  $SQL_Query_Visit_Stats = 'SELECT COUNT(*) FROM visit WHERE ChurchID = "' . $_SESSION['church'] . '" AND V_Complete != 0 AND Counted = 0 AND Category = "TRANSPORT";';
  $visitObj = mysqli_query($db, $SQL_Query_Visit_Stats);
  $visitArray = mysqli_fetch_array($visitObj);

  return $visitArray[0];
}

function petDisplay() {
  require 'config.php';
  $SQL_Query_Visit_Stats = 'SELECT COUNT(*) FROM visit WHERE ChurchID = "' . $_SESSION['church'] . '" AND V_Complete != 0 AND Counted = 0 AND Category = "PET";';
  $visitObj = mysqli_query($db, $SQL_Query_Visit_Stats);
  $visitArray = mysqli_fetch_array($visitObj);

  return $visitArray[0];
}

function socialDisplay() {
  require 'config.php';
  $SQL_Query_Visit_Stats = 'SELECT COUNT(*) FROM visit WHERE ChurchID = "' . $_SESSION['church'] . '" AND V_Complete != 0 AND Counted = 0 AND Category = "SOCIAL";';
  $visitObj = mysqli_query($db, $SQL_Query_Visit_Stats);
  $visitArray = mysqli_fetch_array($visitObj);

  return $visitArray[0];
}

function otherDisplay() {
  require 'config.php';
  $SQL_Query_Visit_Stats = 'SELECT COUNT(*) FROM visit WHERE ChurchID = "' . $_SESSION['church'] . '" AND V_Complete != 0 AND Counted = 0 AND Category = "OTHER";';
  $visitObj = mysqli_query($db, $SQL_Query_Visit_Stats);
  $visitArray = mysqli_fetch_array($visitObj);

  return $visitArray[0];
}

function churchDisplay() {
  require 'config.php';
  $current_church_ID = $_SESSION['church'];
  $SQL_Query_Church = "SELECT ChurchID, ChurchName FROM church WHERE ChurchID = $current_church_ID ";
  $display_church = mysqli_query($db, $SQL_Query_Church);
  $churchArray = mysqli_fetch_array($display_church);

  return $churchArray;
}

$churchDisplay = churchDisplay();
$churchName = $churchDisplay['ChurchName'];
$visitNumber = visitnumber();
$respiteCount = respiteDisplay();
$mealCount = mealDisplay();
$financialCount = financialDisplay();
$houseCount = houseDisplay();
$yardCount = yardDisplay();
$transportCount = transportDisplay();
$petCount = petDisplay();
$socialCount = socialDisplay();
$otherCount = otherDisplay();
?>


<body>
  <center style="margin-top: 44px;">
    <script language="javascript" type="text/javascript">
    var day_of_week = new Array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
    var month_of_year = new Array('January','February','March','April','May','June','July','August','September','October','November','December');

    //  DECLARE AND INITIALIZE VARIABLES
    var Calendar = new Date();

    var year = Calendar.getFullYear();     // Returns year
    var month = Calendar.getMonth();    // Returns month (0-11)
    var today = Calendar.getDate();    // Returns day (1-31)
    var weekday = Calendar.getDay();    // Returns day (1-31)

    var DAYS_OF_WEEK = 7;    // "constant" for number of days in a week
    var DAYS_OF_MONTH = 31;    // "constant" for number of days in a month
    var cal;    // Used for printing

    Calendar.setDate(1);    // Start the calendar day at '1'
    Calendar.setMonth(month);    // Start the calendar month at now


    /* VARIABLES FOR FORMATTING
    NOTE: You can format the 'BORDER', 'BGCOLOR', 'CELLPADDING', 'BORDERCOLOR'
    tags to customize your calendar's look. */

    var TR_start = '<TR style="line-height: 40px;">';
    var TR_end = '</TR>';
    var highlight_start = '<TD WIDTH="52"><TABLE CELLSPACING=0 BORDER=1 BGCOLOR=DEDEFF BORDERCOLOR=CCCCCC><TR><TD WIDTH=96><B><CENTER>';
    var highlight_end   = '</CENTER></TD></TR></TABLE></B>';
    var TD_start = '<TD WIDTH="96" STYLE="border: 1px solid black;"><CENTER>';
    var TD_end = '</CENTER></TD>';

    /* BEGIN CODE FOR CALENDAR
    NOTE: You can format the 'BORDER', 'BGCOLOR', 'CELLPADDING', 'BORDERCOLOR'
    tags to customize your calendar's look.*/

    cal =  '<TABLE BORDER=1 CELLSPACING=0 CELLPADDING=0 BORDERCOLOR=BBBBBB><TR><TD>';
    cal += '<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=2>' + TR_start;
    cal += '<TD COLSPAN="' + DAYS_OF_WEEK + '" BGCOLOR="#EFEFEF"><CENTER><B>';
    cal += month_of_year[month]  + '   ' + year + '</B>' + TD_end + TR_end;
    cal += TR_start;

    //   DO NOT EDIT BELOW THIS POINT  //

    // LOOPS FOR EACH DAY OF WEEK
    for(index=0; index < DAYS_OF_WEEK; index++)
    {

      // BOLD TODAY'S DAY OF WEEK
      if(weekday == index)
      cal += TD_start + '<B>' + day_of_week[index] + '</B>' + TD_end;

      // PRINTS DAY
      else
      cal += TD_start + day_of_week[index] + TD_end;
    }

    cal += TD_end + TR_end;
    cal += TR_start;


    // FILL IN BLANK GAPS UNTIL TODAY'S DAY
    for(index=0; index < Calendar.getDay(); index++)
    cal += TD_start + '  ' + TD_end;

    // LOOPS FOR EACH DAY IN CALENDAR
    for(index=0; index < DAYS_OF_MONTH; index++)
    {


      if( Calendar.getDate() > index )
      {
        // RETURNS THE NEXT DAY TO PRINT
        week_day =Calendar.getDay();

        // START NEW ROW FOR FIRST DAY OF WEEK
        if(week_day == 0)
        cal += TR_start;

        if(week_day != DAYS_OF_WEEK)
        {

          // SET VARIABLE INSIDE LOOP FOR INCREMENTING PURPOSES
          var day  = Calendar.getDate();


          // Here we will add visits to the printed day once we have pulled arrays from the database, using an if statement.
          day += '<br style="margin-top: -10px;">.';


          // HIGHLIGHT TODAY'S DATE
          if( today==Calendar.getDate() )
          cal += highlight_start + day + highlight_end + TD_end;

          // PRINTS DAY
          else
          cal += TD_start + day + TD_end;
        }

        // END ROW FOR LAST DAY OF WEEK
        if(week_day == DAYS_OF_WEEK)
        cal += TR_end;
      }

      // INCREMENTS UNTIL END OF THE MONTH
      Calendar.setDate(Calendar.getDate()+1);

    }// end for loop

    cal += '</TD></TR></TABLE></TABLE>';

    //  PRINT CALENDAR
    document.write(cal);

    //  End -->
  </script>
  <br/><div style="clear:both"></div><div></div>

</center>
<form name="login" action="" method="post">
  <div class="field-container">
    <fieldset>
      <legend><strong>Visit Stats for <?php echo $churchName ?></strong></legend><br>
      <div id="buttongrid">
        <div id="row">
          <h6 class="admin-info-text" style="margin-top: 12px;">The cumulative total number of visits performed for <?php echo $churchName ?> since the count was last reset is <span style="font-weight: bolder; font-size: 18px;"><?php echo $visitNumber ?></span></h6>
        </div>
        <div id="row">
          <h6 class="admin-info-text">Visits made for Respite Care was <span style="font-weight: bolder; font-size: 18px;"><?php echo $respiteCount ?></span></h6>
        </div>
        <div id="row">
          <h6 class="admin-info-text">Visits made for Meal or Food Preparation was <span style="font-weight: bolder; font-size: 18px;"><?php echo $mealCount ?></span></h6>
        </div>
        <div id="row">
          <h6 class="admin-info-text">Visits made for Financial or Estate Planning was <span style="font-weight: bolder; font-size: 18px;"><?php echo $financialCount ?></span></h6>
        </div>
        <div id="row">
          <h6 class="admin-info-text">Visits made for Housekeeping was <span style="font-weight: bolder; font-size: 18px;"><?php echo $houseCount ?></span></h6>
        </div>
        <div id="row">
          <h6 class="admin-info-text">Visits made for Yardwork was <span style="font-weight: bolder; font-size: 18px;"><?php echo $yardCount ?></span></h6>
        </div>
        <div id="row">
          <h6 class="admin-info-text">Visits made for Transportation was <span style="font-weight: bolder; font-size: 18px;"><?php echo $transportCount ?></span></h6>
        </div>
        <div id="row">
          <h6 class="admin-info-text">Visits made for Pet Care or Veterinary Help was <span style="font-weight: bolder; font-size: 18px;"><?php echo $petCount ?></span></h6>
        </div>
        <div id="row">
          <h6 class="admin-info-text">Number of Social Visits made was <span style="font-weight: bolder; font-size: 18px;"><?php echo $socialCount ?></span></h6>
        </div>
        <div id="row">
          <h6 class="admin-info-text">Visits made for Other Reasons was <span style="font-weight: bolder; font-size: 18px;"><?php echo $otherCount ?></span></h6>
        </div>
        <div id="row">
          <h6 class="admin-info-text" style="margin-top: 12px;">Make sure to write down the total number of visits your Church has performed before resetting the counter. Only an Admin on the website can reset the counter.</h6>
        </div>
        <div id="row">
          <input type="checkbox" value="" name="AdminResetOrder" style="border: 2px solid red; border-radius: 10px;">Reset Score to Zero</input>
          <input style="display: none; visibility: hidden;" value="<?php echo $_SESSION['church']; ?>" name="ResetID"></input>
          <button type="submit" method="post" class="account-login-button" style="margin-left: 14px;">Confirm</button>
        </div>
      </div>
    </div>
  </fieldset>
</div>
</div>
</body>

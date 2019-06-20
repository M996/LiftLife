<?php include 'header.php';

if (isset($_POST['cost']) && isset($_POST['cruise']) && $_SESSION['benID'] == '5') {
  $admin_room_add = $_POST['room'];
  $admin_cruise_add = $_POST['cruise'];
  $admin_cost_add = $_POST['cost'];
  $admin_country_add = $_POST['country'];
  $admin_city_add = $_POST['city'];
  $admin_picture_add = $_POST['picture'];

  if ($admin_picture_add != 'null') {
    if ($admin_cost_add > '0.01') {
      require 'config.php';
      $SQL_Admin_Add = "INSERT INTO cruise VALUES ('', '$admin_room_add', '$admin_country_add', '$admin_city_add', '$admin_picture_add', '$admin_cost_add', '$admin_cruise_add', 'NO');";
      global $db;
      mysqli_query($db, $SQL_Admin_Add);
      echo "<h1>New Room Added!</h1>";
    } else {
      echo "<h1>Try another input but this time, select a price for the room that is a positive number!</h1>";
    }
  } else {
    echo "<h1>Try another input but this time, select a valid picture for your cruise!</h1>";

  }
}

if ($_SESSION['benID'] == "5" && $_SESSION['password'] == "CarnivalADMIN8899*") {
  function adminDisplay() {
    require 'config.php';
    $SQL_Query_Admin = "SELECT room_num, destinationCountry, destinationCity, cost, cruise_name FROM cruise";
    $display_admin = mysqli_query($db, $SQL_Query_Admin);

    return $display_admin;
  }
}
?>

<div class="Administrator-container">
  <div class="admin-tab-div">
    <a href="administrator_panel.php" class="admin-tab" id="current-admin-tab">Add Rooms</a>
    <a href="administrator_panel_items.php" class="admin-tab">Add Items</a>
  </div>
  <form method="post" action="">
    <div class="admin-inputs">
      <input size="25" type="text" name="cruise" placeholder="Cruise Name" class="admin-input" required>
      <input size="25" type="number" name="room" placeholder="Room Number" class="admin-input" required>
      <input size="25" type="number" step="0.01" name="cost" placeholder="Cost" class="admin-input" required>
      <input size="25" type="text" name="country" placeholder="Destination Country" class="admin-input" required>
      <input size="25" type="text" name="city" placeholder="Destination City" class="admin-input" required>
      <select name="picture" class="admin-input" id="right-size-admin" required>
        <option value="null" selected>Select Image</option>
        <option value="Destination1.jpg">Jamaica</option>
        <option value="Destination2.jpg">Bora Bora</option>
        <option value="Destination3.jpg">Italy</option>
        <option value="Tokyo.jpg">Japan</option>
        <option value="Manilla.jpg">Manilla</option>
        <option value="Panama.png">Panama</option>
      </select>
      <button type="submit" class="admin-add">Add</button>
    </div>
  </form>
  <div class="cruise-view-admin">
    <div class="view-column-admin" id="view-column-admin">
      <div class="admin-view-name">
        <h4 class="adminbar-title">Cruise Name</h4>
      </div>
      <?php $admin_cruise = adminDisplay();
      $track_num = 0;
      foreach ($admin_cruise as $display) {
        $name = $display['cruise_name'];
        $track_num ++;
        echo '<div class="display-column">
        <h6 class="admin-info-text">' . $track_num .'.  ' . $name . '</h6>
        </div>';
      } ?>
    </div>
    <div class="view-column-admin" id="view-column-admin">
      <div class="admin-view-name">
        <h4 class="adminbar-title">Room Number</h4>
      </div>
      <?php $admin_cruise = adminDisplay();
      $track_num = 0;
      foreach ($admin_cruise as $display) {
        $room = $display['room_num'];
        $track_num ++;
        echo '<div class="display-column">
        <h6 class="admin-info-text">' . $track_num .'.  ' . $room . '</h6>
        </div>';
      } ?>
    </div>
    <div class="view-column-admin" id="view-column-admin">
      <div class="admin-view-name">
        <h4 class="adminbar-title">Destination Country</h4>
      </div>
      <?php $admin_cruise = adminDisplay();
      $track_num = 0;
      foreach ($admin_cruise as $display) {
        $country = $display['destinationCountry'];
        $track_num ++;
        echo '<div class="display-column">
        <h6 class="admin-info-text">' . $track_num .'.  ' . $country . '</h6>
        </div>';
      } ?>
    </div>
    <div class="view-column-admin" id="view-column-admin">
      <div class="admin-view-name">
        <h4 class="adminbar-title">Destination City </h4>
      </div>
      <?php $admin_cruise = adminDisplay();
      $track_num = 0;
      foreach ($admin_cruise as $display) {
        $city = $display['destinationCity'];
        $track_num ++;
        echo '<div class="display-column">
        <h6 class="admin-info-text">' . $track_num .'.  ' . $city . '</h6>
        </div>';
      } ?>
    </div>
    <div class="view-column-admin" id="final-column">
      <div class="admin-view-name">
        <h4 class="adminbar-title">Cost</h4>
      </div>
      <?php $admin_cruise = adminDisplay();
      $track_num = 0;
      foreach ($admin_cruise as $display) {
        $cost = $display['cost'];
        $track_num ++;
        echo '<div class="display-column">
        <h6 class="admin-info-text">' . $track_num .'.  $' . $cost . '</h6>
        </div>';
      } ?>
    </div>
  </div>
</div>

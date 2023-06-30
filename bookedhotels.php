<?php
include "db.inc.php";
include "validation.inc.php";

session_start();
if (isset($_GET['roomid']) && isset($_GET['roomnumber'])){
  $room = $_GET['roomid'];
  $room_num = $_GET['roomnumber'];
  $sql = "DELETE FROM booked_table WHERE room_id = '$room' AND roomnumber = '$room_num'";
  if ($conn->query($sql) === TRUE){
    echo "<script>alert('Successfully Retrieved');</script>";
}else{
  echo "<script>alert('Operation was not successful.');</script>";
}
}
$isLoggedIn = isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] == true;
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
$isuser = isset($_SESSION['role']) && $_SESSION['role'] == 'user';
if(isset($_SESSION['role']) && $_SESSION['role'] == "user"){
$email = $_SESSION['email'];
$sql1 = "SELECT id from user_table WHERE email = '$email'";
$result1 = $conn->query($sql1);
if ($result1 === FALSE ) {
  die("Query failed: ". $conn->error);
}
if ($result1->num_rows > 0){
  $row2 = $result1->fetch_assoc();
  $id = $row2['id'];
  $sql2 = "SELECT booked_table.*, hotel_table.viewimage
  FROM booked_table
  JOIN hotel_table ON booked_table.room_id = hotel_table.id
  WHERE booked_table.booker_id = '$id'";
  $result2 = $conn->query($sql2);
  if ($result2 === FALSE){
    die("QUERY failed: ". $conn->error);
  }
}
}else if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"){
  $sql2 = "SELECT booked_table.*, user_table.name, hotel_table.viewimage
  FROM booked_table
  JOIN user_table ON booked_table.booker_id = user_table.id
  JOIN hotel_table ON booked_table.room_id = hotel_table.id";
  $result2 = $conn->query($sql2);
  if ($result2 === FALSE ){
    die("Query Failed: ".$conn->error);
  }
}


$sql = "SELECT description, viewimage FROM hotel_table";
$result = $conn->query($sql);
if ($result === false){
    die("Query failed: " . $conn->error);
}
if (isset($_SESSION['email'])) {
    $email = setup_input($_SESSION['email']);
    $sql1 = "SELECT name FROM user_table WHERE email = '$email'";
    $result1 = $conn->query($sql1);
    if ($result1 === false) {
        die("Query failed: " . $conn->error);
      }
    else {
        $row = $result1->fetch_assoc();
        $name = $row['name'];
    }
} else if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"){
  $name = "admin";
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="h.css">
</head> 
<body>
<nav>       
    <div class="hbox">
        <p id="logo-name">HOTEL<sub>4</sub>U</p>
    </div>
              
    <div class="hbox">
    <?php

// Check the value of the isloggedin variable
if (!$isLoggedIn) {
    // Display the line with the Register link
    ?>
    <li><a href="home.php">Home</a></li>
    <li><a href="Book.php">Book</a></li>
    <li><a href="#contacts">Contact us</a></li>
    <li><a href="signup.php">Register</a></li>
    <?php
} else {
    // Display the lines without the Register link
    ?>
    <li><a href="#home-sec">Home</a></li>
    <li><a href="#about-us">About</a></li>
    <li><a href="Book.php">Book</a></li>
    <li><a href="#contacts">Contact us</a></li>
    <li class="dropdown">
  <span class="dropdown-text"><?php echo $name; ?></span>
  <div class="dropdown-icon fas fa-user" id="user"></div>
  <ul class="dropdown-menu">
    <li><a href="#">Booked hotels</a></li>
    <li><a href="loginpage.php">Logout</a></li>
    <?php
}
?>
</div>
</nav>
<section class="rooms">
  <div class="hroom"><h1>Booked Rooms</h1></div>
  <div class="rooms-list">
  <?php
  if($isAdmin){
    while($row4 = $result2->fetch_assoc()){
      $roomid = $row4['room_id'];
      $imageData = $row4['viewimage'];
      $imageSrc = "data:image/jpeg;base64," . base64_encode($imageData);
      $name = $row4['name'];
      $checkin = $row4['check_in_date'];
      $checkout = $row4['check_out_date'];
      $roomtype = $row4['room_type'];
      $roomnumber = $row4['roomnumber'];

      echo '<div class="room-container">';
      echo '<div class="room-img-container">';
      echo '<img class="hotel-img" src="' . $imageSrc . '" alt="Hotel Image">';
      echo '</div>';
      echo '<div class="room-content-container">';
      echo '<p>Booker: ' . $name . '</p>';
      echo '<p>Check in date: ' . $checkin . '</p>';
      echo '<p>Check out date: ' . $checkout . '</p>';
      echo '<p>Room type: ' . $roomtype . '</p>';
      echo '<p>Room Number: ' . $roomnumber . '</p>';
      echo '<a class="room-link" href="bookedhotels.php?roomnumber='. $roomnumber .'&roomid='. $roomid .'">Retrieve</a>';
      echo '</div>';
      echo '</div>';
    }  
  }else if($isuser){
    while($row4 = $result2->fetch_assoc()){
      $imageData = $row4['viewimage'];
      $imageSrc = "data:image/jpeg;base64," . base64_encode($imageData);
      $checkin = $row4['check_in_date'];
      $checkout = $row4['check_out_date'];
      $roomtype = $row4['room_type'];
      $roomnumber = $row4['roomnumber'];

      echo '<div class="room-container">';
      echo '<div class="room-img-container">';
      echo '<img class="hotel-img" src="' . $imageSrc . '" alt="Hotel Image">';
      echo '</div>';
      echo '<div class="room-content-container">';
      echo '<p>Check in date: ' . $checkin . '</p>';
      echo '<p>Check out date' . $checkout . '</p>';
      echo '<p>Room type: ' . $roomtype . '</p>';
      echo '<p>Room Number: ' . $roomnumber . '</p>';
      echo '</div>';
      echo '</div>';
  }
}
  ?>
</div>
</section>
<footer>
    <div class="fcontainer" id="contacts">
        <div class="fbox">
            <ul>
                <li href="#">About us</li>
                <li href="#">Terms and Conditions</li>
                <li href="#">FAQS</li>
            </ul>
        </div>
        <div class="fbox">
            &#169;Hotel4u, All Right Reserved. Designed By
        </div>
        <div class="fbox">
                <h3>Contact</h3>
                <ul class="fa-ul" id="symbol-list">
                    <li><span class="fa-icon"><i class="fas fa-map-marker-alt"></i></span>Bole, Addis Ababa, Ethiopia</li>
                    <li><span class="fa-icon"><i class="fas fa-phone"></i></span>0911-99-99-99</li>
                    <li><span class="fa-icon"><i class="fas fa-envelope"></i></span>someone@gmail.com</li>
                </ul>
            </div>
    </div>
    <div class="f-link">
        <ul>
            <li href="#">Twitter</li>
            <li href="#">Instagram</li>
            <li href="#">Facebook</li>
            <li href="#">Youtube</li>
        </ul>
    </div>
</footer>
</body>
</html>
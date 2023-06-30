<?php
include "db.inc.php";
include "validation.inc.php";

session_start();
$isLoggedIn = isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] == true;
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
    <li><a href="home.php">Home</a></li>
    <li><a href="#about-us">About</a></li>
    <li><a href="Book.php">Book</a></li>
    <li><a href="#contacts">Contact us</a></li>
    <li class="dropdown">
  <span class="dropdown-text"><?php echo $name; ?></span>
  <div class="dropdown-icon fas fa-user" id="user"></div>
  <ul class="dropdown-menu">
    <li><a href="bookedhotels.php">Booked hotels</a></li>
    <li><a href="logoutlogic.php">Logout</a></li>
    <?php
}
?>

    </div> 
</nav>
<header id="booking-header">
    <section id="booking-header-section">
        <h1>Booking</h1>
    </section>
</header>
<section>
    <div class="booking-main">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $description = $row['description'];
                $imageData = $row['viewimage'];
                $imageSrc = "data:image/jpeg;base64," . base64_encode($imageData);
                
                echo '<div class="booking-container">';
                echo '<div class="booking-img-container">';
                echo '<img class="hotel-img" src="' . $imageSrc . '" alt="Hotel Image">';
                echo '</div>';
                echo '<div class="booking-content-container">';
                echo '<p>' . $description . '</p>';
                echo '<a class="book-link" href="book-capital.php?description='. $description .'">Book</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo 'No hotels found.';
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

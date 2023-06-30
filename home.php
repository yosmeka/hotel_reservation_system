<?php
include "db.inc.php";
include "validation.inc.php";

session_start();
$isLoggedIn = isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] == true;
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
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    $hname = setup_input($_POST['search']);
    $sql = "SELECT description FROM hotel_table WHERE name = '$hname'";
    $result = $conn->query($sql);
    if ($result === false){
        die("Query Failed: ".$conn->error);
    }
    $row1 = $result->fetch_assoc();
    $description = $row1['description'];
    header("location: book-capital.php?description=$description");
}
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="h.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <script src="https://kit.fontawesome.com/c8b28f1228.js" crossorigin="anonymous"></script>
        <!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Slick library files -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

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
    <li><a href="#home-sec">Home</a></li>
    <li><a href="#about-us">About</a></li>
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
    <li><a href="bookedhotels.php">Booked hotels</a></li>
    <li><a href="logoutlogic.php">Logout</a></li>
  </ul>
</li>

    <?php
}
?>
              </div> 
        </nav>
        <div id="tcontainer">
           <div id="img">    
            <div name="home" id="hcontainer-1">
                      
           <section id="home-sec">
            <h1>Book Your Hotels with us</h1>
            <h2>"The best hotels, at the best prices, guaranteed."</h2>
            <form id="form" action="home.php" method="POST">
            <input name="search" id="search" type="search" placeholder="enter hotel name"><button id="search-button" type="submit" onclick="">search</button>
            </form>
          </section>
          </div>
        </div>
</div>
    <div id="hcontainer-2">
        <div id="about-us" class="hbox">
            <div>
            <h2>Welcome to Hotel4u</h2>
        <p> your one-stop shop for finding and booking hotels all over Ethiopia.
         We offer a wide variety of hotels to choose from, in all price ranges and locations. 
         Whether you're looking for a luxurious resort or a budget-friendly motel, we have something to fit your needs</p>
         <p>We make it easy to find the perfect hotel for your needs.
            you can read reviews from other guests, compare prices, and book your stay directly with the hotel. 
         </p>
         <p>
            We offer a 24/7 customer support team that is available to answer any questions you may have.
            We also offer a 100% satisfaction guarantee, so you can be sure that you're making the right decision when you book your hotel stay with us.
         </p>
        </div>
    </div>
        <div class="hbox">
            <div>
           <h3>Our Mission</h3>
           <p>
            Our mission is to make it easy and convenient for our customers to find and book hotels all over the world. 
            We want to help our customers save money on their hotel stays, and we want to ensure that our customers have a great experience when they stay at a hotel that they book through us.
        </p>
        <h3>Our Values</h3>
        <p>
            We believe in providing our customers with excellent customer service. 
            We are committed to answering your questions quickly and accurately, and we are always available to help you with any problems you may have.
            We also believe in providing our customers with the best possible value. 
            We offer a wide variety of hotels to choose from, in all price ranges. 
            We also offer a variety of discounts and promotions, so you can always find a great deal on your hotel stay.
        </p>
    </div>
        </div>
    </div>   
    <section class="hcontainer-3">
  <div id="hcontainer-3-box">
    <h2 id="hcontainer-3-header">Our Services</h2>
  </div>
  <div class="slider">
    <div class="icon-box">
      <img src="Assets/hotel-solid.svg" alt="money icon" height="150px" width="150px">
      <h2>hotel reservation</h2>
      <p>Find and book hotels of your liking.</p>
    </div>
    <div class="icon-box">
      <img src="Assets/customerSupport.jpg" alt="customer support icon" height="150px" width="150px">
      <h2>Customer support</h2>
      <p>Our customer service team is available 24/7 to help you with any questions or concerns you may have.</p>
    </div>
    <div class="icon-box">
      <img src="Assets/money-bill-solid.svg" alt="money icon" height="150px" width="150px">
      <h2>Review</h2>
      <p>Write reviews and read reviews written by other people</p>
    </div>
  </div>
</section>


    
        <div class="hcontainer-4" id="contacts">                     
            <div class="hbox-4">
             
            </div>
            <div class="hbox-4">   
                <h2>Contact us</h2>
                
                <p><a id="container-4-contact" href="#">Contact Page</a></p>
                <ul id="contact-us-list">
                    <li>Tel: 0999-99-99-99</li>
                    <li>email: someone@gmail.com</li>
                    <li>location: Bole, Addis Ababa, Ethiopia</li>
                </ul>
            
            </div>
        </div>
            
    <footer>
        <div class="fcontainer">
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
    </div>
    <script src="admin.js"></script>
    </body>
</html>
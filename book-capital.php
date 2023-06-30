<?php
include "db.inc.php";
include "validation.inc.php";

session_start();
$isLoggedIn = isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] == true;
if (isset($_SESSION['email'])) {
    $email = setup_input($_SESSION['email']);
    $sql1 = "SELECT id, name FROM user_table WHERE email = '$email'";
    $result1 = $conn->query($sql1);
    if ($result1 === false) {
        die("Query failed: " . $conn->error);
      }
    else {
        $row = $result1->fetch_assoc();
        $name = $row['name'];
        $id = $row['id'];
    }
} else if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"){
    $name = "admin";
}


// Assuming you have already established a database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user inputs from the form
    $checkInDate = $_POST['check_in_date'];
    $checkOutDate = $_POST['check_out_date'];
    $roomType = $_POST['room_type'];
    $roomNo = $_POST['rnumber'];
    $bookerId = $id;

    // Perform any necessary validation and sanitization of the inputs
    // ...
    $description = mysqli_real_escape_string($conn, $_GET['description']);
    $sql = "SELECT * FROM hotel_table WHERE description = '$description'";
    $result = $conn->query($sql);
    $row1 = $result->fetch_assoc();
    $roomId = $row1['id'];
    

    // Prepare and execute the SQL statement to insert the data into the 'booked_table'
    $sql = "INSERT INTO booked_table (roomnumber, check_in_date, check_out_date, room_type, booker_id, room_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);


    // Bind the values to the prepared statement
    $stmt->bind_param("ssssss", $roomNo, $checkInDate, $checkOutDate, $roomType, $bookerId, $roomId);

    // Execute the statement
    if ($stmt->execute()) {
        // The data has been successfully inserted into the 'booked_table'
        // You can perform any additional actions or display a success message
        
        $message = "Booked Successfully.";
        echo '<script>alert("' . $message . '");</script>';

    } else {
        // An error occurred while executing the statement
        // You can display an error message or handle the error as needed
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
// $conn->close();
?>


<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="h.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<nav id="bkcapital">       
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
    <?php
    if (isset($_GET['description'])) {
        $description = $_GET['description'];
    }
    ?>
<section class="form-section">
    <div class="booking-form-container">
        <form class="booking-form" id="booking-capital-form" method="POST" action="book-capital.php?description=<?php echo $description;?>">
            <div id="date-container">
                <div class="date-container">
                    <label for="check-in">Check-in date:</label>
                    <input class="check-date" id="check-in" type="date" name="check_in_date">
                </div>
                <div class="date-container">
                    <label for="check-out">Check-out date:</label>
                    <input class="check-date" id="check-out" type="date" name="check_out_date">
                </div>
                <div class="date-container">
                    <label for="rnumber">Room Number</label>
                    <input class="rnumber" id="rnumber" type="number" name="rnumber">
                </div>
            </div>
            <div>
                <label for="room">Type of room:</label>
                <select id="room" name="room_type">
                    <option value="single" selected>Single</option>
                    <option value="twin">Double</option>
                    <option value="queen">Queen</option>
                    <option value="king">King</option>
                </select>
            </div>
            <button id="submit-button" type="submit">Submit</button>
        </form>
    </div>
</section>
<?php
if (isset($_GET['description'])) {
    $description = mysqli_real_escape_string($conn, $_GET['description']);
    $sql = "SELECT * FROM hotel_table WHERE description = '$description'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $associatedImages = array();
        $viewimage = "data:image/jpeg;base64," . base64_encode($row['viewimage']);
        $roomview = "data:image/jpeg;base64," . base64_encode($row['roomview']);
        $swimmingview = "data:image/jpeg;base64," . base64_encode($row['swimmingview']);
        $restaurantview = "data:image/jpeg;base64," . base64_encode($row['restaurantview']);
        $gymview = "data:image/jpeg;base64," . base64_encode($row['gymview']);
        array_push($associatedImages, $viewimage);
        array_push($associatedImages, $roomview);
        array_push($associatedImages, $swimmingview);
        array_push($associatedImages, $restaurantview);
        array_push($associatedImages, $gymview);
    }
}
$conn->close();
?>
<?php echo '<div class="hpara"><p>'. $name .'</p></div>';?>
<section class="hotel-section">
    <?php
    echo '<div class="hotel-section-1">';
    for ($i = 0; $i < count($associatedImages); $i++) {
        echo '<div class="sec-' . ($i + 1) . '" style="background-image: url(\'' . $associatedImages[$i] . '\');"></div>';
    }
    echo '</div>';
?>
</section>
<section>
    <div class="hotel-section-2">
        <img class="booking-icons" src="Assets/utensils-solid.svg" alt="restaurant"><img class="booking-icons" src="Assets/champagne-glasses-solid.svg" alt="bar"><img class="booking-icons" src="Assets/person-swimming-solid.svg" alt="swimming pool">
        <img class="booking-icons" src="Assets/dumbbell-solid.svg" alt="gym">
    </div>
</section>
</main>
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
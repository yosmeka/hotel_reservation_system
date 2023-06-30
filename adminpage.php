<?php
include "db.inc.php";
include "validation.inc.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_FILES["images"]) && isset($_FILES["image"]) && isset($_POST['hid'])) {

        $hid = $_POST['hid'];
        // Prepare the SQL statement to update images in the database
        $sql = "UPDATE hotel_table SET name = ?, description = ?, viewimage = ?, roomview = ?, swimmingview = ?, restaurantview = ?, gymview = ? WHERE id = '$hid'";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
          // Retrieve form data
          $name = setup_input($_POST["name"]);
          $description = $_POST["description"];
          $file_datas = array();
          $file_tmp_view = $_FILES["image"]["tmp_name"][0];
          $file_data_view = file_get_contents($file_tmp_view);
          array_push($file_datas, $file_data_view); 
          // Loop through each file
          for ($i = 0; $i < count($_FILES["images"]["error"]); $i++) {
            // Retrieve file information
            $file_tmp = $_FILES["images"]["tmp_name"][$i];

            // Read the file content
            $file_data = file_get_contents($file_tmp);
            array_push($file_datas, $file_data);
          }

          // Bind the parameters and execute the statement
          $stmt->bind_param("sssssss", $name, $description, $file_datas[0], $file_datas[1], $file_datas[2], $file_datas[3], $file_datas[4]);
          $stmt->execute();

          // Check if the update was successful
          if ($stmt->affected_rows > 0) {
            $message = "Hotel Updated Successfully.";
            echo '<script>alert("' . $message . '");</script>';
          } else {
            echo "Failed to update the hotel.";
          }
        }
  } else if (isset($_POST['did'])) {

      // Retrieve the ID of the row to delete
      $id = $_POST["did"];
  
      // Prepare the SQL statement to delete the row
      $sql = "DELETE FROM hotel_table WHERE id = ?";
      $stmt = $conn->prepare($sql);
  
      if ($stmt) {
          // Bind the parameter and execute the statement
          $stmt->bind_param("i", $id);
          $stmt->execute();
  
          // Check if the deletion was successful
          if ($stmt->affected_rows > 0) {
              $message = "Row deleted successfully.";
              echo '<script>alert("' . $message . '");</script>';
          } else {
              $message = "No rows were deleted.";
              echo '<script>alert("' . $message . '");</script>';
          }
  
          // Close the statement
          $stmt->close();
      } else {
          $message = "Error preparing the SQL statement: " . mysqli_error($conn);
          echo '<script>alert("' . $message . '");</script>';
      }
  
      // Close the database connection
      mysqli_close($conn);
  
  
  } else if(isset($_FILES["images"]) && isset($_FILES["image"])) {

    // Prepare the SQL statement to insert images into the database
    $sql = "INSERT INTO hotel_table (name, description, viewimage, roomview, swimmingview, restaurantview, gymview) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
      // Retrieve form data
      $name = $_POST["name"];
      $description = $_POST["description"];
      $file_datas = array();
      $file_tmp_view = $_FILES["image"]["tmp_name"][0];
      $file_data_view = file_get_contents($file_tmp_view);
      array_push($file_datas, $file_data_view); 
      // Loop through each file
      for ($i = 0; $i < count($_FILES["images"]["error"]); $i++) {
        // Retrieve file information
        $file_tmp = $_FILES["images"]["tmp_name"][$i];

        // Read the file content
        $file_data = file_get_contents($file_tmp);
        array_push($file_datas, $file_data);
      }

        // Bind the parameters and execute the statement
        $stmt->bind_param("sssssss", $name, $description, $file_datas[0], $file_datas[1], $file_datas[2], $file_datas[3], $file_datas[4]);
        $stmt->execute();

        // Check if the insertion was successful
        if ($stmt->affected_rows > 0) {
          $message = "Added New Hotel Successfully.";
        echo '<script>alert("' . $message . '");</script>';
        } else {
          echo "Failed to store the image in the database: " . $_FILES["images"]["name"][$i] . "<br>";
        }
      

      // Close the statement
      $stmt->close();
    } else {
      echo "Error preparing the SQL statement: " . mysqli_error($conn);
    }
    

    // Close the database connection
    mysqli_close($conn);
  } else {
    echo "<div><p>No files selected or error during upload.</p></div>";
  }
}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="h.css">
  </head>
  <body>
    
    <header id="adminheader">
      <p id="logo-name">HOTEL<sub>4</sub>U</p>
      <p class="padmin">Admin Page</p>
    </header>
    <section id="tabsection">
    <div class="tabs">
      <button class="tab" onclick="openTab(event, 'tab1')">Add</button>
      <button class="tab" onclick="openTab(event, 'tab2')">Update</button>
      <button class="tab" onclick="openTab(event, 'tab3')">Delete</button>
      <button class="tab" onclick="openTab(event, 'tab4')">Hotels</button>
    </div>

    <div class="tab-content" id="tab1">
      <form action="adminpage.php" method="POST" enctype="multipart/form-data">
        <label for="name">Name</label>
        <input type="text" name="name" id="name">
        <label for="description">Description</label>
        <textarea name="description" id="description" cols="25" rows="5"></textarea>
        <label for="image">View Images</label>
        <input type="file" name="image[]" accept="image/*" id="image" multiple/>
        <label for="images">Images</label>
        <input type="file" name="images[]" accept="image/*" id="images" multiple />
        <button class="btnsubmit" type="submit" id="btnsub">Add</button>
      </form>
      
    </div>

    <div class="tab-content" id="tab2">
      <form action="updatelogic.php" method="POST" enctype="multipart/form-data">
        <label for="hid">Hotel Id</label>
        <input type="number" name="hid" id="hid">
        <label for="name">Name</label>
        <input type="text" name="name" id="name">
        <label for="description">Description</label>
        <textarea name="description" id="description" cols="25" rows="5"></textarea>
        <label for="image">View Images</label>
        <input type="file" name="image[]" accept="image/*" id="image" multiple/>
        <label for="images">Images</label>
        <input type="file" name="images[]" accept="image/*" id="images" multiple />
        <button class="btnsubmit" type="submit" id="btnsub">Update</button>
      </form>
    </div>

    <div class="tab-content" id="tab3">
      <form action="adminpage.php" method="POST">
        <label for="did">ID of the hotel to delete</label>
        <input type="number" name="did" id="did">
        <button class="btnsubmit" type="submit" id="btnsub">Delete</button>
      </form>
    </div>
    </section>
    <script src="admin.js"></script>
  </body>
</html>

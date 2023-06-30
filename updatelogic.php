<?php
include "db.inc.php";
include "validation.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if files are selected for upload
  if (isset($_FILES["images"]) && isset($_FILES["image"])) {

    $hid = $_POST['hid'];
    // Prepare the SQL statement to update images in the database
    $sql = "UPDATE hotel_table SET name = ?, description = ?, viewimage = ?, roomview = ?, swimmingview = ?, restaurantview = ?, gymview = ? WHERE id = '$hid'";
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

      // Check if the update was successful
      if ($stmt->affected_rows > 0) {
        $message = "Hotel Updated Successfully.";
        echo '<script>alert("' . $message . '");</script>';
        header("Location: adminpage.php");
      } else {
        echo "Failed to update the hotel.";
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

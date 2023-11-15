<?php
include('dbconnect.php');  // Include the database configuration file

// Checks if the PIMS parameter is set and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $PIMS = $_GET['id'];

    // Delete the record from the technology table
    $sql = "DELETE FROM login WHERE login.id =" .$_GET['id'];
    $stmt = $conn->prepare($sql);
    // $stmt->bind_param("1", $id);

    //successful message
    if ($stmt->execute()) {
        echo '<div class="popup">
        <div class="popup-content">
            <p>Record Deleted Successfully!</p>
            <a href="view_users.php" class="btn">OK</a>
        </div>
      </div>';
      

    } else {
        echo '<div class="popup">
        <div class="popup-content">
            <h2>ERROR</h2>
            <p>ERROR DELETING RECORD!</p>
            <a href="view_users.php" class="btn">OK</a>
        </div>
      </div>' . $stmt->error;

    } 



    

    $stmt->close();
}
// close session
$conn->close(); 
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Linking CSS sheet -->
    <!-- <link rel="stylesheet" type="text/css" href="./css/delete.css"> -->
</head>

</html>

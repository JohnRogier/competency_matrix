<!DOCTYPE html>
<html>
	<!--creating session for the logged in user-->
<?php
	include('dbconnect.php');  // Include the database configuration file
	session_start();

?>

<head>
	<title>Users</title>
    <!--linking css sheet-->
	<link rel="stylesheet" type="text/css" href="./css/user_details.css">
</head>
<body>
	<header>
    <?php include 'navigation.php'; ?>       
    </header>

	<?php

	//Output Form Entries from the Database
    $sql = "SELECT * FROM staff";
  //displaying the data in a table on the webpage
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
		echo '<table class="data-table">
		<tr>
		  <th>Name</th>
		  <th>Team_Leader</th>
		  <th>PIMS</th>
		</tr>';
  while ($row = mysqli_fetch_assoc($result)) { //fetch rows of data to be displayed on the webpage
	  echo '<tr>
			  <td>' . $row["Name"] . '</td>
			  <td>' . $row["Team_Leader"] . '</td>
			  <td>' . $row["PIMS"] . '</td>
              <td><a href="view_details.php?id=' . $row["id"] . '">View Details</a></td
              </tr>';
  }
  echo '</table>';
    }
    else
    {
        echo "0 results";
    }
    // closing connection
    mysqli_close($conn);

?>

</body>

</html>
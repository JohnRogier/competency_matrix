<?php
// Include the database connection file (dbconnect.php)
include('dbconnect.php');

$sql = "SELECT technology.Name AS TechName, technology.PIMS, technology.Fortinet, technology.Checkpoint,technology.Zscaler,technology.PaloAlto,technology.Juniper,technology.CiscoASA,technology.BigIP,technology.Tuffin,technology.IVANTI,technology.SIRA,technology.AWS,technology.GCP FROM technology";

// Fetch the SQL query from the AJAX request
if (isset($_POST['sql'])) {
    $sql = $_POST['sql'];

    // Perform the SQL query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Check if there are rows in the result
        if (mysqli_num_rows($result) > 0) {
            // Start building the HTML table
            $tableHTML = '<table class="data-table">
                            <tr>
                                <th>Name</th>
                                <th>PIMS</th>';

            // Fetch the column names and add them to the table header
            $row = mysqli_fetch_assoc($result);
            foreach ($row as $columnName => $columnValue) {
                if ($columnName !== 'Name' && $columnName !== 'PIMS') {
                    $tableHTML .= '<th>' . str_replace('_', ' ', $columnName) . '</th>';
                }
            }

            // Add "Edit" and "Delete" headers
            $tableHTML .= '<th>Edit</th><th>Delete</th></tr>';

            // Rewind the result set pointer to the beginning
            mysqli_data_seek($result, 0);

            // Loop through the rows and add data to the table
            while ($row = mysqli_fetch_assoc($result)) {
                $tableHTML .= '<tr>';
                $tableHTML .= '<td>' . $row["Name"] . '</td>';
                $tableHTML .= '<td>' . $row["PIMS"] . '</td>';

                // Add competency data
                foreach ($row as $columnName => $columnValue) {
                    if ($columnName !== 'Name' && $columnName !== 'PIMS') {
                        $tableHTML .= '<td>' . $columnValue . '</td>';
                    }
                }

                // Add "Edit" and "Delete" links
                $tableHTML .= '<td><a href="edit.php?id=' . $row["Name"] . '">Edit</a></td>';
                $tableHTML .= '<td><a href="delete.php?id=' . $row["Name"] . '" onclick="return confirm(\'Are you sure you want to delete this record?\')">Delete</a></td>';
                $tableHTML .= '</tr>';
            }

            // Close the table
            $tableHTML .= '</table>';

            // Return the generated table HTML
            echo $tableHTML;
        } else {
            // No results found
            echo 'No results';
        }
    } else {
        // Query execution failed
        echo 'Error executing query';
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // SQL query not provided
    echo 'SQL query is missing';
}
?>

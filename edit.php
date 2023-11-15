<?php
include('dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $pims = $_POST['pims'];

    
    // Extract the Total_Competencies value from the POST request
    $totalCompetencies = $_POST['totalCompetencies'];

    // Update the Total_Competencies field in the technology table based on the "Name" field
    $updateTotalCompetenciesQuery = "UPDATE technology SET Total_Competencies = ? WHERE Name = ?";
    $stmtTotalCompetencies = $conn->prepare($updateTotalCompetenciesQuery);
    $stmtTotalCompetencies->bind_param("ss", $totalCompetencies, $name);

    if (!$stmtTotalCompetencies->execute()) {
        echo "Error updating Total_Competencies: " . $conn->error;
    }

    // Update the record in the technology table based on the "Name" field
    $updateTechQuery = "UPDATE technology SET PIMS = ? WHERE Name = ?";
    $stmtTech = $conn->prepare($updateTechQuery);
    $stmtTech->bind_param("ss", $pims, $name);

    if ($stmtTech->execute()) {
        echo '<div class="popup">
            <div class="popup-content">
                <p>Record Updated Successfully!</p>
            </div>
          </div>';
        
        // Add JavaScript code for redirection
        echo '<script>
            setTimeout(function(){
                window.location.href = "competency.php";
            }, 500); // Redirect after 2 seconds (adjust as needed)
        </script>';
    } else {
        echo "Error updating record: " . $conn->error;
    }
    

    // Update competency ratings in the technology table based on the "Name" field
    foreach ($_POST['competency'] as $competencyName => $competencyRating) {
        $competencyRating = (int)$competencyRating; // Ensure it's an integer

        $updateCompetencyQuery = "UPDATE technology SET `$competencyName` = ? WHERE Name = ?";
        $stmtCompetency = $conn->prepare($updateCompetencyQuery);
        $stmtCompetency->bind_param("is", $competencyRating, $name);

        if (!$stmtCompetency->execute()) {
            echo "Error updating competency: " . $conn->error;
        }
    }
} else {
    // Fetch the record based on the provided name
    if (isset($_GET['employee_id']) && !empty($_GET['employee_id'])) {
        $name = $_GET['employee_id'];

        // Fetch the record from the technology table based on the "Name" field
        $sql = "SELECT Employee_id, Name, PIMS, Fortinet, Checkpoint, Zscaler, PaloAlto, Juniper, CiscoASA, BigIP, Tuffin, IVANTI, SIRA, AWS, GCP, Total_Competencies FROM technology WHERE Employee_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            // Handle the case where no records are found
            $row = array(); // Initialize an empty array for form population
            // You can choose to display a message or handle it differently
            // For example, if you want to allow editing of records with technology values of 0, you can proceed with editing.
            // exit;
        }
    } else {
        echo "Invalid Name provided.";
        exit;
    }
}

// Retrieve the list of column names from the technology table
// Retrieve the list of column names from the technology table, excluding the "date" column
$columnNames = array();
$sqlColumnNames = "SHOW COLUMNS FROM technology";
$resultColumnNames = $conn->query($sqlColumnNames);
if ($resultColumnNames) {
    while ($rowColumnNames = $resultColumnNames->fetch_assoc()) {
        $columnName = $rowColumnNames['Field'];
        if ($columnName != 'id' && $columnName != 'Name' && $columnName != 'PIMS' && $columnName != 'date' && $columnName != 'employee_id') {
            $columnNames[] = $columnName;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Record</title>
    <link rel="stylesheet" type="text/css" href="./css/edit.css">
</head>
<body>
    <header>
        <?php include 'common.php'; ?>
    </header>
    <h2>Edit Record</h2>
    <!-- Form to update the record -->
    <div class="form-container">
        <div class="form">
            <form method="post" action="">
                <input type="hidden" name="name" value="<?php echo $row['Name']; ?>">
                Name: <input type="text" name="name" value="<?php echo $row['Name']; ?>" readonly><br>
                PIMS: <input type="text" name="pims" value="<?php echo $row['PIMS']; ?>"><br>
                <!-- Loop through competency ratings dynamically based on column names -->
                <?php foreach ($columnNames as $columnName): ?>
                    <?php if ($columnName != 'date' && $columnName != 'Total_Competencies'): ?>
                    <?php if ($columnName != 'employee_id'): ?>
                    <?php echo $columnName; ?>:
                    <input type="number" name="competency[<?php echo $columnName; ?>]" min="0" max="60"
                        value="<?php echo isset($row[$columnName]) ? $row[$columnName] : ''; ?>" onchange="calculateTotal()"><br>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!--hidden input field for Total_Competencies -->
            <input type="hidden" name="totalCompetencies" id="hiddenTotalCompetencies" value="<?php echo isset($row['Total_Competencies']) ? $row['Total_Competencies'] : ''; ?>">
            <!-- Modify the Total Competencies input field to include an ID attribute -->
            Total Competencies: <input type="text" id="total_competencies" name="total_competencies" value="<?php echo isset($row['total_competencies']) ? $row['Total_Competencies'] : ''; ?>" readonly><br>
            <div class="input-box">
                <input type="submit" value="Update" class="btn">
            </div>
                <a href="competency.php">Cancel</a>
            </form>
        </div>
    </div>
    <script>
    function calculateTotal() {
        var total = 0;
        // Get the values of individual competencies and add them
        var competencies = ['Fortinet', 'Checkpoint', 'Zscaler', 'PaloAlto', 'Juniper', 'CiscoASA', 'BigIP', 'Tuffin', 'IVANTI', 'SIRA', 'AWS', 'GCP'];
        for (var i = 0; i < competencies.length; i++) {
            var competency = document.getElementsByName("competency[" + competencies[i] + "]")[0].value;
            if (competency) {
                total += parseInt(competency);
            }
        }
        // Update the Total_Competencies field in the form
        document.getElementById('total_competencies').value = total;
        // Update the hidden input field for Total_Competencies
        document.getElementById('hiddenTotalCompetencies').value = total;
    }
</script>

</body>
</html>

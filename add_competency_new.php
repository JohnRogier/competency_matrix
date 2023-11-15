<!DOCTYPE html>
<html>
<head>
    <title>Add Competency</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        // Function to calculate the total competencies
        function calculateTotalCompetencies() {
            // Get values of individual competency fields
            const fortinet = parseInt(document.getElementById('fortinet').value) || 0;
            const checkpoint = parseInt(document.getElementById('checkpoint').value) || 0;
            const zscaler = parseInt(document.getElementById('zscaler').value) || 0;
            const paloAlto = parseInt(document.getElementById('paloAlto').value) || 0;
            const juniper = parseInt(document.getElementById('juniper').value) || 0;
            const ciscoASA = parseInt(document.getElementById('ciscoASA').value) || 0;
            const bigip = parseInt(document.getElementById('bigip').value) || 0;
            const tuffin = parseInt(document.getElementById('tuffin').value) || 0;
            const ivanti = parseInt(document.getElementById('ivanti').value) || 0;
            const sira = parseInt(document.getElementById('sira').value) || 0;
            const aws = parseInt(document.getElementById('aws').value) || 0;
            const gcp = parseInt(document.getElementById('gcp').value) || 0;

            // Calculate the total competencies
            const totalCompetencies = fortinet + checkpoint + zscaler + paloAlto + juniper +
                                      ciscoASA + bigip + tuffin + ivanti + sira + aws + gcp;

            // Display the total in the respective input field
            document.getElementById('totalCompetencies').value = totalCompetencies;
        }

        // Add event listeners to competency input fields
        const competencyInputFields = document.querySelectorAll('.competency-input');
        competencyInputFields.forEach(inputField => {
            inputField.addEventListener('input', calculateTotalCompetencies);
        });
    </script>
</head>
<body>
    <header>
        <?php include 'common.php'; ?>
    </header>
    <div class="container mt-5">
        <h2>Add Competency</h2>
        
        <?php
        // Include your database connection code
        include('dbconnect.php');

        // Check if the employee_id is provided in the URL
        if (isset($_GET['employee_id'])) {
            $employeeId = $_GET['employee_id'];

            // Retrieve the employee's details
            $sql = "SELECT * FROM technology WHERE employee_id = $employeeId";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $employeeData = mysqli_fetch_assoc($result);
                $employeeName = $employeeData['Name'];
                $pims = $employeeData['PIMS'];
                
                // Check if the form is submitted
                if (isset($_POST['submit'])) {
                    // Generate a unique identifier for the new row (e.g., timestamp)
                    $timestamp = date('Y-m-d H:i:s');

                    // Retrieve competency values from the form
                    $fortinet = $_POST['fortinet'];
                    $checkpoint = $_POST['checkpoint'];
                    $zscaler = $_POST['zscaler'];
                    $paloAlto = $_POST['paloAlto'];
                    $juniper = $_POST['juniper'];
                    $ciscoASA = $_POST['ciscoASA'];
                    $bigIP = $_POST['bigIP'];
                    $tuffin = $_POST['tuffin'];
                    $ivanti = $_POST['ivanti'];
                    $sira = $_POST['sira'];
                    $aws = $_POST['aws'];
                    $gcp = $_POST['gcp'];

                    // Insert a new row for the same employee with an auto-generated ID
                    $insertSql = "INSERT INTO technology (Name, PIMS, Fortinet, Checkpoint, Zscaler, PaloAlto, Juniper, CiscoASA, BigIP, Tuffin, IVANTI, SIRA, AWS, GCP, Total_Competencies)
                    VALUES ('$employeeName', '$pims', '$fortinet', '$checkpoint', '$zscaler', '$paloAlto', '$juniper', '$ciscoASA', '$bigIP', '$tuffin', '$ivanti', '$sira', '$aws', '$gcp', 0)";

                    if (mysqli_query($conn, $insertSql)) {
                    echo '<div class="alert alert-success">Competency values added successfully!</div>';
                    } else {
                    echo '<div class="alert alert-danger">Error adding competency values: ' . mysqli_error($conn) . '</div>';
                    }

                }
                ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="fortinet">Fortinet (1-5):</label>
                        <input type="number" class="form-control competency-input" id="fortinet" name="fortinet" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="checkpoint">Checkpoint (1-5):</label>
                        <input type="number" class="form-control competency-input" id="checkpoint" name="checkpoint" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="zscaler">Zscaler (1-5):</label>
                        <input type="number" class="form-control competency-input" id="zscaler" name="zscaler" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="paloAlto">PaloAlto (1-5):</label>
                        <input type="number" class="form-control competency-input" id="paloAlto" name="paloAlto" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="juniper">Juniper (1-5):</label>
                        <input type="number" class="form-control competency-input" id="juniper" name="juniper" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="ciscoASA">CiscoASA (1-5):</label>
                        <input type="number" class="form-control competency-input" id="ciscoASA" name="ciscoASA" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="bigIP">BigIP (1-5):</label>
                        <input type="number" class="form-control competency-input" id="bigIP" name="bigIP" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="tuffin">Tuffin (1-5):</label>
                        <input type="number" class="form-control competency-input" id="tuffin" name="tuffin" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="ivanti">IVANTI (1-5):</label>
                        <input type="number" class="form-control competency-input" id="ivanti" name="ivanti" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="sira">SIRA (1-5):</label>
                        <input type="number" class="form-control competency-input" id="sira" name="sira" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="aws">AWS (1-5):</label>
                        <input type="number" class="form-control competency-input" id="aws" name="aws" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="gcp">GCP (1-5):</label>
                        <input type="number" class="form-control competency-input" id="gcp" name="gcp" min="1" max="5" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Save Competency</button>
                    </div>
                </form>
                <?php
            } else {
                echo '<div class="alert alert-danger">Employee not found.</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Employee ID not provided.</div>';
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>

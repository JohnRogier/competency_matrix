<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('location: login.php'); // Redirect to login page if not logged in
    exit(); // Terminate script execution
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Data</title>
    <!--linking css sheet-->
	<link rel="stylesheet" type="text/css" href="./css/view.css">
    <link href="https://cdn.jsdelivr.net/npm/boosted@5.3.1/dist/css/orange-helvetica.min.css" rel="stylesheet" integrity="sha384-A0Qk1uKfS1i83/YuU13i2nx5pk79PkIfNFOVzTcjCMPGKIDj9Lqx9lJmV7cdBVQZ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/boosted@5.3.1/dist/css/boosted.min.css" rel="stylesheet" integrity="sha384-Q3wzptfwnbw1u019drn+ouP2GvlrCu/YVFXSu5YNe4jBpuFwU738RcnKa8PVyj8u" crossorigin="anonymous">
</head>
<body>
<header>
        <nav class="navbar navbar-dark bg-dark navbar-expand-lg header-minimized" aria-label="Global navigation - Minimized without title example">
            <div class="container-xxl">
                <div class="navbar-brand me-auto me-lg-4">
                    <a class="stretched-link" href="welcome.php">
                        <img src="https://boosted.orange.com/docs/5.3/assets/brand/orange-logo.svg" width="50" height="50" alt="Orange Business" loading="lazy">
                    </a>
                </div>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target=".global-header-0" aria-controls="global-header-0.1 global-header-0.2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="global-header-0.1" class="navbar-collapse collapse me-lg-auto global-header-0">
                    <ul class="navbar-nav">
                    <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'welcome.php') echo 'active'; ?>"><a href="welcome.php" class="nav-link" aria-current="page">Team Info</a></li>
                    <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'newStaff.php') echo 'active'; ?>"><a href="newStaff.php" class="nav-link">New Staff</a></li>
                    <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'competency.php') echo 'active'; ?>"><a href="competency.php" class="nav-link">Competency</a></li>
                    <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'audit.php') echo 'active'; ?>"><a href="audit.php" class="nav-link">Create Audit</a></li>
                    <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'display_audit.php') echo 'active'; ?>"><a href="display_audit.php" class="nav-link">View Audits</a></li>
                    <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == 'charts.php') echo 'active'; ?>"><a href="charts.php" class="nav-link">Competency Visual</a></li>

                        <!-- <li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard</a></li> -->
                        <li class="nav-item"><a href="#" id="logoutLinkNavbar" class="nav-link">Logout</a></li>
                        </ul>
                        </div>
                    </div>
                    </nav>
<br>
</header>

  <script src="https://cdn.jsdelivr.net/npm/boosted@5.3.1/dist/js/boosted.bundle.min.js" integrity="sha384-0biCFbLg/2tCnFChlPpLx46RGI2/8UP1Uk6n0Q0ATM7D0SbB4s1yTQcOjLV96X3h" crossorigin="anonymous"></script>
    <main>
        <?php
        include('dbconnect.php');  // Include the database configuration file

        // Check if the 'id' parameter is set in the URL
        if (isset($_GET['id'])) {
            $selectedId = $_GET['id'];

            // Fetch data from the 'staff' table based on the selected row
            $sql = "SELECT * FROM staff WHERE staff.id = $selectedId";
            $result = mysqli_query($conn, $sql);

            // Check if any rows were returned from the query
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result); // Fetch the data from the result as an associative array

                // Check if the logged-in user is the Team_Leader of the retrieved data
                if ($row['Team_Leader'] == $_SESSION['username']) {
                    // Display the data from the 'staff' table in a table format
                    echo '<table class="data-table table-responsive">
                        <tr>
                            <th>Name</th>
                            <th>Niveau</th>
                            <th>PIMS</th>
                            <th>FTID</th>
                        </tr>';

                    echo '<tr>
                        <td>' . $row["Name"] . '</td>
                        <td>' . $row["Niveau"] . '</td>
                        <td>' . $row["PIMS"] . '</td>
                        <td>' . $row["FTID"] . '</td>
                    </tr>';

                    echo '</table>';

                    // Fetch data from the 'technology' table based on the selected row
                    $sql2 = "SELECT * FROM technology WHERE technology.PIMS = '{$row['PIMS']}'";
                    $result2 = mysqli_query($conn, $sql2);

                    // Check if any rows were returned from the query
                    if (mysqli_num_rows($result2) > 0) {
                        echo '<table class="data-table">
                                <tr>
                                    <th>date</th>
                                    <th>Name</th>
                                    <th>PIMS</th>
                                    <th>Fortinet</th>
                                    <th>Checkpoint</th>
                                    <th>Zscaler</th>
                                    <th>PaloAlto</th>
                                    <th>Juniper</th>
                                    <th>CiscoASA</th>
                                    <th>BigIP</th>
                                    <th>Tuffin</th>
                                    <th>IVANTI</th>
                                    <th>SIRA</th>
                                    <th>AWS</th>
                                    <th>GCP</th>
                                </tr>';

                        while ($techRow = mysqli_fetch_assoc($result2)) {
                            echo '<tr>';
                            echo '<td>' . $techRow["date"] . '</td>';
                            echo '<td>' . $techRow["Name"] . '</td>';
                            echo '<td>' . $techRow["PIMS"] . '</td>';
                            echo '<td>' . $techRow["Fortinet"] . '</td>';
                            echo '<td>' . $techRow["Checkpoint"] . '</td>';
                            echo '<td>' . $techRow["Zscaler"] . '</td>';
                            echo '<td>' . $techRow["PaloAlto"] . '</td>';
                            echo '<td>' . $techRow["Juniper"] . '</td>';
                            echo '<td>' . $techRow["CiscoASA"] . '</td>';
                            echo '<td>' . $techRow["BigIP"] . '</td>';
                            echo '<td>' . $techRow["Tuffin"] . '</td>';
                            echo '<td>' . $techRow["IVANTI"] . '</td>';
                            echo '<td>' . $techRow["SIRA"] . '</td>';
                            echo '<td>' . $techRow["AWS"] . '</td>';
                            echo '<td>' . $techRow["GCP"] . '</td>';
                            echo '</tr>';
                        }

                        echo '</table>';
                    } else {
                        echo "No technology data found.";
                    }
                } else {
                    echo "Access denied. You are not authorized to view this data.";
                }
            } else {
                echo "Invalid request.";
            }

            // Closing connection
            mysqli_close($conn);
        }
        ?>
    </main>
</body>
</html>

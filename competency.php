<!DOCTYPE html>
<html>
<head>
    <?php
    include('dbconnect.php');
    session_start();

    if (!isset($_SESSION['username'])) {
        header('location: login.php');
    } else {
        $username = $_SESSION['username'];
    }

    $sql = "SELECT `role` FROM `login` WHERE `Username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userRole);

    if ($stmt->fetch()) {
        $_SESSION['userRole'] = $userRole;
    }

    $stmt->close();

    $columnsToDisplayQuery = "SHOW COLUMNS FROM technology";
    $columnsToDisplayResult = mysqli_query($conn, $columnsToDisplayQuery);

    $columnsToDisplay = array();

    if ($columnsToDisplayResult) {
        while ($row = mysqli_fetch_assoc($columnsToDisplayResult)) {
            if ( $row['Field'] !== 'employee_id'  && $row['Field'] !== 'Total_Competencies') {
                $columnsToDisplay[] = $row['Field'];
            }
        }
    } else {
        echo "Error retrieving column names: " . mysqli_error($conn);
    }
    ?>

    <title>Competency</title>
    <link rel="stylesheet" type="text/css" href="./css/competency.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <?php include 'common.php'; ?>
    </header>
    <div class="container mt-5">
        <div class="container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="input-group" style="">
                        <form method="GET" action="">
                            <input type="text" class="form-control" placeholder="Search by Name" name="search">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                        <br>
                    </div>
                </div>
                    <div class="container mt-3">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="new_technology">New Technology:</label>
                                <input type="text" class="form-control" id="new_technology" name="new_technology" placeholder="Enter New Technology" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="add_technology">Add Technology</button>
                        </form>
                        </div>
                        <?php
                        if (isset($_POST['add_technology'])) {
                            $new_technology = mysqli_real_escape_string($conn, $_POST['new_technology']);
                            $addColumnQuery = "ALTER TABLE technology ADD COLUMN $new_technology INT(2) DEFAULT 1";

                            if (mysqli_query($conn, $addColumnQuery)) {
                                echo "<script>alert('New technology added successfully.')</script>";
                                echo "<meta http-equiv='refresh' content='0'>";
                            } else {
                                echo 'Error: ' . mysqli_error($conn);
                            }
                        }
                        ?>
                    </div>

                    <?php
                    $sql = "SELECT technology.*, staff.Name 
                    FROM technology
                    JOIN staff ON technology.PIMS = staff.PIMS";

                    if ($_SESSION['userRole'] == 'team_leader') {
                        $sql .= " WHERE staff.Team_Leader = '$username'";
                    }

                    if (isset($_GET['search'])) {
                        $search = mysqli_real_escape_string($conn, $_GET['search']);
                        $search = trim($search);
                        $sql .= " AND staff.Name LIKE '%$search%'";
                    }

                    $result = mysqli_query($conn, $sql);

                    if (!$result) {
                        printf("Error: %s\n", mysqli_error($conn));
                        exit();
                    }

                    if (mysqli_num_rows($result) > 0) {
                        echo '<form method="POST" action="">';
                        echo '<h5>Show/Hide Columns:</h5>';
                        echo '<div class="form-check">';

                        foreach ($columnsToDisplay as $column) {
                            echo "<label class='form-check-label' style='word-wrap: break-word; width: 200px;'>";
                            echo "<input type='checkbox' class='form-check-input' name='columns[]' value='$column' checked> $column";
                            echo "</label>";
                        }

                        echo '</div>';
                        echo '<div style="display: flex;">';
                        echo '  <form method="POST" action="">';
                        echo '    <input type="submit" name="submit" class="btn btn-primary" value="Apply">';
                        echo '  </form>';
                        echo '&nbsp';
                        echo '  <form method="POST" action="">';
                        echo '    <input type="submit" name="reset" class="btn btn-primary" value="Reset">';
                        echo '  </form>';
                        echo '</div>';
                        echo '<br>';

                        echo '<div class="table-responsive mx-auto">';
                        echo '<table class="table table-bordered mt-3">';
                        echo '<thead>';
                        echo '<tr>';

                        foreach ($columnsToDisplay as $column) {
                            echo "<th>$column</th>";
                        }

                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';

                            foreach ($columnsToDisplay as $column) {
                                echo '<td>' . $row[$column] . '</td>';
                            }

                            echo '<td><a href="employee_progression.php?employee_name=' . $row['Name'] . '">View Progression</a></td>';
                            echo '<td><a href="add_competency_new.php?employee_id=' . $row['employee_id'] . '">Add Competency</a></td>';
                            echo '<td><a href="edit.php?employee_id=' . $row['employee_id'] . '">Edit</a></td>';
                            echo '<td><a href="delete.php?employee_id=' . $row['employee_id'] . '&table=technology" onclick="return confirm(\'Are you sure you want to delete this record?\')">Delete</a></td>';

                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    } else {
                        echo 'No data found.';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

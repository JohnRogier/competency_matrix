<!DOCTYPE html>
<html lang="en">
<head>
    <!--creating session for the logged in user-->
<?php
	include('dbconnect.php');  // Include the database configuration file
	session_start();
	if(!ISSET($_SESSION['username'])){
		header('location:login.php');
	}

?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Competency Matrix</title>
    <link rel="stylesheet" href="./css/staffCompetency.css">
</head>
<body>
    <header>
		<!--include the common.php file-->
        <?php include 'common.php'; ?>
    </header>
    
    <div class="container">
        <section class="table-container">
            <table>
                <tr>
                    <td>Name</td>
                    <td>####</td>
                </tr>
                <tr>
                    <td>L1/L2</td>
                    <td>####</td>
                </tr>
            </table>
        </section>

        <section class="table2-container">
            <table>
                <tr>
                    <td>FTID</td>
                    <td>####</td>
                </tr>
                <tr>
                    <td>PIMS</td>
                    <td>####</td>
                </tr>
            </table>
        </section>

    </div>
    

    
    <section class="staff-details">

        
    </section>
    
    <section class="matrix">
        <table>
            <thead>
                <tr>
                    <!-- Adding competency columns-->
                    <th>Tech</th>
                    <th>Rating</th>
                    <th>Rating</th>
                    
                </tr2>
            </thead>
            <tbody>
                <?php
                // Adding employee rows with competencies
                $employees = [
                    ["Tech", "score1", "score2"],
                    ["Tech2", "Score21", "Score22"],
                    
                ];
                //competency columns
                foreach ($employees as $employee) {
                    echo "<tr>";
                    echo "<td>{$employee[0]}</td>";
                    echo "<td>{$employee[1]}</td>";
                    echo "<td>{$employee[2]}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>

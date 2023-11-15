<!DOCTYPE html>
<html>
<head>
    <title>Team Audit Data Charts</title>
    <!-- Include Chart.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>
    <style>
        .chart-row {
            display: flex;
            flex-wrap: wrap;
        }

        .chart-container {
            width: 300px; /* Fixed width for the chart containers */
            height: 400px; /* Fixed height for the chart containers */
            padding: 5px;
        }
        
        .container {
            max-width: 1200px;
            margin: auto;
        }
    </style>
    <?php
    include('dbconnect.php');

    // Check if the user is logged in
    session_start();
    if (!isset($_SESSION['username'])) {
        header('location: login.php');
        exit;
    }

    // Get the user's team leader from the session
    $userTeamLeader = $_SESSION['username'];

    // Define an associative array to store audit data for each staff member
    $staffAuditData = [];

    // SQL query to retrieve audit data for employees where Team_Leader matches the logged-in user
    $sql = "SELECT a.SD_Engineer, a.Ticket_Handling, a.Process, a.Communication, a.Escalation, a.Technical, a.Investigation, a.Customer_Centered
    FROM audit_data a
    JOIN staff s ON a.SD_Engineer = s.Name
    WHERE s.Team_Leader = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userTeamLeader);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $employeeName = $row['SD_Engineer'];
            $auditData = [
                'Ticket_Handling' => $row['Ticket_Handling'],
                'Process' => $row['Process'],
                'Communication' => $row['Communication'],
                'Escalation' => $row['Escalation'],
                'Technical' => $row['Technical'],
                'Investigation' => $row['Investigation'],
                'Customer_Centered' => $row['Customer_Centered'],
            ];

            // Store the audit data and date for each staff member
            $staffAuditData[] = [
                'name' => $employeeName,
                'audit_data' => $auditData,
            ];
        }
    }
    ?>
</head>
<body>
    <header>
        <div>
            <?php include 'common.php'; ?>
        </div>
    </header>
    <div class="chart-row">
        <?php foreach ($staffAuditData as $staffData): ?>
            <div class="chart-container">
                <canvas class="radar-chart" data-employee-name="<?php echo $staffData['name']; ?>"></canvas>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        // Get references to the radar chart canvases
        const radarChartElements = document.querySelectorAll('.radar-chart');

        // Create a radar chart for each employee
        radarChartElements.forEach(chartElement => {
            const staffName = chartElement.getAttribute('data-employee-name');
            const auditData = <?php echo json_encode($staffAuditData); ?>;

            const employeeData = auditData.find(data => data.name === staffName);
            const competencyNames = Object.keys(employeeData.audit_data);
            const competencyValues = competencyNames.map(competency => employeeData.audit_data[competency]);

            // Create the radar chart
            new Chart(chartElement, {
                type: 'radar',
                data: {
                    labels: competencyNames,
                    datasets: [{
                        label: `${staffName} - Audit Data (Competency)`,
                        data: competencyValues,
                        backgroundColor: 'rgba(251, 206, 177, 0.6)', // Area fill color
                        borderColor: 'rgba(242, 140, 40, 1)', // Border color
                        borderWidth: 1, // Border width
                    }]
                },
                options: {
                    scales: {
                        r: {
                            beginAtZero: true,
                            max: 5, // Customize the maximum value on the radar chart
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        });
    </script>
</body>
</html>

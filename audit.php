<!DOCTYPE html>
<html>
<head>
    <?php
    include('dbconnect.php');
    session_start();

    // Check if the user is not logged in
    if (!isset($_SESSION['username'])) {
        header('location: login.php');
    }
    else {
        $username = $_SESSION['username'];
    }

    // Define the user's role based on authentication logic
    $userRole = 'team_leader'; 
    $_SESSION['role'] = $userRole; // Set the role in the session
    ?>

    <title>Audit</title>
    <link rel="stylesheet" type="text/css" href="./css/competency.css">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header>
        <?php include 'common.php'; ?>
    </header>
    <br>
    <div class="container">
        <h2>Audit Form</h2>
        <form method="POST" action="process_call_audit.php">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="Handling_date">Date of Handling</label>
                    <input type="date" class="form-control" id="Handling_date" name="Handling_date" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="Customer">Customer</label>
                    <input type="text" class="form-control" id="Customer" name="Customer" required>
                </div>
            </div>

            <div class="form-row">
            <div class="form-group col-md-6">
            <label for="SD_Engineer">SD Engineer</label>
            <select class="form-control" id="SD_Engineer" name="SD_Engineer" required>
            <?php
            // Fetch employees with the current user as the team leader.
            $current_user = $_SESSION['username']; // Initialize $current_user
            $sql = "SELECT `Name` FROM `staff` WHERE `Team_Leader` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $current_user);
            $stmt->execute();
            $result = $stmt->get_result();

            // Generate dropdown options.
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($row['Name']) . '">' . htmlspecialchars($row['Name']) . '</option>';
            }

            // Close the statement.
            $stmt->close();
            ?>

            </select>
        </div>

            <div class="form-group col-md-6">
                <label for="Team">Team</label>
                <input type="text" class="form-control" id="Team" name="Team" value="<?php echo htmlspecialchars($username); ?>" readonly>
            </div>

            <div class="form-group col-md-6">
                <label for="Audited_By">Audited By</label>
                <input type="text" class="form-control" id="Audited_By" name="Audited_By" required>
            </div>
            <div class="form-group col-md-6">
                <label for="Num_Ticket">Ticket Number</label>
                <input type="text" class="form-control" id="Num_Ticket" name="Num_Ticket" required>
            </div>
            <div class="form-group col-md-6">
                <label for="Int_Ticket">Ticket Type</label>
                <select class="form-control" id="Int_Ticket" name="Int_Ticket" required>
                    <option value="incident">Incident</option>
                    <option value="change_request">Change/Request</option>
                    <option value="alarm">Alarm</option>
                </select>
            </div>
            </div>

            <hr>

            <h3>Rating</h3>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="Ticket_Handling">Ticket Handling (0-5)</label>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<label class="btn btn-secondary">
                                    <input type="radio" name="Ticket_Handling" value="' . $i . '">' . $i . '
                                  </label>';
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="Process">Process (0-5)</label>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<label class="btn btn-secondary">
                                    <input type="radio" name="Process" value="' . $i . '">' . $i . '
                                  </label>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="Communication">Communication (0-5)</label>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<label class="btn btn-secondary">
                                    <input type="radio" name="Communication" value="' . $i . '">' . $i . '
                                  </label>';
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="Escalation">Escalation (0-5)</label>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<label class="btn btn-secondary">
                                    <input type="radio" name="Escalation" value="' . $i . '">' . $i . '
                                  </label>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="Technical">Technical (0-5)</label>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<label class="btn btn-secondary">
                                    <input type="radio" name="Technical" value="' . $i . '">' . $i . '
                                  </label>';
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="Investigation">Investigation (0-5)</label>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<label class="btn btn-secondary">
                                    <input type="radio" name="Investigation" value="' . $i . '">' . $i . '
                                  </label>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="Customer_Centered">Customer centered (0-5)</label>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<label class="btn btn-secondary">
                                    <input type="radio" name="Customer_Centered" value="' . $i . '">' . $i . '
                                  </label>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <hr>

            <div class="form-group">
                <label for="comments">Comments</label>
                <textarea class="form-control" id="Comments" name="Comments" rows="4"></textarea>
            </div>

            <div class="form-group">
            <label for="Total_Score">Total Score (Calculated)</label>
            <input type="number" class="form-control" id="Total_Score" name="Total_Score" readonly>
        </div>

        <button type="button" class="btn btn-primary" onclick="calculateTotalScore()">Calculate Total Score</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>

    <!-- Include Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript to calculate total score -->
    <script>
        // Function to calculate the total score
        function calculateTotalScore() {
            console.log('calculateTotalScore function called'); // Check if the function is called
            
            // Initialize variables to store the values
            let Ticket_Handling = 0;
            let Process = 0;
            let Communication = 0;
            let Escalation = 0;
            let Technical = 0;
            let Investigation = 0;
            let Customer_Centered = 0;
            let checkedCount = 0;

            // Define unique names for each category's radio buttons
            const categoryNames = [
                'Ticket_Handling',
                'Process',
                'Communication',
                'Escalation',
                'Technical',
                'Investigation',
                'Customer_Centered',
                'Num_Ticket',
                'Int_Ticket'
            ];

            // Loop through each category name
            categoryNames.forEach((categoryName) => {
                const radioButtons = document.querySelectorAll(`input[name="${categoryName}"]:checked`);
                if (radioButtons.length > 0) {
                    checkedCount++;
                    radioButtons.forEach((radioButton) => {
                        // Sum the values of checked radio buttons in each category
                        switch (categoryName) {
                            case 'Ticket_Handling':
                                Ticket_Handling += parseFloat(radioButton.value);
                                break;
                            case 'Process':
                                Process += parseFloat(radioButton.value);
                                break;
                            case 'Communication':
                                Communication += parseFloat(radioButton.value);
                                break;
                            case 'Escalation':
                                Escalation += parseFloat(radioButton.value);
                                break;
                            case 'Technical':
                                Technical += parseFloat(radioButton.value);
                                break;
                            case 'Investigation':
                                Investigation += parseFloat(radioButton.value);
                                break;
                            case 'Customer_Centered':
                                Customer_Centered += parseFloat(radioButton.value);
                                break;
                        }
                    });
                }
            });

            // Ensure there are checked radio buttons to avoid division by zero
            if (checkedCount > 0) {
                console.log('Ticket_Handling:', Ticket_Handling); // Check the value of Ticket_Handling
                console.log('Process:', Process); // Check the value of Process
                // Calculate the total score as an average
                const Total_Score = (Ticket_Handling + Process + Communication + Escalation + Technical + Investigation + Customer_Centered) / checkedCount;

                // Display the calculated total score in the "Total Score" field
                document.getElementById('Total_Score').value = Total_Score.toFixed(2); // Round to 2 decimal places
            } else {
                // No radio buttons are checked, set the total score to 0
                document.getElementById('Total_Score').value = '0.00';
            }
        }

        // Add an event listener to call the calculateTotalScore function when any of the radio buttons change
        const radioButtons = document.querySelectorAll('input[type="radio"]');
        radioButtons.forEach((radioButton) => {
            radioButton.addEventListener('change', calculateTotalScore);
        });

        // Initialize the total score when the page loads
        calculateTotalScore();

    </script>
</body>
</html>

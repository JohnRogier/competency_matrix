<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <style>
        .list-group li a:hover {
            background-color: #e99964;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <ul class="list-group">
        <li>
            <a href="admin.php">
                <img src="https://boosted.orange.com/docs/5.3/assets/brand/orange-logo.svg" width="60" height="60" alt="Orange Business" loading="lazy">
            </a>
        </li>
        <li><a href="admin.php">Dashboard</a></li>
        <li><a href="view_users.php">Registered Users</a></li>
        <li><a href="create_user.php">Create a user</a></li>
        <li><a href="user_details.php">User Details</a></li>
        <li><a href="team_details.php">Team Data Charts</a></li>
        <li><a href="admin_page_graph.php">Employee progression graph</a></li>
        <li><a href="#" id="logoutButton">Logout</a></li><!-- Use '#' to prevent default link behavior -->
    </ul>
</div>

    <!-- Modal for Logout Confirmation -->
    <div class="modal fade" id="logoutConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="logoutConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutConfirmationModalLabel">Logout Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <!-- Button to trigger the logout function -->
                    <button type="button" class="btn btn-primary" onclick="logout()">Logout</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- JavaScript to open the modal when the "Logout" link is clicked -->
    <script>
        $(document).ready(function() {
            $("#logoutButton").click(function() {
                $("#logoutConfirmationModal").modal('show');
            });
        });

        function logout() {
            // Perform the logout actions; destroying the session
            // You can add your session destruction code here

            // Redirect to the login page after logout
            window.location.href = 'login.php';
        }
    </script>
</body>
</html>

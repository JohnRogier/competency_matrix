<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
    <link rel="stylesheet" type="text/css" href="./css/common.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <script>
        $(document).ready(function() {
            $('#logoutLink').on('click', function(e) {
                e.preventDefault(); 
                showLogoutConfirmation();
            });

            function showLogoutConfirmation() {
                if (confirm("Are you sure you want to logout?")) {
                    logout();
                }
            }

            function logout() {
                $.ajax({
                    type: 'POST',
                    url: 'logout_script.php',
                    success: function (response) {
                        window.location.href = 'login.php';
                    }
                });
            }
        });
    </script>
</body>
</html>

<!-- navigation bar -->
<head>
    <link href="https://cdn.jsdelivr.net/npm/boosted@5.3.1/dist/css/orange-helvetica.min.css" rel="stylesheet" integrity="sha384-A0Qk1uKfS1i83/YuU13i2nx5pk79PkIfNFOVzTcjCMPGKIDj9Lqx9lJmV7cdBVQZ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/boosted@5.3.1/dist/css/boosted.min.css" rel="stylesheet" integrity="sha384-Q3wzptfwnbw1u019drn+ouP2GvlrCu/YVFXSu5YNe4jBpuFwU738RcnKa8PVyj8u" crossorigin="anonymous">
</head>
<header>
        <nav class="navbar navbar-dark bg-dark navbar-expand-lg header-minimized" aria-label="Global navigation - Minimized without title example">
            <div class="container-xxl">
                <div class="navbar-brand me-auto me-lg-4">
                    <a class="stretched-link" href="home.php">
                        <img src="https://boosted.orange.com/docs/5.3/assets/brand/orange-logo.svg" width="50" height="50" alt="Orange Business" loading="lazy">
                    </a>
                </div>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target=".global-header-0" aria-controls="global-header-0.1 global-header-0.2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="global-header-0.1" class="navbar-collapse collapse me-lg-auto global-header-0">
                    <ul class="navbar-nav">
                        <?php
                        // Get the current file name (without directory path or parameters)
                        $currentPage = basename($_SERVER['PHP_SELF']);

                        // associative array of page names and their corresponding labels
                        $pages = array(
                            'welcome.php' => 'Team Info',
                            'newStaff.php' => 'New Staff',
                            'competency.php' => 'Competency',
                            'audit.php' => 'Technical Audit',
                            'display_audit.php' => 'View Audits',
                            'charts.php' => 'Competency Visual',
                        );

                        // Loop through the pages and create navigation links
                        foreach ($pages as $page => $label) {
                            $isActive = ($currentPage === $page) ? 'active' : '';
                            echo '<li class="nav-item ' . $isActive . '"><a href="' . $page . '" class="nav-link">' . $label . '</a></li>';
                        }

                        ?>
                        <li class="nav-item"><a href="#" id="logoutLinkNavbar" class="nav-link">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
<br>
</header>

<script src="https://cdn.jsdelivr.net/npm/boosted@5.3.1/dist/js/boosted.bundle.min.js" integrity="sha384-0biCFbLg/2tCnFChlPpLx46RGI2/8UP1Uk6n0Q0ATM7D0SbB4s1yTQcOjLV96X3h" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#logoutLinkNavbar').on('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior
            showLogoutConfirmation();
        });

        function showLogoutConfirmation() {
            if (confirm("Are you sure you want to logout?")) {
                logout();
            }
        }

        function logout() {
            // Perform the logout actions; destroying the session
            $.ajax({
                type: 'POST',
                url: 'logout_script.php',
                success: function (response) {
                    // Redirect to the login page after logout
                    window.location.href = 'login.php';
                }
            });
        }
    });
</script>

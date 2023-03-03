<?php

include '../classes/schedule.php';

class Controller {

    // ---------- Routing functions ----------
    function home() {
        $displayLoginForm = false;
        // Open login form if redirected
        if (isset($_SESSION['displayLogin']) && $_SESSION['displayLogin'] === true) {
            // IMPORTANT! CLEAR VALUE
            $_SESSION['displayLogin'] = false;
            $displayLoginForm = true;
        }

        // Generate token for new plan link/s
        $newToken = $GLOBALS['datalayer']->generateToken();
        $username = "";
        $errorMessage = "";

        // Render the view
        require 'views/home.php';
    }

    function educationPlan() {
        // Generating new student token
        $_SESSION['token'] = $token = $GLOBALS['datalayer']->generateToken();

        // Initialize Variables to determine rendering characteristics
        $lastUpdated = ""; // Variable to store most recent save time
        $formSubmitted = false; // Display submitted form data + confirmation
        $saveSuccess = false; // Determines state of confirmation message
        $advisor = "";

        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $formSubmitted = true;

            // Store current token (if valid)
            if (Validator::validToken($_POST['token'])) {
                $token = $_POST['token'];
            }
            if (isset($_POST['advisor'])) {
                $advisor = $_POST['advisor'];
            }

            // Attempt to save data in POST to database
            if ($GLOBALS['datalayer']->planExists($token)) {
                // Plan is stored in database (UPDATE)
                $saveSuccess = $GLOBALS['datalayer']->updatePlan($token);
            }
            else {
                // Plan was not already in database (INSERT)
                $saveSuccess = $GLOBALS['datalayer']->saveNewPlan($token);
            }
        }

        // Get token data from database
        $plan = $GLOBALS['datalayer']->getPlan($token);

        // Check if Token is stored in database (new plans are not in database)
        if (!empty($plan['token'])) {
            $token = $plan['token'];
            $lastUpdated = Formatter::formatTime($plan['lastUpdated']);
            $advisor = $plan['advisor'];
            $schoolYears = $plan['schoolYears'];
        }
        else { // No plan data (display current blank year)
            $schoolYears = DataLayer::createBlankPlan()['schoolYears'];
        }

        $_SESSION['schoolYears'] = $schoolYears;
        var_dump($_SESSION['schoolYears']['2023']);

        // Render the view
        require 'views/education_plan.php';
    }


    function login() {
        // Ensure form has been submitted
        if (empty($_POST)) {
            // Load home page (without login form)
            require 'views/home.php';
            return; // Escape controller
        }

        // Get the login form data (if present)
        $username = $_POST['username'] ?? "";
        $password = $_POST['password'] ?? "";

        // Validate not empty
        if ($username === "" || $password === "") {
            // Reload login form
            $this->failedLogin("Please enter username and Password", $username);
            return; // Escape controller
        }

        // Require the credentials file, which defines a $Logins array
        require($_SERVER['DOCUMENT_ROOT'].'/../users.php');
        if (!isset($logins)) {
            $this->failedLogin("Failed to connect to server", $username);
            return; // Escape controller
        }

        // Validate username (if credentials loaded)
        if (!array_key_exists($username, $logins)) {
            //Invalid login (username) -- set flag variable
            $this->failedLogin("Invalid username or password", $username);
            return; // Escape controller
        }
        
        // Validate Password
        if ($password !== $logins[$username]) {
            // Invalid login (password) -- set flag variable
            $this->failedLogin("Invalid username or password", $username);
            return; // Escape controller
        }
        
        // ==== LOGGED IN ==== //

        //Record the username in the session array
        $_SESSION['logged-in'] = true;
        $_SESSION['username'] = $username;

        // Load admin page!
        header('location: admin');
    }


    function admin() {
        // Check that the user is logged in
        if (!isset($_SESSION['logged-in']) || $_SESSION['logged-in'] != true || !isset($_SESSION['username'])) {
            // Failed to log in (Render Login on Home page)
            $_SESSION['displayLogin'] = true;
            header('location: '.$GLOBALS['PROJECT_DIR']);
        }

        // Generate New Token for "Education Plan" Link
        $newToken = $GLOBALS['datalayer']->generateToken();

        // Get plan data
        $plans = $GLOBALS['datalayer']->getPlans();

        // Render the view
        require 'views/admin.php';
    }

    // ---------- Helper functions ----------
    // Helper method to reload login form on a failed login attempt
    private function failedLogin($errorMessage, $username) {
        // Error message and username are loaded on page
        // Open login form on load
        $displayLoginForm = true;

        // Load home page
        $newToken = $GLOBALS['datalayer']->generateToken();
        require 'views/home.php';
    }

    function logout() {
        session_destroy();
        // Redirect to home page
        header("Location: ".$GLOBALS['PROJECT_DIR']);
    }
}


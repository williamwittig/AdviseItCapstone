<?php

include '../classes/schedule.php';

class Controller {
    private $_dbh;

    // ---------- Constructor function ----------
    function __construct() {
        require_once $_SERVER['DOCUMENT_ROOT'].'/../config.php';
        $this->_dbh = $dbh;

        // Enable Error reporting
        $this->_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->_dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    // ---------- Routing functions ----------
    function home() {
        // Open login form if redirected
        if (isset($_SESSION['displayLogin']) && $_SESSION['displayLogin'] === true) {
            // IMPORTANT! CLEAR VALUE
            $_SESSION['displayLogin'] = false;
        }

        // Render the view
        require $_SERVER['DOCUMENT_ROOT'] . '/AdviseItCapstone/views/home.php';
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
        require $_SERVER['DOCUMENT_ROOT'] . '/AdviseItCapstone/views/education_plan.php';
    }


    function login() {
        // Render the view
        require $_SERVER['DOCUMENT_ROOT'].'/AdviseItCapstone/views/login.html';
    }

    function admin() {
        // Check that the user is logged in
        if (!isset($_SESSION['logged-in']) || $_SESSION['logged-in'] != true || !isset($_SESSION['username'])) {
            // Failed to log in (Render Login on Home page)
            $_SESSION['displayLogin'] = true;
            header('location: ./');
        }

        // Generate New Token for "Education Plan" Link
        $newToken = $GLOBALS['datalayer']->generateToken();

        // Get plan data
        $plans = $GLOBALS['datalayer']->getPlans();

        // Render the view
        require $_SERVER['DOCUMENT_ROOT'] . '/AdviseItCapstone/views/admin.php';
    }

    // ---------- Helper functions ----------
    function loginAttempt() {
        // If the form has been submitted
        if (!empty($_POST)) {

            //Get the form data
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Require the credentials file, which defines a $Logins array
            require($_SERVER['DOCUMENT_ROOT'].'/../users.php');
            if (!isset($logins)) {
            }
            // If the username is in the array and the passwords match
            else if (array_key_exists($username, $logins)) {
                if ($password == $logins[$username]) {
                    //Record the username in the session array
                    $_SESSION['logged-in'] = true;
                    $_SESSION['username'] = $username;

                    header('location: admin');
                }
                else {
                    // Invalid login (password) -- set flag variable
                }
            }
            else {
                //Invalid login (username) -- set flag variable
                if ($username !== "") {
                }
            }
            // Failed to log in (Render Home page)
            require $_SERVER['DOCUMENT_ROOT'] . '/AdviseItCapstone/views/home.php';
        }
    }

    function logout() {
        session_destroy();
        header("Location: ./");
    }
}


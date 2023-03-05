<?php
    // Required Variables to be assigned in controller
    // IGNORE "Undefined variable" errors
    $plans;

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- Styles -->
    <!-- Styles -->
    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
            crossorigin="anonymous"
    >
    <link rel="stylesheet" href="<?php echo $GLOBALS['PROJECT_DIR'] ?>/styles/styles.css">

    <title>Admin Table</title>
</head>

<body class="">
    <!--NAVBAR-->
    <?php include "includes/navbar.php"; ?>

    <div class="container mt-2 grfont">
        <div class="row justify-content-center">
            <div class="col text-center">
                <h1 class="pt-5">Academic Schedules</h1>
                <hr class="shadow-sm">
            </div>
        </div>
        <!-- Admin Table -->
        <section class="ml-5 mr-5 p-5">
            <table class="table table-responsive table-bordered table-hover text-center shadow-sm">
                <thead class="bg-grcgreen">
                    <tr>
                        <th scope="col">Token</th>
                        <th scope="col">URL</th>
                        <th scope="col">Advisor</th>
                        <th scope="col">Last Saved</th>
                    </tr>
                </thead>
                <tbody>
                    <!--Repeating section to show all data in table from database-->
                    <?php
                        foreach ($plans as $plan) {
                            $url = $GLOBALS['PROJECT_DIR'].'/plan/'.$plan['token'];
                            echo
                            '<tr>
                                <td>'.$plan['token'].'</td>
                                <td>
                                    <a href="'.$url.'" target="_blank">
                                        https://adviseit.greenriverdev.com'.$url.'
                                    </a>
                                </td>
                                <td>'.$plan['advisor'].'</td>
                                <td>'. Formatter::formatTime($plan['lastUpdated']) .'</td>
                            </tr>';
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

    <!-- JavaScript -->
	<script 
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous">
    </script>
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/scripts/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous">
    </script>
</body>
</html>
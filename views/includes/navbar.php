<nav class="navbar navbar-expand-lg nav-grc sticky-top grfont shadow-sm">
    <div>
        <a class="text-dark d-block bg-grcgreen p-3" href="<?php echo $GLOBALS['PROJECT_DIR']; ?>">
            <img src="https://www.greenriver.edu/media/site-assets/img/logo.png"
                 class="gr-logo">
        </a>
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav align-items-center">
            <li class="nav-item active">
                <a class="nav-link text-dark" href="plan/<?php echo $newToken; ?>">
                    <h5 class="mb-0">Education Plan</h5>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link text-dark" href="admin">
                    <h5 class="mb-0">Admin</h5>
                </a>
            </li>
            <?php
            if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] === true) {
                echo '<li class="nav-item active">
                    <a class="nav-link text-dark" href="logout">
                        <h5 class="mb-0">Logout</h5>
                    </a>
                </li>';
            }
            ?>
        </ul>
    </div>
</nav>
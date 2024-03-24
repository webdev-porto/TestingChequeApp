<?php
//starting session rif no session has started
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<header>
    <nav>
        <h1> PTS Cheque App </h1>

        <a href="#" id="lang_change"> AR </a>

    </nav>
    <nav>
        <button>
            <span class="icofont-navigation-menu"></span>
        </button>

        <a href="manage_cheques.php" id="logo">
            <span>
                <?=
                    //uncomement late
                    $_SESSION['client_name']
                    //"Sup1"
                    ?>
            </span>
        </a>
        <button class="user_controls_btn" onclick="open_profile_pop()">
            <span class="icofont-business-man" id="user_prof"></span>
        </button>
    </nav>
    <nav id="profile_pop_up">
        <button id="close_profile_btn">
            <span class="icofont-ui-close" onclick="close_profile_pop()"></span>
        </button>
        <a href="#">
            <span class="icofont-business-man"></span>
            <span>COMING SOON A</span>
        </a>
        <a href="#">
            <span class="icofont-business-man"></span>

            <span>COMING SOON B</span>
        </a>
        <a href="logout.php">
            <span class="icofont-power"></span>

            <span>Logout</span>
        </a>

    </nav>
</header>
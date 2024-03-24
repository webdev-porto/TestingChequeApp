<?php
session_start();
if (!isset ($_SESSION["loged_admin_account_id"])) {
    header("location: logout.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTS - CHEQUE APP - Manage Banks</title>
    <link rel="stylesheet" href="../styles/icons/icofont.css" />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Protest+Strike&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../styles/top_menu.css" />
    <link rel="stylesheet" href="../styles/side_menu.css" />
    <link rel="stylesheet" href="../styles/manage.css">
</head>

<body>
    <?php
    require ("include/top_menu.php");
    ?>
    <main>
        <section>
            <!--Side Menu-->
            <?php
            require ("include/side_menu.php");
            ?>

            <!--
                Panel
            -->
            <div class="panel">
                <div id="add_bank">
                    <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                        <input type="text" name="bank_name" placeholder="Enter A Bank Name">
                        <input type="submit" value="Add Bank" name="add_bank_form">
                    </form>
                </div>
                <span id="data_error" class="error"></span>

                <div id="datagrid">
                    <?php
                    require ("../includes/connection.php");
                    require ("include/functions.php");
                    //$db = new Database($config["test_database"]);
                    $db = new Database($config["live_database"]);

                    //$loged_uid = $_SESSION["loged_account_id"];
                    
                    if (isset ($_POST["add_bank_form"])) {
                        $bank_name = trim($_POST["bank_name"]);

                        $sql = "INSERT INTO table4_bank (bank_name)
                        VALUES(?)";
                        addBank($db, $sql, $bank_name);

                        $sql = "SELECT table4_bank.bank_id, table4_bank.bank_name 
                        FROM table4_bank";

                        showBanks($db, $sql);


                    } else if (isset ($_POST["search_br"])) {
                        $bank_name = trim($_POST["bank_name"]);
                        if ($bank_name == "") {
                            //echo "test case 1";
                            echo '<script>';
                            echo 'document.getElementById("data_error").innerHTML="You Have To Enter A Value in the bank Name <br> Or Click Reset Search"';
                            echo '</script>';


                        } else {
                            $sql = "SELECT table4_bank.bank_id, table4_bank.bank_name 
                            FROM table4_bank
                            WHERE table4_bank.bank_name LIKE '%$bank_name%'";
                            showBanks($db, $sql, "bank");


                        }


                    } else {
                        $sql = "SELECT table4_bank.bank_id, table4_bank.bank_name 
                        FROM table4_bank";
                        if (isset ($_POST["reset_search"])) {
                            showBanks($db, $sql);

                        } else {
                            showBanks($db, $sql);

                        }


                    }



                    ?>

                </div>
            </div>
            <!--
                Right Menu
            -->

            <aside class="right">


                <h1 style="margin-top:2vw;">Search By Bank</h1>

                <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="data_input">
                        <label for="">Bank Name</label>
                        <input type="text" name="bank_name" id="" placeholder="Please Enter Bank Name">
                    </div>

                    <!-- <span id="search_error" class="error">
                    </span>
                -->
                    <input type="submit" value="Search" name="search_br" id="">
                    <input type="submit" value="Reset Search" name="reset_search" id="reset">
                </form>
            </aside>

        </section>
    </main>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="../scripts/switch_menu.js" defer></script>
    <script>
        function open_popup(control, number) {
            // document.getElementById("element_id").innerHTML = "sup"
            console.log(control + number)
            if (control == "delete") {
                gsap.timeline()
                    .to("#del_pop" + number, { display: "flex", duration: 0 })
                    .to("#del_pop" + number, { opacity: 1, duration: 1 })
            }
            if (control == "edite") {
                gsap.timeline()
                    .to("#edite_pop" + number, { display: "flex", duration: 0 })
                    .to("#edite_pop" + number, { opacity: 1, duration: 1 })
            }

        }
        function close_pop(control, number) {
            if (control == "delete") {
                gsap.timeline()
                    .to("#del_pop" + number, { opacity: 0, duration: 1 })
                    .to("#del_pop" + number, { display: "none", duration: 0 })
            }
            if (control == "edite") {
                gsap.timeline()
                    .to("#edite_pop" + number, { opacity: 0, duration: 1 })
                    .to("#edite_pop" + number, { display: "none", duration: 0 })
            }



        }

        /*
        function open_edite_pop(number){
            open_edite_popup
        }*/
    </script>

    <script defer>
        let ele1 = document.getElementsByTagName("main")[0]
        let ele2 = document.querySelectorAll("nav")
    </script>
</body>

</html>
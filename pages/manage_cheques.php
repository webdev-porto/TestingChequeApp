<?php
//dlelete later
session_start();
if (!isset ($_SESSION["loged_account_id"])) {
    header("location: logout.php");
    exit;

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTS - CHEQUE APP - Manage Cheques</title>
    <link rel="stylesheet" href="../styles/icons/icofont.css" />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Protest+Strike&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../styles/top_menu.css" />
    <link rel="stylesheet" href="../styles/side_menu.css" />
    <link rel="stylesheet" href="../styles/mobile_menu.css" />

    <link rel="stylesheet" href="../styles/manage.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>

<body>
    <?php
    require ("include/top_menu.php");
    ?>
    <main>
        <?php
        require ("include/mobile_menu.php");
        ?>
        <section>
            <!--Side Menu-->
            <?php
            require ("include/side_menu.php");
            ?>


            <!--
                Panel
            -->
            <div class="panel">

                <span id="data_error" class="error"></span>

                <div id="datagrid">
                    <?php
                    require ("../includes/connection.php");
                    require ("include/functions.php");
                    //$db = new Database($config["test_database"]);
                    $db = new Database($config["live_database"]);

                    $loged_uid = $_SESSION["loged_account_id"];

                    if (isset ($_POST["search_br"])) {
                        //$bank_name = trim($_POST["bank_name"]);
                        $due_date = $_POST["due_date"];
                        $recipe_name = trim($_POST["recip_name"]);
                        // echo $due_date;
                    
                        if ($recipe_name == "" && $due_date == "") {
                            //You Have To Enter A Value in Recipient Name<br> Or Click Reset Search 
                            // echo "triggred error";
                            echo '<script>';
                            echo 'document.getElementById("data_error").innerHTML="You Have To Enter A Value in Recipient Name / Choose Date<br> Or Click Reset Search"';
                            echo '</script>';


                        } elseif ($recipe_name != "" && $due_date == "") {
                            $sql = "SELECT 
                            table6_saved_cheque_data.* 
                            FROM table6_saved_cheque_data 
                            
                            INNER JOIN table3_user_account 
                            ON 
                            table3_user_account.user_account_id=table6_saved_cheque_data.fk_user_account_id 
                            
                            WHERE table3_user_account.user_account_id = '$loged_uid'
                            AND table6_saved_cheque_data.cheque_pay_name LIKE '%$recipe_name%'";

                            showCheques($db, $sql, 'recipient');
                            # code...
                        } elseif ($recipe_name == "" && $due_date != "") {
                            $sql = "SELECT 
                            table6_saved_cheque_data.* 
                            FROM table6_saved_cheque_data 
                            
                            WHERE table6_saved_cheque_data.fk_user_account_id = '$loged_uid'
                            AND table6_saved_cheque_data.cheque_date = '$due_date'";

                            showCheques($db, $sql);
                            # code...
                        } else {

                            $sql = "SELECT 
                            table6_saved_cheque_data.* 
                            FROM table6_saved_cheque_data 
                            
                            INNER JOIN table3_user_account 
                            ON 
                            table3_user_account.user_account_id=table6_saved_cheque_data.fk_user_account_id 
                            
                            WHERE table3_user_account.user_account_id = '$loged_uid'
                            AND table6_saved_cheque_data.cheque_pay_name LIKE '%$recipe_name%'";

                            showCheques($db, $sql, 'recipient');

                            //cond 2 search by recipent only
                            // cond 3 search by bank and recipent
                    


                        }


                    } else {
                        $sql = "SELECT 
                        table6_saved_cheque_data.* 
                        FROM table6_saved_cheque_data 
                        
                        INNER JOIN table3_user_account 
                        ON 
                        table3_user_account.user_account_id=table6_saved_cheque_data.fk_user_account_id 
                        
                        WHERE table3_user_account.user_account_id = '$loged_uid'";


                        if (isset ($_POST["reset_search"])) {
                            showCheques($db, $sql);

                        } else {
                            showCheques($db, $sql);

                        }


                    }



                    ?>

                </div>
            </div>
            <!--
                Right Menu
            -->

            <aside class="right">

                <h1>Search By Recipient</h1>

                <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="data_input">
                        <label for="due_date">Cheque Due Date</label>
                        <input type="date" name="due_date" id="due_date">
                    </div>
                    <div class="data_input">
                        <label for="recip_name">Recipient Name</label>
                        <input type="text" name="recip_name" id="recip_name" placeholder="Please Enter Recipient Name">
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
    <script src="../scripts/mobile_menu.js"></script>
    <script>
        function open_popup(number) {
            // document.getElementById("element_id").innerHTML = "sup"
            // console.log("cheque" + number)
            gsap.timeline()
                .to("#pop" + number, { display: "flex", duration: 0 })
                .to("#pop" + number, { opacity: 1, duration: 1 })
        }
        function close_pop(number) {

            gsap.timeline()
                .to("#pop" + number, { opacity: 0, duration: 1 })
                .to("#pop" + number, { display: "none", duration: 0 })


        }
    </script>
    <script defer>
        let ele1 = document.getElementsByTagName("main")[0]
        let ele2 = document.querySelectorAll("nav")
    </script>
    <script>
        //show active menu fro mobile      
        showMenu("manage_cheques_active")

    </script>


</body>

</html>
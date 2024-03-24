<?php
session_start();
if (!isset ($_SESSION["loged_admin_account_id"])) {
    header("location: logout.php");
    exit;
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>PTS - CHEQUE APP - Bank Details</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../styles/icons/icofont.css" />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Protest+Strike&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../styles/top_menu.css" />

    <link rel="stylesheet" href="../styles/side_menu.css" />
    <link rel="stylesheet" href="../styles/template_details.css" />

</head>

<body>
    <!--[if lt IE 7]>
      <p class="browsehappy">
        You are using an <strong>outdated</strong> browser. Please
        <a href="#">upgrade your browser</a> to improve your experience.
      </p>
    <![endif]-->

    <?php
    require ("include/top_menu.php");
    ?>
    <main>
        <section>
            <!--Side Menu-->
            <?php
            require ("include/side_menu.php");
            ?>

            <div class="panel">
                <div id="top_controls">
                    <h1 id="title1">
                        <?php
                        require ("../includes/connection.php");
                        require ("include/functions.php");
                        //$db = new Database($config["test_database"]);
                        $db = new Database($config["live_database"]);

                        $bank_id = $_GET["bank_id"];
                        $sql = "SELECT table4_bank.bank_name
                        FROM table4_bank
                        WHERE table4_bank.bank_id='$bank_id'";
                        $statment = $db->pdo->prepare($sql);

                        //var_dump($statment);
                        $statment->execute();
                        $data = $statment->fetchAll();

                        foreach ($data as $record) {
                            $bank_name = $record["bank_name"];
                            echo $bank_name;
                        }
                        ?>
                    </h1>
                    <div id="add_cheque">
                        <form action="<?= htmlentities($_SERVER['PHP_SELF']) . '?bank_id=' . $bank_id ?>" method="POST"
                            enctype="multipart/form-data">
                            <input type="file" name="image_url" required>
                            <input type="submit" value="Upload Cheque" name="upload_template">
                        </form>
                        <span class="error" id="add_template_error"></span>
                        <span class="msg" id="add_template_msg"></span>

                    </div>
                    <?php

                    if (isset ($_POST["upload_template"])) {
                        // echo "its working";
                        //$db = new Database($config["test_database"]);
                        $db = new Database($config["live_database"]);

                        $file = $_FILES["image_url"];
                        $allowed_types = array("jpg", "png", "jpeg");
                        $upload_date = date("Y-m-d");

                        // var_dump($file);
                    
                        $file_pass = fileProcesser($file, $allowed_types);
                        if ($file_pass == true) {
                            //  $bank_id = $_GET["bank_template_id"];
                    

                            $folder_created = createUserFolders(
                                $db,
                                $bank_id
                            );
                            if ($folder_created == false) {
                                echo "error - folder creation problem";

                            } else {
                                //var_dump([$db, $file, $folder_created, $bank_id, $upload_date]);
                                //echo "folder created next Step";
                                upload_template($db, $file, $folder_created, $bank_id, $upload_date);

                            }
                        } else {

                            //file dosnt meet conditions
                            //echo "error file didnt pass";
                            echo '<script>';
                            echo 'document.getElementById("add_template_error").innerHTML+="Error - File Uploade "';
                            echo '</script>';
                        }
                    }

                    ?>
                </div>

                <!--Cheque Output-->
                <div id="data_output">
                    <?php
                    if (isset ($_POST['search_template'])) {
                        //require("include/functions.php");
                        // echo "clicked Seaarch";
                        //
                        $temp_upload_date = $_POST["input_cheque_date"];

                        $sql = "SELECT table5_cheque_image.* 
                        FROM table5_cheque_image
                        WHERE table5_cheque_image.fk_bank_id='$bank_id'
                        AND table5_cheque_image.upload_date='$temp_upload_date'";
                        // echo "triggred";
                        showTempaltes($db, $sql, $bank_id);
                        $cheque_date = trim($_POST['input_cheque_date']);




                    } else {
                        $sql = "SELECT table5_cheque_image.* 
                        FROM table5_cheque_image
                        WHERE table5_cheque_image.fk_bank_id='$bank_id'
                        ORDER BY table5_cheque_image.upload_date DESC";
                        if (isset ($_POST['reset_search'])) {
                            //   echo "reset";
                            showTempaltes($db, $sql, $bank_id);

                        } else {
                            showTempaltes($db, $sql, $bank_id);

                        }

                        // echo "triggred";
                    }
                    ?>




                </div>

            </div>

            <!--Cheque Input-->
            <aside class="right">
                <h1 id="title2"> - </h1>
                <h2>Fill The Data Bellow</h2>

                <form id="cheque_data_form" action="<?= htmlentities($_SERVER['PHP_SELF']) . '?bank_id=' . $bank_id ?>"
                    method="POST">
                    <div class="data_input">
                        <label for="input_cheque_date">Template Upload Date</label>
                        <input type="date" id="input_cheque_date" name="input_cheque_date" />
                    </div>


                    <input type="submit" value="Search" name="search_template" />
                    <input type="submit" value="Reset Search" name="reset_search" id="reset" />
                    <span class="msg" id="msg"></span>
                    <span class="error" id="right_error"></span>


                </form>
            </aside>
        </section>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <script src="../scripts/switch_menu.js" defer></script>


    <script defer>
        let ele1 = document.getElementsByTagName("main")[0]
        let ele2 = document.querySelectorAll("nav")
    </script>


</body>

</html>
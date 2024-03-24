<?php
session_start();
if (!isset ($_SESSION["loged_admin_account_id"])) {
    header("location: logout.php");
    exit;
}

if (isset ($_GET["del_bank_id"])) {
    //recive bank id
    $con = "includes/connection.php";
    require ("include/functions.php");

    $bank_id = $_GET["del_bank_id"];
    deleteBank("../" . $con, $bank_id);
    exit;

}

if (isset ($_GET["del_cheque_id"])) {
    $con = "includes/connection.php";
    require ("include/functions.php");
    $cheque_id = $_GET["del_cheque_id"];

    deleteCheques("../" . $con, $cheque_id);

}

if (isset ($_GET["update_bank"])) {
    //update bank name script
    $con = "includes/connection.php";
    require ("include/functions.php");
    $bank_id = $_GET["bank_id"];
    $bank_name = trim($_GET["bank_name"]);
    if (isset ($bank_name) && $bank_name != "") {
        updateBank($con, $bank_id, $bank_name);
    } else {
        //bank name has to be filled error
    }
}

if (isset ($_POST["update_saved_cheq"])) {
    require "../includes/connection.php";

    require ("include/functions.php");
    //$db = new Database($config["test_database"]);
    $db = new Database($config["live_database"]);


    if (isset ($_GET["cheque_data_id"])) {
        $cheque_data_id = $_GET["cheque_data_id"];
        $cheque_date = trim($_POST['input_cheque_date']);
        $cheque_recipient = trim($_POST['input_recipient_name']);
        $cheque_amount_number = trim($_POST['input_amount_number']);
        $cheque_amount_words = trim($_POST['input_amount_words']);

        //  $chosen_image_id = trim($_POST['chosen_image_id']);
        $cheque_currancy = trim($_POST['input_currency']);
        if ($cheque_data_id != NULL) {
            $sql = "UPDATE table6_saved_cheque_data SET 
                cheque_date=?,
                cheque_pay_name=?,
                cheque_amount=?,
                cheque_currency=?,
                cheque_words_amount=?
                WHERE cheque_data_id=?";
            $statment = $db->pdo->prepare($sql);
            $statment->execute([
                $cheque_date,
                $cheque_recipient,
                $cheque_amount_number,
                $cheque_currancy,
                $cheque_amount_words,
                $cheque_data_id
            ]);
            header("location: edit_cheque.php?cheque_id=" . $cheque_data_id);

        } else {
            echo "LOL WAT";
        }
    } else {
        //missing data error
    }
}

if (isset ($_GET["del_temp_id"])) {
    echo "delete me";
    require ("../includes/connection.php");
    require ("include/functions.php");
    //$db = new Database($config["test_database"]);
    $db = new Database($config["live_database"]);

    $template_id = $_GET["del_temp_id"];
    $sql = "SELECT * FROM table5_cheque_image
    WHERE table5_cheque_image.cheque_image_id='$template_id'";
    $statment = $db->pdo->prepare($sql);
    // var_dump($statment);
    $statment->execute();
    $data = $statment->fetchAll();
    foreach ($data as $record) {

        $file_path = $record["cheque_image_file"];
        $bank_id = $record["fk_bank_id"];

    }
    echo $file_path;
    try {
        //code...

        if (file_exists($file_path)) {
            unlink($file_path);

        }
        $sql = "DELETE FROM table5_cheque_image WHERE cheque_image_id='$template_id'";
        $statment = $db->pdo->prepare($sql);
        var_dump($statment);
        $statment->execute();
        header("location: template_details.php?bank_id=" . $bank_id);

    } catch (Exception $e) {
        //throw $th;
        echo $e->getMessage();
    }

}
<?php
session_start();
if (!isset ($_SESSION["loged_account_id"])) {
    header("location: logout.php");
    exit;
}



if (isset ($_POST["update_saved_cheq"])) {
    require "../includes/connection.php";

    require ("include/functions.php");
    //    $db = new Database($config["test_database"]);
    $db = new Database($config["live_database"]);

    if (isset ($_GET["cheque_data_id"])) {
        $cheque_data_id = $_GET["cheque_data_id"];
        $cheque_date = trim($_POST['input_cheque_date']);
        $cheque_recipient = trim($_POST['input_recipient_name']);
        $cheque_amount_number = trim($_POST['input_amount_number']);
        $cheque_amount_words = trim($_POST['input_amount_words']);
        $cheque_currancy = trim($_POST['input_currency']);
        $cheque_crossing = trim($_POST["input_crossing"]);

        if ($cheque_data_id != NULL) {
            $sql = "UPDATE table6_saved_cheque_data SET 
                cheque_date=?,
                cheque_pay_name=?,
                cheque_amount=?,
                cheque_currency=?,
                cheque_words_amount=?,
                cheque_crossing=?
                WHERE cheque_data_id=?";
            $statment = $db->pdo->prepare($sql);
            $statment->execute([
                $cheque_date,
                $cheque_recipient,
                $cheque_amount_number,
                $cheque_currancy,
                $cheque_amount_words,
                $cheque_crossing,
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

if (isset ($_GET["del_cheque_id"])) {
    $con = "includes/connection.php";
    require ("include/functions.php");
    $cheque_id = $_GET["del_cheque_id"];

    deleteCheques("../" . $con, $cheque_id);

}
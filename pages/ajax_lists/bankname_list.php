<?php
require ("../../includes/connection.php");

if (isset ($_POST["bankId"])) {
    session_start();
    if (isset ($_SESSION['loged_account_id'])) {
        $user_id = $_SESSION['loged_account_id'];
        $bank_id = $_POST["bankId"];
    } else {

        header("location:../../pages/logout.php");

        exit;
    }
    //$db = new Database($config["test_database"]);
    $db = new Database($config["live_database"]);

    $sql = "SELECT * FROM table4_bank
    WHERE bank_id='$bank_id'";
    $statment = $db->pdo->prepare($sql);
    //var_dump($statment);
    $statment->execute();
    $data = $statment->fetchAll();
    foreach ($data as $record) {
        $bankname = $record["bank_name"];
    }
    if (isset ($bankname)) {
        echo $bankname;

    } else {
        echo "-";
    }
} else {
    echo "-";
}

//echo "" . $bank_id . "";

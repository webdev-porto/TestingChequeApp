<?php
require ("../../includes/connection.php");
if (isset ($_POST["bankId"])) {
    //
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


    $sql = "SELECT 
            table5_cheque_image.cheque_image_file, 
            table5_cheque_image.cheque_image_file_name,
            table5_cheque_image.cheque_image_id,
            table4_bank.bank_name
            FROM 
            table4_bank
            INNER JOIN 
            table5_cheque_image ON table5_cheque_image.fk_bank_id = table4_bank.bank_id
            AND table4_bank.bank_id='$bank_id'";

    $statment = $db->pdo->prepare($sql);
    //var_dump($statment);
    $statment->execute();
    if ($statment->rowCount() == 0) {
        echo "<option value=''>Choose Template</option>";

    } else {
        $data = $statment->fetchAll();
        echo "<option value=''>Choose Template</option>";

        foreach ($data as $record) {
            $image_id = $record["cheque_image_id"];
            $image_file_name = $record["cheque_image_file_name"];
            echo "<option value='$image_id'>$image_file_name</option>";

        }
    }

} else {
    echo "<option value=''>Choose Template</option>";
}
?>
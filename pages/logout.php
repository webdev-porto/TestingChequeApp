<?php
echo "test";
require ("../includes/connection.php");
//$db = new Database($config["test_database"]);
$db = new Database($config["live_database"]);

session_start();
$loged_status = 0;
$sql = "UPDATE table3_user_account SET 
                  logedin=?
                  WHERE user_account_id=?";
$statment = $db->pdo->prepare($sql);
$statment->execute([
    $loged_status,
    $_SESSION['loged_account_id']
]);
session_unset();
session_destroy();
header("location:../index.php");
exit;

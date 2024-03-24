<?php
// Check if 'uname' is set in the POST request
require ("../../includes/connection.php");
if (isset ($_POST["lvl1_btn"])) {
    $db = new Database($config["live_database"]);
    //var_dump(getallheaders());
    if (isset ($_POST['uname'])) {
        $submitted_user_name = trim($_POST['uname']);
        // echo 'the submited data is' . $submitted_user_name . '';

        if ($submitted_user_name == "") {
            echo '<script>';
            echo 'document.getElementById("error1").innerText="User Name Cant\'t Be Left Empty"';
            echo '</script>';
        } else {
            $sql = "SELECT * FROM table3_user_account
                    WHERE user_account_username='$submitted_user_name'";

            $statment = $db->pdo->prepare($sql);
            // var_dump($statment);
            $statment->execute();
            if ($statment->rowCount() == 0) {
                echo '<script>';
                echo 'document.getElementById("error1").innerText="The User Doesn\'t Exist"';
                echo '</script>';
            } else {
                $data = $statment->fetchAll();

                foreach ($data as $record) {
                    $user_name = $record["user_account_username"];
                    echo "the user name " . $user_name . " is stored in db<br>";
                }
            }
        }

    } else {
        echo '<script>';
        echo 'document.getElementById("error1").innerText="somthing"';
        echo '</script>';
    }


    // echo "Working";
} else {
    echo '<script>';
    echo 'document.getElementById("error1").innerText="Somthing Went Wrong"';
    echo '</script>';
}
/*if (isset($_POST['nameInput'])) {
    $submitted_user_name = $_POST['nameInput'];

    if ($submitted_user_name == "") {
        echo '<script>';
        echo 'document.getElementById("error").innerText="input is empty"';
        echo '</script>';
    } else {
        $db = new Database($config["test_database"], "root", "");
        $sql = "SELECT * FROM table3_user_account
        WHERE user_account_username='$submitted_user_name'";
        echo $sql;
    }


} else {
    echo "not there";
}
*/
?>
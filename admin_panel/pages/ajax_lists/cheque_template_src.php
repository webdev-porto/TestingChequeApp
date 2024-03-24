<?php
require ("../../includes/connection.php");
if (isset ($_POST["imgId"])) {
    session_start();
    if (isset ($_SESSION['loged_account_id'])) {
        $user_id = $_SESSION['loged_account_id'];
        $imgId = $_POST["imgId"];
    } else {

        header("location:../../pages/logout.php");

        exit;
    }
    //$db = new Database($config["test_database"]);
    $db = new Database($config["live_database"]);

    $sql = "SELECT * FROM table5_cheque_image
    WHERE cheque_image_id='$imgId'";
    $statment = $db->pdo->prepare($sql);
    //var_dump($statment);
    $statment->execute();
    if ($statment->rowCount() == 0) {
        // echo "Select";
        echo "";

    } else {
        $data = $statment->fetchAll();
        foreach ($data as $record) {
            $image_file = $record["cheque_image_file"];
            //  echo "<option value='$image_id'>$image_file_name</option>";
            //echo '<img id="cheque_image_src" src="' . $image_file . '" alt="" />';

        }
        echo $image_file;

    }

} else {
    echo "fail";
    //   echo "<option value=''>Choose Template</option>";
}
?>
<?php

function showCheques($db, $sql, $search = "all")
{
    //require($con);
    if ($search == "all") {
        $statment = $db->pdo->prepare($sql);
        //var_dump($statment);
        $statment->execute();
        if ($statment->rowCount() == 0) {
            echo '<script>';
            echo 'document.getElementById("data_error").innerText="There are no Cheques Saved in the system"';
            echo '</script>';
            return;
        }
    } elseif ($search == "recipient") {
        # code...
        $statment = $db->pdo->prepare($sql);
        //var_dump($statment);
        $statment->execute();
        if ($statment->rowCount() == 0) {
            echo '<script>';
            echo 'document.getElementById("data_error").innerText="There are no Recipient Name Similar to your input"';
            echo '</script>';
            return;
        }

    }
    $data = $statment->fetchAll();
    $counter = 1;
    echo '<table>';
    echo '<tr>';
    echo '<th> Controls </th>';
    //echo '<th> File Name </th>';
    echo '<th> Due Date </th>';

    echo '<th> Amount </th>';

    echo '<th> Recipient Name </th>';

    // echo '<th> Bank Name </th>';
    echo '<th> # </th>';

    echo '</tr>';
    foreach ($data as $record) {
        //$bankname = $record["bank_name"];

        $cheque_id = $record['cheque_data_id'];
        $cheque_date = $record["cheque_date"];
        $cheque_pay_name = $record["cheque_pay_name"];
        $cheque_amount = $record["cheque_amount"];
        $cheque_currency = $record["cheque_currency"];




        echo "<tr>";
        echo '<td class="controls">';
        echo '<button class="delete" id="cheque' . $counter . '" onclick="open_popup(' . $counter . ')">';

        // echo '<button class="delete">';
        echo "<span class='icofont-ui-delete'></span>";
        echo '</button>';

        echo '<a href="edit_cheque.php?cheque_id=' . $cheque_id . '"> <span class="icofont-eye"></span> </a>';
        echo '</td>';

        // echo "<td class='file_link'><img src='$image_link' alt='$image_name'> $image_name</td> 
        echo "<td>$cheque_date</td>";

        echo "<td> $cheque_currency $cheque_amount</td>";

        echo "<td>$cheque_pay_name</td>";

        // echo "<td>$bankname</td>";

        echo "<td>$counter</td>";
        echo " </tr>";

        echo '<div id="pop' . $counter . '" class="pop">';

        echo "<div class='warrning_messge'>";
        echo "<button class='icofont-ui-close' onclick='close_pop($counter)'></button>";
        echo "<h1>Deleting A Cheque Will Result In The Following Data Removed:</h1>";
        echo '<ul>';
        echo '<li>All Data Associated With This Cheque</li>';
        echo '</ul>';



        echo "<a href=processor.php?del_cheque_id=$cheque_id>Delete Now</a>";


        echo "</div>";

        echo '</div>';

        $counter += 1;

    }
    echo "</table>";
}

function deleteCheques($conn, $cheque_id)
{
    require ($conn);
    //$db = new Database($config["test_database"]);
    $db = new Database($config["live_database"]);

    $sql = "DELETE FROM table6_saved_cheque_data WHERE cheque_data_id='$cheque_id'";
    $statment = $db->pdo->prepare($sql);
    var_dump($statment);
    $statment->execute();
    header("location: manage_cheques.php");
}

function showBanks($db, $sql, $search = "all")
{
    if ($search == "all") {
        $statment = $db->pdo->prepare($sql);
        // var_dump($statment);
        $statment->execute();
        if ($statment->rowCount() == 0) {
            echo '<script>';
            echo 'document.getElementById("data_error").innerText="There are no Bank Saved in the system"';
            echo '</script>';
            return;
        }
    } elseif ($search == "bank") {
        # code...
        $statment = $db->pdo->prepare($sql);
        // var_dump($statment);
        $statment->execute();
        if ($statment->rowCount() == 0) {
            echo '<script>';
            echo 'document.getElementById("data_error").innerText="There are no Bank Name Similar to your input"';
            echo '</script>';
            return;
        }

    }

    $data = $statment->fetchAll();
    $counter = 1;
    echo '<table>';
    echo '<tr>';
    echo '<th> Controls </th>';
    echo '<th> Bank Name </th>';
    echo '<th> # </th>';

    echo '</tr>';
    foreach ($data as $record) {
        $bankname = $record["bank_name"];
        $bank_id = $record["bank_id"];
        //$uname = $record["user_account_username"];
        //
        echo "<tr>";
        echo '<td class="controls">';
        // echo '<a href="#" ></a>';
        //


        echo '<button class="delete" id="bank' . $counter . '" onclick="open_popup(\'delete\',' . $counter . ')">';
        echo "<span class='icofont-ui-delete'></span>";
        echo '</button>';

        echo '<button class="edite" id="edit_bank' . $counter . '" onclick="open_popup(\'edite\',' . $counter . ')">';
        echo "<span class='icofont-ui-edit'></span>";
        echo '</button>';

        echo '<a class="view" href="template_details.php?bank_id=' . $bank_id . '" class="view_bank">';
        echo "<span class='icofont-eye'></span>";
        echo '</a>';

        echo '</td>';

        echo "<td>$bankname</td> <td>$counter</td>";
        echo " </tr>";

        //del pop up code start
        echo '<div id="del_pop' . $counter . '" class="pop">';
        // echo $bank_id;

        echo "<div class='warrning_messge'>";
        echo '<button class="icofont-ui-close" onclick=close_pop(\'delete\',' . $counter . ')></button>';
        echo "<h1>Deleting A Bank Will Result In The Following Data Removed:</h1>";
        echo '<ul>';
        echo '<li>All Information Related To The Bank</li>';
        echo '<li>All Cheques Data Associated With The Bank</li>';
        echo '<li>All Bank Images Template For The Selected Bank</li>';
        echo '</ul>';
        echo "<a href=processor.php?del_bank_id=$bank_id>Delete Now</a>";
        echo "</div>";

        echo '</div>';
        //del pop end

        //edite pop start
        echo '<div id="edite_pop' . $counter . '" class="pop">';

        echo "<div class='edite_messge'>";
        echo '<button class="icofont-ui-close" onclick=close_pop(\'edite\',' . $counter . ')></button>';
        echo '<form action="processor.php" method="get">
        <input class="hide" type="number" value="' . $bank_id . '" name="bank_id">
        <input class="update_data" type="text" placeholder="Enter Bank Name" value="' . $bankname . '" name="bank_name">
        <input type="submit" value="Update" name="update_bank">
        </form>';

        echo '</div>';

        echo '</div>';
        //edite pop end

        //echo "</div>";

        $counter += 1;

    }
    echo "</table>";
}

function deleteBank($conn, $bank_id)
{
    require ($conn);
    //$db = new Database($config["test_database"]);
    $db = new Database($config["live_database"]);

    $sql = "DELETE FROM table4_bank WHERE bank_id='$bank_id'";
    $statment = $db->pdo->prepare($sql);
    //var_dump($statment);
    $statment->execute();
    header("location: manage_banks.php");
    //echo $sql;
}
function updateBank($conn, $bank_id, $bank_name)
{
    //  echo $conn;
    require ("../" . $conn);

    //$db = new Database($config["test_database"]);
    $db = new Database($config["live_database"]);

    var_dump($db);
    $sql = "UPDATE table4_bank SET bank_name=?
    WHERE bank_id=?";
    $statment = $db->pdo->prepare($sql);
    $statment->execute([$bank_name, $bank_id]);
    header("location: manage_banks.php");

}

function addBank($db, $sql, $bank_name)
{
    $statment = $db->pdo->prepare($sql);
    //var_dump($statment);
    $statment->execute([$bank_name]);

}


function saveChequesData(
    $db,
    $sql,
    $cheque_date,
    $cheque_recipient,
    $cheque_amount_number,
    $cheque_currancy,
    $cheque_amount_words,
    $loged_uid
) {
    if (isset ($loged_uid) && $loged_uid != "") {
        //  echo "data filled";


        $statment = $db->pdo->prepare($sql);

        $statment->execute([
            $cheque_date,
            $cheque_recipient,
            $cheque_amount_number,
            $cheque_currancy,
            $cheque_amount_words,
            $loged_uid,
        ]);
        echo '<script>';
        echo 'document.getElementById("msg").innerHTML="Data Has Been Saved"';
        echo '</script>';

    } else {
        // some error triggred
        //  echo "some error user loged out mid process";
        echo '<script>';
        echo 'document.getElementById("right_error").innerHTML="User has To Be Loged in To Save The Data"';
        echo '</script>';
    }
}



/*
Files Folder and Images
*/

function showTempaltes(
    $db,
    $sql,
    $bank_id
) {
    $statment = $db->pdo->prepare($sql);
    // var_dump($statment);
    $statment->execute();
    $data = $statment->fetchAll();
    foreach ($data as $record) {
        # code...

        $template_id = $record['cheque_image_id'];
        $template_file = $record['cheque_image_file'];
        $template_name = $record['cheque_image_file_name'];
        $template_upload_date = $record['upload_date'];

        echo "<div class='item'>";
        echo '<a href="processor.php?del_temp_id=' . $template_id . '">';
        echo '<span class="icofont-close-squared-alt"></span>';
        echo '</a>';
        echo '<img src="' . $template_file . '" alt="' . $template_name . '">';
        echo "<span class='template_date'>$template_upload_date</span>";
        echo "</div>";


    }

}



function fileProcesser($file, $allowed_types)
{
    $file_size = $file["size"];
    $file_ext = pathinfo($file["name"], PATHINFO_EXTENSION);
    $error_message = "";

    if ($file_size > 7000000 || $file_size <= 0 || !in_array(strtolower($file_ext), $allowed_types)) {
        if ($file_size > 7000000) {
            $error_message .= "Error - Max File Size 7 MB<br>";
        }
        if ($file_size <= 0) {
            $error_message .= "Error - Unable to Identify The File Choose Another One<br>";
        }
        //if ($file["type"] == "") {
        /**/
        if (!in_array(strtolower($file_ext), $allowed_types)) {
            $error_message .= "Error - This File Not Supported<br>";
        }
        echo '<script>';
        echo 'document.getElementById("add_template_error").innerHTML="' . $error_message . '"';
        echo '</script>';
        return false;
    } else {
        //only if no error is trigrred
        echo '<script>';
        echo 'document.getElementById("add_template_msg").innerHTML="Uploaded Sucessfully"';
        echo '</script>';
        return true;
    }




}

function createUserFolders(
    $db,
    $bank_id

) {
    //echo "folder created";
    // require($conn);


    $sql = "SELECT table4_bank.bank_name 
    FROM
    table4_bank
    WHERE table4_bank.bank_id='$bank_id'";

    $statment = $db->pdo->prepare($sql);
    //var_dump($statment);
    $statment->execute();
    $data = $statment->fetchAll();
    foreach ($data as $record) {
        $bank_name = $record["bank_name"];
    }

    try {
        $main_folder = "../../images/templates/";
        $full_path = $main_folder . $bank_name . "/";
        //echo $full_path;
        if (!file_exists($full_path)) {
            mkdir($full_path, 0777, recursive: true);
            //directory permission

            chmod($full_path, 0777);
        }

        //upload_template($db, $full_path, );

        return $full_path;

    } catch (Exception $e) {
        echo "" . $e->getMessage() . "";
        return false;
    }


}


function upload_template($db, $file, $full_path, $bank_id, $upload_date)
{
    //require_once($conn);

    $file_ext = pathinfo($file["name"], PATHINFO_EXTENSION);

    $sql = "SELECT MAX(table5_cheque_image.cheque_image_id) 
    AS maximum_id
    FROM table5_cheque_image";
    $statment = $db->pdo->prepare($sql);
    //var_dump($statment);
    $statment->execute();
    $data = $statment->fetchAll();
    foreach ($data as $record) {
        $maximum_id = $record["maximum_id"];
    }
    $next_id = (int) $maximum_id + 1;
    $new_file_name = "template" . $next_id . "." . $file_ext;
    $full_path .= $new_file_name;
    //echo basename($file);
    //echo "<hr>" . $full_path . "<hr>";
    //create script to upload from abloute path
    move_uploaded_file($file["tmp_name"], $full_path);


    //echo "TESSST";
    // var_dump([$full_path, $new_file_name, $upload_date, $bank_id]);
    try {
        $subtracted_full_path = substr($full_path, 6);
        $db_full_path = "https://ptscheques.com/" . $subtracted_full_path;
        //echo "the full path" . $db_full_path;
        $sql = "INSERT INTO table5_cheque_image 
        (cheque_image_file, 
        cheque_image_file_name, 
        upload_date, 
        fk_bank_id)
        VALUES(?,?,?,?)";
        $statment = $db->pdo->prepare($sql);
        //var_dump($statment);
        $statment->execute([$db_full_path, $new_file_name, $upload_date, $bank_id]);
    } catch (Exception $e) {
        echo "" . $e->getMessage() . "";
    }

}


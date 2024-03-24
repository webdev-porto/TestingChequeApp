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



function saveChequesData(
    $db,
    $sql,
    $cheque_date,
    $cheque_recipient,
    $cheque_amount_number,
    $cheque_currancy,
    $cheque_amount_words,
    $cheque_crossing,
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
            $cheque_crossing,
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








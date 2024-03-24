<?php
session_start();
if (!isset ($_SESSION["loged_account_id"])) {
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
    <title>PTS - CHEQUE APP - Edite Cheque</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../styles/icons/icofont.css" />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Protest+Strike&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../styles/top_menu.css" />

    <link rel="stylesheet" href="../styles/side_menu.css" />
    <link rel="stylesheet" href="../styles/mobile_menu.css" />

    <link rel="stylesheet" href="../styles/edite_cheque.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
        <?php
        require ("include/mobile_menu.php");
        ?>
        <section>
            <!--Side Menu-->
            <?php
            require ("include/side_menu.php");
            ?>

            <div class="panel">
                <div id="top_controls">

                    <select name="" id="change_bank_id" required>
                        <option value="">Select Bank</option>
                        <?php
                        $loged_uid = $_SESSION["loged_account_id"];
                        require ("../includes/connection.php");
                        //$db = new Database($config["test_database"]);
                        $db = new Database($config["live_database"]);

                        $sql = "SELECT table4_bank.bank_id, table4_bank.bank_name 
                        FROM table4_bank";
                        $statment = $db->pdo->prepare($sql);
                        // var_dump($statment);
                        $statment->execute();
                        if ($statment->rowCount() == 0) {
                            echo "Some Eroor ";
                        } else {
                            $data = $statment->fetchAll();
                            foreach ($data as $record) {
                                $bank_id = $record["bank_id"];
                                //echo $bank_id;
                                $bank_name = $record["bank_name"];
                                echo "<option value=" . $bank_id . ">" . $bank_name . "</option>";
                            }

                        }


                        ?>

                    </select>
                    <h1 id="title1"> - </h1>
                    <!--Image Drop Down Template-->
                    <select name="" id="change_template_id" required>
                        <?= "<option value=''>Choose Template</option>" ?>

                    </select>

                </div>

                <?php


                if (isset ($_GET["cheque_id"]) && $_GET["cheque_id"] != "") {
                    $cheque_id = $_GET["cheque_id"];

                    $loged_uid = $_SESSION["loged_account_id"];
                    $sql = "SELECT 
                    table6_saved_cheque_data.* 
                    FROM table6_saved_cheque_data 
                    
                    WHERE table6_saved_cheque_data.cheque_data_id = '$cheque_id'";


                    $statment = $db->pdo->prepare($sql);
                    // var_dump($statment);
                    $statment->execute();
                    $data = $statment->fetchAll();
                    //echo var_dump($data);
                    foreach ($data as $record) {
                        $cheque_data_id = $record["cheque_data_id"];
                        $cheque_date = $record["cheque_date"];
                        $cheque_recipient = $record["cheque_pay_name"];
                        $cheque_amount_number = $record["cheque_amount"];
                        $cheque_currency = $record["cheque_currency"];

                        $cheque_amount_words = $record["cheque_words_amount"];
                        $cheque_crossing = $record["cheque_crossing"];
                        //   $image_file = $record["cheque_image_file"];
                        //    echo "lllllllllllll" . $cheque_currency;
                    }
                }

                ?>

                <!--Cheque Output-->
                <div id="data_output">
                    <img id="cheque_image_src" src="#" alt="" />
                    <div class="warapper_data_cell" id="warapper_data_cell">
                        <div id="output_cheque_date" class="data_cell">
                            <?= date("m/d/Y", strtotime($cheque_date)) ?>

                        </div>
                        <div id="output_the_recipent_name" class="data_cell">
                            <?= $cheque_recipient ?>
                        </div>
                        <div id="output_the_amount_numbers" class="data_cell">
                            <?= "#$cheque_amount_number#" ?>

                        </div>
                        <div id="output_the_amount_words" class="data_cell">
                            <?php
                            $sql = "SELECT * FROM list1_cheque_currancy 
                            WHERE cheque_currency='$cheque_currency'";
                            $statment = $db->pdo->prepare($sql);
                            // var_dump($statment);
                            $statment->execute();
                            $data = $statment->fetchAll();
                            foreach ($data as $record) {
                                //get the text represntaion of the currrancy
                                $cheque_currency_words = $record["cheque_currency_words"];

                            }

                            ?>
                            <?= "#$cheque_amount_words $cheque_currency_words#" ?>

                        </div>
                        <div id="output_crossing" class="data_cell">
                            <?= $cheque_crossing ?>
                        </div>


                    </div>

                </div>
                <div id="bottom_controls">
                    <button id="reset_data" onclick="reset_data()">
                        Clear All Data
                    </button>
                    <button id="print_cheque" onclick="printCheque()">
                        Print Cheque
                    </button>
                </div>
            </div>

            <!--Cheque Input-->
            <aside class="right">
                <h1 id="title2"> </h1>
                <h2>Fill The Data Bellow</h2>

                <form id="cheque_data_form" action="processor.php?cheque_data_id=<?= $cheque_data_id ?>" method="POST">

                    <div class="data_input">
                        <label for="input_cheque_date">
                            <button id="if1" class="fontControl" onclick="increaseFont(this)">+</button>

                            Cheque Date
                            <button id="df1" class="fontControl" onclick="reduceFont(this)">-</button>

                        </label>
                        <input type="date" id="input_cheque_date" name="input_cheque_date"
                            onchange="write_value('input_cheque_date','output_cheque_date')"
                            value="<?= $cheque_date ?>" />
                    </div>
                    <!--<div class="row">

                    
                        <div class="data_input">
                            <label for="input_cheque_end_date">End Date</label>
                            <input type="date" id="input_cheque_end_date" name="input_cheque_end_date" />
                        </div>
                  
                    </div>      -->

                    <div class="data_input">
                        <label for="input_recipient_name">
                            <button id="if2" class="fontControl" onclick="increaseFont(this)">+</button>

                            Recipient Name

                            <button id="df2" class="fontControl" onclick="reduceFont(this)">-</button>

                        </label>
                        <input type="text" id="input_recipient_name" name="input_recipient_name"
                            placeholder="Please Enter Recipient Name"
                            oninput="write_value('input_recipient_name','output_the_recipent_name')"
                            value="<?= $cheque_recipient ?>" />
                    </div>

                    <div class="data_input">
                        <label for="#">
                            <button id="if3" class="fontControl" onclick="increaseFont(this)">+</button>

                            Amount & Currency
                            <button id="df3" class="fontControl" onclick="reduceFont(this)">-</button>
                        </label>
                        <div class="row">

                            <select id="input_currency" name="input_currency">

                                <?php
                                $sql = "SELECT * FROM list1_cheque_currancy";
                                $statment = $db->pdo->prepare($sql);
                                // var_dump($statment);
                                $statment->execute();
                                $data = $statment->fetchAll();
                                foreach ($data as $record) {
                                    $currancy_id = $record["cheque_currency_id"];
                                    $currancy = $record["cheque_currency"];
                                    // echo "The " . $currancy;
                                    // print_r([$cheque_currancy, $currancy]);
                                    if ($cheque_currency == $currancy) {
                                        echo '<option value=' . $cheque_currency . ' selected>' . $cheque_currency . '</option>';

                                    } else {
                                        echo '<option value=' . $currancy . '>' . $currancy . '</option>';

                                    }

                                }

                                ?>

                            </select>

                            <input min="1" type="number" step="0.25" type="number" id="input_amount_number"
                                name="input_amount_number" placeholder="Please Enter Amount"
                                oninput="write_value('input_amount_number','output_the_amount_numbers')"
                                value="<?= $cheque_amount_number ?>" />
                        </div>
                    </div>

                    <div class="data_input">
                        <label for="input_amount_words">
                            <button id="if4" class="fontControl" onclick="increaseFont(this)">+</button>

                            Amount In Words
                            <button id="df4" class="fontControl" onclick="reduceFont(this)">-</button>
                        </label>
                        <input type="text" id="input_amount_words" placeholder="Please Enter Amount In Words"
                            name="input_amount_words" value="<?= $cheque_amount_words ?>" readonly />
                    </div>

                    <div class="data_input">
                        <label for="input_crossing">
                            <button id="if5" class="fontControl" onclick="increaseFont(this)">+</button>

                            Crossing
                            <button id="df5" class="fontControl" onclick="reduceFont(this)">-</button>
                        </label>
                        <select name="input_crossing" id="input_crossing"
                            onchange="write_value('input_crossing','output_crossing')">
                            <option value="">Select Crossing</option>
                            <?php
                            if ($cheque_crossing != "") {
                                if ($cheque_crossing == "A/C PAYEE ONLY") {
                                    echo '<option value="A/C PAYEE ONLY" selected>A/C PAYEE ONLY</option>';
                                    echo '<option value="CASH ONLY">CASH ONLY</option>';
                                    echo '<option value="NOT NEGOTIABLE">NOT NEGOTIABLE</option>';
                                } elseif ($cheque_crossing == "CASH ONLY") {
                                    # code...
                                    echo '<option value="A/C PAYEE ONLY">A/C PAYEE ONLY</option>';
                                    echo '<option value="CASH ONLY" selected>CASH ONLY</option>';
                                    echo '<option value="NOT NEGOTIABLE">NOT NEGOTIABLE</option>';
                                } else {
                                    echo '<option value="A/C PAYEE ONLY">A/C PAYEE ONLY</option>';
                                    echo '<option value="CASH ONLY">CASH ONLY</option>';
                                    echo '<option value="NOT NEGOTIABLE" selected>NOT NEGOTIABLE</option>';
                                }

                            } else {
                                echo '<option value="A/C PAYEE ONLY">A/C PAYEE ONLY</option>';
                                echo '<option value="CASH ONLY">CASH ONLY</option>';
                                echo '<option value="NOT NEGOTIABLE">NOT NEGOTIABLE</option>';
                            }


                            ?>

                        </select>

                    </div>
                    <input type="submit" value="Save Cheque" name="update_saved_cheq" />
                    <span class="msg" id="msg"></span>
                    <span class="error" id="right_error"></span>

                </form>
            </aside>
        </section>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/Draggable.min.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

    <script src="../scripts/switch_menu.js" defer></script>
    <script src="../scripts/mobile_menu.js"></script>

    <script src="../scripts/fill_cheques.js" defer></script>
    <script src="../scripts/print_cheques.js" defer></script>

    <script>
        Draggable.create(".data_cell", {
            bounds: document.getElementById("data_output"),
            onDragEnd: function () {
                getPosDimension();
            },
        });


    </script>
    <script>
        $(document).ready(
            function () {
                //start of bank change drop down

                $('#change_bank_id').change(function () {
                    //console.log("hi")
                    var bank_id = $('#change_bank_id').val();
                    //console.log("hi" + bank_id)
                    $.ajax({
                        type: 'POST',
                        url: 'ajax_lists/bankname_list.php',
                        data: { bankId: bank_id },
                        success: function (data) {
                            $('#title1').html(data)
                            $('#title2').html(data)
                        }
                    });


                    //
                    $.ajax({
                        type: 'POST',
                        url: 'ajax_lists/template_name_list.php',
                        data: { bankId: bank_id },
                        success: function (data) {
                            $('#change_template_id').html(data)
                            // $('#title2').html(data)

                        }
                    })


                });
                //end of bank change drop down
                //cheque_image_src

                $('#change_template_id').change(function () {
                    //pass the selected image id to the right side form for later insert
                    var selected_image_id = $('#change_template_id').val();
                    $("#chosen_image_id").val(selected_image_id)
                    $.ajax({
                        type: 'POST',
                        url: 'ajax_lists/cheque_template_src.php',
                        data: { imgId: selected_image_id },
                        success: function (data) {
                            //    console.log("aaaaaaaaaaaaaaaaaa" + data)
                            $('#cheque_image_src').attr("src", data)
                            $('#cheque_image_src').css("display", "unset")

                        }
                    });
                })
            }
        )
    </script>

    <script defer>
        let ele1 = document.getElementsByTagName("main")[0]
        let ele2 = document.querySelectorAll("nav")
    </script>

    <script>

        //alert("window width" + window.innerWidth)

        //desktop /mobile
        //desktop
        var date_fsize = 1
        var name_fsize = 1
        var amnc_fsize = 1
        var amw_fsize = 1
        var crossing_fsize = 1

        let fontControlEle = document.querySelectorAll(".fontControl")
        fontControlEle.forEach(element => {
            element.addEventListener("click", (event) => {
                event.preventDefault()

                output_cell = document.querySelectorAll(".data_cell")
                //console.log("working0")
            })
        });


        function increaseFont(ele_btn) {
            if (ele_btn.id == "if1") {
                date_fsize += 0.1;
                output_cell[0].style.fontSize = `${date_fsize}em`

            }
            else if (ele_btn.id == "if2") {
                name_fsize += 0.1;
                output_cell[1].style.fontSize = `${name_fsize}em`
            }
            else if (ele_btn.id == "if3") {
                amnc_fsize += 0.1;
                output_cell[2].style.fontSize = `${amnc_fsize}em`
            }
            else if (ele_btn.id == "if4") {
                amw_fsize += 0.1;
                output_cell[3].style.fontSize = `${amw_fsize}em`
            }
            else {
                crossing_fsize += 0.1;
                output_cell[4].style.fontSize = `${crossing_fsize}em`
            }
        }
        function reduceFont(ele_btn) {
            if (ele_btn.id == "df1") {
                date_fsize -= 0.1;
                output_cell[0].style.fontSize = `${date_fsize}em`

            }
            else if (ele_btn.id == "df2") {
                name_fsize -= 0.1;
                output_cell[1].style.fontSize = `${name_fsize}em`
            }
            else if (ele_btn.id == "df3") {
                amnc_fsize -= 0.1;
                output_cell[2].style.fontSize = `${amnc_fsize}em`
            }
            else if (ele_btn.id == "df4") {
                amw_fsize -= 0.1;
                output_cell[3].style.fontSize = `${amw_fsize}em`
            }
            else {
                crossing_fsize -= 0.1;
                output_cell[4].style.fontSize = `${crossing_fsize}em`
            }
        }
    </script>



</body>

</html>
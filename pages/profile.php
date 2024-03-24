<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>PTS - CHEQUE APP - Fill Cheque</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../styles/icons/icofont.css" />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Protest+Strike&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../styles/top_menu.css" />

    <link rel="stylesheet" href="../styles/side_menu.css" />
    <link rel="stylesheet" href="../styles/profile.css" />

</head>

<body>
    <!--[if lt IE 7]>
      <p class="browsehappy">
        You are using an <strong>outdated</strong> browser. Please
        <a href="#">upgrade your browser</a> to improve your experience.
      </p>
    <![endif]-->

    <?php
    require("include/top_menu.php");
    ?>
    <main>
        <section>
            <!--Side Menu-->
            <?php
            require("include/side_menu.php");
            ?>

            <div class="panel">
                <div id="top_controls">




                </div>

                <!--Cheque Output-->
                <div id="data_output">

                    <img id="cheque_image_src" src="#" alt="" />
                    <div class="warapper_data_cell" id="warapper_data_cell">
                        <div id="output_cheque_date" class="data_cell"></div>
                        <div id="output_the_recipent_name" class="data_cell"></div>
                        <div id="output_the_amount_numbers" class="data_cell"></div>
                        <div id="output_the_amount_words" class="data_cell"></div>
                    </div>

                </div>
                <div id="bottom_controls">
                    <button id="reset_data" onclick="reset_data()">
                        Clear All Data
                    </button>
                    <button id="print_cheque" onclick="print_cheque()">
                        Print Cheque
                    </button>
                </div>
            </div>


        </section>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <script src="../scripts/switch_menu.js" defer></script>






</body>

</html>
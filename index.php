<?php
session_start();
if (isset ($_SESSION["loged_account_id"])) {
  echo "logged in";
  header("location: pages/manage_cheques.php");
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
  <title>PTS - CHEQUE APP - LOGIN</title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Protest+Strike&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="styles/icons/icofont.css" />

  <link rel="stylesheet" href="styles/index.css" />
</head>

<body>
  <!--[if lt IE 7]>
      <p class="browsehappy">
        You are using an <strong>outdated</strong> browser. Please
        <a href="#">upgrade your browser</a> to improve your experience.
      </p>
    <![endif]-->


  <main>
    <section>
      <div class="left">
        <h1>PORTO TECHNOLOGY SOLUTIONS</h1>
        <h2>Cheque App Genrator</h2>
      </div>
      <div class="right">
        <div class="panel">
          <form action='<?= htmlentities($_SERVER['PHP_SELF']); ?>' method="POST">
            <div class="row">
              <label for="uname">
                <span class="icofont-business-man"></span>
                <span> USER NAME </span>
              </label>
              <span class="error" id="user_error"></span>
            </div>
            <div class="row">
              <input type="text" id="uname" name="uname" oninput="resetError('user_error')" />
            </div>

            <div class="row">
              <label for="upass">
                <span class="icofont-ui-lock"></span>
                <span>PASSWORD</span>
              </label>
              <span class="error" id="password_error"></span>
            </div>
            <div class="row">
              <input type="password" id="upass" name="upass" oninput="resetError('password_error')" />
              <span id="show_hide_pass" class="icofont-eye-blocked" onclick="show_hide_pass()"></span>
            </div>

            <div class="row">
              <div id="submit_btn">
                <input type="submit" value="login" name="login" />
                <button class="icofont-login"></button>
              </div>

              <a href="#" id="forget_pass_btn">
                Forget Password
              </a>
            </div>
          </form>
          <?php
          if (isset ($_POST["login"])) {
            $uname = trim($_POST["uname"]);
            $upass = trim($_POST["upass"]);
            require ("includes/connection.php");
            //$db = new Database($config["test_database"]);
            $db = new Database($config["live_database"]);
            login_validation($db, $uname, $upass);
          }

          function login_validation($db, $uname, $upass)
          {

            $sql = "SELECT table1_client.client_name, table3_user_account.* FROM table3_user_account
                    INNER JOIN table1_client
                    ON table1_client.client_id=table3_user_account.fk_client_id
                    WHERE table3_user_account.user_account_username='$uname'";


            $statment = $db->pdo->prepare($sql);
            // var_dump($statment);
            $statment->execute();
            if ($statment->rowCount() == 0) {
              //  couldnt find user name in db
              echo '<script>';
              echo 'document.getElementById("user_error").innerText="Invalid User Name"';
              echo '</script>';
              return;
            } else {
              $data = $statment->fetchAll();

              foreach ($data as $record) {

                $stored_account_id = $record['user_account_id'];
                $stored_username = $record["user_account_username"];
                $stored_password_hash = $record["user_account_password"];
                $stored_client_id = $record["fk_client_id"];
                $stored_client_name = $record["client_name"];
                $loged_status = $record["logedin"];
              }
              if ($stored_client_id == NULL || $stored_account_id == "") {
                echo '<script>';
                echo 'document.getElementById("user_error").innerText="This User Is Not Assigned to Client Yet"';
                echo '</script>';
                return;
              }
              if (password_verify($upass, $stored_password_hash)) {
                // in here function will be trigrred to check for the api key associated with client
          
                $found_key = find_api_key($db, $stored_client_id);



                if (!$found_key) {
                  //missing key from db
                  echo '<script>';
                  echo 'document.getElementById("user_error").innerText="The Account Has Expired Please Renew Your License"';
                  echo '</script>';
                  return;
                } else if ($loged_status == 1) {
                  echo '<script>';
                  echo 'document.getElementById("user_error").innerText="You Are Loged in From Another Device Please Log out First"';
                  echo '</script>';
                } else {
                  //echo 'clicked2';
                  //  session_start();
                  $_SESSION['loged_account_id'] = $stored_account_id;
                  $_SESSION['loged_user_name'] = $stored_username;
                  $_SESSION['client_id'] = $stored_client_id;
                  $_SESSION['client_name'] = $stored_client_name;
                  $loged_status = 1;
                  $sql = "UPDATE table3_user_account SET 
                  logedin=?
                  WHERE user_account_id=?";
                  $statment = $db->pdo->prepare($sql);
                  $statment->execute([
                    $loged_status,
                    $stored_account_id
                  ]);

                  try {
                    header("location: pages/manage_cheques.php");

                  } catch (Exception $e) {
                    var_dump($e->getMessage());
                  }

                }

              } else {
                //invalid password
          
                echo '<script>';
                echo 'document.getElementById("password_error").innerText="Invalid Password"';
                echo '</script>';
                return;
              }
            }
          }

          function find_api_key($db, $stored_client_id)
          {
            //function which will validate an api key using client id to confirm
            //if an account associated with client has an api key 
            //return api_key_number if pass
            $sql = "SELECT * FROM table2_apikey
            WHERE fk_client_id='$stored_client_id'";
            $statment = $db->pdo->prepare($sql);
            $statment->execute();
            if ($statment->rowCount() == 0) {
              //api key is not found and they should be denied access
              return false;
            } else {
              $data = $statment->fetchAll();
              foreach ($data as $record) {
                $api_number = $record["apikey_number"];
                $api_exp = $record["apikey_expiary_date"];
                $today_date = date("Y-m-d");

                if ($today_date <= $api_exp) {
                  return $api_number;
                } else {

                  return false;
                }
              }

            }
          }


          ?>
        </div>
      </div>
    </section>
  </main>

  <script src="scripts/index.js" defer></script>
</body>

</html>
<?php
session_start();
if (isset ($_SESSION["loged_admin_account_id"])) {
  // header("location: pages/manage_cheques.php");
  header("location: pages/manage_banks.php");

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
  <title>PTS - CHEQUE APP - Admin Login</title>
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
        <h2>Admin Panel - Cheque App Genrator</h2>
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
            $sql = "SELECT table0_admin.admin_id,
            table0_admin.admin_username,
            table0_admin.admin_password,
            table0_admin.admin_role
            FROM table0_admin 
            WHERE table0_admin.admin_username='$uname'";
            $statment = $db->pdo->prepare($sql);
            $statment->execute();


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
                $stored_account_id = $record['admin_id'];
                $stored_username = $record["admin_username"];
                $stored_password_hash = $record["admin_password"];
                $stored_account_role = $record["admin_role"];

              }
              if ($stored_account_role != "Super Admin") {
                echo '<script>';
                echo 'document.getElementById("user_error").innerText="Only Super Admins Are Allowed To Use This System"';
                echo '</script>';
                return;

              }

              if (password_verify($upass, $stored_password_hash)) {
                $_SESSION['loged_admin_account_id'] = $stored_account_id;
                $_SESSION['loged_admin_user_name'] = $stored_username;

                try {
                  header("location: pages/manage_banks.php");

                  //echo "loged in2";
          
                } catch (Exception $e) {
                  var_dump($e->getMessage());
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




          ?>
        </div>
      </div>
    </section>
  </main>

  <script src="scripts/index.js" defer></script>
</body>

</html>
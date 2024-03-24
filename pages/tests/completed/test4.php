<!-- 
  index.html
The current test cas has been completed and ready for development
-->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>htmx Example</title>
  <script src="https://unpkg.com/htmx.org@1.7.0/dist/htmx.js"></script>
  <script src="https://unpkg.com/hyperhtml@2.5.0/umd/index.min.js"></script>
  <style>
    .error {
      color: red;
    }
  </style>

</head>

<body>

  <form hx-post="../../ajax_lists/user_list.php" hx-trigger="submit" hx-target="#result">
    <label for="nameInput">Enter Name:</label>
    <input type="text" id="uname" name="uname" oninput="clearError()" />

    <button type="submit" name="lvl1_btn">Submit</button>

  </form>


  <div id="result">
    <!-- Display the result from user_list.php here -->
  </div>
  <div id="error1" class="error"></div>

  <script>
    function clearError() {
      document.getElementById("error1").innerText = ""
    }
  </script>
</body>

</html>
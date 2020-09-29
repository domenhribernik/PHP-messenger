<?php
  session_start();
  include("include/connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/first_page.css">
  <title>Log in</title>
</head>
<body>
  <div class="container">
    <div class="contant">
    <h1>Log in</h1>
    <form action="login.php" method="POST">
        <div class="down">
            <input type="email" name="email" placeholder="Email" required autocomplete="off"><br>
        </div>
        <div class="down">
            <input type="password" name="password" placeholder="Password" required/><br>
        </div>
        <button type="submit" name="login" value="login" >
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Log in
        </button>
    </form> 
    <a href="register.php">Create an account?</a>
    </div>
  </div>
  <?php
    include("include/connection.php");
    include("include/login_php.php");
  ?>
</body>
</html>
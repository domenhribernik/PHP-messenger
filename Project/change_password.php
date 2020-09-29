<?php
 session_start();
 include("include/connection.php");
 if (!isset($_SESSION['user_email'])) {
  header("location: login.php");
 }
 else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/change_password.css">
  <title>Settings</title>
</head>
<body onload="gender()">
  <div class="container">
    <div class="contant">
    <?php
      $user = $_SESSION['user_email'];
      $get_user = "SELECT * FROM users WHERE user_email = '$user'";
      $run_user = mysqli_query($db, $get_user);
      $row = mysqli_fetch_array($run_user);

      $user_password = $row['user_password'];
    ?>
    <h1>Change your password</h1>
    <form action="change_password.php" method="POST">
        <div class = "grid">
          <span class = "desno">
           <div class = "text">Enter your old password</div>
           <div class = "text">Enter your new password</div>
           <div class = "text">Confirm your new password</div>
          </span>
          <span class = "levo">
            <div class="down">
                <input type="password" name="old_password" placeholder="Old password" required><br>
            </div>
            <div class="down">
                <input type="password" name="new_password" placeholder="New password" required><br>
            </div>
            <div class="down">
                <input type="password" name="confirm" placeholder="Confirm password" required><br>
            </div>
          </span> 
        </div>
        <span class = "grid">
          <span class ="desno">
            <button type="submit" name="update" value="update" class="form">
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              Update
            </button>
          </span>
          <span class = "levo">
            <button name="main" value="main" class="form" onclick="settings()">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Back to settings
            </button>
          </span>
      </span>
    </form>
    <script>
      function settings() {
        <?php echo "window.open('settings.php', '_self');"; ?>
      }
    </script>
    <?php 
      if (isset($_POST['update'])) {

        $real_password = $row['user_password'];

        $old_password =  htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['old_password'])));
        $new_password =  htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['new_password'])));
        $confirm_password =  htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['confirm'])));

        if ($real_password != $old_password) {
          echo "<script>alert('Old password does not match!')</script>";
          echo "<script>window.open('change_password.php', '_self')</script>";
        }
        else if (strlen($new_password) < 8) {
          echo "<script>alert('Password should be minimum 8 characters!')</script>";
          exit();
        }
        else if ($new_password != $confirm_password) {
          echo "<script>alert('New password does not match!')</script>";
          echo "<script>window.open('change_password.php', '_self')</script>";
          exit();
        }
        else {
          $update = "UPDATE users SET user_password='$new_password' WHERE user_email='$user'";
          $run = mysqli_query($db, $update);

          if ($run) {
            echo "<script>alert('Password has been updated!')</script>";
            echo"<script>window.open('change_password.php', '_self')</script>";
          }
        }
      } 
    ?>
    </div>
  </div>
</body>
</html>
<?php } ?>
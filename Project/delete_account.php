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
  <link rel="stylesheet" type="text/css" href="css/delete_account.css">
  <title>Delete account</title>
</head>
<body onload="gender()">
  <div class="container">
    <div class="contant">
    <?php
      $user = $_SESSION['user_email'];
      $get_user = "SELECT * FROM users WHERE user_email = '$user'";
      $run_user = mysqli_query($db, $get_user);
      $row = mysqli_fetch_array($run_user);

      $user_name = $row['user_name'];
      $user_password = $row['user_password'];
      $user_email = $row['user_email'];
      $user_phone = $row['user_phone'];
      $user_age = $row['user_age'];
      $user_profile = $row['user_photo'];
      $user_country = $row['user_city'];
      $user_gender = $row['user_gender'];
    ?>
    <h1>Are you sure?</h1>
    <form method="POST">
      <div class = "grid">
        <span class = "center">
        <button type="submit" name="delete_profile" class = "gradient update1">
              Yes
            </button>
        </span>
        <span class = "center">
            <button type="submit" name="cancel_delete" class="gradient update1">
              No
            </button>
        </span> 
      </div>
    </form>
    <?php 
      if (isset($_POST['cancel_delete'])) {
        echo"<script>window.open('settings.php', '_self')</script>";
      }
      if (isset($_POST['delete_profile'])) {

        $get_profile = "SELECT * FROM users WHERE user_email='$user'";
        $run_profile = mysqli_query($db, $get_profile);
        $row = mysqli_fetch_array($run_profile);
        $delete_profile = $row['user_photo'];
        unlink($delete_profile);

        $sent_msg = "SELECT * FROM users_chat WHERE sender_username = '$user_name' OR receiver_username='$user_name'";
        $run_sent_msg = mysqli_query($db, $sent_msg);
        echo "<div class='message-body' id='message-body'>";
        while($row = mysqli_fetch_array($run_sent_msg))  {
          $select_photo = $row['msg_image'];
          if ($select_photo != "") {
            unlink($select_photo);
          }

          $delete_msg = "DELETE FROM users_chat WHERE sender_username='$user_name' OR receiver_username='$user_name'";
          $run_delete = mysqli_query($db, $delete_msg);
        }

        $delete_friends = "SELECT * FROM users_friends WHERE friend_a='$user_name' OR friend_b='$user_name'";
        $run_delete_friends = mysqli_query($db, $delete_friends);
        while ($row_friends = mysqli_fetch_array($run_delete_friends)) {
          $friend_delete = "DELETE FROM users_friends WHERE friend_a='$user_name' OR friend_b='$user_name'";
          $delete = mysqli_query($db, $friend_delete);
        }

        $test_msg = "SELECT * FROM users_chat WHERE sender_username='$user_name' OR receiver_username='$user_name'";
        $run_test = mysqli_query($db, $test_msg);
        $check_rows = mysqli_num_rows($run_test);

        $delete_user = "DELETE FROM users WHERE user_email='$user'";
        $run_del = mysqli_query($db, $delete_user);
        if (!$check_rows) {
          echo "<script>alert('We are sad to see you go!')</script>";
          session_destroy();
          echo "<script>window.open('login.php', '_self')</script>";
        }
      }
    ?>
    </div>
  </div>
</body>
</html>
<?php } ?>
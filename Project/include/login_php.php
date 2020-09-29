<?php
  if (isset($_POST['login'])){
    $email = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['email'])));
    $password = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['password'])));
    $select_user = "SELECT * FROM users WHERE user_email = '$email' AND user_password = '$password'";
    $query = mysqli_query($db, $select_user);
    $check_user = mysqli_num_rows($query);

    if ($check_user == 1) {
      $_SESSION['user_email'] = $email;
      $update_msg = mysqli_query($db, "UPDATE users SET user_status = 'Online' WHERE user_email = '$email'");
      
      $get_user = "SELECT * FROM users WHERE user_email = '$email'";
      $run_user = mysqli_query($db, $get_user);
      $array = mysqli_fetch_array($run_user);

      $username = $array['user_name'];
      $_SESSION['user_name'] = $username;
      $_SESSION['user_photo'] = $array['user_photo'];

      echo "<script>window.open('main.php?user_name=$username', '_self')</script>";
    }
    else {
      echo "<script>alert('Email or Password is incorrect, try again!')</script>";
      echo "<script>window.open('login.php', '_self')</script>";
    }
  }
?>
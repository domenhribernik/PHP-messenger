<?php
  if (isset($_POST['register1'])){
    $email = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['email'])));
    $name = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['name'])));
    $lastname = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['lastname'])));
    $password = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['password'])));
    $confirm = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['confirm'])));
    $city = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['city'])));
    $age = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['age'])));
    $phone = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['phone'])));
    $gender = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['gender'])));

    if ($name == "") {
      echo "<script>alert('We can not verify your name!')</script>";
    }
    else {
      $username = $name . " " . $lastname;
    }
    if (strlen($password) < 8) {
      echo "<script>alert('Password should be minimum 8 characters!')</script>";
      exit();
    }
    $check_email = "SELECT * FROM users WHERE user_email ='$email'";
    $run_email = mysqli_query($db, $check_email);
    $check = mysqli_num_rows($run_email);

    if ($check == 1) {
      echo "<script>alert('Email alredy exists, please try again!')</script>";
      echo "<script>window.open('register.php, '_self')</script>";
      exit();
    }
    if ($password != $confirm) {
      echo "<script>alert('Password does not match!')</script>";
      echo "<script>window.open('register.php', '_self')</script>";
      exit();
    }
    $random_number = rand(1, 1000);
    $profile_photo = fopen("profile_image/".$random_number."profile.png", "w");
    $profile_pic = "profile_image/".$random_number."profile.png";
    echo copy("profile_image/profile.png",$profile_pic);

    $random_number = rand(100, 999);
    $username = $username . $random_number;
    $insert = "INSERT INTO users (user_email, user_name, user_password, user_photo, user_city, user_age, user_phone, user_gender) VALUES ('$email', '$username', '$password', '$profile_pic', '$city', '$age', '$phone', '$gender')";
    $query = mysqli_query($db, $insert);
    $add_friend = "INSERT INTO users_friends (friend_a, friend_b) VALUES ('$username', '$username')";
    $query_friend = mysqli_query($db, $add_friend);
    $username = substr_replace($username, "", (strlen($username) - 3), 3);
    if ($query) {
      echo "<script>alert('Congratulations $username, now log in!')</script>";
      echo "<script>window.open('login.php', '_self')</script>";
    }
    else {
      echo "<script>alert('Registration failed, try again!')</script>";
      echo "<script>window.open('register.php', '_self')</script>";
    }
  } 
?>
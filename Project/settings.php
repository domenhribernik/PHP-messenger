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
  <link rel="stylesheet" type="text/css" href="css/settings.css">
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

      $user_name = $row['user_name'];
      $user_password = $row['user_password'];
      $user_email = $row['user_email'];
      $user_phone = $row['user_phone'];
      $user_age = $row['user_age'];
      $user_profile = $row['user_photo'];
      $user_country = $row['user_city'];
      $user_gender = $row['user_gender'];
    ?>
    <form action="settings.php" method="post" class = "grid">
      <h1>Change Account Settings</h1>
      <button type="submit" name="logout" class="logout">
          Log out
      </button>
    </form>
    <form action="settings.php" method="POST">
        <div class = "grid">
          <span class = "desno">
           <div class = "text">Change your username</div>
           <div class = "text password">Change your password</div>
           <div class = "text">Change your email</div>
           <div class = "text">Change your phone number</div>
           <div class = "text">Change your age</div>
           <div class = "text">Change your city</div> 
           <div class = "text">Change your gender</div>   
           <div class = "update">Change your profile picture</div> 
           <div class = "update">Delete your account</div> 
          </span>
          <span class = "levo">
            <div class="down">
              <?php 
                $user_name_settings = substr_replace($user_name, "", (strlen($user_name) - 3), 3); 
              ?>
                <input type="text" name="username" placeholder="<?php echo $user_name_settings; ?>" value="<?php echo $user_name_settings; ?>" autocomplete="off" required><br>
            </div>
            <div>
              <button type="submit" name="change_password" value="change_password" class = "gradient update1">
                  Change password
              </button>
            </div>
            <div class="down">
                <input type="email" name="email" placeholder="<?php echo $user_email; ?>" value="<?php echo $user_email; ?>" autocomplete="off" required><br>
            </div>
            <div class="down">
                <input type="tel" name="phone_number" placeholder="<?php echo $user_phone; ?>" value="<?php echo $user_phone; ?>" autocomplete="off" required><br>
            </div>
            <div class="down">
                <input type="number" name="age" placeholder="<?php echo $user_age; ?>" value="<?php echo $user_age; ?>" autocomplete="off" required><br>
            </div>
            <div class="down">
                <input type="text" name="city" placeholder="<?php echo $user_country; ?>" value="<?php echo $user_country; ?>" autocomplete="off" required><br>
            </div>
            <div>
              <label id="male" onclick="selected()">
                <input type="radio" value="Male" id="Male" name="gender" required>
                  Male
              </label>
              <label id="female" onclick="selected()">
                <input type="radio" value="Female" id="Female" name="gender" required>
                Female
              </label>
            </div>
            <div>
              <button type="submit" name="change_photo" class = "gradient update1">
                Update photo
              </button>
            </div>
            <div>
              <button type="submit" name="delete_account" class = "gradient update1">
                Delete your account
              </button>
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
            <button type="submit" name="main" value="main" class="form">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Back to messages
            </button>
          </span>
      </span>
    </form>
    <script>
      function gender() {
        <?php echo "document.getElementById('$user_gender').checked = true;"; ?>
        
        <?php 
          if ($user_gender == "Male") {
            echo "document.getElementById('male').style.color = 'white';";
          }
          else if ($user_gender == "Female") {
            echo "document.getElementById('female').style.color = 'white';";
          }
        ?>
      }
      function selected() {
              if (document.getElementById('Male').checked == true) {
                document.getElementById('female').style.color = "rgba(255, 255, 255, 0.7)";
                document.getElementById('male').style.color = "white";
              }
              else if (document.getElementById('Female').checked == true) {
                document.getElementById('male').style.color = "rgba(255, 255, 255, 0.7)";
                document.getElementById('female').style.color = "white";
              }
            }
    </script>
    <?php 
      if (isset($_POST['update'])) {
        $user_name = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['username'])));
        $email =  htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['email'])));
        $u_city = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['city'])));
        $u_gender = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['gender'])));
        $phone_number = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['phone_number'])));
        $age = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['age'])));

        if (strlen($phone_number) != 9) {
          echo "<script>alert('Phone number must have exactly 9 digits!')</script>";
        }
        elseif ($age > 999) {
          echo "<script>alert('The age can have a maximum of 3 digits!')</script>";
        }
        else {
          $random_number = rand(100, 999);
          $old_name = $row['user_name'];
          $user_name = $user_name . $random_number;

          $update_sender = "UPDATE users_chat SET sender_username='$user_name' WHERE sender_username='$old_name'";
          $run_sender = mysqli_query($db, $update_sender);

          $update_receiver = "UPDATE users_chat SET receiver_username='$user_name' WHERE receiver_username='$old_name'";
          $run_receiver = mysqli_query($db, $update_receiver);

          $update_friend_a = "UPDATE users_friends SET friend_a='$user_name' WHERE friend_a='$old_name'";
          $run_friend_a = mysqli_query($db, $update_friend_a);

          $update_friend_b = "UPDATE users_friends SET friend_b='$user_name' WHERE friend_b='$old_name'";
          $run_friend_b = mysqli_query($db, $update_friend_b);

          $update = "UPDATE users SET user_name='$user_name', user_email='$email', user_city='$u_city', user_age='$age', user_phone='$phone_number', user_gender = '$u_gender' WHERE user_email='$user'";
          $run = mysqli_query($db, $update);

          if ($run && $run_receiver && $run_sender && $run_friend_a && $run_friend_b) {
            echo"<script>window.open('settings.php', '_self')</script>";
          $_SESSION['user_email'] = $email;
          $_SESSION['user_name'] = $user_name;
          }
        }
      }
      if (isset($_POST['logout'])) {
        $update_msg = mysqli_query($db, "UPDATE users SET user_status='Offline' WHERE user_name='$user_name'");
        session_destroy();
        echo "<script>window.open('login.php', '_self')</script>";
      }  
      if (isset($_POST['main'])) {
        echo "<script>window.open('main.php?user_name=$user_name', '_self')</script>";
      } 
      if (isset($_POST['change_photo'])) {
        echo "<script>window.open('change_photo.php', '_self')</script>";
      }
      if (isset($_POST['delete_account'])) {
        echo "<script>window.open('delete_account.php', '_self')</script>";
      }
      if (isset($_POST['change_password'])) {
        echo "<script>window.open('change_password.php', '_self')</script>";
      } 
    ?>
    </div>
  </div>
</body>
</html>
<?php } ?>
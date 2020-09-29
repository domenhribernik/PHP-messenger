<?php
  session_start();
  include("include/connection.php");
  if (!isset($_SESSION['user_email'])) {
    header("location: login.php");
  }
  else {
    $user = $_SESSION['user_email'];
    $get_user = "SELECT * FROM users WHERE user_email = '$user'";
    $run_user = mysqli_query($db, $get_user);
    $row = mysqli_fetch_array($run_user);

    $user_name = $row['user_name'];
    $user_profile = $row['user_photo'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/change_photo.css">
  <title>Settings</title>

</head>
<body>
  <div class="container">
    <div class="contant">
      <?php echo "<img src='$user_profile' alt='profile picture'>"; ?>
      <h1><?php echo $title_user = substr_replace($user_name, "", (strlen($user_name) - 3), 3); $title_user; ?></h1>
      <form method='post' enctype='multipart/form-data' class ="form">
        <div class='grid'>
          <div class='center'>
            <label id='update_profile' class="gradient"> 
              Select Profile
              <input type='file' name='update_photo' size='60' >
            </label>
          </div>
          <div class='center'>
            <button name='update' class="gradient">
              Update Profile
            </button>
          </div>
        </div>
      </form>
      <div class='grid'>
        <div class='center'>
          <button type="button" name="settings" value="settings" onclick="settings()">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Back to settings
          </button>
        </div>
        <div class='center'>
          <button type="button"  name="main" value="main" onclick="main()">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Back to messages
          </button>
        </div>
      </div>
    </div>
  </div>
  <script>
    function main() {
      <?php echo "window.open('main.php?user_name=$user_name', '_self');"; ?>
    }
    function settings() {
      <?php echo "window.open('settings.php', '_self');"; ?>
    }
  </script>
  <?php
    if (isset($_POST['update'])) {
      $u_profile = $_FILES['update_photo']['name'];
      $image_tmp = $_FILES['update_photo']['tmp_name'];
      $FileType = strtolower(pathinfo($u_profile, PATHINFO_EXTENSION));
      $random_number = rand(1, 1000);

      if ($u_profile == '') {
        echo "<script>alert('Please Select a Photo')</script>";
        echo "<script>window.open('change_photo.php', '_self')</script>";
        exit();
      }
      else if($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg") {
        echo "<script>alert('Choose a format of .png or .jpg')</script>";
        echo "<script>window.open('change_photo.php', '_self')</script>";
      }
      else if ($_FILES["update_photo"]["size"] > 1000000) {
        echo "<script>alert('Choose a photo smaller than 1MB')</script>";
        echo "<script>window.open('change_photo.php', '_self')</script>";
      }
      else {
        $get = "SELECT user_photo FROM users WHERE user_email='$user'";
        $run_old = mysqli_query($db, $get);
        $row = mysqli_fetch_array($run_old);
        $old_profile = $row['user_photo'];
        unlink($old_profile);
        move_uploaded_file($image_tmp, "profile_image/$random_number$u_profile");
        $update = "UPDATE users SET user_photo='profile_image/$random_number$u_profile' WHERE user_email='$user'";
        $run = mysqli_query($db, $update);
        $_SESSION['user_photo'] = "profile_image/$random_number$u_profile";

        if ($run) {
          echo "<script>alert('Your Profile was Updated')</script>";
          echo "<script>window.open('change_photo.php', '_self')</script>";
        }
      }
    }
  ?>
</body>
</html>
<?php } ?>
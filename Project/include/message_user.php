<?php
  $user = $_SESSION['user_email'];
  $get_user = "SELECT * FROM users WHERE user_email = '$user'";
  $run_user = mysqli_query($db, $get_user);
  $row = mysqli_fetch_array($run_user);
  $user_id = $row['user_id'];
  $user_name = $row['user_name'];
  if (isset($_GET['user_name'])) {
    global $db;
    $get_username = $_GET['user_name'];
    $get_user = "SELECT * FROM users WHERE user_name = '$get_username'";
    $run_user = mysqli_query($db, $get_user);
    $row_user = mysqli_fetch_array($run_user);
    $username = $row_user['user_name'];
    $user_photo_image = $row_user['user_photo'];
    $status = $row_user['user_status'];
  }
  $total_messeges = "SELECT * FROM users_chat WHERE (sender_username = '$user_name' AND receiver_username = '$username') OR (receiver_username = '$user_name' AND sender_username = '$username')";
  $run_messages = mysqli_query($db, $total_messeges);
  $total = mysqli_num_rows($run_messages);
  $username_head = substr_replace($username, "", (strlen($username) - 3), 3);
  echo"
    <div class='left-icon-tab'>
      <a href='#' onclick='openLeftMenu()' id='open-left'>
        <i class='fas fa-bars'></i>
      </a>
    </div>";
    if ($status == "Online") {
      echo "<img src= $user_photo_image alt='user_photo' class='head-photo profile-pic g-img'/>";
    }
    else if ($status == "Offline") {
      echo "<img src= $user_photo_image alt='user_photo' class='head-photo profile-pic r-img'/>";
    }  
  echo"<div class='head-data'>
      <div class = 'head-username'>
        $username_head
      </div><br>
      <div class = 'head-total'>
        $total messages
      </div>
    </div>
    <div class='right-icon-tab'>
      <a href='#' onclick='openRightMenu()' id='open-right'>
        <i class='fas fa-bars'></i>
      </a>
    </div>
  ";
?>
  
<?php
    $receiver_username = $_GET['user_name'];
    $get = "SELECT * FROM users WHERE user_name = '$receiver_username'";
    $run = mysqli_query($db, $get);
    $row= mysqli_fetch_array($run);
    $receiver_img = $row['user_photo'];
    $status = $row['user_status'];
    $gender = $row['user_gender'];
    $city = $row['user_city'];
    $age = $row['user_age'];
    $phone = $row['user_phone'];
    $receiver_username = substr_replace($receiver_username, "", (strlen($receiver_username) - 3), 3);
  echo"<div class='main-data'>
    <ul>
      <div class='right-icon-x'>
        <a href='#' onclick='closeRightMenu()' id='close-right'>
          <i class='fas fa-times'></i>
        </a>
      </div>
      <li class='side_img'>";
        if($status == "Online"){
          echo"<img src=$receiver_img alt ='profile' class='green-img'>";
        }
        else{
          echo"<img src=$receiver_img alt ='profile' class='red-img'>";
        }
        
      echo "</li>
      <li class='data-name'>$receiver_username</li>
      <li>";
        if($status == "Online"){
          echo"
          <div>Status: <span class='green'>$status</span></div>";
        }
        else{
          echo"
          <div>Status: <span class='red'>$status</span></div>";
        }
  echo"</li>
      <li>Gender: $gender</li>
      <li>City: $city</li>
      <li>Age: $age</li>
      <li>Phone: $phone</li>
    </ul>
    <form method='post'>
      <button type='submit' name='delete_chat' class='delete-chat'>Delete chat history</button>
    </form>
  </div>";
  if ($user_name == $username) {
    $photos = "SELECT * FROM users_chat WHERE msg_image!='' AND receiver_username=sender_username";
  }
  else {
    $photos = "SELECT * FROM users_chat WHERE msg_image!='' AND (sender_username='$username' OR sender_username='$user_name') AND (receiver_username='$username' OR receiver_username='$user_name') AND receiver_username!=sender_username";
  }
  $get_images = mysqli_query($db, $photos);
  
  echo "<div class='photo-name' >Sent photos:</div>
  <div class='sent-container'>";
  while ($row = mysqli_fetch_array($get_images)) {
    $msg_img = $row['msg_image'];
  echo"<div class='sent-item'><a href='$msg_img' target='_blanc'><img src='$msg_img' class='sent-img'></a></div>";
  }
  echo "</div>";

  if (isset($_POST['delete_chat'])) {
    $sent_msg = "SELECT * FROM users_chat WHERE (sender_username = '$user_name' AND receiver_username = '$username') OR (receiver_username = '$user_name' AND sender_username='$username')";
    $run_sent_msg = mysqli_query($db, $sent_msg);
    echo "<div class='message-body' id='message-body'>";
    while($row = mysqli_fetch_array($run_sent_msg))  {
      $select_photo = $row['msg_image'];
      if ($select_photo != "") {
        unlink($select_photo);
      }

      if ($user_name == $username) {
        $delete_msg = "DELETE FROM users_chat WHERE receiver_username=sender_username";
      }
      else {
        $delete_msg = "DELETE FROM users_chat WHERE (sender_username='$username' OR sender_username='$user_name') AND (receiver_username='$username' OR receiver_username='$user_name') AND receiver_username!=sender_username";
      }
      $run_delete = mysqli_query($db, $delete_msg);
    }
    $test_msg = "SELECT * FROM users_chat WHERE (sender_username='$username' OR sender_username='$user_name') AND (receiver_username='$username' OR receiver_username='$user_name') AND receiver_username!=sender_username";
    $run_test = mysqli_query($db, $test_msg);
    $check_rows = mysqli_num_rows($run_test);
    if (!$check_rows) {
      echo "<script>alert('Messages were deleted!')</script>";
      echo "<script>window.open('main.php?user_name=$username', '_self')</script>";
    }
  }
?>
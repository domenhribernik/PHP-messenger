<?php
  $update_msg = mysqli_query($db, "UPDATE users_chat SET msg_status = 'read' WHERE sender_username = '$username' AND receiver_username = '$user_name'");
  $sel_msg = "SELECT * FROM users_chat WHERE (sender_username = '$user_name' AND receiver_username = '$username') OR (receiver_username = '$user_name' AND sender_username='$username') ORDER by 1 ASC";
  $run_msg = mysqli_query($db, $sel_msg);
  echo "<div class='message-body' id='message-body'>";
  while($row = mysqli_fetch_array($run_msg))  {
    $sender_username = $row['sender_username'];
    $receiver_username = $row['receiver_username'];
    $msg_content = $row['msg_content'];
    $msg_image = $row['msg_image'];
    $date = strtotime($row['msg_date']);
    $msg_date = date("d. F Y, H:i", $date);
    $msg_status = $row['msg_status'];

    $new_msg = "";
    for ($i=0; $i < strlen($msg_content); $i++) { 
      $new_msg = $new_msg.$msg_content[$i];
      if ($i % 21 == 0 && $i > 20) {
        $new_msg = $new_msg."<br>";
      }
    }
    $msg_content = $new_msg;

    $get_img = "SELECT * FROM users WHERE user_name = '$sender_username'";
    $run_img = mysqli_query($db, $get_img);
    $row_img= mysqli_fetch_array($run_img);
    $sender_img = $row_img['user_photo'];
    echo"<ul>";
      if ($user_name == $sender_username && $username == $receiver_username) {
        if ($msg_image== "") {
          echo "<li>
          <div class='right-chat'>
            <div class='message tooltip left' title='$msg_date $msg_status'>$msg_content</div>
            <img src='$sender_img' alt='photo_reciver' class='message-pic'>";
          echo"</div></li>";
        }
        else if ($msg_content == "") {
          echo "<li>
          <div class='right-chat'>
            <div class='message tooltip left' title='$msg_date $msg_status'><img src='$msg_image' class='message-image'></div>
            <img src='$sender_img' alt='photo_reciver' class='message-pic'>";
          echo"</div></li>";
        }
        else {
          echo "<li>
          <div class='right-chat'>
            <div class='message tooltip left' title='$msg_date $msg_status'><img src='$msg_image' class='message-image'><br>$msg_content</div>
            <img src='$sender_img' alt='photo_reciver' class='message-pic'>";
          echo"</div></li>";
        }
      }
      else if ($user_name == $receiver_username && $username == $sender_username) {
        if ($msg_image== "") {
          echo "<li>
          <div class='left-chat'>
            <img src = $user_photo_image alt='photo_reciver' class='message-pic'>
            <div class='message tooltip right' title='$msg_date $msg_status'>$msg_content</div>";
          echo"</div></li>";
        }
        else if ($msg_content == "") {
          echo "<li>
          <div class='left-chat'>
          <img src = $user_photo_image alt='photo_reciver' class='message-pic'>
          <div class='message tooltip right' title='$msg_date $msg_status'><img src='$msg_image' class='message-image'></div>";
          echo"</div></li>";
        }
        else {
          echo "<li>
          <div class='left-chat'>
          <img src = $user_photo_image alt='photo_reciver' class='message-pic'>
          <div class='message tooltip right' title='$msg_date $msg_status'><img src='$msg_image' class='message-image'><br>$msg_content</div>";
          echo"</div></li>";
        }
      }
    echo"</ul>";
 }
 echo "</div>";
 echo"
  <form method='post' class='down' enctype='multipart/form-data'>
    <label><input type='file' name='msg_photo' size='60' ><img src='image/photo.png' class='image-msg' name='img_msg'></label>
    <input type='text' name='msg_content' autocomplete='off' placeholder='Write your message...'>
    <button class='send-button' type = 'submit' value='submit' name='submit'><img src='image/send.png' class='send-message-img'></button>
  </form>";
  if (isset($_POST['submit'])) {
    $msg_image =  $_FILES['msg_photo']['name'];
    $msg_tmp = $_FILES['msg_photo']['tmp_name'];
    $FileType = strtolower(pathinfo($msg_image, PATHINFO_EXTENSION));
    $random_number = rand(1, 1000);

    $msg = htmlentities(mysqli_real_escape_string($db, stripslashes($_POST['msg_content'])));
    if ($msg == "" && $msg_image == "") {
      echo "<script>alert('Write a message or choose a photo!')</script>";
    }
    else if (strlen($msg) > 255) {
      echo "<script>alert('Your message was too long!')</script>";
    }
    else {
      $insert = "INSERT INTO users_chat(sender_username, receiver_username, msg_content, msg_status, msg_date) 
      VALUES('$user_name', '$username', '$msg', 'unread', NOW())";
      $run_insert = mysqli_query($db, $insert);
    }
    if ($msg_image != "") {
      
      if ($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg") {
        echo "<script>alert('Choose a format of .png or .jpg')</script>";
        echo "<script>window.open('main.php?user_name=$username', '_self')</script>";
        $update = "UPDATE users_chat SET msg_content='error' ORDER BY msg_id DESC LIMIT 1";
        $run_image = mysqli_query($db, $update);
      }
      else if ($_FILES["msg_photo"]["size"] > 1000000) {
        echo "<script>alert('Choose a photo smaller than 1MB')</script>";
        echo "<script>window.open('main.php?user_name=$username', '_self')</script>";
        $update = "UPDATE users_chat SET msg_content='error' ORDER BY msg_id DESC LIMIT 1";
        $run_image = mysqli_query($db, $update);
      }
      else {
        $image_upload = "message_image/$random_number$msg_image";
        move_uploaded_file($msg_tmp, $image_upload);
        $update = "UPDATE users_chat SET msg_image='$image_upload' ORDER BY msg_id DESC LIMIT 1";
        $run_image = mysqli_query($db, $update);
      }
    }
    echo "<script>window.open('main.php?user_name=$username', '_self')</script>";
  }
?> 
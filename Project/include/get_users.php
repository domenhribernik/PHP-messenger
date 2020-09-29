<?php

  function search_user() {
    include("connection.php");
    $loged_user = $_SESSION['user_name'];
    if (isset($_POST['search_btn'])) {
      $search_query = htmlentities($_POST['search_friends']);
      $get_friend = "SELECT * FROM users_friends WHERE SUBSTR(friend_b, 1, (LENGTH(friend_b) - 3)) LIKE '%$search_query%' AND friend_a = '$loged_user' ORDER BY friend_b ASC";
    }
    else {
      $get_friend = "SELECT * FROM users_friends WHERE friend_a = '$loged_user' ORDER BY friends_id DESC";
    }

    $run_friend = mysqli_query($db, $get_friend);
    while ($row_friend = mysqli_fetch_array($run_friend)) {
      $friend = $row_friend['friend_b'];
      $get_user = "SELECT * FROM users";
      $run_user = mysqli_query($db, $get_user);

      while ($row = mysqli_fetch_array($run_user)) {
        $user_name = $row['user_name'];
        $user_photo = $row['user_photo'];
        $status = $row['user_status'];
        $last_msg="";
  
        if ($friend == $user_name) {
          if ($user_name == $loged_user) {
            $get_last_msg = "SELECT * FROM users_chat WHERE receiver_username=sender_username ORDER BY msg_id DESC LIMIT 1";  
          }
          else {
            $get_last_msg = "SELECT * FROM users_chat WHERE ((sender_username='$user_name' OR receiver_username='$user_name') AND (sender_username='$loged_user' OR receiver_username='$loged_user')) AND sender_username!=receiver_username ORDER BY msg_id DESC LIMIT 1";  
          }
          $run_last_msg = mysqli_query($db, $get_last_msg);
          $check = mysqli_num_rows($run_last_msg);
          if($check) {
            $row_last_msg = mysqli_fetch_array($run_last_msg);
            $receiver = $row_last_msg['receiver_username'];
            $sender = $row_last_msg['sender_username'];
    
            if ($sender == $loged_user || $receiver == $loged_user) {
              $last_msg = $row_last_msg['msg_content'];
              if ($last_msg == "") {
                $sender_show = substr_replace($sender, "", strpos($sender, " "), (strlen($sender)-strpos($sender, " ")));
                if ($sender == $loged_user) {
                  $last_msg = "You sent a photo";
                }
                else {
                  $last_msg = $sender_show." sent a photo";
                }
              }
            }
          }
          else {
            $last_msg_name = substr_replace($user_name, "", (strlen($user_name) - 3), 3);
            $last_msg = "Say hi to $last_msg_name!";
            if ($loged_user == $user_name) {
              $last_msg = "";
            }
          }
          if(strlen($last_msg) > 25) {
            $last_msg = substr_replace($last_msg, "", 25, (strlen($last_msg) - 25))."...";
          } 
          
          $user_name_output = substr_replace($user_name, "", (strlen($user_name) - 3), 3);
          echo "<a href='main.php?user_name=$user_name' class='user-name'>
              <li class = 'friends'>
                <div class='friends-photo'>";
                  if ($status == "Online") {
                    echo "<img src='$user_photo' class='profile-pic g-img'>";
                  }
                  else if ($status == "Offline") {
                    echo "<img src='$user_photo' class='profile-pic r-img'>";
                  }
                echo "</div>
                <div class='friends-name'>$user_name_output
                  <div class='last-message'>$last_msg</div>
                  </div></li></a>";
        }
      }
    }
  }
?>
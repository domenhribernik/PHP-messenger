<?php
  function search_user() {
    include("connection.php");
    $logged_user = $_SESSION['user_name'];
    if(isset($_POST['search_btn'])){
      $search = htmlentities($_POST['search_friends']);
      $get_user_name = "SELECT * FROM users WHERE SUBSTR(user_name, 1, (LENGTH(user_name) - 3)) LIKE '%$search%' AND user_name != '$logged_user' ORDER BY user_name ASC";
    }
    else{
      $get_user_name = "SELECT * FROM users WHERE user_name != '$logged_user' ORDER BY user_name ASC";
    }

    $run_user_name = mysqli_query($db, $get_user_name);
    while($row = mysqli_fetch_array($run_user_name)){
      $user_name = $row['user_name'];
      $user_photo = $row['user_photo'];
      $status = $row['user_status'];
      $user_name_output = substr_replace($user_name, "", (strlen($user_name) - 3), 3);
      $user_output = substr_replace($user_name, "", (strlen($user_name) - 3), 3);

      $test_friend = "SELECT * FROM users_friends WHERE friend_a = '$logged_user' AND friend_b = '$user_name'";
      $run_test = mysqli_query($db, $test_friend);
      $test_row = mysqli_fetch_array($run_test);

      if ($test_row) {
        echo "<li class = 'friends'>
            <div class='friends-photo'>";
              if ($status == "Online") {
                echo "<img src='$user_photo' class='profile-pic g-img'>";
              }
              else if ($status == "Offline") {
                echo "<img src='$user_photo' class='profile-pic r-img'>";
              }
            echo "</div>
            <div class='friends-name'>$user_name_output</div>
              <form method='post' class='addbutton'>
                <button value='$user_name' type='submit' name='btn_add' class='gradient none' onclick='add(this)'>
                  Add friend
                </button>
                <button value='$user_name' type='submit' name='btn_remove' class='gradient' onclick='remove(this)'>
                  Remove friend
                </button>
              </form></li>";
      }
      else {
        echo "<li class = 'friends'>
            <div class='friends-photo'>";
              if ($status == "Online") {
                echo "<img src='$user_photo' class='profile-pic g-img'>";
              }
              else if ($status == "Offline") {
                echo "<img src='$user_photo' class='profile-pic r-img'>";
              }
            echo "</div>
            <div class='friends-name'>$user_name_output</div>
              <form method='post' class='addbutton'>
                <button value='$user_name' type='submit' name='btn_add' class='gradient' onclick='add(this)'>
                  Add friend
                </button>
                <button value='$user_name' type='submit' name='btn_remove' class='gradient none' onclick='remove(this)'>
                  Remove friend
                </button>
              </form></li>";
      }
      
      }
   
    if (isset($_POST['btn_add'])) {
      $friend_user = $_POST['btn_add'];
      $add_friend = "INSERT INTO users_friends (friend_a, friend_b) VALUES ('$logged_user', '$friend_user')";
      $run = mysqli_query($db, $add_friend);
      if ($run) {
        echo "<script>window.open('find_friend.php', '_self')</script>";
      }
    }

    if (isset($_POST['btn_remove'])) {
      $friend_delete = $_POST['btn_remove'];
      $remove_friend = "DELETE FROM users_friends WHERE friend_a = '$logged_user' AND friend_b = '$friend_delete'";
      $run = mysqli_query($db, $remove_friend);
      if ($run) {
        echo "<script>window.open('find_friend.php', '_self')</script>";
      }
    } 
  }
?>
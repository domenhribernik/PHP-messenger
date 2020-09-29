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
  <link rel="stylesheet"  type="text/css" href="css/mainpage.css">
  <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  <title>Messenger</title>
</head>
<body onload="scroll()">
<script>
  function scroll() {
    var html = document.getElementById('message-body');
    html.scrollTop += 10000;
  }
</script>
  <main class="container">
  
    <nav class="left-sidebar" id="left-menu">
      <div class="search-box">
        <div class="info">
          <?php
            $title_photo = $_SESSION['user_photo'];
            $user_name = $_SESSION['user_name'];
            $title_user = substr_replace($user_name, "", (strlen($user_name) - 3), 3);
            echo"<img src= '$title_photo' class='profile-pic' alt = 'sener_img'>";
          ?>
          <h1><?php echo "$title_user"; ?></h1>
          <span class = "link">
            <a href="settings.php" ><i class="fas fa-cog" id="icon"></i></a>
            <a href="find_friend.php" ><i class="fas fa-user-plus" id="icon"></i></a>
            <a href="#" onclick="closeLeftMenu()" id="left-icon-x" class="left-icon-x">
              <i class='fas fa-times'></i>
            </a>
          </span>
        </div>
        <div class="search">
        <form action="main.php?user_name=<?php echo $user_name;?>" method="post"> 
            <button type="submit" name="search_btn" class="filter-button"><i class="fas fa-search" id="search"></i></button>
            <input type="text" name="search_friends"  placeholder="Search..." autocomplete="off">
          </form> 
        </div>
      </div>
      <div class="friends-list">
        <ul id="friends-list">
          <?php include("include/get_users.php") ?>
          <?php search_user(); ?>
        </ul>
      </div>
    </nav>
    
    <article class="center-sidebar">
      <div class = "message-head">
        <?php include('include/message_user.php');?>
      </div>
      <?php include('include/messages.php');?> 
    </article>

    <aside class="container" id="right-menu">
        <div class = "right-sidebar">
            <?php include("include/profile_header.php");?>
        </div>
    </aside>
  </main>
  <script>
    function openRightMenu() {
      document.getElementById('right-menu').style.display = "inline-block";
      document.getElementById('open-right').style.display = "none";
    }
    function closeRightMenu() {
      document.getElementById('right-menu').style.display = "none";
      document.getElementById('open-right').style.display = "inline-block";
    }
    function openLeftMenu() {
      document.getElementById('left-menu').style.display = "inline-block";
      document.getElementById('open-left').style.display = "none";
    }
    function closeLeftMenu() {
      document.getElementById('left-menu').style.display = "none";
      document.getElementById('open-left').style.display = "inline-block";
    }
  </script>
</body>
</html>
<?php } ?>
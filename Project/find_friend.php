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
  <link rel="stylesheet"  type="text/css" href="css/findfriends.css">
  <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  <title>Add friends</title>
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
            $user_name = $_SESSION['user_name'];
          ?>
          <h1>Add friends</h1>
          <a href="main.php?user_name=<?php echo $user_name;?>"><i class="fas fa-home homeicon"></i></a>
        </div>
        <div class="search">
        <form action="find_friend.php" method="post"> 
            <button type="submit" name="search_btn" class="filter-button"><i class="fas fa-search" id="search"></i></button>
            <input type="text" name="search_friends"  placeholder="Search..." autocomplete="off">
          </form> 
        </div>
      </div>
      <div class="friends-list">
        <ul id="friends-list">
          <?php include("include/find_friends.php") ?>
          <?php search_user(); ?>
        </ul>
      </div>
    </nav>
  </main>
  <script>
    function add(btn) {
      btn.style.display = "none";
      btn.nextElementSibling.style.display = 'inline-block';
    }
    function remove(btn) {
      btn.style.display = "none";
      btn.previousElementSibling.style.display = 'inline-block';
    }
  </script>;
</body>
</html>
<?php } ?>
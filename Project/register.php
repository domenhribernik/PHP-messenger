<?php
  session_start();
  include("include/connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/first_page.css">
</head>
<body>        
  <div class="container">
    <div class="contant">
      <h1>Register</h1>
      <form action="register.php" method="post">
        <div class="down">
            <input type="email" name="email" placeholder="Email" required autocomplete="off"/><br>
        </div>
        <div class="down">
            <input type="text" name="name" placeholder="Name" required autocomplete="off"/><br>
        </div>
        <div class="down">
            <input type="text" name="lastname" placeholder="Lastname" required autocomplete="off"/><br>
        </div>
        <div class="down">
            <input type="password" name="password" id="password" placeholder="Password" required/><br>
        </div>
        <div class="down">
            <input type="password" name="confirm" placeholder="Confirm" required/><br>
        </div>
        <div class="down">
          <input type="text" name="city" placeholder="City" autocomplete="off" required>
        </div>
        <div class="down">
          <input type="number" name="age" placeholder="Age" required autocomplete="off"><br>
        </div>
        <div class="down">
            <input type="tel" class="tel" name="phone" placeholder="Phone number" autocomplete="off" required><br>
        </div>
        <div class="radio">
          <label onclick="selected()" id="male">
              <input type="radio" value="Male" id="m" name="gender" onclick="swap()" required>
                Male
          </label>
          <label onclick="selected()" id="female">
            <input type="radio" value="Female" id="f" name="gender" onclick="swap()" required>
              Female
          </label>
          <script>
            function selected() {
              if (document.getElementById('m').checked == true) {
                document.getElementById('female').style.color = "rgba(255, 255, 255, 0.7)";
                document.getElementById('male').style.color = "white";
              }
              else if (document.getElementById('f').checked == true) {
                document.getElementById('male').style.color = "rgba(255, 255, 255, 0.7)";
                document.getElementById('female').style.color = "white";
              }
            }
          </script>
        </div>
        <button type="submit" name="register1">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          Register
        </button>
      </form> 
      <a href="login.php">Alredy have an account?</a>
    </div>
  </div>
  <?php
    include('include/connection.php');
    include('include/register_php.php');        
  ?>
</body>
</html>
<?php
require 'clientConx.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $checkUserQuery = "SELECT * FROM `users` WHERE `iEmail` = '$email'";
    $result = mysqli_query($conn, $checkUserQuery);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['iPass'])) {
                $_SESSION['email'] = $email;
                header("Location: home.php");
                exit();
            } else {
                header("Location: loginerr.php");
                exit();
            }
        } else {
            header("Location: loginerr.php");
            exit();
        }
    } else {
        header("Location: loginerr.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Page</title>
<script>
  function validateForm() {
    var email = document.forms["loginForm"]["email"].value;
    var password = document.forms["loginForm"]["password"].value;

    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.match(emailRegex)) {
      alert("Invalid email address");
      return false;
    }

    return true;
  }
</script>
</head>
<body>
    <h2>Login</h2>

    <form name="loginForm" action="login.php" method="post" onsubmit="return validateForm()">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign In</button>
        <button type="button" onclick="window.location.href='reg.php'">Sign Up</button>
    </form>

  
</body>
</html>

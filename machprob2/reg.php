<?php
require 'clientConx.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $checkEmailQuery = "SELECT * FROM `users` WHERE `iEmail` = '$email'";
    $result = mysqli_query($conn, $checkEmailQuery);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "Email already exists!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO `users` (`iName`, `iEmail`, `iPass`) 
            VALUES ('$name', '$email', '$hashedPassword')";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                header("Location: login.php");
                exit(); 
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Page</title>
<script>
  function validateForm() {
    var name = document.forms["registrationForm"]["name"].value;
    var email = document.forms["registrationForm"]["email"].value;
    var password = document.forms["registrationForm"]["password"].value;

    var nameRegex = /^[a-zA-Z\s]+$/;
    if (!name.match(nameRegex)) {
      alert("Name can only contain letters and spaces");
      return false;
    }

    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.match(emailRegex)) {
      alert("Invalid email address");
      return false;
    }

    var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if (!password.match(passwordRegex)) {
      alert("Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character.");
      return false;
    }

    return true;
  }
</script>
</head>
<body>
    <h2>User Registration</h2>

    <form name="registrationForm" action="reg.php" method="post" onsubmit="return validateForm()">
      <input type="text" name="name" placeholder="Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Register</button>
    </form>
  
</body>
</html>

<?php
session_start();
require 'Customer_conx.php';

if (isset($_POST["verify"])) {
    $email = $_SESSION['email'];
    $verification_code = $_POST["verification_code"];

    // Check if the email and verification code match in the database
    $sql = "SELECT cID, userType, cName, cEmail, cPass, cPic, cConNum, cAdd, verification_code, email_verified_at 
            FROM users 
            WHERE cEmail = '" . $email . "' 
              AND verification_code = '" . $verification_code . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Update email_verified_at to mark email as verified
        $update_sql = "UPDATE users SET email_verified_at = NOW() WHERE cEmail = '" . $email . "'";
        mysqli_query($conn, $update_sql);

        echo "<p>Email verified successfully. You can log in now.</p>";
        // Additional logic to set user session or redirect to login page
        // Example: $_SESSION['user'] = mysqli_fetch_assoc($result);
        header("Location: login.php");
    } else {
        echo "<p>Verification code or email does not match. Verification failed.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #077a07;
            border-color: #077a07;
        }
        .btn-primary:hover {
            background-color: #065f05;
            border-color: #065f05;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Email Verification</h2>
        <p>We have sent an verification code to your account. Please enter the code below to verify your account.</p>
        <form action="" method="post">
            <div class="form-group">
                <label for="otp">Enter OTP:</label>
                <input type="text" id="otp" name="verification_code" class="form-control" required>
            </div>
            <button type="submit" name="verify" class="btn btn-primary">Verify OTP</button>
        </form>
    </div>

</body>
</html>

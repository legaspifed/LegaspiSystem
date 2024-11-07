<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home Page</title>
</head>
<body>
    <h2>Welcome, New Account!</h2>

    <h3>Your Information:</h3>
    <?php
    session_start();
    if(isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        echo "<ul>";
        echo "<li>Email: $email</li>";
        
        require 'clientConx.php';
        $getUserQuery = "SELECT * FROM `users` WHERE `iEmail` = '$email'";
        $result = mysqli_query($conn, $getUserQuery);
        if($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row['iPass'];
            echo "<li>Password (hashed): <br> $hashedPassword</li>";
        } else {
            echo "<li>Error fetching user information.</li>";
        }
        echo "</ul>";
        
        echo '<form action="login.php" method="post">
                <button type="submit">Logout</button>
            </form>';
    } else {
        header("Location: login.php");
        exit();
    }
    ?>

</body>
</html>

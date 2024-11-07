<?php 
session_start();
require 'Customer_conx.php'; // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['cID'])) {
    header("Location: login.php");
    exit();
}

// Fetch user information from the database
$userId = $_SESSION['cID'];
$sql = "SELECT * FROM `users` WHERE `cID` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Handle if user not found
    echo "User not found";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #077a07;
            color: #fff;
            padding: 10px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 999;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }
        .menu li {
            margin-right: 20px;
        }
        .menu li:last-child {
            margin-right: 0;
        }
        .menu button {
            color: #fff;
            background-color: #077a07;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .menu button:hover {
            background-color: #529e52;
        }
        .container {
            max-width: 600px;
            margin: 100px auto;
            text-align: center;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .content {
            padding: 20px;
        }
        h1 {
            color: #077a07;
            margin-bottom: 20px;
        }
        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="file"] {
            width: auto;
        }
        input[type="submit"] {
            background-color: #94dc06;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #529e52;
        }
        .imgdiv {
            margin: 0 auto 20px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-image: url('<?php echo isset($user["cPic"]) ? $user["cPic"] : ''; ?>');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .change-link {
            font-size: 0.8em;
            display: inline-block;
            text-align: right;
            width: calc(100% - 22px);
            color: #077a07;
            text-decoration: none;
        }
        .change-link:hover {
            text-decoration: underline;
        }
        .cart-icon {
            margin-left: 1200px; /* Move the cart button to the rightmost part */
        }
        .material-icons {
            font-size: 24px;
        }
    </style>
</head>
<body>
<div class="header">
    <ul class="menu">
        <li><button onclick="window.location.href='landing.php'">Home</button></li>
        <li><button onclick="window.location.href='products.php'">Products</button></li>
        <li><button onclick="window.location.href='profile.php'">Profile</button></li>
        <li><button onclick="window.location.href='logoutPage.php'">Logout</button></li>
        <li class="cart-icon"><button onclick="window.location.href='cart.php'"><i class="material-icons">shopping_cart</i></button></li>
    </ul>
</div>

    <div class="container">
        <div class="content">
            <h1>User Profile</h1>
            <form action="update.php" method="post" enctype="multipart/form-data">
                <!-- Display user's profile picture -->
                <div class="imgdiv"></div>

                <!-- Display user's information in input fields -->
                
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo isset($user['cName']) ? $user['cName'] : ''; ?>" required disabled>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo isset($user['cEmail']) ? $user['cEmail'] : ''; ?>" disabled>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="<?php echo isset($user['cPass']) ? $user['cPass'] : ''; ?>" required disabled>

                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="<?php echo isset($user['cAdd']) ? $user['cAdd'] : ''; ?>" required>

                <!-- Allow user to upload/change profile picture -->
                <label for="profile_pic">Profile Picture</label>
                <input class="file" type="file" name="profile_pic" id="profile_pic" onchange="previewFile()">
                <img id="preview" src="" alt="">

                <!-- Submit button -->
                <input type="submit" value="Update Profile">
            </form>   
        </div>
    </div>

    <script>
        // Function to preview selected profile picture
        function previewFile() {
            const preview = document.getElementById('preview');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>

</body>
</html>

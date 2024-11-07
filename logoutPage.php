<?php
session_start();

if (!isset($_SESSION['cID'])) {
    header("Location: login.php");
    exit();
}

require 'Customer_conx.php'; // Include your database connection file

// Prepare the SQL query

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Logout</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
/* Additional styles specific to the logout page */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
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
.menu a {
    color: #fff;
    text-decoration: none;
    padding: 10px;
}

.cart-icon {
    margin-left: 1200px; /* Move the cart button to the rightmost part */
  }

.container {
    max-width: 600px;
    margin: 0 auto; /* Change margin-top to 0 */
    text-align: center;
}
.content {
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}
.logo {
    text-align: center;
    margin-bottom: 20px;
}
.logo img {
    display: block;
    margin: 0 auto;
}
h2 {
    color: #077a07;
    margin-bottom: 20px;
}
p {
    margin-bottom: 20px;
}
.submit {
    background-color: #dc3545;
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}
button {
    background-color: #077a07;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}
button:hover {
    background-color: #529e52;
}
.material-icons-outlined {
    font-family: 'Material Icons';
    font-weight: normal;
    font-style: normal;
    font-size: 24px; /* Preferred icon size */
    line-height: 1; /* Improve icon vertical alignment */
    letter-spacing: normal;
    text-transform: none;
    display: inline-block;
    white-space: nowrap;
    word-wrap: normal;
    direction: ltr;
    -webkit-font-feature-settings: 'liga';
    -webkit-font-smoothing: antialiased; /* Fix icon rendering on Chrome */
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
    <li class="cart-icon"><button onclick="window.location.href='cart.php'"><i class="material-icons-outlined">shopping_cart</i></button></li>
  </ul>
</div>

<div class="container">
  <div class="content">
    <div class="logo">
      <img src="logo.png" alt="Your Logo">
    </div>
    <h2>Logout</h2>
    <p>Are you sure you want to logout?</p>
    <form action="logout.php" method="post">
      <button type="submit">Logout</button>
    </form>
  </div>
</div>

</body>
</html>

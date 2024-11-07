<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome to the Site</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
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
  justify-content: space-between; /* Align items horizontally with space between them */
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
  .material-icons-outlined {
    font-family: 'Material Symbols Outlined';
    font-weight: 700; /* Adjust weight as needed */
    font-size: 24px; /* Adjust size as needed */
  }
  
  .container {
    max-width: 600px;
    margin: 100px auto;
    text-align: center;
  }
  .content {
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
  }
  h1 {
    color: #077a07;
  }
  p {
    color: #333;
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
  .cart-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
  }
  .cart-item .name {
    flex: 1;
    text-align: left;
  }
  .cart-item .price {
    flex: 1;
    text-align: right;
  }
  /* New styles for quantity input */
  .quantity input {
    width: 40px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    text-align: center;
  }
  
  /* New styles for the "Remove" button */
  .action button {
    background-color: #ff5252;
    color: #fff;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-left: 10px; /* Add margin to create space */
  }

  .action button:hover {
    background-color: #ff6e6e;
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
    <?php if(isset($_SESSION['cName'])): ?>
      <h1>Welcome to the Site, <?php echo $_SESSION['cName']; ?></h1>
    <?php else: ?>
      <h1>Welcome to the Site</h1>
    <?php endif; ?>
    <p>Explore our vast selection of bricks, hollow blocks, and more, all crafted to meet your construction needs. With our commitment to excellence and unbeatable prices, your building journey just got a whole lot easier.</p>
    <button onclick="window.location.href='products.php'">Browse Products</button>
  </div>
</div>

</body>
</html>

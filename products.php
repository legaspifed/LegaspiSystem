<?php
session_start(); // Start the session
require 'admin_conx.php'; // Include the database connection file

// Function to add an item to the cart with a default quantity of 50
function addToCart($productId, $productName, $price, $quantity = 50) {
  // Initialize the cart session if it doesn't exist
  if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
  }

  // Check if the product already exists in the cart
  foreach ($_SESSION['cart'] as &$item) {
      if ($item['product_id'] === $productId) {
          // If the product exists, increment the quantity
          $item['quantity'] += $quantity;
          return;
      }
  }

  // If the product doesn't exist, add it to the cart with the specified quantity
  $_SESSION['cart'][] = [
      'product_id' => $productId,
      'name' => $productName,
      'price' => $price,
      'quantity' => $quantity
  ];
}

// Check if the "Add to Cart" button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addToCart'])) {
  // Retrieve the product details from the form
  $productId = $_POST['productId'];
  $productName = $_POST['productName'];
  $price = $_POST['price'];

  $quantity = 50;

  // Add the product to the cart with a quantity of 50
  addToCart($productId, $productName, $price, $quantity);

  // Redirect back to the products page
  header("Location: products.php");
  exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Online Shopping</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<style>
  body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    color: #333;
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
      background-color: transparent;
      color: #fff;
      border: none;
      padding: 10px;
      cursor: pointer;
  }

  .menu button:hover {
      background-color: #529e52;
  }

  .cart-icon {
    margin-left: 1200px; /* Move the cart button to the rightmost part */
  }

  .material-icons {
    font-family: 'Material Icons';
    font-size: 24px;
  }

  .container {
  max-width: 1200px;
  margin: 80px auto;
  padding: 0 20px;
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* Two items per row */
  gap: 20px;
  }

  .product {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s;
    width: 100%; /* Ensure each product takes full width of its container */
  }

  .product:hover {
    transform: translateY(-5px);
  }

  .product img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
  }

  .product-content {
    padding: 20px;
  }

  .product h2 {
    margin-top: 0;
    margin-bottom: 10px;
    font-size: 1.2rem;
    color: #333;
  }

  .product p {
    margin: 0;
    color: #666;
    font-size: 1rem;
  }

  .product button {
    display: block;
    width: 100%;
    background-color: #077a07;
    color: #fff;
    border: none;
    padding: 10px;
    border-radius: 0 0 5px 5px;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .product button:hover {
    background-color: #529e52;
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
  <?php
  // Fetch data from products table
  $sqlFetchProducts = "SELECT * FROM products";
  $resultProducts = mysqli_query($conn, $sqlFetchProducts);
  if (mysqli_num_rows($resultProducts) > 0) {
    while($rowProduct = mysqli_fetch_assoc($resultProducts)) {
      echo "<div class='product'>";
      echo "<img src='" . $rowProduct['image_path'] . "' alt='" . $rowProduct['product_name'] . "'>";
      echo "<div class='product-content'>";
      echo "<h2>" . $rowProduct['product_name'] . "</h2>";
      echo "<p>₱" . $rowProduct['price'] . " per piece </p>";
      echo "<p>minimum of 50 pcs per item</p>";
      echo "</div>";
      echo "<form action='products.php' method='post'>";
      echo "<input type='hidden' name='productId' value='" . $rowProduct['product_id'] . "'>";
      echo "<input type='hidden' name='productName' value='" . $rowProduct['product_name'] . "'>";
      echo "<input type='hidden' name='price' value='" . $rowProduct['price'] . "'>";
      echo "<button type='submit' name='addToCart'>Add to Cart</button>";
      echo "</form>";
      echo "</div>";
    }
  } else {
    echo "No products found";
  }
  ?>
</div>

</body>
</html>

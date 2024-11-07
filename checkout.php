<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for the e-wallet payment method selection
    if (isset($_POST['paymentMethod']) && $_POST['paymentMethod'] === 'ewallet') {
        $secretKey = 'sk_test_sKdPig85v87RhA4RUSzSdEdE';

        // Retrieve cart items and total amount from session or database
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $totalAmount = 0;
        
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Convert total amount to centavos (PHP uses smallest currency unit in API)
        $amountInCentavos = intval($totalAmount * 100);

        // Prepare PayMongo request payload
        $checkoutData = [
            'data' => [
                'attributes' => [
                    'line_items' => [
                        [
                            'name' => 'Total Order',
                            'amount' => $amountInCentavos,
                            'currency' => 'PHP',
                            'quantity' => 1
                        ]
                    ],  
                    'payment_method_types' => ['gcash'],
                    'cancel_url' => 'http://localhost/ESPINO/cart.php?payment=cancel',
                    'success_url' => 'http://localhost/ESPINO/thank_you.php',
                ]
            ]
        ];

        // Initialize cURL request
        $ch = curl_init('https://api.paymongo.com/v1/checkout_sessions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($secretKey . ':')
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($checkoutData));

        // Execute the request and handle response
        $response = curl_exec($ch);
        curl_close($ch);
        
        if ($response) {
            $responseArray = json_decode($response, true);
            if (isset($responseArray['data']['attributes']['checkout_url'])) {
                $checkoutUrl = $responseArray['data']['attributes']['checkout_url'];
                header("Location: $checkoutUrl");
                exit();
            } else {
                echo "Error: " . htmlspecialchars($responseArray['errors'][0]['detail'] ?? 'Unknown error occurred');
                exit();
            }
        } else {
            echo "Failed to initialize payment. Please try again.";
            exit();
        }
    } else {
        echo "Invalid payment method selected.";
    }
} else {
    header("Location: cart.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout</title>
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
    margin-left: 1200px;
  }

  .material-icons {
    font-family: 'Material Icons';
    font-size: 24px;
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

  .cart-item .quantity {
    flex: 1;
    text-align: center;
  }

  .cart-item .price {
    flex: 1;
    text-align: right;
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
    <h1>Checkout</h1>
    <?php if (count($cart) > 0): ?>
      <?php foreach ($cart as $item): ?>
        <div class="cart-item">
          <div class="name"><?php echo $item['name']; ?></div>
          <div class="quantity"><?php echo $item['quantity']; ?></div>
          <div class="price"><?php echo '₱' . number_format($item['price'] * $item['quantity'], 2); ?></div>
        </div>
      <?php endforeach; ?>
      <p>Total Amount: <?php echo '₱' . number_format($totalAmount, 2); ?></p>
      <form method="post">  
        <h2>Delivery or Pickup</h2>
        <input type="radio" name="deliveryOrPickup" id="delivery" value="delivery" required>
        <label class="radio-label" for="delivery">Delivery</label>
        <input type="radio" name="deliveryOrPickup" id="pickup" value="pickup" required>
        <label class="radio-label" for="pickup">Pickup</label>
        <br><br>
        <h2>Payment Method</h2>
        <input type="radio" name="paymentMethod" id="cash" value="cash" required>
        <label class="radio-label" for="cash">Cash</label>
        <input type="radio" name="paymentMethod" id="e_wallet" value="e_wallet" required>
        <label class="radio-label" for="e_wallet">E-Wallet</label>
        <br><br>
        <button type="submit" name="confirmOrder">Confirm Order</button>
        <button type="submit" name="cancelOrder">Cancel Order</button>
      </form>
    <?php else: ?>
      <p>Your cart is empty.</p>
    <?php endif; ?>
  </div>
</div>
</body>
</html>

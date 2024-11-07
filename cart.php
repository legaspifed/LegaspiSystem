<?php
session_start();

// Check if the "Checkout" button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    // Redirect to checkout.php
    header("Location: checkout.php");
    exit();
}

// Sample cart data (replace this with your actual cart data retrieval)
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$totalAmount = 0;

// Calculate total amount
foreach ($cart as $item) {
    $totalAmount += $item['price'] * $item['quantity'];
}

// Connect to the database 
$servername = 'localhost';
$username = 'GA_Customer';
$password = '456';
$dbname = 'greenantz_db';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have the logged-in user's ID stored in a session variable
$user_id = $_SESSION['cID'];

// Fetch orders for the logged-in user with JOIN to get product details
$sql = "SELECT t.transaction_id, t.transaction_date, t.status, t.total_price, p.product_name 
        FROM transactions t 
        JOIN products p ON t.product_id = p.product_id 
        WHERE t.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cart</title>
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
    margin-top: 10px;
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
    width: 70px;
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
    margin-top: 10px;
  }

  .action button:hover {
    background-color: #ff6e6e;
  }

  .order-history {
    margin-top: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
  }

  .order-history table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }

  .order-history table, .order-history th, .order-history td {
    border: 1px solid #ccc;
    padding: 10px;
  }

  .order-history th {
    background-color: #f2f2f2;
  }

  .status-pending {
    color: orange;
  }

  .status-shipped {
    color: blue;
  }

  .status-delivered {
    color: green;
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
        <h1>Your Cart</h1>
        <?php if (count($cart) > 0): ?>
            <?php foreach ($cart as $key => $item): ?>
                <div class="cart-item">
                    <div class="name"><?php echo htmlspecialchars($item['name']); ?></div>
                    <div class="quantity">
                        <input type="number" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="50" step="50" onchange="updateQuantity(<?php echo $key; ?>, this.value)" onkeydown="return false">
                    </div>
                    <div class="price"><?php echo '₱' . number_format($item['price'] * $item['quantity'], 2); ?></div>
                    <div class="action">
                        <button onclick="removeFromCart(<?php echo $key; ?>)">Remove</button>
                    </div>
                </div>
            <?php endforeach; ?>
            <p>Total Amount: <?php echo '₱' . number_format($totalAmount, 2); ?></p>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
        <form method="post" action="checkout.php">
        
    <h3>Select Payment Method</h3>
      <label>
          <input type="radio" name="paymentMethod" value="ewallet" required> E-wallet (via GCash)
      </label>
      
      <br>
      <button type="submit" name="checkout">Proceed to Pay</button>
</form>

    </div>

    <div class="order-history">
        <h1>Order History</h1>
        <?php if (count($orders) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Product Name</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['transaction_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['transaction_date']); ?></td>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td>
                                <?php
                                    $status = htmlspecialchars($order['status']);
                                    echo "<span class='status-$status'>$status</span>";
                                ?>
                            </td>
                            <td><?php echo '₱' . number_format($order['total_price'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
</div>

<script>
  function removeFromCart(index) {
    if (confirm('Are you sure you want to remove this item from your cart?')) {
      window.location.href = 'remove_from_cart.php?index=' + index;
    }
  }

  function updateQuantity(index, quantity) {
    if (quantity % 50 !== 0) {
        alert('Please enter a quantity that is a multiple of 50.');
        return; // Exit the function if quantity is not a multiple of 50
    }
    // Make an AJAX request to update the quantity
    var xhr = new XMLHttpRequest();
    xhr.open("GET", 'update_quantity.php?index=' + index + '&quantity=' + quantity, true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Update the total amount if needed
        var totalAmount = xhr.responseText;
        document.querySelector('.total-amount').innerText = '₱' + totalAmount;
      }
    };
    xhr.send();
  }
</script>

</body>
</html>
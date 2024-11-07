<?php
session_start(); // Start the session
require 'admin_conx.php'; // Include the database connection file

// Initialize filter variables
$filterEventType = isset($_GET['event_type']) ? $_GET['event_type'] : '';
$filterFullName = isset($_GET['full_name']) ? $_GET['full_name'] : '';
$filterDate = isset($_GET['date']) ? $_GET['date'] : '';
$sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'desc';

// Fetch available full names for the filter dropdown
$sqlFetchNames = "SELECT DISTINCT u.cName FROM users u JOIN login_audit l ON u.cID = l.user_id";
$resultNames = mysqli_query($conn, $sqlFetchNames);

// Fetch data from login_audit table joined with users table to get cName
$sqlFetchLog = "SELECT l.id, l.user_id, u.cName, l.event_type, l.event_time FROM login_audit l JOIN users u ON l.user_id = u.cID WHERE 1=1";

// Apply filters
if ($filterEventType != '') {
    $sqlFetchLog .= " AND l.event_type = '$filterEventType'";
}
if ($filterFullName != '') {
    $sqlFetchLog .= " AND u.cName = '$filterFullName'";
}
if ($filterDate != '') {
    $sqlFetchLog .= " AND DATE(l.event_time) = '$filterDate'";
}

$sqlFetchLog .= " ORDER BY l.event_time $sortOrder";
$result = mysqli_query($conn, $sqlFetchLog);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome to the Site</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons">
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
  .container {
    max-width: 800px;
    margin: 100px auto;
    text-align: center;
  }
  .content {
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    margin-top: 50px;
  }
  h1 {
    color: #077a07;
  }
  p {
    color: #333;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }
  th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
  }
  th {
    background-color: #077a07;
    color: #fff;
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

</style>
</head>
<body>
    
<div class="header">
  <ul class="menu">
    <li><button onclick="window.location.href='dashboard.php'">Dashboard</button></li>
    <li><button onclick="window.location.href='adminPage.php'">User Logs</button></li>
    <li><button onclick="window.location.href='Transactions.php'">Transactions</button></li>
    <li><button onclick="window.location.href='productTable.php'">Products</button></li>
    <li><button onclick="window.location.href='income.php'">Income</button></li>
    <li><button onclick="window.location.href='logoutAdmin.php'">Logout</button></li>
  </ul>
</div>

<div class="container">
  <div class="content">
    <?php if(isset($_SESSION['cName'])): ?>
      <h1>Welcome to the Site, <?php echo $_SESSION['cName']; ?></h1>
    <?php else: ?>
      <h1>Welcome to the Site</h1>
    <?php endif; ?>

    <!-- Form for filters -->
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label for="event_type">Event Type:</label>
            <select id="event_type" name="event_type">
                <option value="" <?php echo ($filterEventType == '') ? 'selected' : ''; ?>>All</option>
                <option value="login" <?php echo ($filterEventType == 'login') ? 'selected' : ''; ?>>Login</option>
                <option value="logout" <?php echo ($filterEventType == 'logout') ? 'selected' : ''; ?>>Logout</option>
                <option value="new user registration" <?php echo ($filterEventType == 'new user registration') ? 'selected' : ''; ?>>New User Registration</option>
            </select>

            <label for="full_name">Full Name:</label>
            <select id="full_name" name="full_name">
                <option value="" <?php echo ($filterFullName == '') ? 'selected' : ''; ?>>All</option>
                <?php
                if (mysqli_num_rows($resultNames) > 0) {
                    while($rowName = mysqli_fetch_assoc($resultNames)) {
                        $selected = ($filterFullName == $rowName['cName']) ? 'selected' : '';
                        echo "<option value=\"" . $rowName['cName'] . "\" $selected>" . $rowName['cName'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="sort_order">Sort by Date:</label>
            <select id="sort_order" name="sort_order">
                <option value="asc" <?php echo ($sortOrder == 'asc') ? 'selected' : ''; ?>>Ascending</option>
                <option value="desc" <?php echo ($sortOrder == 'desc') ? 'selected' : ''; ?>>Descending</option>
            </select>

            <button type="submit">Apply Filters</button>
        </div>
    </form>

    <h2>User Logs</h2>
    <button onclick="window.location.href='user_audit_report.php'">Download PDF report</button>
    <table>
      <thead>
        <tr>
          <th>User ID</th>
          <th>Full Name</th>
          <th>Event Type</th>
          <th>Timestamp</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['cName'] . "</td>";
            echo "<td>" . $row['event_type'] . "</td>";
            echo "<td>" . $row['event_time'] . "</td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='4'>No login events found</td></tr>";
        }
        ?>
      </tbody>
    </table>
    
  </div>
</div>

</body>
</html>

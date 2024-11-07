<?php
session_start();
require_once('tcpdf/tcpdf.php'); // Include TCPDF library
require('customer_conx.php'); // Include your database connection

// Capture search query and date filters from URL parameters
$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$id = $_SESSION['cID']; // Assuming you have user ID in session

// Prepare the SQL query to retrieve filtered transactions data
$sql = "
    SELECT 
        transactions.transaction_id, 
        transactions.product_id, 
        transactions.quantity, 
        transactions.unit_price, 
        transactions.total_price, 
        transactions.status, 
        transactions.transaction_date, 
        transactions.user_id,
        users.cName,
        users.cEmail
    FROM 
        transactions
    LEFT JOIN
        users
    ON
        transactions.user_id = users.cID
    WHERE 
        (transactions.transaction_id LIKE ? 
         OR transactions.product_id LIKE ? 
         OR transactions.status LIKE ? 
         OR transactions.transaction_date LIKE ?)";

// Add date filters to the SQL query
if (!empty($startDate) && !empty($endDate)) {
    // Increment the end date by 1 day to include it in the filter
    $endDatePlusOne = date('Y-m-d', strtotime($endDate . ' +1 day'));
    $sql .= " AND transactions.transaction_date BETWEEN ? AND ?";
}

$sql .= " ORDER BY transactions.transaction_date DESC";

$stmt = $conn->prepare($sql);

// Bind parameters
$search_param = '%' . $search_query . '%';
if (!empty($startDate) && !empty($endDate)) {
    $stmt->bind_param("ssssss", $search_param, $search_param, $search_param, $search_param, $startDate, $endDatePlusOne);
} else {
    $stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
}

// Execute query
$stmt->execute();
$result = $stmt->get_result();
$transactions = $result->fetch_all(MYSQLI_ASSOC);

// Log the action in audit trail
$sqlLog = 'INSERT INTO login_audit (user_id, event_type) VALUES (?, "Downloaded Transactions Report")';
$stmtLog = $conn->prepare($sqlLog);
$stmtLog->bind_param("i", $id);
$stmtLog->execute();

// Initialize TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Company Name');
$pdf->SetTitle('Transactions Report');
$pdf->SetSubject('Transactions Report');
$pdf->SetKeywords('TCPDF, PDF, report, transactions');

// Remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 10);

// Header
$pdf->writeHTML('<h1 class="text-center mb-4">Transactions Report</h1>', true, false, true, false, '');
$pdf->writeHTML('<p class="text-center">Report generated on ' . date('M d, Y') . '</p>', true, false, true, false, '');

// Additional lines
$filteredBy = "<br>";

// Append search query if not empty
if (!empty($search_query)) {
    $filteredBy .= "Filter: {$search_query}";
} else {
    $filteredBy .= "Filter: None";
}

// Append date range if both start date and end date are not empty
if (!empty($startDate) && !empty($endDate)) {
    $filteredBy .= "<br>Dates: {$startDate} to {$endDate}";
} else {
    $filteredBy .= "<br>Dates: None";
}

// Trim trailing space and semicolon if no filters were applied
$filteredBy = rtrim($filteredBy, "; ");

// Write "Filtered by" information
$pdf->writeHTML('<p>' . $filteredBy . '</p>', true, false, true, false, '');

// Table
$html = '<table border="1" cellspacing="0" cellpadding="5">';
$html .= '<thead>';
$html .= '<tr>
            <th>Transaction ID</th>
            <th>Product ID</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Transaction Date</th>
            <th>User</th>
        </tr>';
$html .= '</thead>';
$html .= '<tbody>';

// Loop through the results
foreach ($transactions as $row) {
    // Add data for each record
    $html .= '<tr>';
    $html .= '<td>'. $row['transaction_id'] .'</td>';
    $html .= '<td>'. $row['product_id'] .'</td>';
    $html .= '<td>' . $row['quantity'] . '</td>';
    $html .= '<td>' . $row['unit_price'] . '</td>';
    $html .= '<td>' . $row['total_price'] . '</td>';
    $html .= '<td>' . $row['status'] . '</td>';
    $html .= '<td>' . $row['transaction_date'] . '</td>';
    $html .= '<td>'. $row['cName'] .  '<br>' . $row['cEmail'] . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody>';
$html .= '</table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('transactions_' . date('Y-m-d') . '.pdf', 'D');

// Close the database connection
$conn->close();
?>

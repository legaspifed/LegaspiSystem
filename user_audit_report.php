<?php
session_start();
require_once('tcpdf/tcpdf.php'); // Include TCPDF library
require('customer_conx.php'); // Include your database connection

// Capture search query and date filters from URL parameters
$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$id = $_SESSION['cID']; // Assuming you have user ID in session

// Prepare the SQL query to retrieve filtered login audit data
$sql = "
    SELECT 
        login_audit.id, 
        login_audit.user_id, 
        login_audit.event_type, 
        login_audit.event_time,
        users.cName,
        users.cEmail
    FROM 
        login_audit
    LEFT JOIN
        users
    ON
        login_audit.user_id = users.cID
    WHERE 
        (login_audit.id LIKE ? 
         OR login_audit.event_type LIKE ? 
         OR login_audit.event_time LIKE ?)";

// Add date filters to the SQL query
if (!empty($startDate) && !empty($endDate)) {
    // Increment the end date by 1 day to include it in the filter
    $endDatePlusOne = date('Y-m-d', strtotime($endDate . ' +1 day'));
    $sql .= " AND login_audit.event_time BETWEEN ? AND ?";
}

$sql .= " ORDER BY login_audit.event_time DESC";

$stmt = $conn->prepare($sql);

// Bind parameters
$search_param = '%' . $search_query . '%';
if (!empty($startDate) && !empty($endDate)) {
    $stmt->bind_param("sssss", $search_param, $search_param, $search_param, $startDate, $endDatePlusOne);
} else {
    $stmt->bind_param("sss", $search_param, $search_param, $search_param);
}

// Execute query
$stmt->execute();
$result = $stmt->get_result();
$loginAudit = $result->fetch_all(MYSQLI_ASSOC);

// Log the action in audit trail
$sqlLog = 'INSERT INTO login_audit (user_id, event_type) VALUES (?, "Downloaded Login Audit Report")';
$stmtLog = $conn->prepare($sqlLog);
$stmtLog->bind_param("i", $id);
$stmtLog->execute();

// Initialize TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Company Name');
$pdf->SetTitle('Login Audit Report');
$pdf->SetSubject('Login Audit Report');
$pdf->SetKeywords('TCPDF, PDF, report, login, audit');

// Remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 10);

// Header
$pdf->writeHTML('<h1 class="text-center mb-4">Login Audit Report</h1>', true, false, true, false, '');
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
            <th>ID</th>
            <th>Event Type</th>
            <th>Event Time</th>
            <th>User</th>
        </tr>';
$html .= '</thead>';
$html .= '<tbody>';

// Loop through the results
foreach ($loginAudit as $row) {
    // Add data for each record
    $html .= '<tr>';
    $html .= '<td>'. $row['id'] .'</td>';
    $html .= '<td>'. $row['event_type'] .'</td>';
    $html .= '<td>' . $row['event_time'] . '</td>';
    $html .= '<td>'. $row['cName'] .  '<br>' . $row['cEmail'] . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody>';
$html .= '</table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('login_audit_' . date('Y-m-d') . '.pdf', 'D');

// Close the database connection
$conn->close();
?>

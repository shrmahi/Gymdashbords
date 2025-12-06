<?php
session_start();
include('includes/config.php');
require_once('tcpdf/tcpdf.php');

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
}

// Handle month filter
$whereClause = "";
$title = "Staff List";
if (!empty($_GET['month'])) {
    $month = mysqli_real_escape_string($con, $_GET['month']);
    $whereClause = " WHERE DATE_FORMAT(JoinningDate, '%Y-%m') = '$month'";
    $title .= " - " . date("F Y", strtotime($month . "-01"));
}

// Fetch data
$query = mysqli_query($con, "SELECT FirstName, LastName, Email, Contact, Address, JoinningDate, Is_Active FROM tblstaff $whereClause");

// Create PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Gym');
$pdf->SetTitle($title);
$pdf->SetHeaderData('', 0, $title, '');
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetMargins(15, 27, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Build HTML
$html = '<h2 style="text-align:center;">' . $title . '</h2>';
$html .= '<table border="1" cellpadding="4">
<thead>
<tr style="background-color:#f2f2f2;">
<th>#</th>
<th>Name</th>
<th>Email</th>
<th>Contact</th>
<th>Address</th>
<th>Joining Date</th>
<th>Status</th>
</tr>
</thead>
<tbody>';

$cnt = 1;
while ($row = mysqli_fetch_assoc($query)) {
    $status = ($row['Is_Active'] == 1) ? 'Active' : 'Inactive';
    $html .= '<tr>
        <td>' . $cnt . '</td>
        <td>' . htmlentities($row['FirstName'] . ' ' . $row['LastName']) . '</td>
        <td>' . htmlentities($row['Email']) . '</td>
        <td>' . htmlentities($row['Contact']) . '</td>
        <td>' . htmlentities($row['Address']) . '</td>
        <td>' . htmlentities($row['JoinningDate']) . '</td>
        <td>' . $status . '</td>
    </tr>';
    $cnt++;
}
$html .= '</tbody></table>';

// Output PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('staff_list.pdf', 'D');
?>
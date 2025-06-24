<?php
include('includes/config.php');
require_once('tcpdf/tcpdf.php');

$whereClause = "";
if (!empty($_GET['month'])) {
    $month = $_GET['month'];
    $whereClause = " WHERE DATE_FORMAT(JoinDate, '%Y-%m') = '" . mysqli_real_escape_string($con, $month) . "' ";
}

$query = mysqli_query($con, "SELECT FirstName, LastName, Email, Mobile, PaymentMode, JoinDate FROM tblmember $whereClause");

$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Gym');
$pdf->SetTitle('Members Data');
$pdf->SetHeaderData('', 0, 'Member List', '');
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

$html = '<h2>Member List</h2><table border="1" cellpadding="4">
<tr>
<th>Name</th>
<th>Email</th>
<th>Mobile</th>
<th>Payment Mode</th>
<th>Join Date</th>
</tr>';

while ($row = mysqli_fetch_assoc($query)) {
    $html .= '<tr>
    <td>' . htmlentities($row['FirstName'] . ' ' . $row['LastName']) . '</td>
    <td>' . htmlentities($row['Email']) . '</td>
    <td>' . htmlentities($row['Mobile']) . '</td>
    <td>' . htmlentities($row['PaymentMode']) . '</td>
    <td>' . htmlentities($row['JoinDate']) . '</td>
    </tr>';
}
$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('member_list.pdf', 'D');
?>
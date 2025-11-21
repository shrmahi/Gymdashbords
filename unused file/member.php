<?php
session_start();
include('includes/config.php');
error_reporting(0);

$catid = intval($_GET['cid']);
$query = mysqli_query($con, "SELECT tblmember.id as catid, `MemberBid`, `FirstName`, `LastName`, `Gender`, `Email`, `Mobile`, `AlterNumber`, `DoctorName`, `DoctorNumber`, `MedicalHistory`, `Address`, `PermnentAddress`, `DrivingNumber`, `PanNumber`, `AadharNumber`, `Dob`, `JoinDate`, `MaritalStatus`, `AssignStaff`, `ShiftType`, `PakageType`, `PaymentMode`, `ReceiptType`, `ReceiptDate`, `PostImage` FROM tblmember WHERE id='$catid'");
$row = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gym Dashboard | Member Details</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/core.css" rel="stylesheet" />
    <link href="assets/css/components.css" rel="stylesheet" />
    <link href="assets/css/icons.css" rel="stylesheet" />
    <link href="assets/css/pages.css" rel="stylesheet" />
    <link href="assets/css/menu.css" rel="stylesheet" />
    <link href="assets/css/responsive.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="assets/js/modernizr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

</head>

<body class="fixed-left">
    <div id="wrapper">
        <?php include('includes/topheader.php'); ?>
        <?php include('includes/leftsidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Member Details</h4>
                                <ol class="breadcrumb">
                                    <li><a href="#">Admin</a></li>
                                    <li><a href="#">Member</a></li>
                                    <li class="active">Manage Details</li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <?php if ($msg) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php } ?>

                    <?php if ($delmsg) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Deleted!</strong> <?php echo htmlentities($delmsg); ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php } ?>
                    <button class="btn btn-danger mb-3" onclick="generatePDF()" style="margin-bottom:2%">Download
                        PDF</button>

                    <div class="card" id="member-details">
                        <div class="card-body">
                            <div class="table-responsive" style="padding-left: 10%; padding-right: 10%;">
                                <table class="table table-bordered table-striped text-center">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>
                                                <h4>SRGym</h4>
                                            </th>
                                            <th colspan="5">
                                                <h4 class="text-center">Member Form</h4>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="table-primary">
                                            <th colspan="1">Member's Id :-</th>
                                            <th colspan="3"><?php echo htmlentities($row['MemberBid']); ?></th>
                                            <th>Date :- <?php echo htmlentities($row['JoinDate']); ?></th>
                                            <th><?php if (!empty($row['PostImage'])): ?>
                                                    <img src="postimages/<?php echo htmlentities($row['PostImage']); ?>"
                                                        alt="Photo" style="width: 100px;height: 100px;">
                                                <?php else: ?>
                                                    Photo Here
                                                <?php endif; ?>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th>Candidate Name :-</th>
                                            <td colspan="1" style="text-align:left">
                                                <?php echo htmlentities($row['FirstName'] . ' ' . $row['LastName']); ?>
                                            </td>
                                            <th>Mobile :-</th>
                                            <td style="text-align:left"><?php echo htmlentities($row['Mobile']); ?></td>
                                            <th>Alternate Mobile :-</th>
                                            <td style="text-align:left"><?php echo htmlentities($row['AlterNumber']); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Email Address :-</th>
                                            <td style="text-align:left">
                                                <?php echo htmlentities($row['Email']); ?>
                                            </td>
                                            <th>Gender :-</th>
                                            <td style="text-align:left">
                                                <?php echo htmlentities($row['Gender']); ?>
                                            </td>
                                            <th>Marital Status :-</th>
                                            <td style="text-align:left">
                                                <?php echo htmlentities($row['MaritalStatus']); ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Local Address :-</th>
                                            <td colspan="5" style="text-align:left">
                                                <?php echo htmlentities($row['Address']); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Permanent Address :-</th>
                                            <td colspan="5" style="text-align:left">
                                                <?php echo htmlentities($row['PermnentAddress']); ?>
                                            </td>
                                        </tr>
                                        <tr class="table-primary">
                                            <th colspan="6" style="font-size:25px">Documents Details</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Aadhar Number :-</th>
                                            <th colspan="2">PAN Number :-</th>
                                            <th colspan="2">Driving License :-</th>

                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align:left">
                                                <?php echo htmlentities($row['AadharNumber']); ?>
                                            </td>
                                            <td colspan="2" style="text-align:left">
                                                <?php echo htmlentities($row['PanNumber']); ?>
                                            </td>
                                            <td colspan="2" style="text-align:left">
                                                <?php echo htmlentities($row['DrivingNumber']); ?>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th colspan="2">Doctor Name :-</th>
                                            <th colspan="2">Doctor Number :-</th>
                                            <th colspan="2">Medical Problem :-</th>

                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align:left">
                                                <?php echo htmlentities($row['DoctorName']); ?>
                                            </td>
                                            <td colspan="2" style="text-align:left">
                                                <?php echo htmlentities($row['DoctorNumber']); ?>
                                            </td>
                                            <td colspan="2" style="text-align:left">
                                                <?php echo htmlentities($row['MedicalHistory']); ?>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th colspan="2">Trainer Name :-</th>
                                            <th colspan="2">Shift :-</th>
                                            <th colspan="2">Package :-</th>

                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align:left">
                                                <?php echo htmlentities($row['AssignStaff']); ?>
                                            </td>
                                            <td colspan="2" style="text-align:left">
                                                <?php echo htmlentities($row['ShiftType']); ?>
                                            </td>
                                            <td colspan="2" style="text-align:left">
                                                <?php echo htmlentities($row['PakageType']); ?>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th colspan="2">Payment Mode :-</th>
                                            <th colspan="2">Receipt Date :-</th>
                                            <th colspan="2">Receipt Type :-</th>

                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align:left">
                                                <?php echo htmlentities($row['PaymentMode']); ?>
                                            </td>
                                            <td colspan="2" style="text-align:left">
                                                <?php echo htmlentities($row['ReceiptDate']); ?>
                                            </td>
                                            <td colspan="2" style="text-align:left">
                                                <?php echo htmlentities($row['ReceiptType']); ?>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <script>
        function generatePDF() {
            const { jsPDF } = window.jspdf;
            let pdf = new jsPDF('p', 'pt', 'a4');

            const element = document.getElementById('member-details');

            html2canvas(element, { scale: 2 }).then((canvas) => {
                const imgData = canvas.toDataURL('image/png');
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                pdf.addImage(imgData, 'PNG', 10, 10, pdfWidth - 20, pdfHeight);
                pdf.save('member-details.pdf');
            });
        }
    </script>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>
</body>

</html>
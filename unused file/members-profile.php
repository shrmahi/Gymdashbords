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
    <meta charset="UTF-8">
    <title>Membership Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            width: 100%;
            max-width: 900px;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .photo-box {
            width: 120px;
            height: 150px;
            border: 1px solid #ccc;
            background-size: cover;
            background-position: center;
            margin: 0 auto;
        }

        input.form-control[readonly] {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>
    <div class="container form-container">
        <div class="form-title">Membership Form</div>

        <div class="row mb-3">
            <div class="col-md-8">
                <h5><?php echo htmlentities($row['FirstName'] . ' ' . $row['LastName']); ?></h5>
                <div class="mb-2">
                    <label>Member ID:</label>
                    <input type="text" class="form-control form-control-sm w-50"
                        value="<?php echo htmlentities($row['MemberBid']); ?>" readonly>
                </div>
                <div class="mb-2">
                    <label>Joining Date:</label>
                    <input type="text" class="form-control form-control-sm w-50"
                        value="<?php echo htmlentities($row['JoinDate']); ?>" readonly>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="photo-box">
                    <?php if (!empty($row['PostImage'])): ?>
                        <img src="postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="Photo"
                            style="max-width: 100%; max-height: 100%;">
                    <?php else: ?>
                        Photo Here
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <div id="membershipForm">
            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Name:</label>
                    <input type="text" class="form-control"
                        value="<?php echo htmlentities($row['FirstName'] . ' ' . $row['LastName']); ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label>Gender:</label>
                    <div>
                        <label class="me-2">
                            <input type="radio" <?php if ($row['Gender'] == 'Male')
                                echo 'checked'; ?> disabled> Male
                        </label>
                        <label class="me-2">
                            <input type="radio" <?php if ($row['Gender'] == 'Female')
                                echo 'checked'; ?> disabled> Female
                        </label>
                        <label class="me-2">
                            <input type="radio" <?php if ($row['Gender'] == 'Other')
                                echo 'checked'; ?> disabled> Other
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4">
                    <label>Phone:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['Mobile']); ?>"
                        readonly>
                </div>
                <div class="col-md-4">
                    <label>Alter Number:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['AlterNumber']); ?>"
                        readonly>
                </div>
                <div class="col-md-4">
                    <label>Marital Status:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['MaritalStatus']); ?>"
                        readonly>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Email Id:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['Email']); ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label>Date of Birth:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['Dob']); ?>" readonly>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Aadhar Card:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['AadharNumber']); ?>"
                        readonly>
                </div>
                <div class="col-md-6">
                    <label>PAN Card:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['PanNumber']); ?>"
                        readonly>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Driving Number:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['DrivingNumber']); ?>"
                        readonly>
                </div>
                <div class="col-md-6">
                    <label>Address:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['Address']); ?>"
                        readonly>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Permanent Address:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['PermnentAddress']); ?>"
                        readonly>
                </div>
                <div class="col-md-6">
                    <label>Medical Problems:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['MedicalHistory']); ?>"
                        readonly>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4">
                    <label>Doctor Name:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['DoctorName']); ?>"
                        readonly>
                </div>
                <div class="col-md-4">
                    <label>Doctor Number:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['DoctorNumber']); ?>"
                        readonly>
                </div>
                <div class="col-md-4">
                    <label>Trainer Name:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['AssignStaff']); ?>"
                        readonly>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4">
                    <label>Shift:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['ShiftType']); ?>"
                        readonly>
                </div>
                <div class="col-md-4">
                    <label>Package:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['PakageType']); ?>"
                        readonly>
                </div>
                <div class="col-md-4">
                    <label>Payment Mode:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['PaymentMode']); ?>"
                        readonly>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Receipt Date:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['ReceiptDate']); ?>"
                        readonly>
                </div>
                <div class="col-md-6">
                    <label>Receipt Type:</label>
                    <input type="text" class="form-control" value="<?php echo htmlentities($row['ReceiptType']); ?>"
                        readonly>
                </div>
            </div>
        </div> <!-- membershipForm -->

        <div class="text-center mt-3">
            <button id="downloadPdf" class="btn btn-primary">Download Membership Form PDF</button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById('downloadPdf').addEventListener('click', () => {
            const element = document.getElementById('membershipForm');
            const opt = {
                margin: 0.5,
                filename: '<?php echo htmlentities($row["FirstName"] . "_" . $row["LastName"]); ?>_Membership_Form.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        });
    </script>
</body>

</html>
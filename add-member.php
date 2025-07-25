<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
} else {
    // For adding post  
    if (isset($_POST['submit'])) {
        $memberid = $_POST['memberid'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $number = $_POST['number'];
        $altnumber = $_POST['altnumber'];
        $dname = $_POST['dname'];
        $dnumber = $_POST['dnumber'];
        $medihistory = $_POST['medihistory'];
        $assignstaff = $_POST['assignstaff'];
        $shifttype = $_POST['shifttype'];
        $address = $_POST['address'];
        $altaddress = $_POST['altaddress'];
        $aadhar = $_POST['aadhar'];
        $drivingnum = $_POST['drivingnum'];
        $pannum = $_POST['pannum'];
        $pkgtype = $_POST['pkgtype'];
        $dob = $_POST['dob'];
        $joindate = $_POST['joindate'];
        $expirydate = $_POST['expirydate'];
        $maritalstatus = $_POST['maritalstatus'];
        $receipttype = $_POST['receipttype'];
        $receiptdate = $_POST['receiptdate'];
        $paymode = $_POST['paymode'];
        $postedby = $_SESSION['login'];
        $status = 1;

        $imgfile = $_FILES["postimage"]["name"];
        $extension = strtolower(pathinfo($imgfile, PATHINFO_EXTENSION));
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");

        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg / png / gif format allowed');</script>";
        } else {
            $imgnewfile = md5($imgfile . time()) . '.' . $extension;
            move_uploaded_file($_FILES["postimage"]["tmp_name"], "postimages/" . $imgnewfile);

            $query = mysqli_query($con, "INSERT INTO tblmember (
                MemberBid, FirstName, LastName, Gender, Email, Mobile, AlterNumber,
                DoctorName, DoctorNumber, MedicalHistory, Address, PermnentAddress,
                DrivingNumber, PanNumber, AadharNumber, Dob, JoinDate,expirydate, MaritalStatus,
                AssignStaff, ShiftType, PakageType, PaymentMode, ReceiptType, ReceiptDate,
                Is_Active, PostImage, postedBy
            ) VALUES (
                '$memberid', '$fname', '$lname', '$gender', '$email', '$number', '$altnumber',
                '$dname', '$dnumber', '$medihistory', '$address', '$altaddress',
                '$drivingnum', '$pannum', '$aadhar', '$dob', '$joindate','$expirydate', '$maritalstatus',
                '$assignstaff', '$shifttype', '$pkgtype', '$paymode', '$receipttype', '$receiptdate',
                '$status', '$imgnewfile', '$postedby'
            )");

            if ($query) {
                $msg = "Member successfully added.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme for CRM/CMS">
        <meta name="author" content="Coderthemes">
        <title>Gym Dashboard | Add Member</title>

        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="../plugins/summernote/summernote.css" rel="stylesheet" />
        <link href="../plugins/select2/css/select2.min.css" rel="stylesheet" />
        <link href="../plugins/jquery.filer/css/jquery.filer.css" rel="stylesheet" />
        <link href="../plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="assets/css/core.css" rel="stylesheet" />
        <link href="assets/css/components.css" rel="stylesheet" />
        <link href="assets/css/icons.css" rel="stylesheet" />
        <link href="assets/css/pages.css" rel="stylesheet" />
        <link href="assets/css/menu.css" rel="stylesheet" />
        <link href="assets/css/responsive.css" rel="stylesheet" />
        <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
        <script src="assets/js/modernizr.min.js"></script>
    </head>

    <body class="fixed-left">
        <div id="wrapper">
            <?php include('includes/topheader.php'); ?>
            <?php include('includes/leftsidebar.php'); ?>

            <div class="content-page">
                <div class="content">
                    <div class="container">

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Add Member</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li><a href="#">Member</a></li>
                                        <li><a href="#">Add Member</a></li>
                                        <li class="active">Add Member</li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Feedback messages -->
                        <div class="row">
                            <?php include('alert_message.php'); ?>
                        </div>

                        <!-- Form -->
                        <div class="row">
                            <div class="col-md-10">
                                <form class="form-horizontal" name="category" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Member's ID</label>
                                        <?php
                                        session_start();
                                        $_SESSION['memberid'] = ($_SESSION['memberid'] ?? 100) + 1;
                                        ?>

                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="memberid"
                                                value="<?= $_SESSION['memberid'] ?>" required readonly>

                                        </div>
                                        <div class="col-md-2">
                                            <input type="file" class="form-control" name="postimage" id="postimage"
                                                accept="image/*" required onchange="previewImage(event)">

                                        </div>
                                        <div class="col-md-3">
                                            <img id="imagePreview" src="#" alt="Selected Image"
                                                style="display: none; height: 100px; width: 100px; border: 1px solid #ccc; padding: 5px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Name</label>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="fname" placeholder="First Name"
                                                required>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="lname" placeholder="Last Name"
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Gender</label>
                                        <div class="col-md-5">
                                            <label class="radio-inline"><input type="radio" name="gender" value="Male"
                                                    required> Male</label>
                                            <label class="radio-inline"><input type="radio" name="gender" value="Female">
                                                Female</label>
                                            <label class="radio-inline"><input type="radio" name="gender" value="Other">
                                                Other</label>
                                        </div>
                                        <div class="col-md-5">
                                            <select class="form-control" name="maritalstatus" required>
                                                <option value="">-- Marital Status --</option>
                                                <option value="Married">Married</option>
                                                <option value="Unmarried">Unmarried</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Email</label>
                                        <div class="col-md-10">
                                            <input type="email" class="form-control" name="email" placeholder="Enter Email"
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Mobile</label>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="number"
                                                placeholder="Mobile Number" required>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="altnumber"
                                                placeholder="Alternate Number" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Address</label>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="address" placeholder="Address"
                                                required>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="altaddress"
                                                placeholder="Alternate Address" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Doctor's Details</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="dname" placeholder="Doctor's Name"
                                                required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="dnumber"
                                                placeholder="Doctor's Number" required>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control" name="medihistory" required>
                                                <option value="">-- Medical History --</option>
                                                <option value="No">No</option>
                                                <?php
                                                $query = mysqli_query($con, "SELECT MedicalRecord FROM tblmedical WHERE Is_active=1");
                                                while ($row = mysqli_fetch_array($query)) {
                                                    echo '<option value="' . htmlentities($row['MedicalRecord']) . '">' . htmlentities($row['MedicalRecord']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Staff and Shift</label>
                                        <div class="col-md-5">
                                            <select class="form-control" name="assignstaff" required>
                                                <option value="">-- Assign Staff --</option>
                                                <option value="No">No</option>
                                                <?php
                                                $query = mysqli_query($con, "SELECT FirstName FROM tblstaff WHERE Type='Trainer' AND Is_active=1");
                                                while ($row = mysqli_fetch_array($query)) {
                                                    echo '<option value="' . htmlentities($row['FirstName']) . '">' . htmlentities($row['FirstName']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <select class="form-control" name="shifttype" required>
                                                <option value="">-- Shift Type --</option>
                                                <?php
                                                $query = mysqli_query($con, "SELECT ShiftName FROM tblshift WHERE Is_active=1");
                                                while ($row = mysqli_fetch_array($query)) {
                                                    echo '<option value="' . htmlentities($row['ShiftName']) . '">' . htmlentities($row['ShiftName']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Documents</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="aadhar" placeholder="Aadhar"
                                                required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="drivingnum"
                                                placeholder="Driving License" required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="pannum" placeholder="PAN Number"
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Date of Birth</label>
                                        <div class="col-md-4">
                                            <input type="date" class="form-control" name="dob" id="dob" required
                                                onchange="calculateAge()">

                                            <span id="ageDisplay" style="font-weight: bold;"></span>
                                        </div>
                                        <!-- <div class="col-md-2">
                                            <label class="control-label">Joining Date</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="date" class="form-control" name="joindate" id="joindate" required>
                                        </div> -->
                                        <div class="col-md-2">
                                            <label class="control-label">Payment Mode</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control" name="paymode" required>
                                                <option value="">-- Payment Mode --</option>
                                                <?php
                                                $query = mysqli_query($con, "SELECT PaymentMode FROM tblpaymode WHERE Is_active=1");
                                                while ($row = mysqli_fetch_array($query)) {
                                                    echo '<option value="' . htmlentities($row['PaymentMode']) . '">' . htmlentities($row['PaymentMode']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Package</label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="pkgtype" id="pkgtype" required>
                                                <option value="">-- Package Type --</option>
                                                <?php
                                                $query = mysqli_query($con, "SELECT * FROM tblplan WHERE Is_active=1");
                                                while ($row = mysqli_fetch_array($query)) {
                                                    $durationText = htmlentities($row['Duration']) . ' ' . htmlentities($row['Days']); // e.g. "1 Month 10 Day"
                                                    echo '<option value="' . htmlentities($row['PlanName']) . '" 
              data-duration="' . $durationText . '">'
                                                        . htmlentities($row['PlanName']) . ' - ' . $durationText . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label">Joining Date</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="date" class="form-control" name="joindate" id="joindate" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Receipt</label>
                                        <div class="col-md-4">
                                            <input type="date" class="form-control" name="receiptdate" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label">Receipt Type</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control" name="receipttype" required>
                                                <option value="">-- Receipt Type --</option>
                                                <?php
                                                $query = mysqli_query($con, "SELECT ReceiptNumber FROM tblreceipt WHERE Is_active=1");
                                                while ($row = mysqli_fetch_array($query)) {
                                                    echo '<option value="' . htmlentities($row['ReceiptNumber']) . '">' . htmlentities($row['ReceiptNumber']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Expiry Date</label>
                                        <div class="col-md-4">
                                            <input type="date" class="form-control" name="expirydate" id="expirydate"
                                                readonly>

                                        </div>
                                        <div class=" col-md-5">
                                            <button type="submit" class="btn btn-custom waves-effect waves-light btn-md"
                                                name="submit">Submit</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                <?php include('includes/footer.php'); ?>
            </div>
        </div>

        <!-- Scripts -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="../plugins/switchery/switchery.min.js"></script>
        <script src="../plugins/summernote/summernote.min.js"></script>
        <script src="../plugins/select2/js/select2.min.js"></script>
        <script src="../plugins/jquery.filer/js/jquery.filer.min.js"></script>
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

        <script>
            $(document).ready(function () {
                $('.summernote').summernote({ height: 240 });
                $(".select2").select2();
            });
        </script>
        <script>
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreview');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = "block";
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = "#";
                    preview.style.display = "none";
                }
            }
        </script>
        <script>
            function calculateAge() {
                const dob = document.getElementById('dob').value;
                const ageDisplay = document.getElementById('ageDisplay');

                if (dob) {
                    const birthDate = new Date(dob);
                    const today = new Date();

                    let age = today.getFullYear() - birthDate.getFullYear();
                    const m = today.getMonth() - birthDate.getMonth();

                    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }

                    ageDisplay.textContent = age + " years";
                } else {
                    ageDisplay.textContent = "";
                }
            }
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const pkgtype = document.getElementById("pkgtype");
                const joindate = document.getElementById("joindate");
                const expirydate = document.getElementById("expirydate");

                function calculateExpiryDate() {
                    const joinDateVal = joindate.value;
                    if (!joinDateVal) {
                        expirydate.value = "";
                        return;
                    }

                    const selected = pkgtype.options[pkgtype.selectedIndex];
                    const durationText = selected.getAttribute("data-duration"); // e.g. "1 Month 10 Day"
                    if (!durationText) {
                        expirydate.value = "";
                        return;
                    }

                    const regex = /(\d+)\s*(Year|Month|Day)s?/gi;
                    const matches = [...durationText.matchAll(regex)];

                    let date = new Date(joinDateVal);

                    matches.forEach(match => {
                        const number = parseInt(match[1]);
                        const unit = match[2].toLowerCase();

                        if (unit === 'year') {
                            date.setFullYear(date.getFullYear() + number);
                        } else if (unit === 'month') {
                            date.setMonth(date.getMonth() + number);
                        } else if (unit === 'day') {
                            date.setDate(date.getDate() + number);
                        }
                    });

                    const yyyy = date.getFullYear();
                    const mm = String(date.getMonth() + 1).padStart(2, '0');
                    const dd = String(date.getDate()).padStart(2, '0');
                    expirydate.value = `${yyyy}-${mm}-${dd}`;
                }

                pkgtype.addEventListener("change", calculateExpiryDate);
                joindate.addEventListener("change", calculateExpiryDate);
            });
        </script>






    </body>

    </html>

<?php } ?>
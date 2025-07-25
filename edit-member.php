<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['update'])) {
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
        $maritalstatus = $_POST['maritalstatus'];
        $receipttype = $_POST['receipttype'];
        $receiptdate = $_POST['receiptdate'];
        $paymode = $_POST['paymode'];
        $postedby = $_SESSION['login'];
        $status = 1;
        $catid = intval($_GET['cid']);
        $query = mysqli_query($con, "update tblmember set `MemberBid`='$memberid',`FirstName`='$fname',`LastName`='$lname',`Gender`='$gender',`Email`='$email',`Mobile`='$number',`AlterNumber`='$altnumber',`DoctorName`='$dname',`DoctorNumber`='$dnumber',`MedicalHistory`='$medihistory',`Address`='$address',`PermnentAddress`='$altaddress',`DrivingNumber`='$drivingnum',`PanNumber`='$pannum',`AadharNumber`='$aadhar',`Dob`='$dob',`JoinDate`='$joindate',`MaritalStatus`='$maritalstatus',`AssignStaff`='$assignstaff',`ShiftType`='$shifttype',`PakageType`='$pkgtype',`PaymentMode`='$paymode',`ReceiptType`='$receipttype',`ReceiptDate`='$receiptdate'  where id='$catid'");
        if ($query) {
            $msg = "Member details updated ";
        } else {
            $error = "Something went wrong . Please try again.";
        }

    }


    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Gym Dashboard | Member Details</title>

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
        <script src="assets/js/modernizr.min.js"></script>

    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <?php include('includes/topheader.php'); ?>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
            <?php include('includes/leftsidebar.php'); ?>
            <!-- Left Sidebar End -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">


                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Member Details</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Admin</a>
                                        </li>
                                        <li>
                                            <a href="#">Member Details </a>
                                        </li>
                                        <li class="active">
                                            Member Details
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b>Member Details </b></h4>
                                    <hr />



                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!---Success Message--->
                                        <?php if ($msg) { ?>
                                        <div class="alert alert-success" role="alert">
                                            <strong>Well done!</strong>
                                            <?php echo htmlentities($msg); ?>
                                        </div>
                                        <?php } ?>

                                        <!---Error Message--->
                                        <?php if ($error) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <strong>Oh snap!</strong>
                                            <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>


                                    </div>
                                </div>

                                <?php
                                $catid = intval($_GET['cid']);
                                $query = mysqli_query($con, "Select tblmember.id as catid, `MemberBid`, `FirstName`, `LastName`, `Gender`, `Email`, `Mobile`, `AlterNumber`, `DoctorName`, `DoctorNumber`, `MedicalHistory`, `Address`, `PermnentAddress`, `AadharNumber`, `DrivingNumber`, `PanNumber`, `Dob`, `JoinDate`, `MaritalStatus`, `AssignStaff`, `ShiftType`, `PakageType`, `PaymentMode`, `ReceiptType`, `ReceiptDate`, `PostImage` from  tblmember where id='$catid'");
                                $cnt = 1;
                                while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <form class="form-horizontal" name="category" method="post">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Member's ID</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="memberid"
                                                        value="<?php echo htmlentities($row['MemberBid']); ?>" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <img src="postimages/<?php echo htmlentities($row['PostImage']); ?>"
                                                        width="100" height="100" />
                                                    <a
                                                        href="change-profile.php?cid=<?php echo htmlentities($row['catid']); ?>">Update
                                                        Image</a>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Name</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="fname"
                                                        value="<?php echo htmlentities($row['FirstName']); ?>" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="lname"
                                                        value="<?php echo htmlentities($row['LastName']); ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Gender</label>
                                                <div class="col-md-5">
                                                    <?php $gender = htmlentities($row['Gender']); ?>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="gender" value="Male" <?php if ($gender == 'Male')
                                                            echo 'checked'; ?> required> Male
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="gender" value="Female" <?php if ($gender == 'Female')
                                                            echo 'checked'; ?>> Female
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="gender" value="Other" <?php if ($gender == 'Other')
                                                            echo 'checked'; ?>> Other
                                                    </label>
                                                </div>
                                                <div class="col-md-5">
                                                    <select class="form-control" name="maritalstatus" required>
                                                        <option
                                                            value="<?php echo htmlentities($row['MaritalStatus']); ?>"
                                                            selected>
                                                            <?php echo htmlentities($row['MaritalStatus']); ?>
                                                        </option>
                                                        <option value="Married">Married</option>
                                                        <option value="Unmarried">Unmarried</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Email</label>
                                                <div class="col-md-10">
                                                    <input type="email" class="form-control" name="email"
                                                        value="<?php echo htmlentities($row['Email']); ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Mobile</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="number"
                                                        value="<?php echo htmlentities($row['Mobile']); ?>" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="altnumber"
                                                        value="<?php echo htmlentities($row['AlterNumber']); ?>"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Address</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="address"
                                                        value="<?php echo htmlentities($row['Address']); ?>" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="altaddress"
                                                        value="<?php echo htmlentities($row['PermnentAddress']); ?>"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Doctor's Details</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="dname"
                                                        value="<?php echo htmlentities($row['DoctorName']); ?>"
                                                        required>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="dnumber"
                                                        value="<?php echo htmlentities($row['DoctorNumber']); ?>"
                                                        required>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="medihistory" required>
                                                        <option
                                                            value="<?php echo htmlentities($row['MedicalHistory']); ?>"
                                                            selected>
                                                            <?php echo htmlentities($row['MedicalHistory']); ?>
                                                        </option>
                                                        <option value="No">No</option>
                                                        <option value="High Sugar">High Sugar</option>
                                                        <option value="Low BP">Low BP</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Staff and Shift</label>
                                                <div class="col-md-5">
                                                    <select class="form-control" name="assignstaff" required>
                                                        <option value="<?php echo htmlentities($row['AssignStaff']); ?>"
                                                            selected>
                                                            <?php echo htmlentities($row['AssignStaff']); ?>
                                                        </option>
                                                        <?php
                                                        $staffQuery = mysqli_query($con, "SELECT FirstName FROM tblstaff WHERE Type='Trainer' AND Is_Active=1");
                                                        while ($staffRow = mysqli_fetch_array($staffQuery)) {
                                                            echo '<option value="' . htmlentities($staffRow['FirstName']) . '">' . htmlentities($staffRow['FirstName']) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-5">
                                                    <select class="form-control" name="shifttype" required>
                                                        <?php
                                                        $currentShift = htmlentities($row['ShiftType']);
                                                        $shiftQuery = mysqli_query($con, "SELECT ShiftName FROM tblshift WHERE Is_Active=1");
                                                        while ($shiftRow = mysqli_fetch_array($shiftQuery)) {
                                                            $shiftName = htmlentities($shiftRow['ShiftName']);
                                                            $selected = ($shiftName === $currentShift) ? 'selected' : '';
                                                            echo '<option value="' . $shiftName . '" ' . $selected . '>' . $shiftName . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Documents</label>
                                                <div class="col-md-10">
                                                    <div class="row">
                                                        <div class="col-md-4 mb-2">
                                                            <input type="text" class="form-control" name="aadhar"
                                                                value="<?php echo htmlentities($row['AadharNumber']); ?>"
                                                                required>
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            <input type="text" class="form-control" name="drivingnum"
                                                                value="<?php echo htmlentities($row['DrivingNumber']); ?>"
                                                                required>
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            <input type="text" class="form-control" name="pannum"
                                                                value="<?php echo htmlentities($row['PanNumber']); ?>"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Date of Birth</label>
                                                <div class="col-md-4">
                                                    <input type="date" class="form-control" name="dob"
                                                        value="<?php echo htmlentities($row['Dob']); ?>" required>
                                                </div>
                                                <label class="col-md-2 control-label">Joining Date</label>
                                                <div class="col-md-4">
                                                    <input type="date" class="form-control" name="joindate"
                                                        value="<?php echo htmlentities($row['JoinDate']); ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Package & Payment</label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="pkgtype" required>
                                                        <option value="<?php echo htmlentities($row['PakageType']); ?>"
                                                            selected>
                                                            <?php echo htmlentities($row['PakageType']); ?>
                                                        </option>
                                                        <?php
                                                        $pkgQuery = mysqli_query($con, "SELECT PlanName FROM tblplan WHERE Is_Active=1");
                                                        while ($pkgRow = mysqli_fetch_array($pkgQuery)) {
                                                            echo '<option value="' . htmlentities($pkgRow['PlanName']) . '">' . htmlentities($pkgRow['PlanName']) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label">Payment Mode</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="paymode" required>
                                                        <option value="<?php echo htmlentities($row['PaymentMode']); ?>"
                                                            selected>
                                                            <?php echo htmlentities($row['PaymentMode']); ?>
                                                        </option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Phone Pay">Phone Pay</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Receipt</label>
                                                <div class="col-md-4">
                                                    <input type="date" class="form-control" name="receiptdate"
                                                        value="<?php echo !empty($row['ReceiptDate']) ? htmlentities(date('Y-m-d', strtotime($row['ReceiptDate']))) : ''; ?>"
                                                        required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label">Receipt Type</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="receipttype" required>
                                                        <option value="<?php echo htmlentities($row['ReceiptType']); ?>"
                                                            selected>
                                                            <?php echo htmlentities($row['ReceiptType']); ?>
                                                        </option>
                                                        <?php
                                                        $receiptQuery = mysqli_query($con, "SELECT ReceiptNumber FROM tblreceipt WHERE Is_Active=1");
                                                        while ($receiptRow = mysqli_fetch_array($receiptQuery)) {
                                                            echo '<option value="' . htmlentities($receiptRow['ReceiptNumber']) . '">' . htmlentities($receiptRow['ReceiptNumber']) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">&nbsp;</label>
                                                <div class="col-md-10">
                                                    <button type="submit"
                                                        class="btn btn-custom waves-effect waves-light btn-md"
                                                        name="submit">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </form>


                                    </div>


                                </div>
                                <?php } ?>











                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                    </div> <!-- container -->

                </div> <!-- content -->

                <?php include('includes/footer.php'); ?>

            </div>


        </div>
        <!-- END wrapper -->



        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="../plugins/switchery/switchery.min.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

    </body>

    </html>
<?php } ?>
<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['submit'])) {
        $formtype = $_POST['formtype'];
        $status = 1;

        if ($formtype == 'shift') {
            $shiftname = $_POST['shiftname'];
            $query = mysqli_query($con, "INSERT INTO tblshift (ShiftName, Is_Active) VALUES ('$shiftname', '$status')");
            $msg = $query ? "Shift created" : "Error creating shift.";

        } elseif ($formtype == 'package') {
            $packagename = $_POST['packagename'];
            $query = mysqli_query($con, "INSERT INTO tblpackage (PackageName, Is_Active) VALUES ('$packagename', '$status')");
            $msg = $query ? "Package created" : "Error creating package.";

        } elseif ($formtype == 'receipt') {
            $receiptnumber = $_POST['receiptnumber'];
            $query = mysqli_query($con, "INSERT INTO tblreceipt (ReceiptNumber, Is_Active) VALUES ('$receiptnumber', '$status')");
            $msg = $query ? "Receipt created" : "Error creating receipt.";
        } elseif ($formtype == 'paymode') {
            $paymode = $_POST['paymode'];
            $query = mysqli_query($con, "INSERT INTO tblpaymode (PaymentMode, Is_Active) VALUES ('$paymode', '$status')");
            $msg = $query ? "Payment mode created" : "Error creating receipt.";
        } elseif ($formtype == 'medical') {
            $medicalname = $_POST['medicalname'];
            $query = mysqli_query($con, "INSERT INTO tblmedical (MedicalRecord, Is_Active) VALUES ('$medicalname', '$status')");
            $msg = $query ? "Medical History created" : "Error creating receipt.";
        }
    }

    if ($_GET['action'] == 'del' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        $query = mysqli_query($con, "update tblpackage set Is_Active='0' where id='$id'");
        $msg = "Package deleted ";
    }
    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Gym Dashboard | Add Package</title>

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
                                    <h4 class="page-title">Add Package</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Admin</a>
                                        </li>
                                        <li>
                                            <a href="#">Package </a>
                                        </li>
                                        <li class="active">
                                            Add Package
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
                                    <h4 class="m-t-0 header-title"><b>Add Package </b></h4>
                                    <hr />



                                    <div class="row">
                                        <?php include('alert_message.php'); ?>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <form class="form-horizontal" name="category" method="post">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Master</label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="shifttype" id="shifttype" required>
                                                        <option value="">-- Select Type --</option>
                                                        <option value="shift">Shift Type</option>
                                                        <option value="package" selected>Package Type</option>
                                                        <option value="receipt">Receipt Type</option>
                                                        <option value="paymode">Payment Mode</option>
                                                        <option value="medical">Medical History</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <!-- Shift Form -->
                                        <div id="shift-form" class="form-section" style="display:none;">
                                            <form method="post">
                                                <input type="hidden" name="formtype" value="shift">
                                                <div class="form-group">

                                                    <label class="col-md-2 control-label">Shift Type</label>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="shiftname" required>


                                                        <br>
                                                        <button type="submit" class="btn btn-custom" name="submit">Add
                                                            Shift</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>


                                        <!-- Package Form -->
                                        <div id="package-form" class="form-section" style="display:none;">
                                            <form method="post">
                                                <input type="hidden" name="formtype" value="package">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Package Type</label>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="packagename" required>
                                                        <br>
                                                        <button type="submit" class="btn btn-custom" name="submit">Add
                                                            Package</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Receipt Form -->
                                        <div id="receipt-form" class="form-section" style="display:none;">
                                            <form method="post">
                                                <input type="hidden" name="formtype" value="receipt">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Receipt Type</label>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="receiptnumber"
                                                            required>
                                                        <br>
                                                        <button type="submit" class="btn btn-custom" name="submit">Add
                                                            Receipt</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- Payment Mode-->
                                        <div id="paymode-form" class="form-section" style="display:none;">
                                            <form method="post">
                                                <input type="hidden" name="formtype" value="paymode">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Payment Mode</label>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="paymode" required>
                                                        <br>
                                                        <button type="submit" class="btn btn-custom" name="submit">Add
                                                            Paymode</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!--medical history-->
                                        <div id="medical-form" class="form-section" style="display:none;">
                                            <form method="post">
                                                <input type="hidden" name="formtype" value="medical">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Medical History</label>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="medicalname" required>
                                                        <br>
                                                        <button type="submit" class="btn btn-custom" name="submit">Add
                                                            Medical</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <!-- Tabel-->
                    <!-- Tables Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="demo-box m-t-20">

                                <!-- Shift Table -->
                                <div id="shift-table" class="table-section">
                                    <h4>Shift Records</h4>
                                    <div class="table-responsive">
                                        <table class="table m-0 table-colored-bordered table-bordered-primary">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Shift</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($con, "SELECT id, ShiftName FROM tblshift WHERE Is_Active=1");
                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                        <td><?php echo htmlentities($row['ShiftName']); ?></td>
                                                        <td>
                                                            <a
                                                                href="edit-shift.php?cid=<?php echo htmlentities($row['id']); ?>">
                                                                <i class="fa fa-pencil" style="color: #29b6f6;"></i>
                                                            </a>
                                                            &nbsp;
                                                            <a
                                                                href="add-shift.php?rid=<?php echo htmlentities($row['id']); ?>&action=del">
                                                                <i class="fa fa-trash-o" style="color: #f05050"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $cnt++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Package Table -->
                                <div id="package-table" class="table-section" style="display:none;">
                                    <h4>Package Records</h4>
                                    <div class="table-responsive">
                                        <table class="table m-0 table-colored-bordered table-bordered-primary">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Package</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($con, "SELECT id, PackageName FROM tblpackage WHERE Is_Active=1");
                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                        <td><?php echo htmlentities($row['PackageName']); ?></td>
                                                        <td> <a
                                                                href="edit-package.php?cid=<?php echo htmlentities($row['id']); ?>">
                                                                <i class="fa fa-pencil" style="color: #29b6f6;"></i>
                                                            </a>
                                                            &nbsp;
                                                            <a
                                                                href="add-package.php?rid=<?php echo htmlentities($row['id']); ?>&action=del">
                                                                <i class="fa fa-trash-o" style="color: #f05050"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $cnt++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Receipt Table -->
                                <div id="receipt-table" class="table-section" style="display:none;">
                                    <h4>Receipt Records</h4>
                                    <div class="table-responsive">
                                        <table class="table m-0 table-colored-bordered table-bordered-primary">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Receipt Number</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($con, "SELECT id, ReceiptNumber FROM tblreceipt WHERE Is_Active=1");
                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                        <td><?php echo htmlentities($row['ReceiptNumber']); ?></td>
                                                        <td> <a
                                                                href="edit-shift.php?cid=<?php echo htmlentities($row['id']); ?>">
                                                                <i class="fa fa-pencil" style="color: #29b6f6;"></i>
                                                            </a>
                                                            &nbsp;
                                                            <a
                                                                href="add-shift.php?rid=<?php echo htmlentities($row['id']); ?>&action=del">
                                                                <i class="fa fa-trash-o" style="color: #f05050"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $cnt++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- payment Table-->
                                <div id="paymode-table" class="table-section" style="display:none;">
                                    <h4>Payment Modes</h4>
                                    <div class="table-responsive">
                                        <table class="table m-0 table-colored-bordered table-bordered-primary">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Payment Modes</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($con, "SELECT id, PaymentMode FROM tblpaymode WHERE Is_Active=1");
                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                        <td><?php echo htmlentities($row['PaymentMode']); ?></td>
                                                        <td> <a
                                                                href="edit-shift.php?cid=<?php echo htmlentities($row['id']); ?>">
                                                                <i class="fa fa-pencil" style="color: #29b6f6;"></i>
                                                            </a>
                                                            &nbsp;
                                                            <a
                                                                href="add-shift.php?rid=<?php echo htmlentities($row['id']); ?>&action=del">
                                                                <i class="fa fa-trash-o" style="color: #f05050"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $cnt++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Medical History-->
                                <div id="medical-table" class="table-section" style="display:none;">
                                    <h4>Medical Records</h4>
                                    <div class="table-responsive">
                                        <table class="table m-0 table-colored-bordered table-bordered-primary">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Medical Records</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($con, "SELECT id, MedicalRecord FROM tblmedical WHERE Is_Active=1");
                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                        <td><?php echo htmlentities($row['MedicalRecord']); ?></td>
                                                        <td> <a
                                                                href="edit-shift.php?cid=<?php echo htmlentities($row['id']); ?>">
                                                                <i class="fa fa-pencil" style="color: #29b6f6;"></i>
                                                            </a>
                                                            &nbsp;
                                                            <a
                                                                href="add-shift.php?rid=<?php echo htmlentities($row['id']); ?>&action=del">
                                                                <i class="fa fa-trash-o" style="color: #f05050"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $cnt++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>





                </div> <!-- container -->

            </div> <!-- content -->

            <?php include('includes/footer.php'); ?>

        </div>
        </div>

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
        <script>
            // Function to toggle form visibility
            function showForm(value) {
                document.querySelectorAll('.form-section').forEach(el => el.style.display = 'none');
                if (value === 'shift') {
                    document.getElementById('shift-form').style.display = 'block';
                } else if (value === 'package') {
                    document.getElementById('package-form').style.display = 'block';
                } else if (value === 'receipt') {
                    document.getElementById('receipt-form').style.display = 'block';
                } else if (value === 'paymode') {
                    document.getElementById('paymode-form').style.display = 'block';
                } else if (value === 'medical') {
                    document.getElementById('medical-form').style.display = 'block';
                }
            }

            // Run on dropdown change
            document.getElementById('shifttype').addEventListener('change', function () {
                showForm(this.value);
            });

            // Run on page load to show default selected form
            window.addEventListener('DOMContentLoaded', function () {
                const defaultValue = document.getElementById('shifttype').value;
                showForm(defaultValue);
            });
            function showTable(value) {
                document.querySelectorAll('.table-section').forEach(el => el.style.display = 'none');
                if (value === 'shift') {
                    document.getElementById('shift-table').style.display = 'block';
                } else if (value === 'package') {
                    document.getElementById('package-table').style.display = 'block';
                } else if (value === 'receipt') {
                    document.getElementById('receipt-table').style.display = 'block';
                } else if (value === 'paymode') {
                    document.getElementById('paymode-table').style.display = 'block';
                } else if (value === 'medical') {
                    document.getElementById('medical-table').style.display = 'block';
                }
            }

            document.getElementById('shifttype').addEventListener('change', function () {
                const value = this.value;
                showForm(value);
                showTable(value);
            });

            window.addEventListener('DOMContentLoaded', function () {
                const defaultValue = document.getElementById('shifttype').value;
                showForm(defaultValue);
                showTable(defaultValue);
            });

        </script>


    </body>

    </html>
<?php } ?>
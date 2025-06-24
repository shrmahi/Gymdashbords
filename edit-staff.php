<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $catid = intval($_GET['cid']);
        $type = $_POST['type'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $joinningdate = $_POST['joinningdate'];
        $staffstatus = $_POST['staffstatus'];
        $query = mysqli_query($con, "Update  tblstaff set Type='$type',FirstName='$fname', LastName='$lname',Email='$email',Password='$password',Contact='$contact', Address='$address',JoinningDate='$joinningdate',StaffStatus='$staffstatus'  where id='$catid'");
        if ($query) {
            $msg = "Staff/Trainer Updated successfully ";
        } else {
            $error = "Something went wrong . Please try again.";
        }
    }


    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Gym Dashboard | Add Staff</title>

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
                                    <h4 class="page-title">Edit Staff</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Admin</a>
                                        </li>
                                        <li>
                                            <a href="#">Staff </a>
                                        </li>
                                        <li class="active">
                                            Edit Staff
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
                                    <h4 class="m-t-0 header-title"><b>Edit Staff </b></h4>
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
                                $query = mysqli_query($con, "Select id,Type, FirstName, LastName, Email,Password, Contact, Address, JoinningDate,StaffStatus from  tblstaff where Is_Active=1 and id='$catid'");
                                $cnt = 1;
                                while ($row = mysqli_fetch_array($query)) {
                                    ?>



                                <div class="row">
                                    <div class="col-md-6">
                                        <form class="form-horizontal" name="category" method="post">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Type</label>
                                                <div class="col-md-10">
                                                    <select class="form-control" name="type" id="type" required>
                                                        <option>
                                                            <?php echo htmlentities($row['Type']); ?>
                                                        </option>
                                                        <option value="Staff">Staff</option>
                                                        <option value="Trainer">Trainer</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">First Name</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control"
                                                        value="<?php echo htmlentities($row['FirstName']); ?>"
                                                        name="fname" placeholder="Enter First Name" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control"
                                                        value="<?php echo htmlentities($row['LastName']); ?>"
                                                        name="lname" placeholder="Enter Last Name" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Email Id</label>
                                                <div class="col-md-10">
                                                    <input type="email" class="form-control"
                                                        value="<?php echo htmlentities($row['Email']); ?>" name="email"
                                                        placeholder="Enter Email" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Password</label>
                                                <div class="col-md-10">
                                                    <input type="password" class="form-control"
                                                        value="<?php echo htmlentities($row['Password']); ?>"
                                                        name="password" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Contact</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control"
                                                        value="<?php echo htmlentities($row['Contact']); ?>"
                                                        name="contact" placeholder="Enter Contact Number" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Address</label>
                                                <div class="col-md-10">
                                                    <textarea class="form-control" rows="2" name="address"
                                                        placeholder="Address"
                                                        required><?php echo htmlentities($row['Address']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Joinnig Date</label>
                                                <div class="col-md-10">
                                                    <input type="date" class="form-control"
                                                        value="<?php echo htmlentities($row['JoinningDate']); ?>"
                                                        name="joinningdate" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Status</label>
                                                <div class="col-md-10">
                                                    <select class="form-control" name="staffstatus" id="staffstatus"
                                                        required>
                                                        <option>
                                                            <?php echo htmlentities($row['StaffStatus']); ?>
                                                        </option>
                                                        <option value="Active">Active</option>
                                                        <option value="In Active">In Active</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <?php } ?>
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
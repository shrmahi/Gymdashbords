<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    // Generate random password
    function generateRandomPassword($length = 10)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$!%&*';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $password;
    }

    $generatedPassword = generateRandomPassword();

    if (isset($_POST['submit'])) {
        $type = $_POST['type'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $joinningdate = $_POST['joinningdate'];
        $staffstatus = $_POST['staffstatus'];
        $status = 1;

        // Use generated password
        $password = $generatedPassword; // Consider using password_hash for better security

        $query = mysqli_query($con, "INSERT INTO tblstaff(`Type`, `FirstName`, `LastName`, `Email`, `Password`, `Contact`, `Address`, `JoinningDate`, `StaffStatus`, `Is_Active`) 
        VALUES('$type','$fname','$lname','$email','$password','$contact','$address','$joinningdate','$staffstatus','$status')");

        if ($query) {
            // Email Details
            $subject = "Welcome to Gym - Your Login Credentials";
            $message = "Hi $fname $lname,\n\n" .
                "Welcome to the Gym.\n\n" .
                "Your login credentials are:\n" .
                "Username: $email\n" .
                "Password: $generatedPassword\n\n" .
                "Please change your password after first login.\n\n" .
                "Regards,\nGym Management";
            $headers = "From: noreply@gymdomain.com";

            // Send email
            mail($email, $subject, $message, $headers);

            echo "<script>
                alert('Staff added successfully and credentials sent to email.');
                window.location.href = 'manage-stafflist.php';
            </script>";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- App title -->
        <title>Gym Dashboard | Add Staff</title>

        <!-- Summernote css -->
        <link href="../plugins/summernote/summernote.css" rel="stylesheet" />

        <!-- Select2 -->
        <link href="../plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

        <!-- Jquery filer css -->
        <link href="../plugins/jquery.filer/css/jquery.filer.css" rel="stylesheet" />
        <link href="../plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet" />

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
            <!-- ========== Left Sidebar Start ========== -->
            <?php include('includes/leftsidebar.php'); ?>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">


                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Add Staff </h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Staff</a>
                                        </li>
                                        <li>
                                            <a href="#">Add Staff </a>
                                        </li>
                                        <li class="active">
                                            Add Staff
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

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


                    <div class="row">
                        <div class="col-md-10">
                            <form class="form-horizontal" method="post">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Type</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="type" required>
                                            <option value="Staff">Staff</option>
                                            <option value="Trainer">Trainer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">First Name</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="fname"
                                            placeholder="Enter First Name" required>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="lname"
                                            placeholder="Enter Last Name" required>
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
                                    <label class="col-md-2 control-label">Password</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="password"
                                            value="<?php echo $generatedPassword; ?>" readonly>
                                        <small class="text-muted">This password is auto-generated.</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Contact</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="contact"
                                            placeholder="Enter Contact Number" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Address</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" rows="2" name="address" placeholder="Address"
                                            required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Joining Date</label>
                                    <div class="col-md-10">
                                        <input type="date" class="form-control" name="joinningdate" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Status</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="staffstatus" required>
                                            <option value="Active">Active</option>
                                            <option value="In Active">In Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label"></label>
                                    <div class="col-md-10">
                                        <button type="submit" class="btn btn-custom" name="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end row -->



                    </div> <!-- container -->

                </div> <!-- content -->

                <?php include('includes/footer.php'); ?>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


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

        <!--Summernote js-->
        <script src="../plugins/summernote/summernote.min.js"></script>
        <!-- Select 2 -->
        <script src="../plugins/select2/js/select2.min.js"></script>
        <!-- Jquery filer js -->
        <script src="../plugins/jquery.filer/js/jquery.filer.min.js"></script>

        <!-- page specific js -->
        <script src="assets/pages/jquery.blog-add.init.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

        <script>

            jQuery(document).ready(function () {

                $('.summernote').summernote({
                    height: 240,                 // set editor height
                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor
                    focus: false                 // set focus to editable area after initializing summernote
                });
                // Select2
                $(".select2").select2();

                $(".select2-limiting").select2({
                    maximumSelectionLength: 2
                });
            });
        </script>
        <script src="../plugins/switchery/switchery.min.js"></script>

        <!--Summernote js-->
        <script src="../plugins/summernote/summernote.min.js"></script>




    </body>

    </html>
<?php } ?>
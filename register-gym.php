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

    // For register gym
    if (isset($_POST['submit'])) {
        $gymname = $_POST['gymname'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $mnumber = $_POST['mnumber'];
        $relation = $_POST['relation'];
        $status = 1;
        $password = $generatedPassword;


        $query = mysqli_query($con, "insert into tblgym(GymName,Firstname,LastName,Email,MobileNumber,Relation,Password,Is_Active) values('$gymname','$fname','$lname','$email','$mnumber','$relation','$password','$status')");
        if ($query) {
            $msg = "Gym Register ";
        } else {
            $error = "Something went wrong . Please try again.";
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
        <title>Gym Dashboard | Register Gym</title>

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
                                    <h4 class="page-title">Register Gym </h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Register Gym</a>
                                        </li>
                                        <li>
                                            <a href="#">Register Gym </a>
                                        </li>
                                        <li class="active">
                                            Register Gym
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
                            <div class="alert-container">
                                <?php if ($msg) { ?>
                                <div class="alert alert-success alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Well done!</strong>
                                    <?php echo htmlentities($msg); ?>
                                </div>
                                <?php } ?>

                                <?php if ($error) { ?>
                                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Oh snap!</strong>
                                    <?php echo htmlentities($error); ?>
                                </div>
                                <?php } ?>
                            </div>


                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-8">
                            <form class="form-horizontal" method="post">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">
                                        Gym Name
                                    </label>
                                    <div class="col-md-10">
                                        <input type="text" name="gymname" class="form-control"
                                            placeholder="Enter Gym Name" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">
                                        Name
                                    </label>
                                    <div class="col-md-5">
                                        <input type="text" name="fname" class="form-control"
                                            placeholder="Enter First Name" required />
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="lname" class="form-control"
                                            placeholder="Enter Last Name" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">
                                        Email
                                    </label>
                                    <div class="col-md-10">
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email"
                                            required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">
                                        Mobile Number
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" name="mnumber" class="form-control"
                                            placeholder="Enter Mobile Number" required />
                                    </div>
                                    <label class="col-md-2 control-label">
                                        Relation with Gym
                                    </label>
                                    <div class="col-md-4">
                                        <select class="form-control" name="relation" required>
                                            <option value="">-- Select Relation --</option>
                                            <option value="Owner">Owner</option>
                                            <option value="Maneger">Maneger</option>
                                            <option value="Trainer">Trainer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">
                                        Password
                                    </label>
                                    <div class="col-md-10">
                                        <input type="text" value="<?php echo $generatedPassword; ?>" name="password"
                                            class="form-control" readonly />
                                        <small class="text-muted">This password is auto-generated.</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Branch ID (Leave blank or type 'any' for any
                                        branch)</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="branch_id"
                                            placeholder="Enter Branch ID">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label"></label>
                                    <div class="col-md-10">
                                        <button class="btn btn-custom" name="submit" type="submit">Register</button>

                                    </div>
                                </div>
                            </form>
                        </div> <!-- end col -->
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
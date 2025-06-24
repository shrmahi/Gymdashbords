<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['submit'])) {
        $pkgtype = $_POST['pkgtype'];
        $duration = $_POST['duration'];
        $days = $_POST['days'];
        $price = $_POST['price'];
        $status = 1;
        $query = mysqli_query($con, "insert into tblplan(`PlanName`, `Duration`, `Days`, `Price`,`Is_Active`) values('$pkgtype','$duration','$days','$price','$status')");
        if ($query) {
            // $msg = "Plan added ";
            header("Location: manage-plan.php");
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
        <title>Gym Dashboard | Add Plan</title>

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
                                    <h4 class="page-title">Add Plan </h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Plan</a>
                                        </li>
                                        <li>
                                            <a href="#">Add Plan </a>
                                        </li>
                                        <li class="active">
                                            Add Plan
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
                        <div class="col-md-10 col-md-offset-1">
                            <div class="p-6">
                                <div class="">
                                    <form name="addpost" method="post" enctype="multipart/form-data">
                                        <div class="form-group m-b-20">
                                            <label for="exampleInputEmail1">Package Type</label>
                                            <input type="text" class="form-control" id="pkgtype" name="pkgtype"
                                                placeholder="Package Type Name" required>
                                        </div>
                                        <div class=" col-md-6 form-group m-b-20">
                                            <label for="exampleInputEmail1">Duration</label>
                                            <select class="form-control" name="duration" id="duration" required>
                                                <option value="">0 Month</option>
                                                <option value="1 Month">1 Month</option>
                                                <option value="3 Month">3 Month</option>
                                                <option value="6 Month">6 Month</option>
                                                <option value="1 Year">1 Year</option>
                                                <option value="2 Year">2 Year</option>
                                                <option value="3 Year">3 Year</option>
                                            </select>
                                        </div>

                                        <div class=" col-md-6 form-group m-b-20">
                                            <label for="exampleInputEmail1">Days</label>
                                            <select class="form-control" name="days" id="days"
                                                onChange="getSubCat(this.value);" required>
                                                <option value="">Select Days </option>
                                                <option value="1 Day">1 Day</option>
                                                <option value="2 Day">2 Day</option>
                                                <option value="3 Day">3 Day</option>
                                                <option value="4 Day">4 Day</option>
                                                <option value="5 Day">5 Day</option>
                                                <option value="6 Day">6 Day</option>
                                                <option value="7 Day">7 Day</option>
                                                <option value="8 Day">8 Day</option>
                                                <option value="9 Day">9 Day</option>
                                                <option value="10 Day">10 Day</option>
                                                <option value="11 Day">11 Day</option>
                                                <option value="12 Day">12 Day</option>
                                                <option value="13 Day">13 Day</option>
                                                <option value="14 Day">14 Day</option>
                                                <option value="15 Day">15 Day</option>
                                                <option value="16 Day">16 Day</option>
                                                <option value="17 Day">17 Day</option>
                                                <option value="18 Day">18 Day</option>
                                                <option value="19 Day">19 Day</option>
                                                <option value="20 Day">20 Day</option>
                                                <option value="21 Day">21 Day</option>
                                                <option value="22 Day">22 Day</option>
                                                <option value="23 Day">23 Day</option>
                                                <option value="24 Day">24 Day</option>
                                                <option value="25 Day">25 Day</option>
                                                <option value="26 Day">26 Day</option>
                                                <option value="27 Day">27 Day</option>
                                                <option value="28 Day">28 Day</option>
                                                <option value="29 Day">29 Day</option>
                                                <option value="30 Day">30 Day</option>
                                                <option value="31 Day">31 Day</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-b-20">
                                            <label for="exampleInputEmail1">Package Price</label>
                                            <input type="text" class="form-control" id="price" name="price"
                                                placeholder="Package Price" required>
                                        </div>

                                        <button type="submit" name="submit"
                                            class="btn btn-success waves-effect waves-light">Save and Post</button>
                                        <button type="button"
                                            class="btn btn-danger waves-effect waves-light">Discard</button>
                                    </form>
                                </div>
                            </div> <!-- end p-20 -->
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
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
            $msg = "Plan successfully added.";
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
                            <?php include('alert_message.php'); ?>


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
                                                onchange="getSubCat(this.value);" required>
                                                <option value="">Select Days</option>
                                            </select>
                                        </div>
                                        <div class="form-group m-b-20">
                                            <label for="exampleInputEmail1">Package Price</label>
                                            <input type="text" class="form-control" id="price" name="price"
                                                placeholder="Package Price" required>
                                        </div>

                                        <button type="submit" name="submit"
                                            class="btn btn-success waves-effect waves-light">Save</button>


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



        <script>
            // Populate the "Days" dropdown with options 0 to 31
            const daysDropdown = document.getElementById("days");

            for (let i = 0; i <= 31; i++) {
                const option = document.createElement("option");
                option.value = i + " Day";
                option.textContent = i + (i === 1 ? " Day" : " Days");
                daysDropdown.appendChild(option);
            }
        </script>
    </body>


    </html>
<?php } ?>
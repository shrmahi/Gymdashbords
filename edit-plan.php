<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $catid = intval($_GET['cid']);
        $pkgtype = $_POST['pkgtype'];
        $duration = $_POST['duration'];
        $days = $_POST['days'];
        $price = $_POST['price'];
        $query = mysqli_query($con, "Update  tblplan set PlanName='$pkgtype',Duration='$duration',Price='$price' where id='$catid'");
        if ($query) {
            echo "<script>
            alert('Plan edited successfully');
            window.location.href = 'manage-plan.php';
            </script>";
        } else {
            $error = "Something went wrong . Please try again.";
        }
    }


    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Gym Dashboard | Add Plan</title>

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
                                    <h4 class="page-title">Edit Plan</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Admin</a>
                                        </li>
                                        <li>
                                            <a href="#">Plan </a>
                                        </li>
                                        <li class="active">
                                            Edit Plan
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
                                    <h4 class="m-t-0 header-title"><b>Edit Plan </b></h4>
                                    <hr />



                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!---Success Message--->
                                        <div class="alert-container">
                                            <?php if ($msg) { ?>
                                            <div class="alert alert-success alert-dismissible fade in" role="alert">
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <strong>Well done!</strong>
                                                <?php echo htmlentities($msg); ?>
                                            </div>
                                            <?php } ?>

                                            <?php if ($error) { ?>
                                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <strong>Oh snap!</strong>
                                                <?php echo htmlentities($error); ?>
                                            </div>
                                            <?php } ?>
                                        </div>


                                    </div>
                                </div>

                                <?php
                                $catid = intval($_GET['cid']);
                                $query = mysqli_query($con, "Select id,PlanName,Duration,Price,Days from  tblplan where Is_Active=1 and id='$catid'");
                                $cnt = 1;
                                while ($row = mysqli_fetch_array($query)) {
                                    ?>



                                <div class="row">
                                    <div class="col-md-6">
                                        <form class="form-horizontal" name="category" method="post">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Plan</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control"
                                                        value="<?php echo htmlentities($row['PlanName']); ?>"
                                                        name="pkgtype" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Duration</label>
                                                <div class="col-md-5">
                                                    <select class="form-control" name="duration" id="duration" required>
                                                        <option value="">
                                                            <?php echo htmlentities($row['Duration']); ?>
                                                        </option>
                                                        <option value="1 Month">1 Month</option>
                                                        <option value="3 Month">3 Month</option>
                                                        <option value="6 Month">6 Month</option>
                                                        <option value="1 Year">1 Year</option>
                                                        <option value="2 Year">2 Year</option>
                                                        <option value="3 Year">3 Year</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-5">
                                                    <select class="form-control" name="days" id="days"
                                                        onChange="getSubCat(this.value);" required>
                                                        <option value="">
                                                            <?php echo htmlentities($row['Days']); ?>
                                                        </option>
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

                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Price</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control"
                                                        value="<?php echo htmlentities($row['Price']); ?>" name="price"
                                                        required>
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
<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $catid = intval($_GET['cid']);
        $medicalname = $_POST['medicalname'];
        $query = mysqli_query($con, "Update  tblmedical set MedicalRecord='$medicalname' where id='$catid'");
        if ($query) {
            $msg = "Medical Name Added ";
        } else {
            $error = "Something went wrong . Please try again.";
        }
    }
    if ($_GET['action'] == 'del' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        $query = mysqli_query($con, "update tblmedical set Is_Active='0' where id='$id'");
        $msg = "Medical Name deleted ";
    }


    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Gym Dashboard | Add Medical Records</title>

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
                                    <h4 class="page-title">Edit Medical Records</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Admin</a>
                                        </li>
                                        <li>
                                            <a href="#">Medical Records </a>
                                        </li>
                                        <li class="active">
                                            Edit Medical Records
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
                                    <h4 class="m-t-0 header-title"><b>Edit Medical Records </b></h4>
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
                                $query = mysqli_query($con, "Select id,MedicalRecord from  tblmedical where Is_Active=1 and id='$catid'");
                                $cnt = 1;
                                while ($row = mysqli_fetch_array($query)) {
                                    ?>



                                <div class="row">
                                    <div class="col-md-6">
                                        <form class="form-horizontal" name="category" method="post">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Services</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control"
                                                        value="<?php echo htmlentities($row['MedicalRecord']); ?>"
                                                        name="medicalname" required>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="demo-box m-t-20">

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
                                                $query = mysqli_query($con, "Select id,MedicalRecord from  tblmedical where Is_Active=1");
                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($query)) {
                                                    ?>

                                                    <tr>
                                                        <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                        <td><?php echo htmlentities($row['MedicalRecord']); ?></td>
                                                        <td><a
                                                                href="edit-shift.php?cid=<?php echo htmlentities($row['id']); ?>"><i
                                                                    class="fa fa-pencil" style="color: #29b6f6;"></i></a>
                                                            &nbsp;<a
                                                                href="edit-shift.php?rid=<?php echo htmlentities($row['id']); ?>&&action=del">
                                                                <i class="fa fa-trash-o" style="color: #f05050"></i></a> </td>
                                                    </tr>
                                                    <?php
                                                    $cnt++;
                                                } ?>
                                            </tbody>

                                        </table>
                                    </div>




                                </div>

                            </div>


                        </div>

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
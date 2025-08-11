<?php
session_start();
include('includes/config.php');

// Prevent back button access after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

if (!isset($_SESSION['login']) || strlen($_SESSION['login']) == 0) {
    header('Location: index.php');
    exit();
}
$userEmail = $_SESSION['login'];
$query = mysqli_query($con, "SELECT FirstName FROM tblstaff WHERE Email='$userEmail' LIMIT 1");

if ($row = mysqli_fetch_assoc($query)) {
    $_SESSION['username'] = $row['FirstName']; // Store name in session
} else {
    $_SESSION['username'] = 'User'; // Fallback name
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Gym Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
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

        <!-- Top Bar -->
        <div class="topbar">
            <div class="topbar-left">
                <a href="index.html" class="logo"><span>NP<span>Admin</span></span><i class="mdi mdi-layers"></i></a>
            </div>
            <?php include('includes/topheader.php'); ?>
        </div>

        <!-- Sidebar -->
        <?php include('includes/leftsidebar.php'); ?>

        <!-- Content -->
        <div class="content-page">
            <div class="content">
                <div class="container">

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Dashboard</h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li><a href="#">Gym Dashboard</a></li>
                                    <li><a href="#">Admin</a></li>
                                    <li class="active">Gym Dashboard</li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Dashboard Widgets -->
                    <div class="row">
                        <a href="manage-stafflist.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <i class="mdi mdi-account-outline widget-one-icon icon-success"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow text-black">
                                            Total Staff</p>
                                        <?php
                                        $query = mysqli_query($con, "select * from tblstaff where Is_Active=1");
                                        $countcat = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-black"><?php echo htmlentities($countcat); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="manage-memberlist.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <i class="mdi mdi-account widget-one-icon icon-danger"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow text-black">
                                            Total Members</p>
                                        <?php
                                        $query = mysqli_query($con, "select * from tblmember");
                                        $countsubcat = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-black"><?php echo htmlentities($countsubcat); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="active-member.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <i class="mdi mdi-account widget-one-icon icon-info"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow text-black">
                                            Active Members</p>
                                        <?php
                                        $query = mysqli_query($con, "select * from tblmember where Is_Active=1");
                                        $countsubcat = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-black"><?php echo htmlentities($countsubcat); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </a>


                    </div>
                    <div class="row">
                        <a href="manage-memberlist.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <i class="mdi mdi-cake widget-one-icon icon-pink"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow text-black">
                                            Recent Birthday</p>
                                        <p></p>
                                        <?php
                                        $query = mysqli_query($con, "select * from tblmember where Is_Active=1 AND DATE_FORMAT(dob, '%m-%d') = DATE_FORMAT(CURDATE(), '%m-%d')");
                                        $countsubcat = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-black"><?php echo htmlentities($countsubcat); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="manage-enquiry.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one">
                                    <i class="mdi mdi-layers widget-one-icon icon-warning "></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow text-black">
                                            New Leads
                                        </p>
                                        <?php
                                        $query = mysqli_query($con, "select * from tblenquiry where Is_Active=1");
                                        $countposts = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-black"><?php echo htmlentities($countposts); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <?php include('includes/footer.php'); ?>
        </div>

    </div>

    <!-- JS Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="../plugins/switchery/switchery.min.js"></script>
    <script src="../plugins/waypoints/jquery.waypoints.min.js"></script>
    <script src="../plugins/counterup/jquery.counterup.min.js"></script>
    <script src="../plugins/morris/morris.min.js"></script>
    <script src="../plugins/raphael/raphael-min.js"></script>
    <script src="assets/pages/jquery.dashboard.js"></script>
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>

    <!-- Logout on browser back button -->
    <script>
        // Prevent going back to this page after logout
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            // When user presses back, send them to login page or prevent back
            location.replace("logout.php");
        };
    </script>

</body>

</html>
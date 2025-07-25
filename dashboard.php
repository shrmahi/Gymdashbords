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
                        <a href="manage-staff.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one" style="background-color:#ef7674;">
                                    <i class="mdi mdi-account-outline widget-one-icon"></i>
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
                                <div class="card-box widget-box-one" style="background-color:#ef7674;">
                                    <i class="mdi mdi-account widget-one-icon"></i>
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
                        <a href="inactive-member.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one" style="background-color:#ef7674;">
                                    <i class="mdi mdi-account widget-one-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow text-black">
                                            Inactive Members</p>
                                        <?php
                                        $query = mysqli_query($con, "select * from tblmember where Is_Active=0");
                                        $countsubcat = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-black"><?php echo htmlentities($countsubcat); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </a>


                    </div>
                    <div class="row">

                        <a href="active-member.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one" style="background-color:#ef7674;">
                                    <i class="mdi mdi-account widget-one-icon"></i>
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
                        <a href="manage-plan.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one" style="background-color:#ef7674;">
                                    <i class="mdi mdi-layers widget-one-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow text-black">
                                            Package Type
                                        </p>
                                        <?php
                                        $query = mysqli_query($con, "select * from tblplan where Is_Active=1");
                                        $countposts = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-black"><?php echo htmlentities($countposts); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="manage-memberlist.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one" style="background-color:#ef7674;">
                                    <i class="mdi mdi-account widget-one-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow text-black">
                                            Recent Birthdate</p>
                                        <?php
                                        $query = mysqli_query($con, "select * from tblmember where Is_Active=1 AND DATE_FORMAT(dob, '%m-%d') = DATE_FORMAT(CURDATE(), '%m-%d')");
                                        $countsubcat = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-black"><?php echo htmlentities($countsubcat); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </a>


                    </div>

                    <div class="row">
                        <a href="manage-enquiry.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one" style="background-color:#ef7674;">
                                    <i class="mdi mdi-layers widget-one-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow text-black">
                                            Enquirys
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


                        <a href="register-gymlist.php">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card-box widget-box-one" style="background-color:#ef7674;">
                                    <i class="mdi mdi-dumbbell widget-one-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow text-black">
                                            Register Gym</p>
                                        <?php
                                        $query = mysqli_query($con, "select * from tblgym where Is_Active=1");
                                        $countsubcat = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-black"><?php echo htmlentities($countsubcat); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="demo-box m-t-20" style="border:2px solid #ced4da">
                                <div class="m-b-30">

                                    <h5 style="color:black"><i class="fa fa-users"></i>
                                        Members
                                        about to
                                        expire
                                        membership</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-colored-bordered table-bordered-primary">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Member Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Payment Mode</th>
                                                <th>Join Date</th>
                                                <th>Package Expire</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($con, "
                                            SELECT id, FirstName, LastName, Email, Mobile, AlterNumber, PaymentMode, JoinDate, ExpiryDate, Is_Active 
                                            FROM tblmember 
                                           WHERE ExpiryDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
                                        ");

                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                    <td><?php echo htmlentities($row['FirstName'] . ' ' . $row['LastName']); ?>
                                                    </td>
                                                    <td><?php echo htmlentities($row['Email']); ?></td>
                                                    <td><?php echo htmlentities($row['Mobile']); ?><br><?php echo htmlentities($row['AlterNumber']); ?>
                                                    </td>
                                                    <td><?php echo htmlentities($row['PaymentMode']); ?></td>
                                                    <td><?php echo htmlentities($row['JoinDate']); ?></td>
                                                    <td><?php echo htmlentities($row['ExpiryDate']); ?></td>
                                                    <td>
                                                        <?php if ($row['Is_Active'] == 1): ?>
                                                            <span class="label label-success">Active</span>
                                                        <?php else: ?>
                                                            <span class="label label-danger">Inactive</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="edit-member.php?cid=<?php echo htmlentities($row['id']); ?>"
                                                            title="Edit">
                                                            <i class="fa fa-pencil" style="color:#29b6f6;"></i>
                                                        </a>
                                                        <a href="member.php?cid=<?php echo htmlentities($row['id']); ?>"
                                                            title="View">
                                                            <i class="fa fa-eye" style="color:#29b6f6;"></i>
                                                        </a>
                                                        <?php if ($row['Is_Active'] == 1): ?>
                                                            <a href="manage-memberlist.php?disid=<?php echo htmlentities($row['id']); ?>"
                                                                onclick="return confirm('Deactivate this member?');"
                                                                title="Deactivate">
                                                                <i class="fa fa-toggle-off" style="color:red;"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <a href="manage-memberlist.php?appid=<?php echo htmlentities($row['id']); ?>"
                                                                onclick="return confirm('Activate this member?');"
                                                                title="Activate">
                                                                <i class="fa fa-toggle-on" style="color:green;"></i>
                                                            </a>
                                                            <a href="manage-memberlist.php?rid=<?php echo htmlentities($row['id']); ?>&action=parmdel"
                                                                onclick="return confirm('Delete permanently?');"
                                                                title="Delete Forever">
                                                                <i class="fa fa-trash" style="color:#f05050;"></i>
                                                            </a>
                                                        <?php endif; ?>
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
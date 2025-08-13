<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
} else {
    if (isset($_GET['action']) && $_GET['action'] == 'del' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        mysqli_query($con, "UPDATE tblmember SET Is_Active = 0 WHERE id = '$id'");
        $msg = "Member deactivated";
    }

    if (isset($_GET['appid'])) {
        $id = intval($_GET['appid']);
        mysqli_query($con, "UPDATE tblmember SET Is_Active = 1 WHERE id = $id");
        $msg = "Member activated";
    }

    if (isset($_GET['disid'])) {
        $id = intval($_GET['disid']);
        mysqli_query($con, "UPDATE tblmember SET Is_Active = 0 WHERE id = $id");
        $msg = "Member deactivated";
    }

    if (isset($_GET['resid'])) {
        $id = intval($_GET['resid']);
        mysqli_query($con, "UPDATE tblmember SET Is_Active = 1 WHERE id = '$id'");
        $msg = "Member restored successfully";
    }

    if (isset($_GET['action']) && $_GET['action'] == 'parmdel' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        mysqli_query($con, "DELETE FROM tblmember WHERE id = '$id'");
        $delmsg = "Member deleted forever";
    }

    // $whereClause = "";
    // if (!empty($_GET['month'])) {
    //     $month = mysqli_real_escape_string($con, $_GET['month']);
    //     $whereClause = "WHERE DATE_FORMAT(JoinDate, '%Y-%m') = '$month'";
    // }

    // Pagination setup
    $limit = 5; // records per page
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    // Month filter condition
    $whereClause = "";
    if (!empty($_GET['month'])) {
        $month = $_GET['month'];
        $whereClause = "WHERE DATE_FORMAT(JoinDate, '%Y-%m') = '" . mysqli_real_escape_string($con, $month) . "'";
    }

    // Count total records
    $totalQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM tblmember $whereClause");
    $totalData = mysqli_fetch_assoc($totalQuery);
    $totalRecords = $totalData['total'];
    $totalPages = ceil($totalRecords / $limit);

    // Fetch paginated records
    $query = mysqli_query($con, "SELECT id, FirstName, LastName, Email, Mobile, AlterNumber, PaymentMode, JoinDate, ExpiryDate, Is_Active FROM tblmember $whereClause ORDER BY id DESC LIMIT $limit OFFSET $offset");


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Gym Dashboard | Manage Member</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="assets/css/core.css" rel="stylesheet" />
        <link href="assets/css/components.css" rel="stylesheet" />
        <link href="assets/css/icons.css" rel="stylesheet" />
        <link href="assets/css/pages.css" rel="stylesheet" />
        <link href="assets/css/menu.css" rel="stylesheet" />
        <link href="assets/css/responsive.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <script src="assets/js/modernizr.min.js"></script>
    </head>

    <body class="fixed-left">
        <div id="wrapper">
            <?php include('includes/topheader.php'); ?>
            <?php include('includes/leftsidebar.php'); ?>

            <div class="content-page">
                <div class="content">
                    <div class="container">

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Manage Member</h4>
                                    <!-- <ol class="breadcrumb p-0 m-0">
                                        <li><a href="#">Admin</a></li>
                                        <li><a href="#">Member</a></li>
                                        <li class="active">Manage Member</li>
                                    </ol> -->
                                    <a href="add-member.php" class="btn btn-success">
                                        <i class="mdi mdi-plus"></i> Add Member
                                    </a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
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
                            <div class="col-md-12">
                                <div class="demo-box m-t-20">

                                    <br />

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php include('includes/footer.php'); ?>
            </div>
        </div>

        <script>
            function changeLimit(value) {
                const url = new URL(window.location.href);
                url.searchParams.set('limit', value);
                url.searchParams.set('page', 1); // reset to page 1
                window.location.href = url.toString();
            }
        </script>


        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <script src="assets/js/tooltip.js"></script>
    </body>

    </html>
<?php } ?>
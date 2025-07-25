<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
} else {
    // Deactivate
    if (isset($_GET['action']) && $_GET['action'] == 'del' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        mysqli_query($con, "UPDATE tblstaff SET Is_Active = '0' WHERE id = '$id'");
        $msg = "Staff deactivated";
    }

    // Activate
    if (isset($_GET['resid'])) {
        $id = intval($_GET['resid']);
        mysqli_query($con, "UPDATE tblstaff SET Is_Active = '1' WHERE id = '$id'");
        $msg = "Staff activated";
    }

    // Permanent delete
    if (isset($_GET['action']) && $_GET['action'] == 'parmdel' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        mysqli_query($con, "DELETE FROM tblstaff WHERE id = '$id'");
        $msg = "Staff deleted permanently";
    }

    // Filter condition
    $whereClause = "";
    if (!empty($_GET['month'])) {
        $month = mysqli_real_escape_string($con, $_GET['month']);
        $whereClause = "WHERE DATE_FORMAT(JoinningDate, '%Y-%m') = '$month'";
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Gym Dashboard | Manage Staff</title>
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
                                    <h4 class="page-title">Manage Staff</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li><a href="#">Admin</a></li>
                                        <li><a href="#">Staff</a></li>
                                        <li class="active">Manage Staff</li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <?php include('alert_message.php'); ?>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <form method="GET" class="form-inline" style="margin-bottom:20px;">
                                    <label>Filter by Month: </label>
                                    <input type="month" name="month" class="form-control"
                                        value="<?php echo htmlentities($_GET['month']); ?>">
                                    <button type="submit" class="btn btn-filter">Filter</button>
                                    <a href="manage-stafflist.php" class="btn btn-reset" style="color:white">Reset</a>
                                    <a href="download-staff-pdf.php<?php echo (!empty($_GET['month'])) ? '?month=' . urlencode($_GET['month']) : ''; ?>"
                                        class="btn btn-custom">PDF <i class="mdi mdi-printer"></i></a>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="demo-box m-t-20">
                                    <div class="m-b-30">
                                        <a href="add-staff.php">
                                            <button class="btn btn-success">Add <i
                                                    class="mdi mdi-plus-circle-outline"></i></button>
                                        </a>
                                    </div>
                                    <br />
                                    <div class="table-responsive">
                                        <table class="table table-colored-bordered table-bordered-primary">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Contact</th>
                                                    <th>Address</th>
                                                    <th>Joining Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($con, "SELECT id, FirstName, LastName, Email, Contact, Address, JoinningDate, Is_Active FROM tblstaff $whereClause");
                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                        <td><?php echo htmlentities($row['FirstName']) . " " . htmlentities($row['LastName']); ?>
                                                        </td>
                                                        <td><?php echo htmlentities($row['Email']); ?></td>
                                                        <td><?php echo htmlentities($row['Contact']); ?></td>
                                                        <td><?php echo htmlentities($row['Address']); ?></td>
                                                        <td><?php echo htmlentities($row['JoinningDate']); ?></td>
                                                        <td>
                                                            <?php if ($row['Is_Active'] == 1): ?>
                                                                <span class="label label-success">Active</span>
                                                            <?php else: ?>
                                                                <span class="label label-danger">Inactive</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="edit-staff.php?cid=<?php echo htmlentities($row['id']); ?>">
                                                                <i class="fa fa-pencil" style="color:#29b6f6;"></i>
                                                            </a>&nbsp;
                                                            <?php if ($row['Is_Active'] == 1): ?>
                                                                <a href="manage-stafflist.php?rid=<?php echo htmlentities($row['id']); ?>&action=del"
                                                                    onclick="return confirm('Deactivate this staff?');">
                                                                    <i class="fa fa-toggle-off" style="color:red;"></i>
                                                                </a>&nbsp;
                                                            <?php else: ?>
                                                                <a href="manage-stafflist.php?resid=<?php echo htmlentities($row['id']); ?>"
                                                                    onclick="return confirm('Activate this staff?');">
                                                                    <i class="fa fa-toggle-on" style="color:green;"></i>
                                                                </a>&nbsp;
                                                                <a href="manage-stafflist.php?rid=<?php echo htmlentities($row['id']); ?>&action=parmdel"
                                                                    onclick="return confirm('Delete this staff permanently?');">
                                                                    <i class="fa fa-trash" style="color:#f05050;"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <?php $cnt++;
                                                } ?>
                                            </tbody>
                                        </table>
                                        <h6 style="float: right;">Powered by CoreStorm</h6>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- row end -->

                    </div> <!-- container -->
                </div> <!-- content -->
                <?php include('includes/footer.php'); ?>
            </div>
        </div>

        <!-- Scripts -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
    </body>

    </html>
<?php } ?>
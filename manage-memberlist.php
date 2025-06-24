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

    $whereClause = "";
    if (!empty($_GET['month'])) {
        $month = mysqli_real_escape_string($con, $_GET['month']);
        $whereClause = "WHERE DATE_FORMAT(JoinDate, '%Y-%m') = '$month'";
    }
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
                                    <ol class="breadcrumb p-0 m-0">
                                        <li><a href="#">Admin</a></li>
                                        <li><a href="#">Member</a></li>
                                        <li class="active">Manage Member</li>
                                    </ol>
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

                            <div class="col-sm-12">
                                <form method="GET" class="form-inline" style="margin-bottom:20px;">
                                    <label>Filter by Month: </label>
                                    <input type="month" name="month" class="form-control"
                                        value="<?php echo htmlentities($_GET['month']); ?>">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="manage-memberlist.php" class="btn btn-default">Reset</a>
                                    <a href="download-member-pdf.php<?php echo (!empty($_GET['month'])) ? '?month=' . urlencode($_GET['month']) : ''; ?>"
                                        class="btn btn-danger">Download PDF</a>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="demo-box m-t-20">
                                    <div class="m-b-30">
                                        <a href="add-member.php">
                                            <button class="btn btn-success">Add <i
                                                    class="mdi mdi-plus-circle-outline"></i></button>
                                        </a>
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
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($con, "SELECT id, FirstName, LastName, Email, Mobile, AlterNumber, PaymentMode, JoinDate, Is_Active FROM tblmember $whereClause");
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

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
    </body>

    </html>
<?php } ?>
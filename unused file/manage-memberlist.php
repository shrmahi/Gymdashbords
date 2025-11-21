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
                                    <button type="submit" class="btn btn-filter">Filter</button>
                                    <a href="manage-memberlist.php" class="btn btn-reset" style="color:white">Reset</a>
                                    <a href="add-member.php" class="btn btn-success">
                                        <i class="mdi mdi-plus-circle-outline"></i> Add Member
                                    </a>&nbsp;
                                    <a href="download-member-pdf.php<?php //echo (!empty($_GET['month'])) ? '?month=' . urlencode($_GET['month']) : ''; ?>"
                                        class="btn btn-custom" style="margin-right:5px">
                                        <i class="mdi mdi-printer"></i> Export
                                    </a>

                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="demo-box m-t-20">

                                    <br />
                                    <div class="table-responsive">
                                        <table class="table table-colored-bordered table-bordered-primary table-bordered">
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
                                                $query = mysqli_query($con, "SELECT id, FirstName, LastName, Email, Mobile, AlterNumber, PaymentMode, JoinDate,ExpiryDate, Is_Active FROM tblmember $whereClause");
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
                                                            <div class="action-menu">
                                                                <button class="dots-btn" onclick="toggleMenu(this)">
                                                                    &#8942; <!-- vertical ellipsis -->
                                                                </button>
                                                                <div class="tooltip-menu">
                                                                    <a href="edit-member.php?cid=<?php echo htmlentities($row['id']); ?>"
                                                                        title="Edit">
                                                                        <i class="fa fa-pencil" style="color:#29b6f6;"></i> Edit
                                                                    </a>
                                                                    <a href="member.php?cid=<?php echo htmlentities($row['id']); ?>"
                                                                        title="View">
                                                                        <i class="fa fa-eye" style="color:#29b6f6;"></i> View
                                                                    </a>
                                                                    <?php if ($row['Is_Active'] == 1): ?>
                                                                        <a href="manage-memberlist.php?disid=<?php echo htmlentities($row['id']); ?>"
                                                                            onclick="return confirm('Deactivate this member?');"
                                                                            title="Deactivate">
                                                                            <i class="fa fa-toggle-off" style="color:red;"></i>
                                                                            In Active
                                                                        </a>
                                                                    <?php else: ?>
                                                                        <a href="manage-memberlist.php?appid=<?php echo htmlentities($row['id']); ?>"
                                                                            onclick="return confirm('Activate this member?');"
                                                                            title="Activate">
                                                                            <i class="fa fa-toggle-on" style="color:green;"></i>
                                                                            Activate
                                                                        </a>
                                                                        <a href="manage-memberlist.php?rid=<?php echo htmlentities($row['id']); ?>&action=parmdel"
                                                                            onclick="return confirm('Delete permanently?');"
                                                                            title="Delete Forever">
                                                                            <i class="fa fa-trash" style="color:#f05050;"></i>
                                                                            Delete
                                                                        </a>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    <?php $cnt++;
                                                } ?>

                                            </tbody>



                                        </table>
                                        <!-- <div style="text-align: right; margin-top: 5px;">
                                            <h6 style="margin: 0;">Powered by CoreStorm</h6>
                                        </div> -->

                                        <!-- <h6 style="float: right;">Powered by CoreStorm</h6> -->
                                        <!-- Add a wrapper div with a class for centering -->
                                        <br />
                                        <br />
                                        <br />

                                        <div class="pagination-wrapper">
                                            <div class="entries-info">
                                                <span>Showing</span>
                                                <select onchange="changeLimit(this.value)">
                                                    <option <?php if ($limit == 10)
                                                        echo "selected"; ?>>10</option>
                                                    <option <?php if ($limit == 25)
                                                        echo "selected"; ?>>25</option>
                                                    <option <?php if ($limit == 50)
                                                        echo "selected"; ?>>50</option>
                                                    <option <?php if ($limit == 100)
                                                        echo "selected"; ?>>100</option>
                                                </select>
                                                <span>of <?php echo $totalRecords; ?> entries</span>
                                            </div>

                                            <div class="pagination">
                                                <?php if ($page > 1): ?>
                                                    <a
                                                        href="?page=<?php echo $page - 1; ?>&month=<?php echo urlencode($_GET['month'] ?? ''); ?>">Previous</a>
                                                <?php endif; ?>

                                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                    <a href="?page=<?php echo $i; ?>&month=<?php echo urlencode($_GET['month'] ?? ''); ?>"
                                                        class="<?php echo ($page == $i) ? 'active' : ''; ?>">
                                                        <?php echo $i; ?>
                                                    </a>
                                                <?php endfor; ?>

                                                <?php if ($page < $totalPages): ?>
                                                    <a
                                                        href="?page=<?php echo $page + 1; ?>&month=<?php echo urlencode($_GET['month'] ?? ''); ?>">Next</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <h6 style="float: right;">Powered by CoreStorm</h6>



                                    </div>
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
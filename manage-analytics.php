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

    // Search and filter conditions
    $whereClause = "";
    $searchTerm = "";
    $statusFilter = "";
    
    if (!empty($_GET['search'])) {
        $searchTerm = mysqli_real_escape_string($con, $_GET['search']);
        $whereClause = "WHERE (FirstName LIKE '%$searchTerm%' OR LastName LIKE '%$searchTerm%' OR Email LIKE '%$searchTerm%')";
    }
    
    if (!empty($_GET['status']) && $_GET['status'] != 'all') {
        $statusFilter = mysqli_real_escape_string($con, $_GET['status']);
        if (!empty($whereClause)) {
            $whereClause .= " AND Is_Active = '$statusFilter'";
        } else {
            $whereClause = "WHERE Is_Active = '$statusFilter'";
        }
    }

    // Pagination setup
    $limit = 10; // records per page
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    // Count total records
    $totalQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM tblmember $whereClause");
    $totalData = mysqli_fetch_assoc($totalQuery);
    $totalRecords = $totalData['total'];
    $totalPages = ceil($totalRecords / $limit);

    // Fetch paginated records with additional fields for analytics
    $query = mysqli_query($con, "SELECT id, FirstName, LastName, Email, Mobile, AlterNumber, PaymentMode, JoinDate, ExpiryDate, Is_Active FROM tblmember $whereClause ORDER BY id DESC LIMIT $limit OFFSET $offset");

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Gym Dashboard | Manage Members</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
        <script src="assets/js/modernizr.min.js"></script>
        <style>
            .search-container {
                background: #f8f9fa;
                padding: 20px;
                border-radius: 8px;
                margin-bottom: 20px;
            }
            .search-input {
                border-radius: 25px;
                border: 1px solid #ddd;
                padding: 10px 20px;
                width: 100%;
                max-width: 400px;
            }
            .status-filter {
                border-radius: 25px;
                border: 1px solid #ddd;
                padding: 8px 20px;
                background: white;
            }
            .member-card {
                background: white;
                border-radius: 12px;
                padding: 20px;
                margin-bottom: 15px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                border: 1px solid #e9ecef;
            }
            .member-avatar {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                background: #007bff;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 20px;
                font-weight: bold;
            }
            .member-info {
                display: flex;
                align-items: center;
                gap: 15px;
                margin-bottom: 15px;
            }
            .member-details {
                display: flex;
                gap: 30px;
                flex-wrap: wrap;
            }
            .detail-item {
                display: flex;
                align-items: center;
                gap: 8px;
                color: #6c757d;
            }
            .detail-item i {
                width: 16px;
                text-align: center;
            }
            .status-badge {
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 500;
            }
            .status-active {
                background: #d4edda;
                color: #155724;
            }
            .status-inactive {
                background: #f8d7da;
                color: #721c24;
            }
            .member-name {
                font-weight: bold;
                font-size: 18px;
                color: #333;
                margin: 0;
            }
            .member-email, .member-phone {
                color: #6c757d;
                font-size: 14px;
                margin: 2px 0;
            }
            .stats-container {
                display: flex;
                gap: 30px;
                flex-wrap: wrap;
            }
            .stat-item {
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .stat-value {
                font-weight: bold;
                color: #333;
            }
            .stat-label {
                color: #6c757d;
                font-size: 12px;
            }
        </style>
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
                                    <h4 class="page-title">Members</h4>
                                    <a href="add-member.php" class="btn btn-success">
                                        <i class="mdi mdi-plus"></i> Add Member
                                    </a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <?php include('alert_message.php'); ?>
                            </div>
                        </div>

                        <!-- Search and Filter Section -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="search-container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-search"></i>
                                                </span>
                                                <input type="text" class="form-control search-input" placeholder="Search members..." 
                                                       value="<?php echo htmlentities($searchTerm); ?>" name="search">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control status-filter" name="status">
                                                <option value="all" <?php echo (empty($_GET['status']) || $_GET['status'] == 'all') ? 'selected' : ''; ?>>All Status</option>
                                                <option value="1" <?php echo (isset($_GET['status']) && $_GET['status'] == '1') ? 'selected' : ''; ?>>Active</option>
                                                <option value="0" <?php echo (isset($_GET['status']) && $_GET['status'] == '0') ? 'selected' : ''; ?>>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary" onclick="applyFilters()">
                                                <i class="fa fa-filter"></i> Apply Filters
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Members List -->
                        <div class="row">
                            <div class="col-md-12">
                                <?php if (mysqli_num_rows($query) > 0) { ?>
                                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                                        <div class="member-card">
                                            <div class="member-info">
                                                <div class="member-avatar">
                                                    <?php echo strtoupper(substr($row['FirstName'], 0, 1)); ?>
                                                </div>
                                                <div>
                                                    <h5 class="member-name"><?php echo htmlentities($row['FirstName'] . ' ' . $row['LastName']); ?></h5>
                                                    <div class="member-email">
                                                        <i class="fa fa-envelope"></i> <?php echo htmlentities($row['Email']); ?>
                                                    </div>
                                                    <div class="member-phone">
                                                        <i class="fa fa-phone"></i> <?php echo htmlentities($row['Mobile']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="stats-container">
                                                <div class="stat-item">
                                                    <i class="fa fa-bolt" style="color: #28a745;"></i>
                                                    <div>
                                                        <div class="stat-value">45</div>
                                                        <div class="stat-label">Total Visits</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="stat-item">
                                                    <i class="fa fa-calendar" style="color: #007bff;"></i>
                                                    <div>
                                                        <div class="stat-value">12/20/2024</div>
                                                        <div class="stat-label">Last Visit</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="stat-item">
                                                    <i class="fa fa-balance-scale" style="color: #6f42c1;"></i>
                                                    <div>
                                                        <div class="stat-value">65 kg</div>
                                                        <div class="stat-label">Current Weight</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="stat-item">
                                                    <i class="fa fa-trophy" style="color: #ffc107;"></i>
                                                    <div>
                                                        <div class="stat-value">Premium</div>
                                                        <div class="stat-label">Joined <?php echo date('m/d/Y', strtotime($row['JoinDate'])); ?></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="ml-auto">
                                                    <span class="status-badge <?php echo $row['Is_Active'] ? 'status-active' : 'status-inactive'; ?>">
                                                        <?php echo $row['Is_Active'] ? 'Active' : 'Inactive'; ?>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3 text-right">
                                                <a href="edit-member.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <?php if ($row['Is_Active']) { ?>
                                                    <a href="?disid=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning" 
                                                       onclick="return confirm('Are you sure you want to deactivate this member?')">
                                                        <i class="fa fa-ban"></i> Deactivate
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="?appid=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">
                                                        <i class="fa fa-check"></i> Activate
                                                    </a>
                                                <?php } ?>
                                                <a href="?action=parmdel&rid=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('Are you sure you want to delete this member permanently?')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    
                                    <!-- Pagination -->
                                    <?php if ($totalPages > 1) { ?>
                                        <div class="text-center">
                                            <ul class="pagination">
                                                <?php if ($page > 1) { ?>
                                                    <li><a href="?page=<?php echo ($page - 1); ?>&search=<?php echo urlencode($searchTerm); ?>&status=<?php echo urlencode($_GET['status'] ?? ''); ?>">Previous</a></li>
                                                <?php } ?>
                                                
                                                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                                    <li class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                                                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($searchTerm); ?>&status=<?php echo urlencode($_GET['status'] ?? ''); ?>"><?php echo $i; ?></a>
                                                    </li>
                                                <?php } ?>
                                                
                                                <?php if ($page < $totalPages) { ?>
                                                    <li><a href="?page=<?php echo ($page + 1); ?>&search=<?php echo urlencode($searchTerm); ?>&status=<?php echo urlencode($_GET['status'] ?? ''); ?>">Next</a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                    
                                <?php } else { ?>
                                    <div class="text-center" style="padding: 50px;">
                                        <i class="fa fa-users" style="font-size: 48px; color: #ddd;"></i>
                                        <h4 style="color: #999; margin-top: 20px;">No members found</h4>
                                        <p style="color: #999;">Try adjusting your search criteria or add a new member.</p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
                <?php include('includes/footer.php'); ?>
            </div>

        </div> <!-- END wrapper -->

        <script>
            var resizefunc = [];
            
            function applyFilters() {
                var search = document.querySelector('input[name="search"]').value;
                var status = document.querySelector('select[name="status"]').value;
                var url = 'manage-analytics.php?';
                
                if (search) url += 'search=' + encodeURIComponent(search) + '&';
                if (status && status !== 'all') url += 'status=' + encodeURIComponent(status) + '&';
                
                // Remove trailing & if exists
                if (url.endsWith('&')) url = url.slice(0, -1);
                
                window.location.href = url;
            }
            
            // Allow Enter key to trigger search
            document.addEventListener('DOMContentLoaded', function() {
                var searchInput = document.querySelector('input[name="search"]');
                if (searchInput) {
                    searchInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            applyFilters();
                        }
                    });
                }
            });
        </script>

        <!-- jQuery and App Scripts -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="../plugins/switchery/switchery.min.js"></script>
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <script src="https://kit.fontawesome.com/ae115648d7.js" crossorigin="anonymous"></script>

    </body>

    </html>
<?php } ?>
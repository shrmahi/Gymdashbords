<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
}
else{

// ========== INSERT / UPDATE STAFF ==========
if (isset($_POST['submit'])) {

    // Escape inputs
    foreach ($_POST as $key => $value) {
        $_POST[$key] = mysqli_real_escape_string($con, $value);
    }

    // FORM FIELDS
    $Staffid       = $_POST['staff_id'];
    $Type          = $_POST['Type'];
    $FirstName     = $_POST['FirstName'];
    $LastName      = $_POST['LastName'];
    $Email         = $_POST['Email'];
    $Password      = $_POST['Password'];
    $Contact       = $_POST['Contact'];
    $Address       = $_POST['Address'];
    $JoinningDate  = $_POST['JoinningDate'];
    $StaffStatus   = $_POST['StaffStatus'];
    $userType      = $_POST['userType'];
    $Is_Active     = $_POST['Is_Active'];

    /* ================= UPDATE ================= */
    if (!empty($Staffid)) {

        $sql = "UPDATE staff_details SET
                Type='$Type',
                FirstName='$FirstName',
                LastName='$LastName',
                Email='$Email',
                Password='$Password',
                Contact='$Contact',
                Address='$Address',
                JoinningDate='$JoinningDate',
                StaffStatus='$StaffStatus',
                userType='$userType',
                Is_Active='$Is_Active'
                WHERE id='$Staffid'";

        mysqli_query($con, $sql);
        $msg = "Staff updated successfully.";

    } else {

        /* ================= INSERT ================= */
        $sql = "INSERT INTO staff_details 
        (Type, FirstName, LastName, Email, Password, Contact, Address, 
         JoinningDate, StaffStatus, userType, Is_Active)
        VALUES 
        ('$Type', '$FirstName', '$LastName', '$Email', '$Password', '$Contact',
         '$Address', '$JoinningDate', '$StaffStatus', '$userType', '$Is_Active')";

        mysqli_query($con, $sql);
        $msg = "Staff added successfully.";
    }
}

// ========== DELETE / DEACTIVATE / RESTORE ==========
if (isset($_GET['action']) && $_GET['action'] == 'del' && $_GET['rid']) {
    $id = intval($_GET['rid']);
    mysqli_query($con, "UPDATE staff_details SET Is_Active = 0 WHERE id = '$id'");
    $msg = "Staff deactivated";
}

if (isset($_GET['appid'])) {
    $id = intval($_GET['appid']);
    mysqli_query($con, "UPDATE staff_details SET Is_Active = 1 WHERE id = '$id'");
    $msg = "Staff activated";
}

if (isset($_GET['disid'])) {
    $id = intval($_GET['disid']);
    mysqli_query($con, "UPDATE staff_details SET Is_Active = 0 WHERE id = '$id'");
    $msg = "Staff deactivated";
}

if (isset($_GET['resid'])) {
    $id = intval($_GET['resid']);
    mysqli_query($con, "UPDATE staff_details SET Is_Active = 1 WHERE id = '$id'");
    $msg = "Staff restored successfully";
}

if (isset($_GET['action']) && $_GET['action'] == 'parmdel' && isset($_GET['rid'])) {
    $id = intval($_GET['rid']);
    mysqli_query($con, "UPDATE staff_details SET is_delete = 1 WHERE id = '$id'");
    $delmsg = "Staff deleted permanently";
}

// ========== SEARCH & FILTER ==========
$whereClause = " WHERE is_delete = 0";

$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
if ($searchTerm !== '') {
    $whereClause .= " AND (FirstName LIKE '%$searchTerm%' 
                        OR LastName LIKE '%$searchTerm%' 
                        OR Email LIKE '%$searchTerm%')";
}

if (isset($_GET['status']) && $_GET['status'] !== 'all' && $_GET['status'] !== '') {
    $statusFilter = mysqli_real_escape_string($con, $_GET['status']);
    $whereClause .= " AND Is_Active = '$statusFilter'";
}

$statusParam = isset($_GET['status']) ? $_GET['status'] : '';

// ========== PAGINATION ==========
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$totalQuery = mysqli_query($con, "SELECT COUNT(*) AS total FROM staff_details $whereClause");
$totalRecords = mysqli_fetch_assoc($totalQuery)['total'];
$totalPages = ceil($totalRecords / $limit);

// ========== FETCH STAFF ==========
$query = mysqli_query($con,
"SELECT id, Type, FirstName, LastName, Email, Password, Contact, Address,
JoinningDate, StaffStatus, userType, Is_Active
FROM staff_details
$whereClause
ORDER BY id DESC
LIMIT $limit OFFSET $offset"
);

// ========== LOAD DATA FOR EDIT ==========
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $Staffid = intval($_GET['id']);
    $memberRes = mysqli_query($con, "SELECT * FROM staff_details WHERE id = '$Staffid' LIMIT 1");

    if ($memberRes && mysqli_num_rows($memberRes) > 0) {
        $m = mysqli_fetch_assoc($memberRes);

        $Type = $m['Type'];
        $FirstName = $m['FirstName'];
        $LastName = $m['LastName'];
        $Email = $m['Email'];
        $Password = $m['Password'];
        $Contact = $m['Contact'];
        $Address = $m['Address'];
        $JoinningDate = $m['JoinningDate'];
        $StaffStatus = $m['StaffStatus'];
        $userType = $m['userType'];
        $Is_Active = $m['Is_Active'];
    }
}
?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Gym Dashboard | Manage Staff</title>
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
        <div id="wrapper">
            <?php include('includes/topheader.php'); ?>
            <?php include('includes/leftsidebar.php'); ?>
            <div class="content-page">
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Staff</h4>
                                    <button class="btn btn-success waves-effect waves-light btnAddMember" data-toggle="modal"
                                    data-target="#addMemberModal">
                                    <i class="mdi mdi-plus-circle-outline"></i> Add Staff
                                </button>
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
                                                <input type="text" class="form-control search-input" placeholder="Search Staff..." 
                                                       value="<?php echo htmlentities($searchTerm); ?>" name="search">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control status-filter" name="status">
                                                <option value="all" <?php echo ($statusParam === '' || $statusParam === 'all') ? 'selected' : ''; ?>>All Status</option>
                                                <option value="1" <?php echo ($statusParam === '1') ? 'selected' : ''; ?>>Active</option>
                                                <option value="0" <?php echo ($statusParam === '0') ? 'selected' : ''; ?>>Inactive</option>
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
                                                
                                                <div>
                                                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                                        <h5 class="member-name"><?php echo htmlentities($row['FirstName'] . ' ' . $row['LastName']); ?></h5> &nbsp;&nbsp;
                                                        
                                                    </div>
                                                    <div style="display:flex;justify-content:space-between;" >
                                                        <div class="member-email" >
                                                         <i class="fa fa-envelope"></i> <?php echo htmlentities($row['Email']); ?>
                                                        </div> &nbsp;&nbsp;
                                                    &nbsp;<div class="member-phone">
                                                        <i class="fa fa-phone"></i> <?php echo htmlentities($row['Contact']); ?>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                                                <div class="stats-container">
                                                    <div class="stat-item">
                                                        <i class="fa fa-bolt" style="color: #28a745;"></i>
                                                        <div>
                                                            <div class="stat-value">Type</div>
                                                            <div class="stat-label">Type</div>
                                                        </div>
                                                    </div>
                                                    <div class="stat-item">
                                                        <i class="fa fa-calendar" style="color: #007bff;"></i>
                                                        <div>
                                                            <div class="stat-value">12/20/2024</div>
                                                            <div class="stat-label">Joinning Date</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <a href="manage-staff.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-edit">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-delete"
                                                    onclick="event.preventDefault(); openModal('<?php echo $row['id']; ?>', 'member')">
                                                        <i class="fa fa-trash"></i> Remove
                                                    </a>
                                                </div>
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
        <!-- Add/Edit Package Modal -->
        <div class="modal fade custom-modal-rounded" id="addMemberModal" tabindex="-1" role="dialog"
            aria-labelledby="addMemberModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="POST" enctype="multipart/form-data">
                    <!-- <input type="hidden" name="Staffid" id="Staffid"> -->
                    <input type="hidden" name="staff_id" value="<?php echo $Staffid; ?>">

                    <div class="modal-content rounded-lg">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addMemberModalLabel"><span class="icon-bg"><i
                                        class="fa-solid fa-user fa-2x"></i></span> <?php echo !empty($Staffid) ? 'Edit Staff' : 'Add New Staff'; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <h4>Personal Details</h4>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="personal">
                                    <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstName">First Name*</label>
                                        <input type="text" class="form-control" name="FirstName" id="firstName" required value="<?php echo htmlentities($FirstName ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastName">Last Name*</label>
                                        <input type="text" class="form-control" name="LastName" id="lastName" required value="<?php echo htmlentities($LastName ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branchNumber"><i class="fa-solid fa-Mobile-volume"></i> Mobile
                                                    Number</label>
                                        <input type="text" class="form-control" id="Contact" name="Contact" required value="<?php echo htmlentities($Contact ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Email"><i class="fa-regular fa-envelope"></i> Email Address</label>
                                            <input type="text" class="form-control" id="Email" name="Email" required value="<?php echo htmlentities($Email ?? ''); ?>">
                                        </div>
                                    </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dob"><i class="fa-solid fa-calendar-days"></i>Joinnig Date</label>
                                                <input type="date" class="form-control" id="JoinningDate" name="JoinningDate" required value="<?php echo htmlentities($JoinningDate ?? ''); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="address"><i class="fa-solid fa-location-dot"></i> Address</label>
                                                <textarea type="text" class="form-control" id="address" name="Address" required><?php echo htmlentities($Address ?? ''); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                         <div class="form-group">
                                        <label for="membershipStatus">Membership Status</label>
                                        <select class="form-select form-control" id="membershipStatus" name="StaffStatus">
                                            <option selected disabled>Select a Status</option>
                                            <option value="active" <?php echo (isset($StaffStatus) && $StaffStatus == 'active') ? 'selected' : ''; ?>>Active</option>
                                            <option value="In active" <?php echo (isset($StaffStatus) && $StaffStatus == 'In active') ? 'selected' : ''; ?>>In Active</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success" name="submit">Save Member</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
         <?php include('modal-alert.php'); ?>

        <script>
            var resizefunc = [];

            function applyFilters() {
                var search = document.querySelector('input[name="search"]').value;
                var status = document.querySelector('select[name="status"]').value;
                var url = 'manage-staff.php?';
                
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
        <script>
        // Auto hide alert after 5 seconds (5000ms)
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 5000);
        </script>
        <script>
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreview');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = "block";
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = "#";
                    preview.style.display = "none";
                }
            }
        </script>
        <!-- Auto-open modal script moved to after jQuery/Bootstrap includes -->
        <!-- Delete Modal Script -->
        <script src="assets/js/modal-alert.js"></script>

        <!-- jQuery and App Scripts -->
        <script src="assets/js/url.js"></script>
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

        <?php if (!empty($Staffid)) { ?>
        <script>
            (function($){
                $(function(){
                    $('#addMemberModal').modal('show');
                    $('#addMemberModalLabel').text('Edit Member');
                });
            })(jQuery);
        </script>
        <?php } ?>

    </body>

    </html>
    <?php } ?>

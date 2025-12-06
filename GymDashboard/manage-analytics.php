<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
} else {

    // ========== INSERT / UPDATE MEMBER ==========
    if (isset($_POST['submit'])) {

        // Escape all inputs
        foreach ($_POST as $key => $value) {
            $_POST[$key] = mysqli_real_escape_string($con, $value);
        }

        $member_id       = $_POST['member_id'];
        $first_name      = $_POST['first_name'];
        $last_name       = $_POST['last_name'];
        $phone           = $_POST['phone'];
        $email           = $_POST['email'];
        $dob             = $_POST['dob'];
        $medical         = $_POST['medical_History'];
        $branch          = $_POST['branch_manager'];
        $membership_type = $_POST['membership_type'];
        $status          = $_POST['membership_status'];
        $trainer         = $_POST['assigned_trainer'];

        $contact_name  = $_POST['contact_name'];
        $relationship  = $_POST['relationship'];
        $contact_phone = $_POST['phone_Number'];

        $current_weight = $_POST['current_weight'];
        $goal_weight    = $_POST['goal_weight'];
        $body_fat       = $_POST['body_fat'];
        $muscle_mass    = $_POST['muscle_mass'];
        $chest          = $_POST['chest'];
        $waist          = $_POST['waist'];
        $hips           = $_POST['hips'];
        $arms           = $_POST['arms'];
        $thighs         = $_POST['thighs'];
        $Is_Active      = 1;

        // =================== UPDATE MEMBER ===================
        if (!empty($member_id)) {

            $sql = "UPDATE measurements SET 
                first_name='$first_name',
                last_name='$last_name',
                phone='$phone',
                email='$email',
                dob='$dob',
                medical_history='$medical',
                branch_manager='$branch',
                membership_type='$membership_type',
                membership_status='$status',
                assigned_trainer='$trainer',
                emg_contact_name='$contact_name',
                emg_relationship='$relationship',
                emg_phone='$contact_phone',
                current_weight='$current_weight',
                goal_weight='$goal_weight',
                body_fat='$body_fat',
                muscle_mass='$muscle_mass',
                chest='$chest',
                waist='$waist',
                hips='$hips',
                arms='$arms',
                thighs='$thighs'
                WHERE id='$member_id'";

            $query = mysqli_query($con, $sql);
            $msg = $query ? "Member updated successfully." : "Update failed. Try again.";

        } else {

            // =================== INSERT MEMBER ===================
            $sql = "INSERT INTO measurements(
                first_name, last_name, phone, email, dob, medical_history,
                branch_manager, membership_type, membership_status, assigned_trainer,
                emg_contact_name, emg_relationship, emg_phone,
                current_weight, goal_weight, body_fat, muscle_mass,
                chest, waist, hips, arms, thighs, Is_Active
            ) VALUES (
                '$first_name','$last_name','$phone','$email','$dob','$medical',
                '$branch','$membership_type','$status','$trainer',
                '$contact_name','$relationship','$contact_phone',
                '$current_weight','$goal_weight','$body_fat','$muscle_mass',
                '$chest','$waist','$hips','$arms','$thighs','$Is_Active'
            )";

            $query = mysqli_query($con, $sql);
            $msg = $query ? "Member added successfully." : "Insert failed. Try again.";
        }
    }

    // ========== DELETE / DEACTIVATE / RESTORE ==========
    if (isset($_GET['action']) && $_GET['action'] == 'del' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        mysqli_query($con, "UPDATE measurements SET Is_Active = 0 WHERE id = '$id'");
        $msg = "Member deactivated";
    }

    if (isset($_GET['appid'])) {
        $id = intval($_GET['appid']);
        mysqli_query($con, "UPDATE measurements SET Is_Active = 1 WHERE id = '$id'");
        $msg = "Member activated";
    }

    if (isset($_GET['disid'])) {
        $id = intval($_GET['disid']);
        mysqli_query($con, "UPDATE measurements SET Is_Active = 0 WHERE id = '$id'");
        $msg = "Member deactivated";
    }

    if (isset($_GET['resid'])) {
        $id = intval($_GET['resid']);
        mysqli_query($con, "UPDATE measurements SET Is_Active = 1 WHERE id = '$id'");
        $msg = "Member restored successfully";
    }

    if (isset($_GET['action']) && $_GET['action'] == 'parmdel' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        mysqli_query($con, "DELETE FROM measurements WHERE id = '$id'");
        $delmsg = "Member deleted permanently";
    }

    // ========== SEARCH & FILTER ==========
    $whereClause = "WHERE 1=1";

    if (!empty($_GET['search'])) {
        $searchTerm = mysqli_real_escape_string($con, $_GET['search']);
        $whereClause .= " AND (first_name LIKE '%$searchTerm%' 
                            OR last_name LIKE '%$searchTerm%' 
                            OR email LIKE '%$searchTerm%')";
    }

    if (!empty($_GET['status']) && $_GET['status'] != 'all') {
        $statusFilter = mysqli_real_escape_string($con, $_GET['status']);
        $whereClause .= " AND Is_Active = '$statusFilter'";
    }

    // ========== PAGINATION ==========
    $limit = 10;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    $totalQuery = mysqli_query($con, "SELECT COUNT(*) AS total FROM measurements $whereClause");
    $totalRecords = mysqli_fetch_assoc($totalQuery)['total'];
    $totalPages = ceil($totalRecords / $limit);

    // ========== FETCH MEMBERS ==========
    $query = mysqli_query($con, 
        "SELECT id, first_name, last_name, email, phone,current_weight, membership_type, membership_status, Is_Active 
        FROM measurements 
        $whereClause 
        ORDER BY id DESC 
        LIMIT $limit OFFSET $offset"
    );

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
                                    <button class="btn btn-success waves-effect waves-light btnAddMember" data-toggle="modal"
                                    data-target="#addMemberModal">
                                    <i class="mdi mdi-plus-circle-outline"></i> Add Member
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
                                                    <?php echo strtoupper(substr($row['first_name'], 0, 1)); ?>
                                                </div>
                                                
                                                <div>
                                                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                                        <h5 class="member-name"><?php echo htmlentities($row['first_name'] . ' ' . $row['last_name']); ?></h5> &nbsp;&nbsp;
                                                        <span class="status-badge <?php echo $row['Is_Active'] ? 'status-active' : 'status-inactive'; ?>">
                                                            <?php echo $row['Is_Active'] ? 'Active' : 'Inactive'; ?>
                                                        </span>
                                                    </div>
                                                    <div style="display:flex;justify-content:space-between;" >
                                                        <div class="member-email" >
                                                         <i class="fa fa-envelope"></i> <?php echo htmlentities($row['email']); ?>
                                                        </div> &nbsp;&nbsp;
                                                    &nbsp;<div class="member-phone">
                                                        <i class="fa fa-phone"></i> <?php echo htmlentities($row['phone']); ?>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
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
                                                            <div class="stat-value"><?php echo htmlentities($row['current_weight']); ?> kg</div>
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
                                                </div>
                                                
                                                <div class="text-right">
                                                    <a href="manage-analytics.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-edit">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <?php if ($row['Is_Active']) { ?>
                                                        <a href="?disid=<?php echo $row['id']; ?>" class="btn btn-sm btn-deactive"
                                                            onclick="return confirm('Are you sure you want to deactivate this member?')">
                                                            <i class="fa fa-ban"></i> Deactivate
                                                        </a>
                                                    <?php } else { ?>
                                                        <a href="?appid=<?php echo $row['id']; ?>" class="btn btn-sm btn-active">
                                                            <i class="fa fa-check"></i> Activate
                                                        </a>
                                                    <?php } ?>
                                                    <a href="#" class="btn btn-sm btn-delete"
                                                    onclick="event.preventDefault(); openModal('<?php echo $row['id']; ?>')">
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
                <form method="POST">
                    <input type="hidden" name="member_id" id="member_id">
                    <div class="modal-content rounded-lg">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addMemberModalLabel"><span class="icon-bg"><i
                                        class="fa-solid fa-chart-simple fa-2x"></i></span> Add New Member</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#personal" data-toggle="tab">Personal</a></li>
                            <li><a href="#membership" data-toggle="tab">Membership</a></li>
                            <li><a href="#documents" data-toggle="tab">Documents</a></li>
                            <li><a href="#progress" data-toggle="tab">Progress</a></li>
                        </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="personal">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="postimage" id="postimage"
                                                accept="image/*" required onchange="previewImage(event)">
                                        </div>
                                        <div class="col-md-6">
                                            <img id="imagePreview" src="#" alt="Selected Image"
                                                style="display: none; height: 100px; width: 100px; border: 1px solid #ccc; padding: 5px;">
                                        </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstName">First Name*</label>
                                        <input type="text" class="form-control" name="first_name" id="firstName" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastName">Last Name*</label>
                                        <input type="text" class="form-control" name="last_name" id="lastName" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastName">Gender*</label>
                                        
                                            <label class="radio-inline"><input type="radio" name="gender" value="Male"
                                                    required> Male</label>
                                            <label class="radio-inline"><input type="radio" name="gender" value="Female">
                                                Female</label>
                                            <label class="radio-inline"><input type="radio" name="gender" value="Other">
                                                Other</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" name="maritalstatus" id="maritalstatus" required>
                                                <option value="">-- Marital Status --</option>
                                                <option value="Married">Married</option>
                                                <option value="Unmarried">Unmarried</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="branchNumber"><i class="fa-solid fa-phone-volume"></i> Phone
                                                    Number</label>
                                                <input type="text" class="form-control" id="branchNumber" name="branch_number" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="branchEmail"><i class="fa-regular fa-envelope"></i> Email Address</label>
                                                <input type="text" class="form-control" id="branchEmail" name="branch_email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="address"><i class="fa-solid fa-location-dot"></i> Address</label>
                                                <textarea type="text" class="form-control" id="address" name="address" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="dob"><i class="fa-solid fa-calendar-days"></i> Date of Birth</label>
                                                <input type="date" class="form-control" id="dob" name="dob" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="medicalHistory"><i class="fa-regular fa-heart"></i> Medical History</label>
                                                <textarea type="text" class="form-control" id="medicalHistory" name="medical_History" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!------------------------------------------------------>

                                <div class="tab-pane fade" id="membership">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="branchManager">Branch</label>
                                                <select class="form-select form-control" id="branchManager" name="branch_manager">
                                                    <option selected disabled>Select a branch</option>
                                                    <?php
                                                    $query = mysqli_query($con, "SELECT BranchName FROM tblbranch WHERE Is_active=1");
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        echo '<option value="' . htmlentities($row['BranchName']) . '">' . htmlentities($row['BranchName']) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="membershipType">Membership Type</label>
                                        <select class="form-select form-control" id="membershipType" name="membership_type">
                                            <option selected disabled>Select a membership</option>
                                            <?php
                                                        $query = mysqli_query($con, "SELECT PackageName FROM tblpackage WHERE Is_active=1");
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            echo '<option value="' . htmlentities($row['PackageName']) . '">' . htmlentities($row['PackageName']) . '</option>';
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="membershipStatus">Membership Status</label>
                                        <select class="form-select form-control" id="membershipStatus" name="membership_status">
                                            <option selected disabled>Select a Status</option>
                                            <option value="active">Active</option>
                                            <option value="In active">In Active</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="assignedTrainer">Assingned Trainer(Optional)</label>
                                        <select class="form-select form-control" id="assignedTrainer" name="assigned_trainer">
                                            <option selected disabled>Select Trainer</option>
                                            <?php
                                                        $query = mysqli_query($con, "SELECT FirstName FROM tblstaff WHERE Is_active=1");
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            echo '<option value="' . htmlentities($row['FirstName']) . '">' . htmlentities($row['FirstName']) . '</option>';
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="assignedTrainer">Shift Type</label>
                                        <select class="form-select form-control" id="assignedTrainer" name="assigned_trainer">
                                            <option selected disabled>Select Shift</option>
                                            <?php
                                                        $query = mysqli_query($con, "SELECT ShiftName FROM tblshift WHERE Is_active=1");
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            echo '<option value="' . htmlentities($row['ShiftName']) . '">' . htmlentities($row['ShiftName']) . '</option>';
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                
                                    </div>
                                    
                                </div>
                                <!------------------------------------------------------>
                                <div class="tab-pane fade" id="documents">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="adharnum">Adhar Number</label>
                                                <input type="text" class="form-control" name="adhar_Number" id="adharnum" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pannum">Pan Number</label>
                                                <input type="text" class="form-control" name="pan_Number" id="pannum" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="drivingnum">Driving License</label>
                                                <input type="text" class="form-control" name="driving_Num" id="drivingnum" required>
                                            </div>
                                        </div>
                                        <h4 style="margin-left:10px">Doctor's Details</h4>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dname">Doctor's Name</label>
                                                <input type="text" class="form-control" name="dname" id="dname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dnumber">Doctor's Number</label>
                                                <input type="text" class="form-control" name="dnumber" id="dnumber" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="medihistory" required>
                                                <option value="">-- Medical History --</option>
                                                <option value="No">No</option>
                                                <?php
                                                $query = mysqli_query($con, "SELECT MedicalRecord FROM tblmedical WHERE Is_active=1");
                                                while ($row = mysqli_fetch_array($query)) {
                                                    echo '<option value="' . htmlentities($row['MedicalRecord']) . '">' . htmlentities($row['MedicalRecord']) . '</option>';
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <!------------------------------------------------------>
                                <div class="tab-pane fade" id="progress">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="currentWeight">Payment Mode</label>
                                                <select class="form-control" name="paymode" id="paymode" required>
                                                        <option value="">-- Payment Mode --</option>
                                                    <?php
                                                        $query = mysqli_query($con, "SELECT PaymentMode FROM tblpaymode WHERE Is_active=1");
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            echo '<option value="' . htmlentities($row['PaymentMode']) . '">' . htmlentities($row['PaymentMode']) . '</option>';
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="receiptdate">Receipt</label>
                                                <input type="date" class="form-control" name="receiptdate" id="receiptdate" required>
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="receipttype">Receipt Type</label>
                                                <select class="form-control" name="paymode" id="paymode" required>
                                                <option value="">-- Receipt Type --</option>
                                                    <?php
                                                        $query = mysqli_query($con, "SELECT ReceiptNumber FROM tblreceipt WHERE Is_active=1");
                                                        while ($row = mysqli_fetch_array($query)) {
                                                        echo '<option value="' . htmlentities($row['ReceiptNumber']) . '">' . htmlentities($row['ReceiptNumber']) . '</option>';
                                                    }?>
                                                 </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success" name="submit">Save Package</button>
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
        <!-- Delete Modal Script -->
        <script>
            function openModal(id) {
                document.getElementById('deleteModal').style.display = 'flex';
                document.getElementById('confirmDelete').href = "?action=parmdel&rid=" + id;
            }

            function closeModal() {
                document.getElementById('deleteModal').style.display = 'none';
            }
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
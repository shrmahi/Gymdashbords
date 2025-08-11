<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $branch_id = isset($_POST['branch_id']) ? intval($_POST['branch_id']) : 0;
        $branch_name = mysqli_real_escape_string($con, $_POST['branch_name']);
        $branch_manager = mysqli_real_escape_string($con, $_POST['branch_manager']);
        $branch_address = mysqli_real_escape_string($con, $_POST['branch_address']);
        $branch_email = mysqli_real_escape_string($con, $_POST['branch_email']);
        $branch_number = mysqli_real_escape_string($con, $_POST['branch_number']);
        $status = 1;

        if ($branch_id > 0) {
            // UPDATE branch
            $query = mysqli_query($con, "UPDATE tblbranch 
            SET BranchName='$branch_name', BranchManager='$branch_manager', BranchAddress='$branch_address', 
                BranchEmail='$branch_email', BranchNumber='$branch_number', Is_Active='$status'
            WHERE id='$branch_id'");
            $msg = $query ? "Branch updated successfully." : "Update failed. Try again.";
        } else {
            // INSERT branch
            $query = mysqli_query($con, "INSERT INTO tblbranch 
            (BranchName, BranchManager, BranchAddress, BranchEmail, BranchNumber, Is_Active) 
            VALUES('$branch_name','$branch_manager','$branch_address','$branch_email','$branch_number','$status')");
            $msg = $query ? "Branch added." : "Something went wrong. Please try again.";
        }
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Gym Dashboard | Manage Branch</title>
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

                        <!-- Page Title -->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Manage Branch</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li><a href="#">Admin</a></li>
                                        <li><a href="#">Branch</a></li>
                                        <li class="active">Manage Branch</li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Alerts -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert-container">
                                    <?php if (!empty($msg)) { ?>
                                        <div class="alert alert-success alert-dismissible fade in" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                        </div>
                                    <?php } ?>

                                    <?php if (!empty($error)) { ?>
                                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <!-- Add Branch Button -->
                            <div class="col-sm-12 mb-3">
                                <button class="btn btn-success waves-effect waves-light" data-toggle="modal"
                                    data-target="#addBranchModal">
                                    <i class="mdi mdi-plus-circle-outline"></i> Add Branch
                                </button>
                            </div>
                            <br />
                            <br />
                        </div>

                        <!-- Sample Branch Card -->
                        <div class="row">
                            <?php
                            $query = mysqli_query($con, "SELECT `id`, `BranchName`, `BranchManager`, `BranchAddress`, `BranchEmail`, `BranchNumber`, `Is_Active` FROM `tblbranch` Where Is_Active = 1");
                            while ($row = mysqli_fetch_array($query)) {
                                ?>
                                <div class="col-sm-4">
                                    <div class="card-box">
                                        <div class="card card-custom p-4 bg-white">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <h5 class="mb-0"><?php echo htmlentities($row['BranchName']); ?></h5>
                                                    <small
                                                        class="text-muted"><?php echo htmlentities($row['BranchAddress']); ?></small>
                                                </div>
                                                <span class="status-badge">Active</span>
                                            </div>
                                            <hr>
                                            <div class="info-line"><span>Monthly Revenue:</span> <strong>₹38,200</strong></div>
                                            <div class="info-line"><span>Active Members:</span> <strong>156 / 189</strong></div>
                                            <div class="info-line"><span>New Enquiries:</span> <strong>18</strong></div>
                                            <div class="info-line"><span>Conversions:</span> <strong>8</strong></div>
                                            <hr>
                                            <div class="mb-3">
                                                <p class="mb-1"><strong>Contact:</strong></p>
                                                <small><?php echo htmlentities($row['BranchManager']); ?></small>
                                                <small>+91 <?php echo htmlentities($row['BranchNumber']); ?></small><br>
                                                <small><?php echo htmlentities($row['BranchEmail']); ?></small>
                                            </div>
                                            <div class="d-flex justify-content-between card-footer-btns">
                                                <a href="#" class="btn btn-primary btn-branch">View Details</a>
                                                <a href="#" class="text-secondary editBranchBtn"
                                                    data-id="<?php echo $row['id']; ?>"
                                                    data-name="<?php echo htmlentities($row['BranchName']); ?>"
                                                    data-manager="<?php echo htmlentities($row['BranchManager']); ?>"
                                                    data-address="<?php echo htmlentities($row['BranchAddress']); ?>"
                                                    data-email="<?php echo htmlentities($row['BranchEmail']); ?>"
                                                    data-number="<?php echo htmlentities($row['BranchNumber']); ?>"
                                                    data-toggle="modal" data-target="#addBranchModal">Edit Branch</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>

                    </div>
                </div>

                <?php include('includes/footer.php'); ?>
            </div>
        </div>

        <!-- Add Branch Modal -->
        <div class="modal fade custom-modal-rounded" id="addBranchModal" tabindex="-1" role="dialog"
            aria-labelledby="addBranchModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="POST">
                    <div class="modal-content rounded-lg">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addBranchModalLabel"><span class="icon-bg"><i
                                        class="fa-regular fa-building fa-2x"></i></span> Add New Branch</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branchName"><i class="fa-regular fa-building"></i> Branch Name</label>
                                        <input type="text" class="form-control" name="branch_name" id="branchName" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branchManager">Branch Manager</label>
                                        <select class="form-select form-control" id="branchManager" name="branch_manager">
                                            <option selected disabled>Select a manager</option>
                                            <?php
                                            $query = mysqli_query($con, "SELECT FirstName FROM tblstaff WHERE Is_active=1");
                                            while ($row = mysqli_fetch_array($query)) {
                                                echo '<option value="' . htmlentities($row['FirstName']) . '">' . htmlentities($row['FirstName']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="branchName"><i class="fa-solid fa-location-dot"></i> Address</label>
                                        <textarea type="text" class="form-control" id="branchAddress" name="branch_address"
                                            required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branchName"><i class="fa-solid fa-phone-volume"></i> Phone
                                            Number</label>
                                        <input type="text" class="form-control" id="branchNumber" name="branch_number"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branchName"><i class="fa-regular fa-envelope"></i> Email Address</label>
                                        <input type="text" class="form-control" id="branchEmail" name="branch_email"
                                            required>
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="isActive" checked>
                                    <label class="form-check-label" for="isActive">
                                        Branch is active and operational
                                    </label>
                                </div>


                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success" name="submit">Save Branch</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- JS Scripts -->
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
        <script src="https://kit.fontawesome.com/ae115648d7.js" crossorigin="anonymous"></script>
        <script>
            // Reset Modal for Adding
            $(document).on("click", ".btnAddBranch", function () {
                $("#branch_id").val("");
                $("#branchName").val("");
                $("#branchManager").val("");
                $("#branchAddress").val("");
                $("#branchNumber").val("");
                $("#branchEmail").val("");
                $(".modal-title").text("Add New Branch");
                $("button[name=submit]").text("Save Branch");
            });

            // Fill Modal for Editing
            $(document).on("click", ".editBranchBtn", function () {
                $("#branch_id").val($(this).data("id"));
                $("#branchName").val($(this).data("name"));
                $("#branchManager").val($(this).data("manager"));
                $("#branchAddress").val($(this).data("address"));
                $("#branchNumber").val($(this).data("number"));
                $("#branchEmail").val($(this).data("email"));
                $(".modal-title").text("Edit Branch");
                $("button[name=submit]").text("Update Branch");
            });
        </script>
    </body>


    </html>
<?php } ?>
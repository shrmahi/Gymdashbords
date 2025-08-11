<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $package_id = isset($_POST['package_id']) ? intval($_POST['package_id']) : 0;
        $package_name = mysqli_real_escape_string($con, $_POST['package_name']);
        $package_duration = mysqli_real_escape_string($con, $_POST['package_duration']);
        $package_days = mysqli_real_escape_string($con, $_POST['package_days']);
        $package_price = mysqli_real_escape_string($con, $_POST['package_price']);
        $status = 1;

        if ($package_id > 0) {
            // UPDATE package
            $query = mysqli_query($con, "UPDATE tblplan 
                SET PlanName='$package_name', Duration='$package_duration', Days='$package_days', 
                    Price='$package_price', Is_Active='$status'
                WHERE id='$package_id'");
            $msg = $query ? "Package updated successfully." : "Update failed. Try again.";
        } else {
            // INSERT package
            $query = mysqli_query($con, "INSERT INTO tblplan 
                (PlanName, Duration, Days, Price, Is_Active) 
                VALUES('$package_name','$package_duration','$package_days','$package_price','$status')");
            $msg = $query ? "Package added successfully." : "Something went wrong. Please try again.";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Gym Dashboard | Manage Package</title>
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
                                    <h4 class="page-title">Manage Package</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li><a href="#">Admin</a></li>
                                        <li><a href="#">Package</a></li>
                                        <li class="active">Manage Package</li>
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

                            <!-- Add Package Button -->
                            <div class="col-sm-12 mb-3">
                                <button class="btn btn-success waves-effect waves-light btnAddPackage" data-toggle="modal"
                                    data-target="#addPackageModal">
                                    <i class="mdi mdi-plus-circle-outline"></i> Add Package
                                </button>
                            </div>
                            <br /><br />
                        </div>

                        <!-- Package Cards -->
                        <div class="row">
                            <?php
                            $query = mysqli_query($con, "SELECT `id`, `PlanName`, `Duration`, `Days`, `Price`, `PostingDate`, `UpdationDate`, `Is_Active` FROM `tblplan` WHERE Is_Active = 1");
                            while ($row = mysqli_fetch_array($query)) {
                                ?>
                                <div class="col-sm-4">
                                    <div class="card-box">
                                        <div class="card card-custom p-4 bg-white">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <h5 class="mb-0"><?php echo htmlentities($row['PlanName']); ?></h5>
                                                </div>
                                                <span class="status-badge">Active</span>
                                            </div>
                                            <small class="text-muted">Weight gain and Cardio</small>
                                            <h2>₹<?php echo htmlentities($row['Price']); ?><span
                                                    style="font-size:15px">/month</span></h2>
                                            <hr>
                                            <div class="info-line"><span><i class="fa-solid fa-circle-check"
                                                        style="color:green"></i>
                                                    <?php echo htmlentities($row['Duration']); ?></span></div>
                                            <div class="info-line"><span><i class="fa-solid fa-circle-check"
                                                        style="color:green"></i> Gym Equipment
                                                    Access</span></div>
                                            <div class="info-line"><span><i class="fa-solid fa-circle-check"
                                                        style="color:green"></i>
                                                    Group Classes</span></div>
                                            <div class="info-line"><span><i class="fa-solid fa-circle-check"
                                                        style="color:green"></i>
                                                    Nutrition Consultation</span></div>
                                            <div class="info-line"><span><i class="fa-solid fa-circle-check"
                                                        style="color:green"></i>
                                                    Locker Room</span></div>
                                            <hr>
                                            <div class="mb-3"><small>Available in all branches</small></div>
                                            <div class="d-flex justify-content-between card-footer-btns">
                                                <a href="#" class="btn btn-primary btn-custom">View Package</a>
                                                <a href="#" class="text-secondary editPackageBtn"
                                                    data-id="<?php echo $row['id']; ?>"
                                                    data-name="<?php echo htmlentities($row['PlanName']); ?>"
                                                    data-duration="<?php echo htmlentities($row['Duration']); ?>"
                                                    data-days="<?php echo htmlentities($row['Days']); ?>"
                                                    data-price="<?php echo htmlentities($row['Price']); ?>" data-toggle="modal"
                                                    data-target="#addPackageModal">Edit Package</a>
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

        <!-- Add/Edit Package Modal -->
        <div class="modal fade custom-modal-rounded" id="addPackageModal" tabindex="-1" role="dialog"
            aria-labelledby="addPackageModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="POST">
                    <div class="modal-content rounded-lg">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPackageModalLabel"><span class="icon-bg"><i
                                        class="fa-solid fa-chart-simple fa-2x"></i></span> Add New Package</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="package_id" id="package_id">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="packageName"><i class="fa-solid fa-chart-simple"></i> Package
                                            Name</label>
                                        <input type="text" class="form-control" name="package_name" id="packageName"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="packageDuration"><i class="fa-regular fa-clock"></i> Duration</label>
                                        <select class="form-control" name="package_duration" id="packageDuration" required>
                                            <option value="">Select Duration</option>
                                            <option value="1 Month">1 Month</option>
                                            <option value="3 Month">3 Month</option>
                                            <option value="6 Month">6 Month</option>
                                            <option value="1 Year">1 Year</option>
                                            <option value="2 Year">2 Year</option>
                                            <option value="3 Year">3 Year</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group m-b-20">
                                    <label for="packageDays"><i class="fa-regular fa-clock"></i> Days</label>
                                    <select class="form-control" name="package_days" id="packageDays" required></select>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="packagePrice"><i class="fa-solid fa-money-bill-1"></i> Price</label>
                                        <input type="text" class="form-control" id="packagePrice" name="package_price"
                                            required>
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

        <!-- JS Scripts -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <script src="https://kit.fontawesome.com/ae115648d7.js" crossorigin="anonymous"></script>

        <script>
            // Add Package - reset form
            $(document).on("click", ".btnAddPackage", function () {
                $("#package_id").val("");
                $("#packageName").val("");
                $("#packageDuration").val("");
                $("#packageDays").val("");
                $("#packagePrice").val("");
                $(".modal-title").text("Add New Package");
                $("button[name=submit]").text("Save Package");
            });

            // Edit Package - fill form
            $(document).on("click", ".editPackageBtn", function () {
                $("#package_id").val($(this).data("id"));
                $("#packageName").val($(this).data("name"));
                $("#packageDuration").val($(this).data("duration"));
                $("#packageDays").val($(this).data("days"));
                $("#packagePrice").val($(this).data("price"));
                $(".modal-title").text("Edit Package");
                $("button[name=submit]").text("Update Package");
            });

            // Populate Days dropdown
            const daysDropdown = document.getElementById("packageDays");
            for (let i = 1; i <= 31; i++) {
                const option = document.createElement("option");
                option.value = i + " Days";
                option.textContent = i + (i === 1 ? " Day" : " Days");
                daysDropdown.appendChild(option);
            }
        </script>
    </body>

    </html>
<?php } ?>
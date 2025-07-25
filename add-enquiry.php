<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $enquiryfor = $_POST['enquiryfor'];
        $enquiryon = $_POST['enquiryon'];
        $status = 1;
        $query = mysqli_query($con, "insert into tblenquiry(FirstName,LastName,Email,Number,EnquiryFor,EnquiryOn,Is_Active) values('$fname','$lname','$email','$number','$enquiryfor','$enquiryon','$status')");
        if ($query) {
            $msg = "Enquiry successfully added.";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }


    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Gym Dashboard | Add Enquiry</title>

        <!-- App css -->
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

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <?php include('includes/topheader.php'); ?>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
            <?php include('includes/leftsidebar.php'); ?>
            <!-- Left Sidebar End -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">


                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Add Enquiry</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Admin</a>
                                        </li>
                                        <li>
                                            <a href="#">Enquiry </a>
                                        </li>
                                        <li class="active">
                                            Add Enquiry
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <?php include('alert_message.php'); ?>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-sm-12">

                            <div class="row">
                                <div class="col-md-6">
                                    <form class="form-horizontal" name="category" method="post">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Name</label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" value="" name="fname" required>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" value="" name="lname" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Email Id</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="" name="email" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Contact Number</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="" name="number" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Enquiry For</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="" name="enquiryfor" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Enquiry On</label>
                                            <div class="col-md-9">
                                                <input type="date" class="form-control" value="" name="enquiryon" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Reference</label>
                                            <div class="col-md-9">
                                                <select class="form-control" id="referenceSelect">
                                                    <option value="Walk In">Walk In</option>
                                                    <option value="Social Media">Social Media</option>
                                                    <option value="Advertisement">Advertisement</option>
                                                    <option value="Banner">Banner</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div id="otherReferenceDiv" style="display: none; margin-top: 10px;">
                                                <input type="text" class="form-control" id="otherReferenceText"
                                                    placeholder="Enter Reference">
                                                <button type="button" class="btn btn-sm btn-success mt-2"
                                                    id="saveReferenceBtn">Save</button>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-2 control-label">&nbsp;</label>
                                            <div class="form-group text-right">
                                                <button type="submit" class="btn btn-custom waves-effect waves-light btn-md"
                                                    name="submit">
                                                    Submit
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
        <?php include('includes/footer.php'); ?>



        </div>
        </div>
        <script>
            var resizefunc = [];
        </script>
        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="../plugins/switchery/switchery.min.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <!-- <script>
            $('#referenceSelect').on('change', function () {
                let selected = $(this).val();
                if (selected === 'User' || selected === 'Person') {
                    $('#referenceModal').modal('show');
                }
            });

            $('#referenceForm').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: 'add_reference.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        alert(response);
                        $('#referenceModal').modal('hide');
                        $('#referenceForm')[0].reset();
                    },
                    error: function () {
                        alert('Error saving reference.');
                    }
                });
            });
        </script> -->
        <script>
            document.getElementById("referenceSelect").addEventListener("change", function () {
                var selected = this.value;
                var otherDiv = document.getElementById("otherReferenceDiv");
                if (selected === "Other") {
                    otherDiv.style.display = "block";
                } else {
                    otherDiv.style.display = "none";
                }
            });
        </script>
        <script>
            document.getElementById("saveReferenceBtn").addEventListener("click", function () {
                var reference = document.getElementById("otherReferenceText").value.trim();
                if (reference === "") {
                    alert("Please enter a reference name.");
                    return;
                }

                // AJAX
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "insert_reference.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        if (xhr.responseText === "success") {
                            alert("Reference saved!");
                            document.getElementById("referenceSelect").innerHTML += `<option value="${reference}" selected>${reference}</option>`;
                            document.getElementById("otherReferenceDiv").style.display = "none";
                            document.getElementById("otherReferenceText").value = "";
                        } else {
                            alert("Error saving reference.");
                        }
                    }
                };
                xhr.send("reference=" + encodeURIComponent(reference));
            });
        </script>



    </body>

    </html>
<?php } ?>
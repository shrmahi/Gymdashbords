<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if ($_GET['action'] == 'del' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        $query = mysqli_query($con, "update tblenquiry set Is_Active='0' where id='$id'");
        $msg = "Category deleted ";
    }

    if ($_GET['resid']) {
        $id = intval($_GET['resid']);
        $query = mysqli_query($con, "update tblenquiry set Is_Active='1' where id='$id'");
        $msg = "Category restored successfully";
    }

    if ($_GET['action'] == 'parmdel' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        $query = mysqli_query($con, "delete from tblenquiry where id='$id'");
        $delmsg = "Category deleted forever";
    }

    // Month filter logic
    $selectedMonth = isset($_GET['month']) ? $_GET['month'] : '';
    if ($selectedMonth) {
        $start_date = $selectedMonth . "-01";
        $end_date = date("Y-m-t", strtotime($start_date));
        $query = mysqli_query($con, "SELECT id, FirstName, LastName, Email, Number, EnquiryFor, EnquiryOn 
                                     FROM tblenquiry 
                                     WHERE Is_Active=1 AND EnquiryOn BETWEEN '$start_date' AND '$end_date'");
    } else {
        $query = mysqli_query($con, "SELECT id, FirstName, LastName, Email, Number, EnquiryFor, EnquiryOn 
                                     FROM tblenquiry WHERE Is_Active=1");
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Gym Dashboard | Manage Enquiry</title>
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
                                    <h4 class="page-title">Manage Enquiry</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li><a href="#">Admin</a></li>
                                        <li><a href="#">Enquiry</a></li>
                                        <li class="active">Manage Enquiry</li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Form -->
                        <form method="get" class="form-inline mb-4">
                            <label for="month" class="mr-2">Filter by Month:</label>
                            <input type="month" name="month" id="month" class="form-control mr-2"
                                value="<?php echo htmlentities($selectedMonth); ?>" required>
                            <button type="submit" class="btn btn-filter">Filter</button>
                            <a href="manage-enquiry.php" class="btn btn-reset ml-2" style="color: white;">Reset</a>
                        </form>

                        <!-- Alert Messages -->
                        <div class="row">
                            <div class="col-sm-6">
                            <div class="alert-container">
                                            <?php if ($msg) { ?>
                                            <div class="alert alert-success alert-dismissible fade in" role="alert">
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <strong>Well done!</strong>
                                                <?php echo htmlentities($msg); ?>
                                            </div>
                                            <?php } ?>

                                            <?php if ($error) { ?>
                                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <strong>Oh snap!</strong>
                                                <?php echo htmlentities($error); ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                            </div>
                        </div>

                        <!-- Enquiry Table -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="demo-box m-t-20">
                                    <div class="m-b-30 d-flex gap-2">
                                        <a href="add-enquiry.php">
                                            <button id="addToTable" class="btn btn-success waves-effect waves-light">
                                                Add <i class="mdi mdi-plus-circle-outline"></i>
                                            </button>
                                        </a>
                                        <button id="printPDF" class="btn btn-info waves-effect waves-light">
                                            Print PDF <i class="mdi mdi-printer"></i>
                                        </button>
                                    </div>

                                    <div class="table-responsive" id="enquiryTablePDF">
                                        <table class="table m-0 table-colored-bordered table-bordered-primary">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Number</th>
                                                    <th>EnquiryFor</th>
                                                    <th>EnquiryOn</th>
                                                    <th class="no-pdf">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                        <td><?php echo htmlentities($row['FirstName'] . ' ' . $row['LastName']); ?>
                                                        </td>
                                                        <td><?php echo htmlentities($row['Email']); ?></td>
                                                        <td><?php echo htmlentities($row['Number']); ?></td>
                                                        <td><?php echo htmlentities($row['EnquiryFor']); ?></td>
                                                        <td><?php echo htmlentities($row['EnquiryOn']); ?></td>
                                                        <td class="no-pdf">
                                                            <a
                                                                href="edit-enquiry.php?cid=<?php echo htmlentities($row['id']); ?>">
                                                                <i class="fa fa-pencil" style="color: #29b6f6;"></i>
                                                            </a>
                                                            &nbsp;
                                                            <a
                                                                href="manage-enquiry.php?rid=<?php echo htmlentities($row['id']); ?>&&action=del">
                                                                <i class="fa fa-trash-o" style="color: #f05050"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $cnt++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                    </div> <!-- container -->
                </div> <!-- content -->
                <?php include('includes/footer.php'); ?>
            </div>
        </div> <!-- END wrapper -->

        <script>
            var resizefunc = [];
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

        <!-- jsPDF and html2canvas -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

        <script>
            document.getElementById('printPDF').addEventListener('click', function () {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF('p', 'pt', 'a4');
                const source = document.getElementById("enquiryTablePDF");

                // Hide action column
                const elements = document.querySelectorAll('.no-pdf');
                elements.forEach(el => el.style.display = 'none');

                html2canvas(source, { scale: 2 }).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const imgProps = doc.getImageProperties(imgData);
                    const pdfWidth = doc.internal.pageSize.getWidth();
                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                    doc.addImage(imgData, 'PNG', 10, 10, pdfWidth - 20, pdfHeight);
                    doc.save("Enquiry_List.pdf");

                    // Restore action column
                    elements.forEach(el => el.style.display = '');
                });
            });
        </script>


    </body>

    </html>
<?php } ?>
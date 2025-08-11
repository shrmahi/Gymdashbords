<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
} else {
    // Delete
    if ($_GET['action'] == 'del' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        mysqli_query($con, "UPDATE tblplan SET Is_Active='0' WHERE id='$id'");
        $msg = "Plan deleted";
    }

    // Restore
    if ($_GET['resid']) {
        $id = intval($_GET['resid']);
        mysqli_query($con, "UPDATE tblplan SET Is_Active='1' WHERE id='$id'");
        $msg = "Plan restored successfully";
    }

    // Permanent delete
    if ($_GET['action'] == 'parmdel' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        mysqli_query($con, "DELETE FROM tblplan WHERE id='$id'");
        $delmsg = "Plan deleted forever";
    }
    // Limit per page
    $limit = 5;

    // Get current page from URL, default is 1
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    // Fetch limited data
    $query = mysqli_query($con, "SELECT * FROM tblplan WHERE Is_Active = 1 ORDER BY id DESC LIMIT $limit OFFSET $offset");

    // Count total records
    $totalQuery = mysqli_query($con, "SELECT COUNT(*) AS total FROM tblplan WHERE Is_Active = 1");
    $totalRow = mysqli_fetch_assoc($totalQuery);
    $totalRecords = $totalRow['total'];
    $totalPages = ceil($totalRecords / $limit);
    
    ?>

<!DOCTYPE html>
<html lang="en">
    <head>

        <title>Gym Dashboard | Manage Plan</title>
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
<?php include('includes/topheader.php');?>

            <!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">


                        <div class="row">
							<div class="col-xs-12">
								<div class="page-title-box">
                                    <h4 class="page-title">Manage Plan</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Admin</a>
                                        </li>
                                        <li>
                                            <a href="#">Plan </a>
                                        </li>
                                        <li class="active">
                                           Manage Plan
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
                        <!-- end row -->


<div class="row">
<div class="col-sm-6">  
 
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
                                 
                                 
                                    


                                   


                                    <div class="row">
										<div class="col-md-12">
											<div class="demo-box m-t-20">
                                            <div class="m-b-30">
                                            <a href="add-plan.php">
                                            <button id="addToTable" class="btn btn-success waves-effect waves-light"> <i class="mdi mdi-plus-circle-outline" ></i> Add Plan</button>
                                            </a>
                                            </div>
                                            <br/>

												<div class="table-responsive">
                                                    <table class="table m-0 table-colored-bordered table-bordered-primary table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th> Package Name</th>
                                                                <th>Duration</th>
                                                                <th>Price </th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
<?php 
$query=mysqli_query($con,"Select id,PlanName,Duration,Days,Price from  tblplan where Is_Active=1");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>

 <tr>
<th scope="row"><?php echo htmlentities($cnt);?></th>
<td><?php echo htmlentities($row['PlanName']);?></td>
<td><?php echo htmlentities($row['Duration']);?> &nbsp; <?php echo htmlentities($row['Days']); ?></td>
<td><?php echo htmlentities($row['Price']);?></td>
<td><a href="edit-plan.php?cid=<?php echo htmlentities($row['id']);?>"><i class="fa fa-pencil" style="color: #29b6f6;"></i></a> 
	&nbsp;<a href="manage-plan.php?rid=<?php echo htmlentities($row['id']);?>&&action=del"> <i class="fa fa-trash-o" style="color: #f05050"></i></a> </td>
</tr>
<?php
$cnt++;
 } ?>
</tbody>
                                                  
                                                    </table>
                                                    <br/>
                                                    <br/>
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
                                    <!--- end row -->


                                    
<div class="row">
<div class="col-md-12">
<div class="demo-box m-t-20">
<div class="m-b-30">

 <h4><i class="fa fa-trash-o" ></i> Deleted Plan</h4>

 </div>

<div class="table-responsive">
<table class="table m-0 table-colored-bordered table-bordered-danger">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th> PlanName</th>
                                                                <th>Duration</th>
                                                                <th>Price</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
<?php 
$query=mysqli_query($con,"Select id,PlanName,Duration,Days,Price from  tblplan where Is_Active=0");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>

 <tr>
<th scope="row"><?php echo htmlentities($cnt);?></th>
<td><?php echo htmlentities($row['PlanName']);?></td>
<td><?php echo htmlentities($row['Duration']);?> &nbsp; <?php echo htmlentities($row['Days']); ?> </td>
<td><?php echo htmlentities($row['Price']);?></td>
<td><a href="manage-plan.php?resid=<?php echo htmlentities($row['id']);?>"><i class="ion-arrow-return-right" title="Restore this category"></i></a> 
	&nbsp;<a href="manage-plan.php?rid=<?php echo htmlentities($row['id']);?>&&action=parmdel" title="Delete forever"> <i class="fa fa-trash-o" style="color: #f05050"></i> </td>
</tr>
<?php
$cnt++;
 } ?>
</tbody>
                                                  
                                                    </table>
                                                </div>



                                                
											</div>

										</div>

							
									</div>                  
                                  



                                   






                        






                    </div> <!-- container -->

                </div> <!-- content -->
<?php include('includes/footer.php');?>
            </div>

        </div>
        <!-- END wrapper -->



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

    </body>
</html>
<?php } ?>
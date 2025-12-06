<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
if(isset($_POST['update']))
{

$imgfile=$_FILES["postimage"]["name"];
// get the image extension
$extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));
// allowed extensions
$allowed_extensions = array(".jpg","jpeg",".png",".gif");
// Validation for allowed extensions .in_array() function searches an array for a specific value.
if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['update'])) {
        $maxSize = 2 * 1024 * 1024; // 2 MB
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

        if (!isset($_FILES['postimage']) || $_FILES['postimage']['error'] !== UPLOAD_ERR_OK) {
            $error = "No file uploaded or upload error.";
        } else {
            $tmpName = $_FILES['postimage']['tmp_name'];
            $origName = $_FILES['postimage']['name'];
            $fileSize = $_FILES['postimage']['size'];

            $imgInfo = @getimagesize($tmpName);
            if ($imgInfo === false) {
                $error = "Uploaded file is not a valid image.";
            } else {
                $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
                if (!in_array($ext, $allowed_ext)) {
                    $error = "Invalid file extension. Only jpg, jpeg, png, gif allowed.";
                } elseif ($fileSize > $maxSize) {
                    $error = "File is too large. Maximum size is 2 MB.";
                } else {
                    $imgnewfile = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
                    $targetDir = __DIR__ . DIRECTORY_SEPARATOR . 'postimages' . DIRECTORY_SEPARATOR;
                    if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0755, true);
                    }
                    $targetPath = $targetDir . $imgnewfile;

                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $postid = intval($_GET['pid']);

                        $oldQ = mysqli_query($con, "SELECT PostImage FROM tblposts WHERE id='$postid' LIMIT 1");
                        if ($oldQ && $oldR = mysqli_fetch_array($oldQ)) {
                            $oldFile = $oldR['PostImage'];
                            if ($oldFile) {
                                $oldPath = $targetDir . $oldFile;
                                if (file_exists($oldPath)) {
                                    @unlink($oldPath);
                                }
                            }
                        }

                        $imgnewfile_sql = mysqli_real_escape_string($con, $imgnewfile);
                        $query = mysqli_query($con, "UPDATE tblposts SET PostImage='$imgnewfile_sql' WHERE id='$postid'");
                        if ($query) {
                            $msg = "Post Feature Image updated";
                        } else {
                            $error = "Database update failed. Please try again.";
                        }
                    } else {
                        $error = "Failed to move uploaded file.";
                    }
                }
            }
        }
    }
?>
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
                                    <h4 class="page-title">Update Image </h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Admin</a>
                                        </li>
                                        <li>
                                            <a href="#"> Posts </a>
                                        </li>
                                           <li>
                                            <a href="#"> Edit Posts </a>
                                        </li>
                                        <li class="active">
                                           Update Image
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
                        <!-- end row -->

<div class="row">
<div class="col-sm-6">  
<!---Success Message--->  
<?php if($msg){ ?>
<div class="alert alert-success" role="alert">
<strong>Well done!</strong> <?php echo htmlentities($msg);?>
</div>
<?php } ?>

<!---Error Message--->
<?php if($error){ ?>
<div class="alert alert-danger" role="alert">
<strong>Oh snap!</strong> <?php echo htmlentities($error);?></div>
<?php } ?>


</div>
</div>
<form name="addpost" method="post" enctype="multipart/form-data">
<?php
$postid=intval($_GET['pid']);
$query=mysqli_query($con,"select PostImage,PostTitle from tblposts where id='$postid' and Is_Active=1 ");
while($row=mysqli_fetch_array($query))
{
?>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="p-6">
                                    <div class="">
                                        <form name="addpost" method="post">
 <div class="form-group m-b-20">
<label for="exampleInputEmail1">Post Title</label>
<input type="text" class="form-control" id="posttitle" value="<?php echo htmlentities($row['PostTitle']);?>" name="posttitle"  readonly>
</div>



 <div class="row">
<div class="col-sm-12">
 <div class="card-box">
<h4 class="m-b-30 m-t-0 header-title"><b>Current Post Image</b></h4>
<img src="postimages/<?php echo htmlentities($row['PostImage']);?>" width="300"/>
<br />

</div>
</div>
</div>

<?php } ?>
<div class="row">
<div class="col-sm-12">
 <div class="card-box">
<h4 class="m-b-30 m-t-0 header-title"><b>New Feature Image</b></h4>
<input type="file" class="form-control" id="postimage" name="postimage"  required>
</div>
</div>
</div>

<button type="submit" name="update" class="btn btn-success waves-effect waves-light">Update </button>
</form>
                                    </div>
                                </div> <!-- end p-20 -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->



                    </div> <!-- container -->

                </div> <!-- content -->

           <?php include('includes/footer.php');?>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


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

        <!--Summernote js-->
        <script src="../plugins/summernote/summernote.min.js"></script>
        <!-- Select 2 -->
        <script src="../plugins/select2/js/select2.min.js"></script>
        <!-- Jquery filer js -->
        <script src="../plugins/jquery.filer/js/jquery.filer.min.js"></script>

        <!-- page specific js -->
        <script src="assets/pages/jquery.blog-add.init.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>


  <script src="../plugins/switchery/switchery.min.js"></script>

        <!--Summernote js-->
        <script src="../plugins/summernote/summernote.min.js"></script>



    </body>
</html>
<?php } ?>
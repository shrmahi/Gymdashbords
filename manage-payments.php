<?php
session_start();
include('includes/config.php');

// Prevent back button access after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

if (!isset($_SESSION['login']) || strlen($_SESSION['login']) == 0) {
    header('Location: index.php');
    exit();
}
$userEmail = $_SESSION['login'];
$query = mysqli_query($con, "SELECT FirstName FROM tblstaff WHERE Email='$userEmail' LIMIT 1");

if ($row = mysqli_fetch_assoc($query)) {
    $_SESSION['username'] = $row['FirstName']; // Store name in session
} else {
    $_SESSION['username'] = 'User'; // Fallback name
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Payment Management - Gym Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/core.css" rel="stylesheet" />
    <link href="assets/css/components.css" rel="stylesheet" />
    <link href="assets/css/icons.css" rel="stylesheet" />
    <link href="assets/css/pages.css" rel="stylesheet" />
    <link href="assets/css/menu.css" rel="stylesheet" />
    <link href="assets/css/responsive.css" rel="stylesheet" />
    <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">

    <script src="assets/js/modernizr.min.js"></script>
    
    <style>
        .summary-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        
        .summary-card .icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 2.5rem;
            opacity: 0.1;
        }
        
        .summary-card .title {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 10px;
            font-weight: 500;
        }
        
        .summary-card .value {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .summary-card .change {
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .card-revenue {
            border-left: 4px solid #28a745;
        }
        
        .card-revenue .icon {
            color: #28a745;
        }
        
        .card-revenue .change {
            color: #28a745;
        }
        
        .card-pending {
            border-left: 4px solid #ffc107;
        }
        
        .card-pending .icon {
            color: #ffc107;
        }
        
        .card-pending .change {
            color: #fd7e14;
        }
        
        .card-overdue {
            border-left: 4px solid #dc3545;
        }
        
        .card-overdue .icon {
            color: #dc3545;
        }
        
        .card-overdue .change {
            color: #dc3545;
        }
        
        .card-methods {
            border-left: 4px solid #007bff;
        }
        
        .card-methods .icon {
            color: #007bff;
        }
        
        .card-methods .methods-list {
            color: #6c757d;
            font-size: 0.85rem;
        }
        
        .btn-record-payment {
            background: #28a745;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-record-payment:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }
        
        .payment-table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .payment-table .table-header {
            background: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .payment-table .table-header h4 {
            margin: 0;
            color: #495057;
            font-weight: 600;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
        }
        
        .status-completed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .method-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .method-card {
            background: #e3f2fd;
            color: #1565c0;
        }
        
        .method-online {
            background: #f3e5f5;
            color: #7b1fa2;
        }
        
        .method-cash {
            background: #e8f5e8;
            color: #2e7d32;
        }
        
        .action-link {
            color: #007bff;
            text-decoration: none;
            margin-right: 15px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .action-link:hover {
            text-decoration: underline;
        }
        
        .action-download {
            color: #28a745;
        }
        
        .action-refund {
            color: #fd7e14;
        }
        
        .receipt-link {
            color: #007bff;
            text-decoration: underline;
            font-weight: 500;
        }
        
        .receipt-link:hover {
            color: #0056b3;
        }
        
        .page-title-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 30px;
            border-radius: 10px;
        }
        
        .page-title-section h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .page-title-section p {
            margin: 10px 0 0 0;
            font-size: 1.1rem;
            opacity: 0.9;
        }
    </style>
</head>

<body class="fixed-left">
    <div id="wrapper">

        <!-- Top Bar -->
        <?php include('includes/topheader.php'); ?>

        <!-- Sidebar -->
        <?php include('includes/leftsidebar.php'); ?>

        <!-- Content -->
        <div class="content-page">
            <div class="content">
                <div class="container">

                    <!-- Page Title Section -->
                    <div class="page-title-section">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1>Payment Management</h1>
                                <p>Track payments, invoices, and financial transactions</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <button class="btn btn-record-payment">
                                    <i class="mdi mdi-bank mr-2"></i>
                                    Record Payment
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="summary-card card-revenue">
                                <div class="icon">
                                    <i class="mdi mdi-currency-usd"></i>
                                </div>
                                <div class="title">Total Revenue</div>
                                <div class="value">$84,000</div>
                                <div class="change">+12.5% this month</div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <div class="summary-card card-pending">
                                <div class="icon">
                                    <i class="mdi mdi-calendar-clock"></i>
                                </div>
                                <div class="title">Pending Payments</div>
                                <div class="value">$2,340</div>
                                <div class="change">Awaiting processing</div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <div class="summary-card card-overdue">
                                <div class="icon">
                                    <i class="mdi mdi-trending-up"></i>
                                </div>
                                <div class="title">Overdue Payments</div>
                                <div class="value">$890</div>
                                <div class="change">Requires attention</div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <div class="summary-card card-methods">
                                <div class="icon">
                                    <i class="mdi mdi-credit-card"></i>
                                </div>
                                <div class="title">Payment Methods</div>
                                <div class="value">4</div>
                                <div class="methods-list">Card, Online, Cash, Bank</div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Payments Table -->
                    <div class="payment-table">
                        <div class="table-header">
                            <h4>Recent Payments</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>MEMBER</th>
                                        <th>AMOUNT</th>
                                        <th>METHOD</th>
                                        <th>STATUS</th>
                                        <th>DATE</th>
                                        <th>RECEIPT</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle mr-3" width="40">
                                                <div>
                                                    <h6 class="mb-0">Alice Johnson</h6>
                                                    <small class="text-muted">Premium Member</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><strong>$79</strong></td>
                                        <td><span class="method-badge method-card">Card</span></td>
                                        <td><span class="status-badge status-completed">Completed</span></td>
                                        <td>2024-12-20</td>
                                        <td><a href="#" class="receipt-link">RCP-001</a></td>
                                        <td>
                                            <a href="#" class="action-link">View</a>
                                            <a href="#" class="action-link action-download">Download</a>
                                            <a href="#" class="action-link action-refund">Refund</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle mr-3" width="40">
                                                <div>
                                                    <h6 class="mb-0">Bob Smith</h6>
                                                    <small class="text-muted">Basic Member</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><strong>$49</strong></td>
                                        <td><span class="method-badge method-online">Online</span></td>
                                        <td><span class="status-badge status-pending">Pending</span></td>
                                        <td>2024-12-19</td>
                                        <td><a href="#" class="receipt-link">RCP-002</a></td>
                                        <td>
                                            <a href="#" class="action-link">View</a>
                                            <a href="#" class="action-link action-download">Download</a>
                                            <a href="#" class="action-link action-refund">Refund</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle mr-3" width="40">
                                                <div>
                                                    <h6 class="mb-0">Carol Davis</h6>
                                                    <small class="text-muted">Premium Member</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><strong>$129</strong></td>
                                        <td><span class="method-badge method-cash">Cash</span></td>
                                        <td><span class="status-badge status-completed">Completed</span></td>
                                        <td>2024-12-18</td>
                                        <td><a href="#" class="receipt-link">RCP-003</a></td>
                                        <td>
                                            <a href="#" class="action-link">View</a>
                                            <a href="#" class="action-link action-download">Download</a>
                                            <a href="#" class="action-link action-refund">Refund</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle mr-3" width="40">
                                                <div>
                                                    <h6 class="mb-0">David Wilson</h6>
                                                    <small class="text-muted">Basic Member</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><strong>$89</strong></td>
                                        <td><span class="method-badge method-card">Card</span></td>
                                        <td><span class="status-badge status-completed">Completed</span></td>
                                        <td>2024-12-17</td>
                                        <td><a href="#" class="receipt-link">RCP-004</a></td>
                                        <td>
                                            <a href="#" class="action-link">View</a>
                                            <a href="#" class="action-link action-download">Download</a>
                                            <a href="#" class="action-link action-refund">Refund</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle mr-3" width="40">
                                                <div>
                                                    <h6 class="mb-0">Emma Brown</h6>
                                                    <small class="text-muted">Premium Member</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><strong>$159</strong></td>
                                        <td><span class="method-badge method-online">Online</span></td>
                                        <td><span class="status-badge status-pending">Pending</span></td>
                                        <td>2024-12-16</td>
                                        <td><a href="#" class="receipt-link">RCP-005</a></td>
                                        <td>
                                            <a href="#" class="action-link">View</a>
                                            <a href="#" class="action-link action-download">Download</a>
                                            <a href="#" class="action-link action-refund">Refund</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div> <!-- container -->
            </div> <!-- content -->

            <!-- Footer -->
            <?php include('includes/footer.php'); ?>

        </div>
        <!-- End content-page -->

    </div>
    <!-- End wrapper -->

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.app.js"></script>

</body>
</html>

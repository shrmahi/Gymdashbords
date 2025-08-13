<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Navigation</li>

                <li class="has_sub">
                    <a href="dashboard.php" class="waves-effect"><i class="fa fa-house"></i> <span> Dashboard
                        </span> </a>

                </li>
                <!-- Admin only -->
                <?php if ($_SESSION['utype'] == '1'): ?>
                    <li class="has_sub">
                        <a href="manage-branches.php" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                            <span>Branches</span></a>
                    </li>
                    <li class="has_sub">
                        <a href="manage-memberlist.php" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i>
                            <span>Members</span></a>
                    </li>
                    <li class="has_sub">
                        <a href="manage-enquiry.php" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i>
                            <span>Leads & CRM</span> </a>
                    </li>
                    <li class="has_sub">
                        <a href="manage-package.php" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                            <span>Plan/ Package</span></a>
                    </li>
                    <li class="has_sub">
                        <a href="manage-payments.php" class="waves-effect"><i class="mdi mdi-credit-card"></i>
                            <span>Payments</span></a>
                    </li>
                    <li class="has_sub">
                        <a href="manage-analytics.php" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                            <span>Analytics</span></a>
                    </li>

                <?php endif; ?>
                <!-- Subadmin only -->
                <?php if ($_SESSION['utype'] == '2'): ?>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                            <span>Enquiry</span> <span class="menu-arrow"></span></a>
                    </li>
                <?php endif; ?>

                <li class="has_sub">
                    <a href="manage-settings.php" class="waves-effect"><i class="mdi mdi-wrench"></i>
                        <span>Settings</span></a>
                </li>


            </ul>
            <hr class="hr-bottom" style="margin-top:40%;" />
            <ul>
                <li><a href="logout.php" class="waves-effect"><i class="mdi mdi-account"></i>
                        <span><?php echo htmlentities($_SESSION['username']); ?></span></a></li>
                <li>
                    <a href="logout.php" class="waves-effect"><i class="mdi mdi-power"></i>
                        <span>Logout</span></a>
                </li>
            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>


    </div>
    <!-- Sidebar -left -->

</div>
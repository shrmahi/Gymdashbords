<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Navigation</li>

                <li class="has_sub">
                    <a href="dashboard.php" class="waves-effect"><i class="mdi mdi-view-dashboard"></i> <span> Dashboard
                        </span> </a>

                </li>

                <!-- Admin only -->
                <?php if ($_SESSION['utype'] == '1'): ?>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i>
                            <span>Members</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="add-member.php">Add Member</a></li>
                            <li><a href="manage-memberlist.php">Member List</a></li>
                            <li><a href="inactive-member.php">Inactive Member</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                            <span>Plan</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="add-plan.php">Add Plan</a></li>
                            <li><a href="manage-plan.php">All Plan</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                            <span>Masters</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li>
                                <a href="javascript:void(0);" class="waves-effect">
                                    <span>Shift</span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="add-shift.php">Add Shift</a></li>
                                    <li><a href="manage-shift.php">Manage Shift</a></li>
                                </ul>
                            </li>
                            <!-- <li>
                                <a href="javascript:void(0);" class="waves-effect">
                                    <span>Package</span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="add-package.php">Add Package</a></li>
                                    <li><a href="manage-package.php">Manage Package</a></li>
                                </ul>
                            </li> -->
                            <li>
                                <a href="javascript:void(0);" class="waves-effect">
                                    <span>Payment Mode</span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="add-paymode.php">Add Pay Mode</a></li>
                                    <li><a href="manage-paymode.php">Payment Mode List</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:void(0);" class="waves-effect">
                                    <span>Medical History</span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="add-medicalhist.php">Add Medical history</a></li>
                                    <li><a href="manage-medical.php">Medical List</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:void(0);" class="waves-effect">
                                    <span>Receipt</span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="add-receipt.php">Add Receipt</a></li>
                                    <li><a href="manage-receipt.php">Receipt List</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                            <span>Followups</span> <span class="menu-arrow"></span></a>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i>
                            <span>Enquiry</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="add-enquiry.php">Add Enquiry</a></li>
                            <li><a href="manage-enquiry.php">All Enquiry</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                            <span>Report</span> <span class="menu-arrow"></span></a>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                            <span>Personal Training</span> <span class="menu-arrow"></span></a>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i>
                            <span>Staff</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="add-staff.php">Add Staff</a></li>
                            <li><a href="manage-stafflist.php">Staff List</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                            <span>Services</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="add-services.php">Add Services</a></li>
                            <li><a href="manage-services.php">All Services</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="register-gym.php" class="waves-effect"><i class="mdi mdi-dumbbell"></i>
                            <span>GYM Register</span></a>
                    </li>
                <?php endif; ?>
                <!-- Subadmin only -->
                <?php if ($_SESSION['utype'] == '2'): ?>
                    <!-- <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                            <span>Enquiry</span> <span class="menu-arrow"></span></a>
                    </li> -->
                    <!-- <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                            <span>Report</span> <span class="menu-arrow"></span></a>
                    </li> -->
                    <!-- <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                            <span>Personal Training</span> <span class="menu-arrow"></span></a>
                    </li> -->
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                            <span>Enquiry</span> <span class="menu-arrow"></span></a>
                    </li>
                <?php endif; ?>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-wrench"></i>
                        <span>Settings</span></a>
                </li>
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
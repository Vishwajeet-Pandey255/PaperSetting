<script>
$(document).ready(function() {
    var classname = "<?php echo $this->uri->segment(2); ?>";

    // Remove 'active' from all links first
    $(".nav-link.menu-title").removeClass("active");
    $(".nav-submenu.menu-content").css("display", "none");

    // Add 'active' to the exact matching menu item
    $("." + classname).addClass("active");

    // If it's inside a submenu, also expand the parent
    $("." + classname).closest(".menu-content").css("display", "block");
});
</script>

<header class="main-nav">
    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">           
                <ul class="nav-menu custom-scrollbar" style="height: calc(100vh - 150px) !important;">
                    <li class="back-btn">
                        <div class="mobile-back text-end">
                            <span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                        </div>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6>General</h6>
                        </div>
                    </li>

                    <?php $MenuStatus = $this->uri->segment(2); ?>

                    <?php if (!isset($_SESSION['faculty'])) { ?>
                    
                    <!-- Admin Menu -->
                    <li class="dropdown">
                        <a class="nav-link menu-title Faculty PaperFormat setting Department Programme Subject" href="javascript:void(0)">
                            <i data-feather="airplay"></i><span>Masters</span>
                        </a>
                        <ul class="nav-submenu menu-content Faculty PaperFormat setting Department Programme Subject">
                            <li><a class="Faculty" href="<?php echo base_url();?>Admin_user/Faculty"><i data-feather="user"></i><span>Faculty</span></a></li>
                            <li><a class="Department" href="<?php echo base_url();?>Admin_user/Department"><i data-feather="home"></i><span>Department</span></a></li>
                            <li><a class="Programme" href="<?php echo base_url();?>Admin_user/Programme"><i data-feather="home"></i><span>Programme</span></a></li>
                            <li><a class="Subject" href="<?php echo base_url();?>Admin_user/Subject"><i data-feather="home"></i><span>Subject</span></a></li>
                            <li><a class="PaperFormat" href="<?php echo base_url();?>Admin_user/PaperFormat"><i data-feather="book"></i><span>Paper Format</span></a></li>
                            <li><a class="setting" href="<?php echo base_url();?>Admin_user/setting"><i data-feather="settings"></i><span>Setting</span></a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link menu-title AssignPaper" href="<?php echo base_url();?>Admin_user/AssignPaper"><i data-feather="book"></i><span>Assign Paper</span></a>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link menu-title PaperForApproval" href="<?php echo base_url();?>Admin_user/PaperForApproval"><i data-feather="check-circle"></i><span>Paper For Approval</span></a>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link menu-title PaperPreview" href="<?php echo base_url();?>Admin_user/PaperPreview"><i data-feather="eye"></i><span>Paper Preview</span></a>
                    </li>
            <li class="dropdown">
    <a class="nav-link menu-title PaperChecking" href="<?php echo base_url();?>Admin_user/PaperChecking">
        <i data-feather="check-square"></i><span>Assign Paper Checking</span>
    </a>
</li>



                    <?php } else { ?>

                    <!-- Faculty Menu -->
                    <li>
                        <a class="nav-link menu-title UserProfile" href="<?php echo base_url();?>Faculty/UserProfile">
                            <i data-feather="user"></i><span>User Profile</span>
                        </a>
                    </li>

                    <li>
                        <a class="nav-link menu-title AssignPaperList" href="<?php echo base_url();?>Faculty/AssignPaperList">
                            <i data-feather="book"></i><span>Assign Paper List</span>
                        </a>
                    </li>

                    <li>
                        <a class="nav-link menu-title ChangePassword" href="<?php echo base_url();?>Faculty/ChangePassword">
                            <i data-feather="lock"></i><span>Change Password</span>
                        </a>
                    </li>
                     <li>
    <a class="nav-link menu-title AssignPaperChecking" href="<?php echo base_url(); ?>Faculty/AssignPaperChecking">
        <i data-feather="check-square"></i><span>Assign Paper Checking</span>
    </a>
</li>


                    <?php } ?>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>

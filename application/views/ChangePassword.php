<html lang="en">
<?php include("AdminMeta.php"); ?>

<body>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php include("AdminHeader.php"); ?>

        <div class="page-body-wrapper sidebar-icon">
            <?php include("AdminSidebar.php"); ?>

            <div class="page-body">
                <div class="container-fluid">

                    <?php
                        $pgHeading = "Change Password";
                    ?>

                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5><?= ucfirst($pgHeading) ?></h5>
                                </div>

                                <div class="card-body">

                                    <?php
                                    // Flash message response
                                    $response = $this->session->flashdata('responce_message');
                                    if (is_array($response) && count($response) > 0) {
                                        echo show_notish($response['responce'], $response['message']);
                                    }
                                    ?>

                                    <form class="form-wizard" method="post" action="<?php echo base_url('Faculty/ChangePassword'); ?>">

                                        <input type="hidden" name="action" value="CHANGE_PASSWORD" />

                                        <div class="mb-3">
                                            <label class="form-label">Old Password</label>
                                            <input type="password" name="oldPassword" class="form-control"
                                                placeholder="Enter Old Password" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">New Password</label>
                                            <input type="password" name="newPassword" class="form-control"
                                                placeholder="Enter New Password" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" name="confirmPassword" class="form-control"
                                                placeholder="Confirm New Password" required>
                                        </div>

                                        <div class="text-end btn-mb">
                                            <button class="btn btn-primary" type="submit">Change Password</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div> <!-- row end -->

                </div>
            </div>
        </div>

        <?php include("AdminFooter.php"); ?>
    </div>
</body>

</html>

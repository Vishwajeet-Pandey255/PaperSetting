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
                $pgMod = "UserProfile";
                $pgAct = "view";
                $pgHeading = "User Profile";

                if (isset($_REQUEST['action']) && trim($_REQUEST['action']) != '')
                    $pgAct = strtolower($_REQUEST['action']);
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-header pb-0">
                                <h5><?= ucfirst($pgHeading) ?></h5>
                            </div>

                            <div class="card-body">

                                <?php if ($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger mb-3">
                                        <?= $this->session->flashdata('error'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($this->session->flashdata('success')): ?>
                                    <div class="alert alert-success mb-3">
                                        <?= $this->session->flashdata('success'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php
                                if (is_array($faculty_profile) && count($faculty_profile) > 0) {
                                    $profile = $faculty_profile[0];
                                ?>

                                <div class="table-responsive">

                                <?php if ($pgAct == "edit") { ?>
                                <form method="POST" 
                                      action="<?= site_url('Faculty/UserProfile?action=update&id='.$profile['Id']); ?>" 
                                      enctype="multipart/form-data">
                                <?php } ?>

                                <table class="table table-bordered">

                                    <tr><th>Name</th><td><?= $profile['Name']; ?></td></tr>
                                    <tr><th>Email</th><td><?= $profile['Email']; ?></td></tr>
                                    <tr><th>Phone</th><td><?= $profile['PhoneNumber']; ?></td></tr>
                                    <tr><th>Address</th><td><?= $profile['Address']; ?></td></tr>

                                    <tr>
                                        <th>Date of Joining</th>
                                        <td>
                                            <?php if ($pgAct == "edit") { ?>
                                                <input type="date" name="DateOfJoining" value="<?= $profile['DateOfJoining']; ?>" class="form-control">
                                            <?php } else echo $profile['DateOfJoining']; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Gender</th>
                                        <td>
                                            <?php if ($pgAct == "edit") { ?>
                                                <select name="Gender" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="Male" <?= ($profile['Gender']=="Male"?"selected":""); ?>>Male</option>
                                                    <option value="Female" <?= ($profile['Gender']=="Female"?"selected":""); ?>>Female</option>
                                                    <option value="Other" <?= ($profile['Gender']=="Other"?"selected":""); ?>>Other</option>
                                                </select>
                                            <?php } else echo $profile['Gender']; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Designation</th>
                                        <td>
                                            <?php if ($pgAct == "edit") { ?>
                                                <input type="text" name="Designation" value="<?= $profile['Designation']; ?>" class="form-control">
                                            <?php } else echo $profile['Designation']; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Experience (Years)</th>
                                        <td>
                                            <?php if ($pgAct == "edit") { ?>
                                                <input type="number" name="ExperienceYears" value="<?= $profile['ExperienceYears']; ?>" class="form-control">
                                            <?php } else echo $profile['ExperienceYears']; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Highest Qualification</th>
                                        <td>
                                            <?php if ($pgAct == "edit") { ?>
                                                <input type="text" name="HighestQualification" value="<?= $profile['HighestQualification']; ?>" class="form-control">
                                            <?php } else echo $profile['HighestQualification']; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Specialization</th>
                                        <td>
                                            <?php if ($pgAct == "edit") { ?>
                                                <input type="text" name="Specialization" value="<?= $profile['Specialization']; ?>" class="form-control">
                                            <?php } else echo $profile['Specialization']; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>
                                            <?php if ($pgAct == "edit") { ?>
                                                <input type="date" name="DateOfBirth" value="<?= $profile['DateOfBirth']; ?>" class="form-control">
                                            <?php } else echo $profile['DateOfBirth']; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Profile Image</th>
                                        <td>
                                            <?php if (!empty($profile['ProfileImage'])) { ?>
                                                <img src="<?= base_url('assets/Uploads/Profile/' . $profile['ProfileImage']); ?>" 
                                                     style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:1px solid #ddd;" />
                                            <?php } else echo "No Image Uploaded"; ?>

                                            <?php if ($pgAct == "edit") { ?>
                                                <input type="file" name="ProfileImage" class="form-control mt-2">
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Status</th>
                                        <td><?= ($profile['Status'] == 1) ? "Active" : "Inactive"; ?></td>
                                    </tr>

                                    <tr>
                                        <th>Action</th>
                                        <td>
                                            <?php if ($pgAct == "edit") { ?>
                                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                                                <a href="<?= site_url('Faculty/UserProfile'); ?>" class="btn btn-secondary">Cancel</a>
                                            <?php } else { ?>
                                                <a href="<?= site_url('Faculty/UserProfile?action=edit&id=' . $profile['Id']); ?>"
                                                   class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Edit</a>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                </table>

                                <?php if ($pgAct == "edit") { ?></form><?php } ?>

                                </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php include("AdminFooter.php");?>
</div>

<script>
setTimeout(function() {
    const alertBox = document.querySelector('.alert');
    if (alertBox) {
        alertBox.style.transition = "opacity 0.5s";
        alertBox.style.opacity = "0";
        setTimeout(() => alertBox.remove(), 500);
    }
}, 3000);
</script>

</body>
</html>

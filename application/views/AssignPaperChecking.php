<!DOCTYPE html>
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
                $pgMod = "Assigned Paper Checking";
                $pgAct = "view";
                $pgHeading = "Assigned Papers";
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h5><?= ucfirst($pgAct) . " " . ucfirst($pgHeading) ?></h5>
                            </div>
                            <div class="card-body">

                                <!-- Flash Messages -->
                                <?php if ($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger" style="margin-bottom: 15px;">
                                        <?= $this->session->flashdata('error'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($this->session->flashdata('success')): ?>
                                    <div class="alert alert-success" style="margin-bottom: 15px;">
                                        <?= $this->session->flashdata('success'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($CheckPaper)) { ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead style="background-color:#f0f0f0;">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Branch</th>
                                                    <th>Session</th>
                                                    <th>Barcode</th>
                                                    <th>Status</th>
                                                    <th>Last Date</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($CheckPaper as $row) { ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($row['Id']); ?></td>
                                                        <td><?= htmlspecialchars($row['Branch']); ?></td>
                                                        <td><?= htmlspecialchars($row['Session']); ?></td>
                                                        <td><?= htmlspecialchars($row['BarcodeNumber']); ?></td>

                                                        <td>
                                                            <?php
                                                                $status = strtolower($row['Status']);
                                                                if ($status == 'pending') { ?>
                                                                    <span class="btn btn-pill btn-warning txt-dark">
                                                                        <?= htmlspecialchars($row['Status']); ?>
                                                                    </span>
                                                                <?php } elseif ($status == 'checking') { ?>
                                                                    <span class="btn btn-pill btn-primary txt-dark">
                                                                        <?= htmlspecialchars($row['Status']); ?>
                                                                    </span>
                                                                <?php } elseif ($status == 'complete') { ?>
                                                                    <span class="btn btn-pill btn-success txt-dark">
                                                                        <?= htmlspecialchars($row['Status']); ?>
                                                                    </span>
                                                                <?php } else { ?>
                                                                    <span class="btn btn-pill btn-light txt-dark">
                                                                        <?= htmlspecialchars($row['Status']); ?>
                                                                    </span>
                                                            <?php } ?>
                                                        </td>

                                                        <td><?= htmlspecialchars($row['LastDate']); ?></td>
                                                        <td><?= htmlspecialchars($row['CreatedAt']); ?></td>

                                                        <td>
                                                            <!-- Updated View Button -->
                                                            <a href="<?= base_url('Faculty/ViewPaper/' . $row['Id']); ?>"
                                                               class="btn btn-info btn-sm">
                                                                View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="text-center text-danger" style="font-weight:bold;">
                                        No records found
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<?php include("AdminScript.php"); ?>

<script>
    setTimeout(function () {
        const alertBox = document.querySelector('.alert');
        if (alertBox) {
            alertBox.style.transition = "opacity 0.5s ease";
            alertBox.style.opacity = "0";
            setTimeout(() => alertBox.remove(), 500);
        }
    }, 3000);
</script>

</body>
</html>

<html lang="en">

<?php include("AdminMeta.php"); ?>

<body>
  <!-- page-wrapper Start -->
  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header -->
    <?php include("AdminHeader.php"); ?>
    <!-- Page Body -->
    <div class="page-body-wrapper sidebar-icon">
      <?php include("AdminSidebar.php"); ?>

      <div class="page-body">
        <div class="container-fluid">

          <?php
            $pgMod = "PaperChecking";
            $pgAct = "view";
            $pgHeading = "Paper Checking";

            if (isset($_REQUEST['action']) && trim($_REQUEST['action']) != '')
              $pgAct = strtolower($_REQUEST['action']);
          ?>

          <div class="row">
            <div class="col-md-12">
              <div class="card">

                <div class="card-header pb-0">
                  <h5><?= ucfirst($pgAct) . " " . ucfirst($pgHeading) ?>
                    <?php if ($pgAct != "edit") { ?>
                      <div class="box-tools pull-right" style="top: 3px;">
                        <a href="<?php echo site_url("Admin_user/PaperChecking?action=add") ?>" class="btn btn-primary">Add New</a>
                      </div>
                    <?php } ?>
                  </h5>
                </div>

                <div class="card-body">

                  <!-- Flash Messages -->
                  <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                  <?php endif; ?>

                  <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                  <?php endif; ?>

                  <?php if ($pgAct == "view") { ?>

                    <div class="table-responsive">
                      <table class="display datatables" id="dt-plugin-method">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Faculty</th>
                            <th>Branch</th>
                            <th>Session</th>
                            <th>Barcode</th>
                            <th>Paper</th>
                            <th>Last Date</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                          if (is_array($PaperChecking_data) && count($PaperChecking_data) > 0) {
                            foreach ($PaperChecking_data as $row) {
                              // normalize status
                              $statusVal = $row['Status'];
                              $isDone = ($statusVal === "1" || strtolower($statusVal) === "completed" || $statusVal === 1);
                          ?>
                              <tr class="record_<?= htmlspecialchars($row['Id'] ?? $row['id']); ?>">
                                <td><?= htmlspecialchars($row['Id'] ?? $row['id']); ?></td>
                                <td><?= htmlspecialchars($row['FacultyId']); ?></td>
                                <td><?= htmlspecialchars($row['Branch']); ?></td>
                                <td><?= htmlspecialchars($row['Session']); ?></td>
                                <td><?= htmlspecialchars($row['BarcodeNumber']); ?></td>

                                <td>
                                  <?php if (!empty($row['PaperUpload'])) { ?>
                                  <a href="<?= base_url('assets/Uploads/PaperChecking/' . $row['PaperUpload']); ?>" target="_blank" class="btn btn-info btn-sm">View File</a>

                                  <?php } else { ?>
                                    <small class="text-muted">No file</small>
                                  <?php } ?>
                                </td>

                                <td><?= !empty($row['LastDate']) ? htmlspecialchars($row['LastDate']) : '-'; ?></td>
                                <td><?= !empty($row['CreatedAt']) ? htmlspecialchars($row['CreatedAt']) : (!empty($row['created_at'])?htmlspecialchars($row['created_at']):'-'); ?></td>
                                <td><?= !empty($row['UpdatedAt']) ? htmlspecialchars($row['UpdatedAt']) : (!empty($row['updated_at'])?htmlspecialchars($row['updated_at']):'-'); ?></td>

                                <td>
                                  <?php if ($isDone) { ?>
                                    <span class="btn btn-pill btn-light-gradien txt-dark"><b>Completed</b></span>
                                  <?php } else { ?>
                                    <span class="btn btn-pill btn-danger"><b>Pending</b></span>
                                  <?php } ?>
                                </td>

                                <td>
                                  <a href="<?php echo site_url('Admin_user/PaperChecking?action=edit&id=' . ($row['Id'] ?? $row['id'])); ?>" class="btn btn-pill btn-primary" title="Edit"><i class="fa fa-pencil-square-o"></i></a>

                                  <a href="javascript:;" onclick="if(confirm('Delete this record?')) location.href='<?= site_url('Admin_user/PaperChecking?action=delete&id=' . ($row['Id'] ?? $row['id'])); ?>';" class="btn btn-pill btn-danger" title="Delete"><i class="fa fa-trash-o"></i></a>
                                </td>
                              </tr>
                          <?php
                            }
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>

                  <?php } elseif ($pgAct == "add" || $pgAct == "edit") {

                    // get existing data when editing
                    $editData = array();
                    if ($pgAct == 'edit' && isset($get_PaperChecking_data) && is_array($get_PaperChecking_data) && count($get_PaperChecking_data) > 0) {
                      $editData = $get_PaperChecking_data[0];
                    }
                  ?>

                    <form class="form-wizard" enctype="multipart/form-data" id="paperchecking_form" method="post" action="<?php echo site_url("Admin_user/action_PaperChecking") ?>">

                      <input type="hidden" name="action" value="<?= ($pgAct == 'edit') ? 'EDIT' : 'ADD'; ?>" />
                      <input type="hidden" name="id" value="<?= ($pgAct == 'edit') ? htmlspecialchars($editData['Id'] ?? $editData['id']) : ''; ?>" />

                      <div class="row">

                        <div class="form-group col-md-4">
                          <label for="FacultyId">Faculty</label>
                          <select name="FacultyId" id="FacultyId" class="form-control" required>
                            <option value="">Please Select Faculty</option>
                            <?php if (is_array($faculty_data) && count($faculty_data) > 0) {
                              foreach ($faculty_data as $f) { ?>
                                <option value="<?= htmlspecialchars($f['Id']); ?>" <?= ($pgAct == 'edit' && isset($editData['FacultyId']) && $editData['FacultyId'] == $f['Id']) ? 'selected' : ''; ?>>
                                  <?= htmlspecialchars($f['Name']); ?>
                                </option>
                            <?php }
                            } ?>
                          </select>
                        </div>

                        <div class="form-group col-md-4">
                          <label for="Branch">Branch</label>
                          <input type="text" name="Branch" id="Branch" class="form-control" required value="<?= htmlspecialchars($editData['Branch'] ?? ''); ?>">
                        </div>

                        <div class="form-group col-md-4">
                          <label for="Session">Session</label>
                          <input type="text" name="Session" id="Session" class="form-control" required value="<?= htmlspecialchars($editData['Session'] ?? ''); ?>">
                        </div>

                        <div class="form-group col-md-4">
                          <label for="BarcodeNumber">Barcode Number</label>
                          <input type="text" name="BarcodeNumber" id="BarcodeNumber" class="form-control" required value="<?= htmlspecialchars($editData['BarcodeNumber'] ?? ''); ?>">
                        </div>

                        <div class="form-group col-md-4">
                          <label for="LastDate">Last Date</label>
                          <input type="date" name="LastDate" id="LastDate" class="form-control" required value="<?= !empty($editData['LastDate']) ? htmlspecialchars($editData['LastDate']) : ''; ?>">
                        </div>

                        <div class="form-group col-md-4">
                          <label for="PaperUpload">Upload Paper (PDF / Image)</label>
                          <input type="file" name="PaperUpload" id="PaperUpload" accept="application/pdf,image/*" class="form-control" <?= ($pgAct == 'add') ? 'required' : ''; ?>>
                          <?php if ($pgAct == 'edit' && !empty($editData['PaperUpload'])) { ?>
                            <div style="margin-top:8px;">
                              <a href="<?= base_url('assets/Uploads/PaperChecking/' . $editData['PaperUpload']); ?>" target="_blank">View Previous File</a>
                            </div>
                          <?php } ?>
                        </div>

                        <div class="form-group col-md-4">
                          <label for="Status">Status</label>
                          <div class="checkbox checkbox-solid-success">
                            <input id="Status" type="checkbox" name="Status" value="1" <?= (!empty($editData['Status']) && ($editData['Status'] === "1" || strtolower($editData['Status']) === "completed")) ? 'checked' : ''; ?>>
                            <label for="Status"> Mark as Completed</label>
                          </div>
                        </div>

                      </div>

                      <div class="text-end">
                        <button class="btn btn-primary" id="saveBtn" type="submit">Save</button>
                      </div>

                    </form>

                  <?php } ?>

                </div>
              </div>
            </div>
          </div>

        </div> <!-- container-fluid -->
      </div> <!-- page-body -->

      <?php include("AdminFooter.php"); ?>

    </div>
  </div>
  <!-- page-wrapper End -->

  <script>
    // auto-dismiss alerts after 3s
    setTimeout(function() {
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

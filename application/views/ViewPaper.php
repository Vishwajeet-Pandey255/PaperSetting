<!DOCTYPE html>
<html lang="en">
<?php include("AdminMeta.php"); ?>

<body>
<div class="page-wrapper compact-wrapper" id="pageWrapper">

    <!-- HEADER -->
    <?php include("AdminHeader.php"); ?>

    <div class="page-body-wrapper sidebar-icon">

        <!-- SIDEBAR -->
        <?php include("AdminSidebar.php"); ?>

        <!-- MAIN CONTENT -->
        <div class="page-body">
            <div class="container-fluid">

                <!-- PAGE TITLE -->
                <div class="row">
                    <div class="col-md-12">
                        <h3 style="font-weight:600;">View Paper</h3>
                    </div>
                </div>

                <div class="row mt-4">

                    <!-- PDF VIEWER -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">

                                <?php 
                                    $full_pdf_path = 'assets/Uploads/PaperChecking/' . $pdf_file_path;
                                ?>

                                <?php if (!empty($pdf_file_path)) { ?>

                                    <iframe 
                                        src="<?= base_url($full_pdf_path); ?>" 
                                        style="width:100%; height:600px; border:1px solid #ccc; border-radius:6px;">
                                    </iframe>

                                <?php } else { ?>
                                    <h5 class="text-center text-danger">PDF File Not Found</h5>
                                <?php } ?>

                            </div>
                        </div>
                    </div>

                    <!-- MARKS + COMMENTS -->
                    <div class="col-md-4">

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Marks</h5>
                            </div>
                            <div class="card-body">
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    name="marks" 
                                    placeholder="Enter Marks">
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5>Comments</h5>
                            </div>
                            <div class="card-body">
                                <textarea 
                                    class="form-control" 
                                    rows="6"
                                    name="comments"
                                    placeholder="Write comments here..."></textarea>
                            </div>
                        </div>

                    </div>

                </div> <!-- row end -->

            </div>
        </div>

    </div>

    <!-- FOOTER -->
    <?php include("AdminFooter.php"); ?>

</div>
</body>
</html>

<html lang="en">

<?php include("AdminMeta.php"); ?>

<body>
  <!-- Loader starts-->
  <!--<div class="loader-wrapper">-->
  <!--  <div class="theme-loader">    -->
  <!--    <div class="loader-p"></div>-->
  <!--  </div>-->
  <!--</div>-->
  <!-- Loader ends-->
  <!-- page-wrapper Start       -->
  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <?php include("AdminHeader.php"); ?>
    <!-- Page Header Ends                              -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper sidebar-icon">
      <!-- Page Sidebar Start-->
      <?php include("AdminSidebar.php"); ?>
      <!-- Page Sidebar Ends-->
      <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">


          <?php
          $pgMod = "PaperFormat";
          $pgAct = "view";
          $pgHeading = "PaperFormat";

          if (isset($_REQUEST['action']) && trim($_REQUEST['action']) != '')
            $pgAct = strtolower($_REQUEST['action']);
//echo $_REQUEST['action'];
          ?>


          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header pb-0">
                  <h5><?= ucfirst($pgAct) . " " . ucfirst($pgHeading) ?>

                    <?php if ($pgAct != "edit") { ?> <div class="box-tools pull-right" style="top: 3px;">
                        <!--<a href="<?php echo site_url("Admin_user/PaperFormat?action=add") ?>" class="btn btn-primary">Add New</a>-->
                      </div>
                    <?php } ?>
                  </h5>

                </div>
                <div class="card-body">
                  <?php



                  if ($pgAct == "view") {

                    $abc = $this->session->flashdata('responce_message');
                    if (is_array($abc) && count($abc) > 0) {
                       echo show_notish($abc['status'],$abc['msg']);
                    }
                  ?>

                    <div class="table-responsive">
                      <table class="display datatables" id="dt-plugin-method">
                        <thead>
                          <tr>
                            <th> Format Number</th>
                            <th> Total Marks</th>
                            <th>Min Marks</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php //echo "<pre>".LinksDetails('logo');print_r(LinksDetails('logo'));
                          if (is_array($PaperFormat_data['data']) && count($PaperFormat_data['data']) > 0) {
                            foreach ($PaperFormat_data['data'] as $abc_PaperFormat_data) {
                              //echo $abc_session_data['SessionID'];
                          ?>
                              <tr class="record_<?= $abc_PaperFormat_data['Name']; ?>">
                                <td><?= $abc_PaperFormat_data['FormatNumber']; ?></td>
                                <td><?= $abc_PaperFormat_data['TotalMarks']; ?></td>
                                <td><?= $abc_PaperFormat_data['MinMarks']; ?></td>


                                <td>
                                  <?php
                                  if ($abc_PaperFormat_data["Status"] == 1) {


                                    echo $status = '<div  class="status_' . $abc_PaperFormat_data["Status"] . ' currentstatus_' . $abc_PaperFormat_data["Status"] . '_' . $abc_PaperFormat_data["Status"] . '"><small class="btn btn-pill btn-light-gradien txt-dark"  ><b>Active</b></small></div>';
                                  } else {
                                    echo $status = '<div  class="status_' . $abc_PaperFormat_data["Status"] . ' currentstatus_' . $abc_PaperFormat_data["Status"] . '_' . $abc_PaperFormat_data["Status"] . '"><small class="btn btn-pill btn-danger active" onclick="session_status(' . $abc_PaperFormat_data["Status"] . ',' . $abc_PaperFormat_data["Status"] . ',' . $abc_PaperFormat_data["Status"] . ',\'' . $abc_PaperFormat_data["Status"] . '\')"><b>Inactive</b></small></div>';
                                  }
                                  //echo $status;      
                                  ?>
                                </td>
                                <td>
                                 
                      <!--<a  href="<?php echo site_url('Admin_user/PaperFormat?action=viewdata&id='.$abc_PaperFormat_data['FormatNumber']) ?>"  type="button" class="btn btn-pill btn-primary active"  data-toggle="modal"  ><i class="fa fa-eye"></i> </a>-->
                      
   <a href="javascript:;" onclick="edit_data('<?php echo site_url('Admin_user/PaperFormat?action=viewdata&id='.$abc_PaperFormat_data['FormatNumber']) ?>')" type="button" class="btn btn-pill btn-primary active" data-toggle="modal"><i class="fa fa-eye"></i> </a>



                                </td>
                              </tr>

                          <?php
                            }
                          }
                          ?>

                          </tfoot>
                      </table>
                    </div>
                  <?php
                  }elseif($pgAct == "viewdata"){
?>
 <div class="table-responsive">


                      <div class="paper-wrap" role="document" aria-label="Exam paper view">
                        <header>
                          <h1>END TERM EXAMINATION</h1>
                          <div class="meta">June-2025 — Non-Technical Programs · New Question Paper Format</div>
                        </header>

<?php 

if (is_array($PaperFormat_data['data']) && count($PaperFormat_data['data']) > 0) {
                          $a = 0;
                          $j = 2;
                          foreach ($PaperFormat_data['data'] as $abc_PaperFormat_data) {
                            $a++;
                            if($a==1){
?>


                        <table border="1" width="100%">
                          <tbody>
                            <tr>
                              <td colspan="3" class="center italic" style="text-align:center"><b>(June–2025)</b> Non-Technical Programs : New Question Paper Format</td>
                            </tr>
                            <tr>
                              <td colspan="3" class="center" style="text-align:center"><b>END TERM EXAMINATION </b></td>
                            </tr>
                            <tr>
                              <td><b>Program:</b></td>
                              <td><b>Branch:</b></td>
                              <td><b>Semester:</b></td>
                            </tr>
                            <tr>
                              <td colspan="3"><b>Course Code:</b></td>
                            </tr>
                            <tr>
                              <td colspan="3"><b>Course Name (Full Name):</b></td>
                            </tr>
                            <tr>
                              <td><b>Max. Marks: <?= $abc_PaperFormat_data['TotalMarks']?></b></td>
                              <td></td>
                              <td><b>Min. Marks: <?= $abc_PaperFormat_data['MinMarks']?></b></td>
                            </tr>
                          </tbody>
                        </table>



                        <hr />

                        <!-- Part I -->
                        <section class="part" id="part-i">

                          <div class="note">
<?= $abc_PaperFormat_data['GeneralNotes']; ?>

                            
                            <section class="part" id="part-i">
                            </section>

                          </div>

                          <hr>
                        </section>




                        <?php 
                            }
                         
                            if (is_array($abc_PaperFormat_data['SubSection_data']) && count($abc_PaperFormat_data['SubSection_data']) > 0) {

                        ?>


                              <section class="part" id="part-i">
                                <span style="text-align: center;">
                                  <h2><?php echo $abc_PaperFormat_data['SectionName'] ?></h2>
                                </span>
                                <div class="note"><?php echo $abc_PaperFormat_data['SectionInstruction'] ?></div>

                                <hr>
                                <?php
                                foreach ($abc_PaperFormat_data['SubSection_data'] as $abc_SubSectionPaperFormat) { ?>
                                  <div class="q">
                                    <div class="qnum"><?= $abc_SubSectionPaperFormat['SectionName'] ?></div>

                                  </div>

                                  <!-- Example MCQs -->
                                  <ol class="custom-list">
                                    <?php for ($i = 1; $i < $abc_SubSectionPaperFormat['TotalQuestion'] + 1; $i++) { ?>
                                      <span class="qnum"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "(" . $i . ")" ?> ---------------------------------------------</span><br />
                                    <?php  } ?>

                                  </ol>
                                  <hr>

                                <?php } ?>
                              </section>




                            <?php  } else { ?>
                              <section class="part" id="part-ii">
                                <span style="text-align: center;">
                                  <h2><?php echo $abc_PaperFormat_data['SectionName'] ?></h2>
                                  <div class="note"><?php echo $abc_PaperFormat_data['SectionInstruction']; ?></div>
                                </span>
                                <hr />
                                <ol class="custom-list">
                                  <?php for ($i = $j; $i < $abc_PaperFormat_data['TotalQuestion'] + $j; $i++) { ?>
                                    <span class="qnum"><?php echo "Q.  " . $i . "  ---------------------------------------------"; ?> </span><br />
                                  <?php } ?>
                                </ol>
                              </section>
                            <?php $j = $j + $abc_SubSectionPaperFormat['TotalQuestion'];
                            } ?>


                            <hr>


                        <?php
                          }
                        }
                        ?>
                      </div>

                      </tfoot>
                      </table>
                    </div>

<?php
                  } 
                  ?>


                   



                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid Ends-->
      </div>


     
      <style>
        /* Reset & base */
        thead,
        tbody,
        tfoot,
        tr,
        td,
        th {

          border-style: solid;
          border-width: 1 !important;
          border-color: #0b0b0b;
        }

        * {
          box-sizing: border-box;
        }

        html,
        body {
          height: 100%;
          margin: 0;
          font-family: "Georgia", "Times New Roman", serif;
          background: #f3f4f6;
          color: #111;
        }

        .paper-wrap {
          max-width: 900px;
          margin: 36px auto;
          background: #fff;
          padding: 36px 48px;
          box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
          border-radius: 6px;
        }

        header {
          text-align: center;
          margin-bottom: 20px;
        }

        header h1 {
          margin: 0;
          font-size: 20px;
          letter-spacing: 1px;
          font-weight: 700;
        }

        header .meta {
          margin-top: 8px;
          font-size: 13px;
          color: #333;
        }

        .top-grid {
          display: flex;
          justify-content: space-between;
          gap: 12px;
          margin: 18px 0 28px;
          align-items: center;
        }

        .top-left,
        .top-right {
          font-size: 14px;
          line-height: 1.45;
        }

        .top-left b,
        .top-right b {
          display: inline-block;
          min-width: 110px;
        }

        .paper-info {
          border-top: 2px dashed #ddd;
          padding-top: 14px;
          margin-bottom: 18px;
          font-size: 14px;
          display: flex;
          justify-content: space-between;
          align-items: center;
        }

        .paper-info .marks {
          font-weight: 700;
          font-size: 15px;
        }

        hr.sep {
          border: none;
          border-top: 1px solid #e6e6e6;
          margin: 22px 0;
        }

        /* Parts / sections */

        .part {
          margin-bottom: 22px;
        }

        /* .part h2 {
            margin: 0 0 10px;
            font-size: 16px;
            background: #fafafa;
            padding: 10px 12px;
            border-left: 4px solid #2b6cb0;
            border-radius: 4px;
            display: inline-block;
        } */

        .part .note {
          font-size: 13px;
          color: #555;
          margin: 8px 0 12px;
        }

        /* Questions */

        .q {
          margin: 12px 0;
          font-size: 15px;
        }

        .q .qnum {
          display: inline-block;
          font-weight: 700;
          width: 100%;
        }

        .options {
          margin-top: 6px;
          display: flex;
          gap: 18px;
          flex-wrap: wrap;
          font-size: 14px;
        }

        .option {
          min-width: 120px;
          display: flex;
          gap: 8px;
          align-items: center;
        }

        .option .bubble {
          width: 18px;
          height: 18px;
          border-radius: 50%;
          border: 2px solid #666;
          display: inline-block;
          vertical-align: middle;
          text-align: center;
          line-height: 14px;
          font-size: 12px;
          color: #666;
        }

        .short-answer-space,
        .long-answer-space {
          margin-top: 10px;
          border: 1px dashed #ddd;
          background: #fbfbfb;
          padding: 12px;
        }

        .short-answer-space {
          height: 54px;
        }

        .long-answer-space {
          height: 140px;
        }

        /* Numbered list style */

        ol.custom-list {
          padding-left: 22px;
          margin: 8px 0;
        }

        ol.custom-list>li {
          margin: 10px 0;
        }

        /* Two-column question list for Part II */

        .two-col {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 18px;
        }

        @media (max-width:720px) {
          .two-col {
            grid-template-columns: 1fr;
          }
        }

        /* Footer / instructions */

        .instructions {
          font-size: 13px;
          color: #444;
          border-left: 4px solid #f6ad55;
          padding: 10px 12px;
          background: #fffaf0;
          border-radius: 4px;
          margin-top: 16px;
        }

        /* small printed bits */

        .muted {
          color: #666;
          font-size: 13px;
        }

        /* print-friendly */

        @media print {
          body {
            background: #fff;
          }

          .paper-wrap {
            box-shadow: none;
            margin: 0;
            padding: 18px;
            max-width: 100%;
          }

          header h1 {
            font-size: 18px;
          }
        }
      </style>

      <!-- footer start-->
      <?php include("AdminFooter.php"); ?>
    </div>
  </div>
  <!-- latest jquery-->
  <!-- login js-->
  <!-- Plugin used-->
</body>

</html>
<html lang="en">

<?php include("AdminMeta.php"); ?>

<body>
  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header -->
    <?php include("AdminHeader.php"); ?>

    <div class="page-body-wrapper sidebar-icon">
      <!-- Sidebar -->
      <?php include("AdminSidebar.php"); ?>

      <div class="page-body">
        <div class="container-fluid">
          <?php
          $pgMod = "PaperPreview";
          $pgAct = "view";
          $pgHeading = "PaperPreview";

          if (isset($_REQUEST['action']) && trim($_REQUEST['action']) != '') {
            $pgAct = strtolower($_REQUEST['action']);
          }
          ?>

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header pb-0">
                  <h5>
                    <?= ucfirst($pgAct) . " " . ucfirst($pgHeading) ?>
                    <?php if ($pgAct != "edit") { ?>
                      <div class="box-tools pull-right" style="top: 3px;">
                        <!--<a href="<?= site_url("Admin_user/PaperPreview?action=add") ?>" class="btn btn-primary">Add New</a>-->
                      </div>
                    <?php } ?>
                  </h5>
                </div>

                <div class="card-body">
                  <?php if ($pgAct == "view") { ?>
                    <div class="table-responsive">
                      
                      
                      <table class="display datatables" id="dt-plugin-method">
                        <thead>
                          <tr>
                            <th> Faculty</th>
                            <th> Depart. / Pro.</th>
                            
                            <th> Subject </th>
                            <th> Paper Format </th>
                            <!--<th> Semester </th>-->
                            <!--<th> Session </th>-->
                             <th> Assign Date </th>
                            
                            <th>   End Date </th>

                            <th>Status</th>
                            <th>Action</th>
                        
                          </tr>
                        </thead>
                        <tbody>
                          <?php //echo "<pre>";print_r($AssignPaper_data);
                          if (is_array($AssignPaper_data) && count($AssignPaper_data) > 0) {
                            foreach ($AssignPaper_data as $abc_AssignPaper_data) {
                                if ($abc_AssignPaper_data["PaperStatus"] == 3) {

                              //echo $abc_session_data['SessionID'];
                          ?>
                              <tr class="record_<?= $abc_AssignPaper_data['Id']; ?>">
                               <td><?= $abc_AssignPaper_data['FacultyId']; ?></td>
                                <td><?= $abc_AssignPaper_data['DepartmentId']."<br><hr>".$abc_AssignPaper_data['ProgrammeId']; ?></td>
                                
                                <td><?= $abc_AssignPaper_data['SubjectId']; ?></td>
                                <td><?= $abc_AssignPaper_data['FormatId']; ?></td>
                                <td><?= $abc_AssignPaper_data['CreatedOn']; ?></td>
                                <td><?= $abc_AssignPaper_data['LastDate']; ?></td>


                                <td>
                                  <?php
                                  

                                    echo $status = '<div  class="status_' . $abc_AssignPaper_data["Status"] . ' currentstatus_' . $abc_AssignPaper_data["Status"] . '_' . $abc_AssignPaper_data["Status"] . '"><small class="btn btn-pill btn-light-gradien txt-dark"  ><b>Approved</b></small></div>';
                                        
                                  ?>
                                </td>
                                <td>
                                

                                  <a href="javascript:;" onclick="View_Paper('<?php echo site_url('Admin_user/PaperPreview?action=viewdata&id=' . $abc_AssignPaper_data['Id']) ?>')" type="button" class="btn btn-pill btn-primary " data-toggle="modal"><i class="fa fa-eye"></i> </a>


                                </td>
                                <!-- <td>-->
                                <!--  <a href="<?= site_url('Admin_user/PaperPreview?action=edit&id=' . $abc_PaperPreview_data['ExamPaper']) ?>" class="btn btn-pill btn-primary"><i class="fa fa-pencil-square-o"></i></a>-->
                                <!--  <a href="<?= site_url('Admin_user/PaperPreview?action=viewdata&id=' . $abc_PaperPreview_data['ExamPaper']) ?>" class="btn btn-pill btn-primary"><i class="fa fa-eye"></i></a>-->
                                <!--</td>-->
                              </tr>

                          <?php
                                }
                            }
                          }
                          ?>

                          </tfoot>
                      </table>

                      
                      
                      
                      
                      
                      
                      
                    </div>

                  <?php } elseif ($pgAct == "viewdata") { ?>
                    <div class="table-responsive">
                      <div class="paper-wrap" role="document" aria-label="Exam paper view">
                        

                       <?php
if (isset($PaperPreview_data['data']) && is_array($PaperPreview_data['data']) && count($PaperPreview_data['data']) > 0) {
  foreach ($PaperPreview_data['data'] as $abc_PaperPreview_data) { ?>

<div style="text-align:center; font-family:'Times New Roman', serif; margin-bottom:15px;">

<h5 style="margin:4px 0; font-weight:bold;">
  BBA(Management)- 1ST Sem.
</h5>
     
<h2 style="margin:4px 0; font-weight:bold;">
  BBBM-T101T
</h2>

    <h3 style="margin:4px 0; font-weight:bold;">
        END TERM EXAMINATION
    </h3>

    <h2 style="margin:4px 0; font-weight:bold;">
        <?= $abc_PaperPreview_data['SubjectName'] ?>
    </h2>

    <p style="margin:6px 0; font-size:18px; ">
        Time : Three Hours
    </p>

    <p style="margin:4px 0; font-size:18px; ">
        Maximum Marks : <?= $abc_PaperPreview_data['FormatData'][1]['TotalMarks'] ?>
    </p>

    <p style="margin:4px 0; font-size:18px; ">
        Minimum Marks : <?= $abc_PaperPreview_data['FormatData'][1]['MinMarks'] ?>
    </p>

</div>




<hr style="border:1px solid #000; margin:10px 0;">

                            <section class="part">
                              <div class="note"><?= $abc_PaperPreview_data['FormatData'][1]['GeneralNotes']; ?></div>
                              <hr>
                            </section>

                            <?php
                            if (isset($abc_PaperPreview_data['FormatData']) && is_array($abc_PaperPreview_data['FormatData'])) {
                              $qNum = 1; $j=2;//print_r($abc_PaperPreview_data['FormatData']);
                              foreach ($abc_PaperPreview_data['FormatData'] as $abc_PaperFormat_data) { ?>

                                <section class="part">
                                  <h2 style="text-align:center;"><?= $abc_PaperFormat_data['SectionName'] ?></h2>
                                  <div class="note"><?= $abc_PaperFormat_data['SectionInstruction'] ?></div>
                                  <hr>

                                  <?php
                                  if (is_array($abc_PaperFormat_data['SubSection_data']) && count($abc_PaperFormat_data['SubSection_data'])>0) {
                                    foreach ($abc_PaperFormat_data['SubSection_data'] as $abc_SubSectionPaperFormat) { ?>
                                      <div class="q">
                                        <div class="qnum"><?= $abc_SubSectionPaperFormat['SectionName'] ?></div>
                                      </div>
                                      <ol class="custom-list">
                                        <?php
                                        if (isset($abc_SubSectionPaperFormat['SubSection_Questiondata'])) {
                                          $i = 0;
                                          foreach ($abc_SubSectionPaperFormat['SubSection_Questiondata'] as $paper_question) { $i++; ?>
                                            <li>
                                              <?=  "(" . $i . ")&nbsp;&nbsp;&nbsp;".$paper_question['QuestionEnglish']; ?><br>
                                              <?php if($paper_question['QuestionType']==1){ ?>
                                             <div style="margin-left:4%;"><div class="optQues"><?= "A : ".$paper_question['eng_option_one']; ?></div><div class="optQues"><?= "B : ".$paper_question['eng_option_two']; ?></div><div class="optQues"><?= "C : ".$paper_question['eng_option_three']; ?></div><div class="optQues"><?= "D : ".$paper_question['eng_option_four']; ?></div></div><br>
                                              <?php } ?><span style="margin-left:4%;"><?= $paper_question['QuestionHindi']; ?></span><br>
                                              <?php if($paper_question['QuestionType']==1){ ?>
                                              <div style="margin-left:4%;"><div class="optQues"><?= "A : ".$paper_question['hin_option_one']; ?></div><div class="optQues"><?= "B : ".$paper_question['hin_option_two']; ?></div><div class="optQues"><?= "C : ".$paper_question['hin_option_three']; ?></div><div class="optQues"><?= "D : ".$paper_question['hin_option_four']; ?></div></div><br>
                                              <?php } ?>
                                            </li>
                                        <?php //$i++;
                                          }
                                        } ?>
                                      </ol>
                                      <hr>
                                    <?php }
                                  } else {    ?>
                                    <ol class="custom-list">
                                      <?php  //echo "aaaaaaaaaaaaaaa". $abc_PaperFormat_data['SectionInstruction'];
                                      if (is_array($abc_PaperFormat_data['SubSection_Questiondata']) && count($abc_PaperFormat_data['SubSection_Questiondata'])>0) {$i = $j;
                                        foreach ($abc_PaperFormat_data['SubSection_Questiondata'] as $paper_question) { ?>
                                          <li>
                                            <?php echo "(" . $i . ")&nbsp;&nbsp;&nbsp;".$paper_question['QuestionEnglish']; ?><br>
                                            <span style="margin-left:4%;"><?php echo $paper_question['QuestionHindi']; ?></span>
                                          </li>
                                      <?php $i++; }
                                      } ?>
                                    </ol>
                                  <?php }  $j = $j + $abc_PaperFormat_data['TotalQuestion'] ;  ?>
                                </section>

                        <?php
                              }
                            }
                          }
                        } ?>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php include("AdminFooter.php"); ?>
    </div>
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
          list-style: none;
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
</body>
</html>


  
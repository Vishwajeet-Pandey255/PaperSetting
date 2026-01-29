<html lang="en">
<?php include("AdminMeta.php"); ?>
<body>
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
          $pgMod = "ViewPaperList";
          $pgAct = "view";
          $pgHeading = "ViewPaperList";

          if (isset($_REQUEST['action']) && trim($_REQUEST['action']) != '')
             $pgAct = strtolower($_REQUEST['action']);

          ?>


          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header pb-0">
                  <h5><?= ucfirst($pgAct) . " " . ucfirst($pgHeading) ?>

                    <?php if ($pgAct != "edit") { ?> <div class="box-tools pull-right" style="top: 3px;">
                        <!--<a href="<?php echo site_url("Admin_user/AssignPaperList?action=add") ?>" class="btn btn-primary">Add New</a>-->
                      </div>
                    <?php } ?>
                  </h5>

                </div>
                <div class="card-body">
                  <?php



                  if ($pgAct == "view") {

                    $abc = $this->session->flashdata('responce_message');
                    if (is_array($abc) && count($abc) > 0) {
                      // echo show_notish($abc['status'],$abc['msg']);
                    }
                  ?>

                    <div class="table-responsive">
                      <table class="display datatables" id="dt-plugin-method">
                        <thead>
                          <tr>
                            <th> Faculty</th>
                            <th> Department</th>
                            <th> Programme </th>
                            <th> Subject </th>
                            <th> Paper Format </th>
                            <th> Assign Date </th>
                     

                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php //echo "<pre>";print_r($AssignPaper_data);
                          if (is_array($AssignPaper_data) && count($AssignPaper_data) > 0) {
                            foreach ($AssignPaper_data as $abc_AssignPaper_data) {
                              //echo $abc_session_data['SessionID'];
                          ?>
                              <tr class="record_<?= $abc_AssignPaper_data['Id']; ?>">
                                <td><?= $abc_AssignPaper_data['FacultyId']; ?></td>
                                <td><?= $abc_AssignPaper_data['DepartmentId']; ?></td>
                                <td><?= $abc_AssignPaper_data['ProgrammeId']; ?></td>
                                <td><?= $abc_AssignPaper_data['SubjectId']; ?></td>
                                <td><?= $abc_AssignPaper_data['FormatId']; ?></td>
                                <td><?= $abc_AssignPaper_data['CreatedOn']; ?></td>
                               

                                <td>
                                  <?php
                                  if ($abc_AssignPaper_data["Status"] == 1) {


                                    echo $status = '<div  class="status_' . $abc_AssignPaper_data["Status"] . ' currentstatus_' . $abc_AssignPaper_data["Status"] . '_' . $abc_AssignPaper_data["Status"] . '"><small class="btn btn-pill btn-light-gradien txt-dark"  ><b>Active</b></small></div>';
                                  } else {
                                    echo $status = '<div  class="status_' . $abc_AssignPaper_data["Status"] . ' currentstatus_' . $abc_AssignPaper_data["Status"] . '_' . $abc_AssignPaper_data["Status"] . '"><small class="btn btn-pill btn-danger active" ><b>Inactive</b></small></div>';
                                  }
                                  //echo $status;      
                                  ?>
                                </td>
                                <td>
                                    <?php if(is_array($_SESSION['faculty'])){?>
                                 
   <a href="javascript:;" onclick="edit_data('<?php echo site_url('Faculty/AssignPaperList?action=AddQuestion&id=' . $abc_AssignPaper_data['Id']) ?>')" type="button" class="btn btn-pill btn-primary active" data-toggle="modal"><i class="fa fa-pencil-square-o">Add/Edit Question</i> </a>




<?php } else{ ?>
<a href="<?php echo site_url('Admin_user/AssignPaperList?action=ViewQuestion&id=' . $abc_AssignPaper_data['Id']) ?>" type="button" class="btn btn-pill btn-primary active" data-toggle="modal">View Question</a>

<?php }?>



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
                  } elseif ($pgAct == "AddQuestion" || $pgAct=="addquestion") {
                    $aryFrmAct = array("page_id" => $pgMod, "action" => $pgAct);
                    $arraydata = '';
                  ?>


 <form  class="form-wizard" enctype="multipart/form-data" id="session_form"  method="post" action="<?php echo site_url("Faculty/action_AssignPaperList") ?>">
              
             
              
               <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"  />
               <input type="hidden" name="action" id="action" value="ADD" />
               
                <?php
              if ( $pgAct == 'edit' ) {  ?>
               <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"  />
               <input type="hidden" name="action" id="action" value="EDIT" />
                 <?php 
                  //echo "<pre>";print_r($get_slider_data);
                  if(isset($get_department_data)){
                        $arraydata=$get_department_data;
                        }else{
                        $arraydata=array();
                  }
                   } ?>
                
              



                    
<?php   //echo "error==><pre>";print_r($PaperPreview_data);exit;
                        if (isset($PaperPreview_data['data']) && is_array($PaperPreview_data['data']) && count($PaperPreview_data['data']) > 0) {
                          foreach ($PaperPreview_data['data'] as $abc_PaperPreview_data) { ?>

                           

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
                                        //if (isset($abc_SubSectionPaperFormat['SubSection_Questiondata'])) {
                                          $i = 0;$a=0;
                                          
                                          for ($k = 1; $k < $abc_SubSectionPaperFormat['TotalQuestion'] + 1; $k++) {
                                         // foreach ($abc_SubSectionPaperFormat['SubSection_Questiondata'] as $paper_question) {
                                          $i++; $a++; ?>
                                            <!--<li>-->
                                            <!--  <?=  "(" . $i . ")&nbsp;&nbsp;&nbsp;".$paper_question['QuestionEnglish']; ?><br>-->
                                            <!--  <span style="margin-left:20px;"><?= $paper_question['QuestionHindi']; ?></span>-->
                                            <!--</li>-->
                                            
                                            
                                            <input type="hidden" name="section_id[]" value="<?= $abc_SubSectionPaperFormat['Id'] ?>">
                                            <input type="hidden" name="question_number[]" value="<?= $i ?>" readonly class="number-input">
                           <div><?= $i; ?></div>
                                           
                                            Question In English
                                            <textarea id="editor2" class="form-control"  name="question_english[]" cols="30" rows="3" ></textarea>
                                            <br> Question In Hindi
                                            <textarea id="editor2" class="form-control"  name="question_hindi[]" cols="30" rows="3" ></textarea>
                                            
                                            <hr/>
                                            
                                        <?php //$i++;
                                         // }
                                        } ?>
                                      </ol>
                                      <hr>
                                    <?php }
                                  } else {    ?>
                                    <ol class="custom-list">
                                      <?php  //echo "aaaaaaaaaaaaaaa". $abc_PaperFormat_data['SectionInstruction'];
                                      //if (is_array($abc_PaperFormat_data['SubSection_Questiondata']) && count($abc_PaperFormat_data['SubSection_Questiondata'])>0) {$i = $j;$a=0;
                                    //    foreach ($abc_PaperFormat_data['SubSection_Questiondata'] as $paper_question) {
                                        for ($k = 1; $k < $abc_SubSectionPaperFormat['TotalQuestion'] + 1; $k++) {
                                        $a++; ?>
                                          <!--<li>-->
                                            <?php //echo "(" . $i . ")&nbsp;&nbsp;&nbsp;".$paper_question['QuestionEnglish']; ?><br>
                                            <span style="margin-left:20px;"><?php //echo $paper_question['QuestionHindi']; ?></span>
                                          <!--</li>-->
                                          <input type="hidden" name="section_id[]" value="<?= $abc_PaperFormat_data['Id'] ?>">
                                            <input type="hidden" name="question_number[]" value="<?= $a ?>" readonly class="number-input">
                           <div><?= $i."    Question In English"; ?></div>
                                           
                                           <input type="text" id="editor2" class="form-control"  name="question_english[]" value="<?= $paper_question['QuestionEnglish']?>"  >
                                            <br> Question In Hindi
                                           <input type="text" class="form-control"  name="question_hindi[]"   value="<?= $paper_question['QuestionHindi']?>">
                                            
                                          <hr/>
                                          
                                          
                                      <?php $i++;// }
                                      } ?>
                                    </ol>
                                  <?php }  $j = $j + $abc_PaperFormat_data['TotalQuestion'] ;  ?>
                                </section>

                        <?php
                              }
                            }
                          }
                        } ?>


 <div class="text-end btn-mb">
                         
                          <button class="btn btn-primary" id="nextBtn" type="submit"  >Save</button>
                          
                        </div>
                      </div>
                       </form>

                  <?php

                  }elseif ($pgAct == "ViewQuestion" || $pgAct=="ViewQuestion") {
                      ?>
                      
                      
                      <form  class="form-wizard" enctype="multipart/form-data" id="session_form"  method="post" action="<?php echo site_url("Admin_user/action_AssignPaperList") ?>">
              
             
              
               <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"  />
               <input type="hidden" name="action" id="action" value="ADD" />
               
                <?php
              if ( $pgAct == 'edit' ) {  ?>
               <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"  />
               <input type="hidden" name="action" id="action" value="EDIT" />
                 <?php 
                  echo "<pre>";print_r($get_slider_data);
                  if(isset($get_department_data)){
                        $arraydata=$get_department_data;
                        }else{
                        $arraydata=array();
                  }
                   } ?>
                
              



                    
<?php  // echo "error==><pre>";print_r($PaperPreview_data);exit;
                        if (isset($PaperPreview_data['data']) && is_array($PaperPreview_data['data']) && count($PaperPreview_data['data']) > 0) {
                          foreach ($PaperPreview_data['data'] as $abc_PaperPreview_data) { ?>

                           

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
                                          $i = 0;$a=0;
                                          
                                          //for ($k = 1; $k < $abc_SubSectionPaperFormat['TotalQuestion'] + 1; $k++) {
                                          foreach ($abc_SubSectionPaperFormat['SubSection_Questiondata'] as $paper_question) {
                                          $i++; $a++; ?>
                                            <!--<li>-->
                                            <!--  <?=  "(" . $i . ")&nbsp;&nbsp;&nbsp;".$paper_question['QuestionEnglish']; ?><br>-->
                                            <!--  <span style="margin-left:20px;"><?= $paper_question['QuestionHindi']; ?></span>-->
                                            <!--</li>-->
                                            
                                            
                                            <input type="hidden" name="section_id[]" value="<?= $abc_SubSectionPaperFormat['Id'] ?>">
                                            <input type="hidden" name="question_number[]" value="<?= $i ?>" readonly class="number-input">
                           <div><?= $i; ?></div>
                                           
                                            Question In English
                                            <textarea id="editor2" class="form-control"  name="question_english[]" cols="30" rows="3" ><?= $paper_question['QuestionEnglish']?></textarea>
                                            <br> Question In Hindi
                                            <textarea id="editor2" class="form-control"  name="question_hindi[]" cols="30" rows="3" ><?= $paper_question['QuestionHindi']?></textarea>
                                            
                                            <hr/>
                                            
                                        <?php //$i++;
                                          }
                                        } ?>
                                      </ol>
                                      <hr>
                                    <?php }
                                  } else {    ?>
                                    <ol class="custom-list">
                                      <?php  //echo "aaaaaaaaaaaaaaa". $abc_PaperFormat_data['SectionInstruction'];
                                      if (is_array($abc_PaperFormat_data['SubSection_Questiondata']) && count($abc_PaperFormat_data['SubSection_Questiondata'])>0) {$i = $j;$a=0;
                                        foreach ($abc_PaperFormat_data['SubSection_Questiondata'] as $paper_question) {
                                    //    for ($k = 1; $k < $abc_SubSectionPaperFormat['TotalQuestion'] + 1; $k++) {
                                        $a++; ?>
                                          <!--<li>-->
                                            <?php //echo "(" . $i . ")&nbsp;&nbsp;&nbsp;".$paper_question['QuestionEnglish']; ?><br>
                                            <span style="margin-left:20px;"><?php //echo $paper_question['QuestionHindi']; ?></span>
                                          <!--</li>-->
                                          <input type="hidden" name="section_id[]" value="<?= $abc_PaperFormat_data['Id'] ?>">
                                            <input type="hidden" name="question_number[]" value="<?= $a ?>" readonly class="number-input">
                           <div><?= $i."    Question In English"; ?></div>
                                           
                                           <input type="text" id="editor2" class="form-control"  name="question_english[]" value="<?= $paper_question['QuestionEnglish']?>"  >
                                            <br> Question In Hindi
                                           <input type="text" class="form-control"  name="question_hindi[]"   value="<?= $paper_question['QuestionHindi']?>">
                                            
                                          <hr/>
                                          
                                          
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


 <div class="text-end btn-mb">
                         
                          <button class="btn btn-primary" id="nextBtn" type="submit"  >Save</button>
                          
                        </div>
                      </div>
                       </form>
                      
                      
                      
                 <?php     
                  }
                  ?>

<div>
      
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid Ends-->
      </div>



      <!-- footer start-->
      <?php include("AdminFooter.php"); ?>
    </div>
  </div>
  <!-- latest jquery-->
  <!-- login js-->
  <!-- Plugin used-->
</body>

</html>
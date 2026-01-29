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
          $pgMod = "AssignPaperList";
          $pgAct = "view";
          $pgHeading = "AssignPaperList";

          if (isset($_REQUEST['action']) && trim($_REQUEST['action']) != '')
            $pgAct = strtolower($_REQUEST['action']);

          ?>


          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header pb-0">
                  <h5><span style="float:left"><?= ucfirst($pgAct) . " " . ucfirst($pgHeading) ?></span>
                  
                  
<?php

if($pgAct=="addquestion"){ $start_time = time();
?>
<div id="timer" style="width: 20%;float: right;color:red"></div>

<?php } ?>

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
                       echo show_notish($abc['status'],$abc['msg']);
                    }
                  ?>

                    <div class="table-responsive">
                      <table class="display datatables" id="dt-plugin-method">
                        <thead>
                          <tr>
                            <th> Faculty</th>
                            <th> Depart. / Pro.</th>
                            
                            <th> Subject </th>
                            <th> Paper Format </th>
                            <th> Assign / End Date </th>
                            
                            <th> Time Consume </th>


                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php // echo "<pre>";print_r($AssignPaper_data);
                          if (is_array($AssignPaper_data) && count($AssignPaper_data) > 0) {
                            foreach ($AssignPaper_data as $abc_AssignPaper_data) {
                              //echo $abc_session_data['SessionID'];
                          ?>
                              <tr class="record_<?= $abc_AssignPaper_data['Id']; ?>">
                                <td><?= $abc_AssignPaper_data['FacultyId']; ?></td>
                                <td><?= $abc_AssignPaper_data['DepartmentId']."<br><hr>".$abc_AssignPaper_data['ProgrammeId']; ?></td>
                                
                                <td><?= $abc_AssignPaper_data['SubjectId']; ?></td>
                                <td><?= $abc_AssignPaper_data['FormatId']; ?></td>
                                <td><?= $abc_AssignPaper_data['CreatedOn']."<br><hr>".$abc_AssignPaper_data['LastDate']; ?></td>
                                <td><?= $abc_AssignPaper_data['ConsumeTime']; ?></td>


                                <td>
                                  <?php
                                  if ($abc_AssignPaper_data["Status"] == 1) {


                                    echo $status = '<div  class="status_' . $abc_AssignPaper_data["Status"] . ' currentstatus_' . $abc_AssignPaper_data["Status"] . '_' . $abc_AssignPaper_data["Status"] . '"><small class="btn btn-pill btn-light-gradien txt-dark"  ><b>Active</b></small></div>';
                                  } else {
                                    echo $status = '<div  class="status_' . $abc_AssignPaper_data["Status"] . ' currentstatus_' . $abc_AssignPaper_data["Status"] . '_' . $abc_AssignPaper_data["Status"] . '"><small class="btn btn-pill btn-danger active" ><b>Inactive</b></small></div>';
                                  }
                                 // echo $abc_AssignPaper_data['PaperQuestion']."/".$abc_AssignPaper_data['TotalQuestion']."/".$abc_AssignPaper_data['PaperStatus'];      
                                  ?>
                                </td>
                                <td>
                                  <?php if (is_array($_SESSION['faculty'])) { 
                                  
                                   if($abc_AssignPaper_data['PaperStatus']==1){?>

                                    <a href="javascript:;" onclick="edit_data('<?php echo site_url('Faculty/AssignPaperList?action=AddQuestion&id=' . $abc_AssignPaper_data['Id']) ?>')" type="button" class="btn btn-pill btn-primary active" data-toggle="modal">Add/Edit Question </a>

<?php }elseif($abc_AssignPaper_data['PaperStatus']==2){ ?>
<h6 style="color:red"><b>Wait for approve / reject your paper</b></h6>
<?php }elseif($abc_AssignPaper_data['PaperStatus']==3){?>
<h6 style="color:red"><b>Your Paper Approved </b></h6>
<?php }elseif($abc_AssignPaper_data['PaperStatus']==4){?>
<h6 style="color:red"><b>Your Paper Rejected </b></h6>
 <a href="javascript:;" onclick="edit_data('<?php echo site_url('Faculty/AssignPaperList?action=AddQuestion&id=' . $abc_AssignPaper_data['Id']) ?>')" type="button" class="btn btn-pill btn-primary active" data-toggle="modal">Add/Edit Question </a>

<?php }if(($abc_AssignPaper_data['PaperQuestion']==$abc_AssignPaper_data['TotalQuestion']) && (($abc_AssignPaper_data['PaperStatus']==1) || ($abc_AssignPaper_data['PaperStatus']==4))){ ?>
 <a href="javascript:;" onclick="approve_data('<?php echo site_url('Faculty/AssignPaperList?action=ApprovePaper&id=' . $abc_AssignPaper_data['Id']) ?>')" type="button" class="btn btn-pill btn-info active" data-toggle="modal">Send For Approval </a>

<?php }?>


                                  <?php }  ?>



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
                  } elseif ($pgAct == "AddQuestion" || $pgAct == "addquestion") {
                    $aryFrmAct = array("page_id" => $pgMod, "action" => $pgAct);
                    $arraydata = '';
                  ?>


                    <form class="form-wizard" enctype="multipart/form-data" id="QuestionPaper_form" method="post" action="<?php echo site_url("Faculty/action_AssignPaperList") ?>">



                      <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
                      <input type="hidden" name="action" id="action" value="ADD" />

                      <input type="hidden" name="deleted_images" id="deleted_images" value="">


                      <?php
                      if ($pgAct == 'edit') {  ?>
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
                        <input type="hidden" name="action" id="action" value="EDIT" />
                      <?php
                        //echo "<pre>";print_r($get_slider_data);
                        if (isset($get_department_data)) {
                          $arraydata = $get_department_data;
                        } else {
                          $arraydata = array();
                        }
                      } ?>




<input type="hidden" name="papertime" id="papertime" value="" class="timer">

                      <?php   //echo "error==><pre>";print_r($PaperPreview_data);exit;
                      $section=0;
                      if (isset($PaperPreview_data['data']) && is_array($PaperPreview_data['data']) && count($PaperPreview_data['data']) > 0) {
                        foreach ($PaperPreview_data['data'] as $abc_PaperPreview_data) { ?>



                          <?php
                          if (isset($abc_PaperPreview_data['FormatData']) && is_array($abc_PaperPreview_data['FormatData'])) {
                            $qNum = 1;
                            $j = 2; //print_r($abc_PaperPreview_data['FormatData']);
                            foreach ($abc_PaperPreview_data['FormatData'] as $abc_PaperFormat_data) { ?>

                              <section class="part">
                                <h2 style="text-align:center;"><?= $abc_PaperFormat_data['SectionName'] ?></h2>
                                <div class="note"><?= $abc_PaperFormat_data['SectionInstruction'] ?></div>
                                <hr>

                                <?php
                                if (is_array($abc_PaperFormat_data['SubSection_data']) && count($abc_PaperFormat_data['SubSection_data']) > 0) {
                                  foreach ($abc_PaperFormat_data['SubSection_data'] as $abc_SubSectionPaperFormat) { ?>
                                    <div class="q">
                                      <div class="qnum"><?= $abc_SubSectionPaperFormat['SectionName'] ?></div>
                                    </div>
                                    <ol class="custom-list">
                                      <?php
                                      $i = 0;
                                      $a = 0; 

                                      for ($k = 1; $k < $abc_SubSectionPaperFormat['TotalQuestion'] + 1; $k++) {
                                        $i++;
                                        $a++; ?>
                                       


                                        <input type="hidden" name="section_id[]" value="<?= $abc_SubSectionPaperFormat['Id'] ?>">
                                        <input type="hidden" name="question_number[]" value="<?= $i ?>" readonly class="number-input">
                                        

                                        <div><?= $i." :   Question In English"; ?> 
                                        </div>

                                        <input type="hidden" name="question_type[]" value="<?= $abc_SubSectionPaperFormat['QuestionType'] ?>" readonly class="number-input">
                                        <textarea id="editor2" class="form-control" name="question_english[]" cols="30" rows="2"><?php if(is_array($abc_SubSectionPaperFormat['SubSection_Questiondata']) && count($abc_SubSectionPaperFormat['SubSection_Questiondata'])>0)echo $abc_SubSectionPaperFormat['SubSection_Questiondata'][$i-1]['QuestionEnglish'];?></textarea>
                                        <?php if($abc_SubSectionPaperFormat['QuestionType']==1) {?>
                                         
                                        <input type="text" name="<?php echo "eng_option".$i."[]"; ?>" id="" value="<?php if(is_array($abc_SubSectionPaperFormat['SubSection_Questiondata']) && count($abc_SubSectionPaperFormat['SubSection_Questiondata'])>0)echo $abc_SubSectionPaperFormat['SubSection_Questiondata'][$i-1]['eng_option_one'];?>" style="width: 48%; margin:1%; float:left;" placeholder="Option1">
                                        <input type="text" name="<?php echo "eng_option".$i."[]"; ?>" id="" value="<?php if(is_array($abc_SubSectionPaperFormat['SubSection_Questiondata']) && count($abc_SubSectionPaperFormat['SubSection_Questiondata'])>0)echo $abc_SubSectionPaperFormat['SubSection_Questiondata'][$i-1]['eng_option_two'];?>" style="width: 48%; margin:1%; float:left;" placeholder="Option2">
                                        <input type="text" name="<?php echo "eng_option".$i."[]"; ?>" id="" value="<?php if(is_array($abc_SubSectionPaperFormat['SubSection_Questiondata']) && count($abc_SubSectionPaperFormat['SubSection_Questiondata'])>0)echo $abc_SubSectionPaperFormat['SubSection_Questiondata'][$i-1]['eng_option_three'];?>" style="width: 48%; margin:1%; float:left;" placeholder="Option3">
                                        <input type="text" name="<?php echo "eng_option".$i."[]"; ?>" id="" value="<?php if(is_array($abc_SubSectionPaperFormat['SubSection_Questiondata']) && count($abc_SubSectionPaperFormat['SubSection_Questiondata'])>0)echo $abc_SubSectionPaperFormat['SubSection_Questiondata'][$i-1]['eng_option_four'];?>" style="width: 48%; margin:1%; float:left;" placeholder="Option4">
                                        <?php } ?>
                                        <br> Question In Hindi
                                        <textarea id="editor2" class="form-control" name="question_hindi[]" cols="30" rows="2"><?php if(is_array($abc_SubSectionPaperFormat['SubSection_Questiondata']) && count($abc_SubSectionPaperFormat['SubSection_Questiondata'])>0)echo $abc_SubSectionPaperFormat['SubSection_Questiondata'][$i-1]['QuestionHindi'];?></textarea>
                                         <?php if($abc_SubSectionPaperFormat['QuestionType']==1) {?>
                                        <input type="text" name="<?php echo "hin_option".$i."[]"; ?>" id="" value="<?php if(is_array($abc_SubSectionPaperFormat['SubSection_Questiondata']) && count($abc_SubSectionPaperFormat['SubSection_Questiondata'])>0)echo $abc_SubSectionPaperFormat['SubSection_Questiondata'][$i-1]['hin_option_one'];?>" style="width: 48%; margin:1%; float:left;" placeholder="Option1">
                                        <input type="text" name="<?php echo "hin_option".$i."[]"; ?>" id="" value="<?php if(is_array($abc_SubSectionPaperFormat['SubSection_Questiondata']) && count($abc_SubSectionPaperFormat['SubSection_Questiondata'])>0)echo $abc_SubSectionPaperFormat['SubSection_Questiondata'][$i-1]['hin_option_two'];?>" style="width: 48%; margin:1%; float:left;" placeholder="Option2">
                                        <input type="text" name="<?php echo "hin_option".$i."[]"; ?>" id="" value="<?php if(is_array($abc_SubSectionPaperFormat['SubSection_Questiondata']) && count($abc_SubSectionPaperFormat['SubSection_Questiondata'])>0)echo $abc_SubSectionPaperFormat['SubSection_Questiondata'][$i-1]['hin_option_three'];?>" style="width: 48%; margin:1%; float:left;" placeholder="Option3">
                                        <input type="text" name="<?php echo "hin_option".$i."[]"; ?>" id="" value="<?php if(is_array($abc_SubSectionPaperFormat['SubSection_Questiondata']) && count($abc_SubSectionPaperFormat['SubSection_Questiondata'])>0)echo $abc_SubSectionPaperFormat['SubSection_Questiondata'][$i-1]['hin_option_four'];?>" style="width: 48%; margin:1%; float:left;" placeholder="Option4">
                                        <?php } ?>

                                        <hr />

                                      <?php //$i++;
                                        // }
                                      } ?>
                                    </ol>
                                    <hr>
                                  <?php }
                                } else {    ?>
                                  <ol class="custom-list">
                                    <?php  $q=0;
                                    for ($k = 1; $k < $abc_PaperFormat_data['TotalQuestion'] + 1; $k++) {
                                      $a++; $section++;$q++;?>
                                      <!--<li>-->
                                      <?php //echo "(" . $i . ")&nbsp;&nbsp;&nbsp;".$paper_question['QuestionEnglish']; 
                                      ?><br>
                                      <span style="margin-left:20px;"><?php //echo $paper_question['QuestionHindi']; 
                                                                      ?></span>
                                      <!--</li>-->
                                      <input type="hidden" name="section_id[]" value="<?= $abc_PaperFormat_data['Id'] ?>">
                                      <input type="hidden" name="question_number[]" value="<?= $q ?>" readonly class="number-input">
                                      <input type="hidden" name="question_type[]" value="<?= $abc_PaperFormat_data['QuestionType'] ?>" readonly class="number-input">
                                      <div><?= $section+1 . "    Question In English";  ?></div>

                                      <input type="text" id="editor2" class="form-control" name="question_english[]" value="<?php if((is_array($abc_PaperFormat_data['SubSection_Questiondata']) && count($abc_PaperFormat_data['SubSection_Questiondata'])>0) && ($abc_PaperFormat_data['SubSection_Questiondata'][$q-1]['QuestionType']==$abc_PaperFormat_data['QuestionType']))echo $abc_PaperFormat_data['SubSection_Questiondata'][$q-1]['QuestionEnglish'];?>">
                                      <br> Question In Hindi
                                      <input type="text" class="form-control" name="question_hindi[]" value="<?php if((is_array($abc_PaperFormat_data['SubSection_Questiondata']) && count($abc_PaperFormat_data['SubSection_Questiondata'])>0) && ($abc_PaperFormat_data['SubSection_Questiondata'][$q-1]['QuestionType']==$abc_PaperFormat_data['QuestionType']))echo $abc_PaperFormat_data['SubSection_Questiondata'][$q-1]['QuestionHindi'];?>">

                                     <div style="margin-bottom:8px;">
                                     <div class="existing-images" style="display:flex; gap:8px; flex-wrap:wrap;">
<?php
$existing_images = [];
if (!empty($abc_PaperFormat_data['SubSection_Questiondata'][$q-1]['QuestionImage'])) {
    $existing_images = explode(',', $abc_PaperFormat_data['SubSection_Questiondata'][$q-1]['QuestionImage']);
}

foreach ($existing_images as $img) {
    if ($img != '') {
?>
    <div class="img-box" style="position:relative;" id="img_<?php echo $img; ?>">
        <span 
            style="position:absolute; top:-6px; right:-6px; cursor:pointer; background:red; color:#fff; border-radius:50%; padding:2px 6px; font-size:12px;"
            onclick="removeImage('<?php echo $img; ?>', <?php echo $i; ?>)"
        >✖</span>

        <img src="<?= base_url('assets/Question/'.$img); ?>"
             style="width:60px; height:60px; object-fit:cover; border:1px solid #ccc; padding:2px;" />

        <input type="hidden" name="existing_images[<?= $i ?>][]" value="<?= $img ?>">
    </div>
<?php } } ?>
</div>

</div>

       <div style="margin-bottom:8px;">
       <label><b>Upload Question Images:</b></label>
       <input 
       type="file" 
       name="question_images[<?php echo $i; ?>][]" 
       id="question_images_<?php echo $i; ?>"
       accept="image/*" 
       class="form-control image_group_class"
       data-id="5"
       multiple
      onChange="count_question_image(<?php echo $i; ?>)"
        />

   </div>
 <hr />


                                         



                                    <?php $i++; // }
                                    } ?>
                                  </ol>
                                <?php }
                                $j = $j + $abc_PaperFormat_data['TotalQuestion']+1;  ?>
                              </section>

                      <?php
                            }
                          }
                        }
                      } ?>


                      <div class="text-end btn-mb">

                        <button class="btn btn-primary" id="nextBtn" type="button" onclick="save_data()">Save</button>

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
  <script>

function save_data(){
    $("#QuestionPaper_form").submit();
}


let startTime = <?php echo $start_time; ?> * 1000;

function updateTimer() {
  let now = new Date().getTime();
  let elapsed = now - startTime;

  let hours = Math.floor((elapsed / (1000 * 60 * 60)) % 24);
  let minutes = Math.floor((elapsed / (1000 * 60)) % 60);
  let seconds = Math.floor((elapsed / 1000) % 60);

  document.getElementById("timer").innerHTML =
    hours + "h " + minutes + "m " + seconds + "s";
    $(".timer").val(hours + "h " + minutes + "m " + seconds + "s");
}

setInterval(updateTimer, 1000);
updateTimer();


function count_question_image(index)
{
    var max_image = 5;

    var file_input = document.getElementById('question_images_' + index);
    var new_count = file_input.files.length;

    var existing_images = document.getElementsByName('existing_images[' + index + '][]');
    var existing_count = 0;

    existing_images.forEach(function(el) {
        if (el.closest('.img-box').style.display !== 'none') {
            existing_count++;
        }
    });

    var total = new_count + existing_count;

    if (total > max_image) {
        Lobibox.alert('error', {
            msg: 'Maximum 5 images allowed per question'
        });

        file_input.value = '';
        return false;
    }
}

let deletedImages = [];

function removeImage(img, index) {
    Lobibox.confirm({
        msg: "Are you sure you want to delete this image?",
        callback: function ($this, type) {
            if (type === 'yes') {
                deletedImages.push(img);
                document.getElementById('deleted_images').value = deletedImages.join(',');

                // remove from UI
                document.getElementById('img_' + img).style.display = 'none';

            }
        }
    });
}

</script>
  
  
</body>

</html>
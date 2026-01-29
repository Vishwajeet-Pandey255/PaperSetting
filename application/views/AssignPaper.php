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
          $pgMod = "AssignPaper";
          $pgAct = "view";
          $pgHeading = "AssignPaper";

          if (isset($_REQUEST['action']) && trim($_REQUEST['action']) != '')
            $pgAct = strtolower($_REQUEST['action']);

          ?>


          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header pb-0">
                  <h5><?= ucfirst($pgAct) . " " . ucfirst($pgHeading) ?>

                    <?php if ($pgAct != "edit") { ?> <div class="box-tools pull-right" style="top: 3px;">
                        <a href="<?php echo site_url("Admin_user/AssignPaper?action=add") ?>" class="btn btn-primary">Add New</a>
                      </div>
                    <?php } ?>
                  </h5>

                </div>
                <div class="card-body">
                      <!-- ✅ Flash Messages -->
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
                  <?php



                  if ($pgAct == "view") {
 // echo show_notish("error","hiiiiiii");
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
                                  if ($abc_AssignPaper_data["Status"] == 1) {


                                    echo $status = '<div  class="status_' . $abc_AssignPaper_data["Status"] . ' currentstatus_' . $abc_AssignPaper_data["Status"] . '_' . $abc_AssignPaper_data["Status"] . '"><small class="btn btn-pill btn-light-gradien txt-dark"  ><b>Active</b></small></div>';
                                  } else {
                                    echo $status = '<div  class="status_' . $abc_AssignPaper_data["Status"] . ' currentstatus_' . $abc_AssignPaper_data["Status"] . '_' . $abc_AssignPaper_data["Status"] . '"><small class="btn btn-pill btn-danger active" ><b>Inactive</b></small></div>';
                                  }
                                  //echo $status;      
                                  ?>
                                </td>
                                <td>
                                  <a href="javascript:;" onclick="edit_data('<?php echo site_url('Admin_user/AssignPaper?action=edit&id=' . $abc_AssignPaper_data['Id']) ?>')" type="button" class="btn btn-pill btn-primary active" data-toggle="modal"><i class="fa fa-pencil-square-o"></i> </a>


                                  <a href="javascript:;" onclick="delete_data('<?php echo site_url('Admin_user/AssignPaper?action=delete&id=' . $abc_AssignPaper_data['Id']) ?>')" type="button" class="btn btn-pill btn-danger active " data-toggle="modal"><i class="fa fa-trash-o"></i> </a>


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
                  } elseif ($pgAct == "add" || $pgAct == "edit") {
                    $aryFrmAct = array("page_id" => $pgMod, "action" => $pgAct);
                    $arraydata = '';
                  ?>


                    <form class="form-wizard" enctype="multipart/form-data" id="session_form" method="post" action="<?php echo site_url("Admin_user/action_AssignPaper") ?>">

                      <input type="hidden" name="id" value="" />
                      <input type="hidden" name="action" value="ADD" />
                      <?php
                      if ($pgAct == 'edit') {  ?>
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
                        <input type="hidden" name="action" id="action" value="EDIT" />
                      <?php
                        //echo "<pre>";print_r($get_slider_data);
                        if (isset($get_AssignPaper_data)) {
                          $arraydata = $get_AssignPaper_data;
                        } else {
                          $arraydata = array();
                        }
                      } ?>




                      <div class="form-group">
                        <label for="name">Faculty </label>
                        <select name="FacultyId" id="FacultyId" class="form-control" required>
                          <option value="Select Category">Please Selcet Faculty</option>
                          <?php
                          if (is_array($faculty_data) && count($faculty_data) > 0) {
                            foreach ($faculty_data as $abc_faculty_data) {
                          ?>
                              <option value="<?php echo $abc_faculty_data['Id']; ?>" <?php if ($pgAct == 'edit' && ($arraydata[0]['FacultyId'] == $abc_faculty_data['Id'])) echo "selected"; ?>><?php echo $abc_faculty_data['Name']; ?></option>
                          <?php }
                          } ?>
                        </select>
                      </div>


                      <div class="form-group">
                        <label for="name">Department </label>
                        <select name="DepartmentId" id="DepartmentId" class="form-control" onChange="get_programme(this.value)" required>
                          <option value="Select Category">Please Selcet Department</option>
                          <?php
                          if (is_array($department_data) && count($department_data) > 0) {
                            foreach ($department_data as $abc_department_data) {
                          ?>
                              <option value="<?php echo $abc_department_data['Id']; ?>" <?php if ($pgAct == 'edit' && ($arraydata[0]['DepartmentId'] == $abc_department_data['Id'])) echo "selected"; ?>><?php echo $abc_department_data['Name']; ?></option>
                          <?php }
                          } ?>
                        </select>
                      </div>


                      <div class="form-group GetAllProgramme">
                        <label for="name">Programme </label>
                        <input type"text" class="form-control" readonly>
                      </div>




 <div class="form-group GetAllSubject">
                        <label for="name">Subject List </label>
                        <input type"text" class="form-control" readonly>
                      </div>

                     

                      <div class="form-group">
                        <label for="name">Paper Format Type</label>
                        <select name="FormatId" id="FormatId" class="form-control" required onChange="$('#TotalQuestion').val($(this).find('option:selected').attr('total_ques'));">
                          <option value="Select Category">Please Selcet Paper Format</option>
                          <?php
                          if (is_array($PaperFormat_data['data']) && count($PaperFormat_data['data']) > 0) { //print_r($PaperFormat_data);
                            foreach ($PaperFormat_data['data'] as $abc_PaperFormat_data) {
                          ?>
                              <option value="<?php echo $abc_PaperFormat_data['FormatNumber']; ?>" total_ques="<?php echo $abc_PaperFormat_data['TotalQuestion']; ?>" <?php if ($pgAct == 'edit' && ($arraydata[0]['FormatId'] == $abc_PaperFormat_data['FormatNumber'])) echo "selected"; ?>><?php echo $abc_PaperFormat_data['Name'] . " (" . $abc_PaperFormat_data['FormatNumber'] . " )"; ?></option>
                          <?php }
                          } ?>
                        </select>
                      </div>

<input type="hidden" name="TotalQuestion" id="TotalQuestion" value="">

 <div class="form-group">
                        <label for="name">Last Date for Paper Submittion</label>
                        <input type="date" name="LastDate" id="LastDate" value="" class="form-control" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                        </div>



                      <div class=" form-group col-md-3">



                        <div class="checkbox checkbox-solid-success">
                          <input id="solid1" type="checkbox" name="Status" value="1" <?php if ($pgAct == 'edit' && $arraydata[0]['Status'] == '1') echo "checked"; ?>>
                          <label for="solid1">Active This Page</label>
                        </div>

                      </div>





                      <div>
                        <div class="text-end btn-mb">

                          <button class="btn btn-primary" id="nextBtn" type="submit">Save</button>

                        </div>
                      </div>

                    </form>

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



      <!-- footer start-->
      <?php include("AdminFooter.php"); ?>
    </div>
  </div>
  <!-- latest jquery-->
  <!-- login js-->
  <!-- Plugin used-->
</body>

</html>


<script>
  function get_programme(Id) {
    //var DistrictId=$("#district").val();
    //alert(Id);exit;
    $.ajax({
      url: "<?= site_url('Admin_user/get_Programme'); ?>",
      type: "get",
      data: {
        DepartmentId: Id
      },
      cache: false,
      dataType: "json",
      success: function(data) {
        console.log(data);

        var datas = '<label for="name">Programme Code </label><select class="form-control" name="ProgrammeId" id="ProgrammeId" onChange="get_Subject(this.value)" required><option value=" ">Select Programme Code</option>';
        if (data.length >= 1) {
          $.each(data, function(key, val) {
            datas += '<option value="' + val.Id + '" data-id="' + val.Id + '">' + val.ProgrammeName + '</option>';
          })

        }
        datas += '</select>';
        $(".GetAllProgramme").html(datas);
      }
    });

  }

  function get_Subject(Id) {
    //var DistrictId=$("#district").val();
    //alert(Id);exit;
    $.ajax({
      url: "<?= site_url('Admin_user/get_subject'); ?>",
      type: "get",
      data: {
        ProgrammeId: Id
      },
      cache: false,
      dataType: "json",
      success: function(data) {
        console.log(data);

        var datas = '<label for="name">Subject Code </label><select class="form-control" name="SubjectId" id="SubjectId" required><option value=" ">Select Subject Code</option>';
        if (data.length >= 1) {
          $.each(data, function(key, val) {
            datas += '<option value="' + val.Id + '" data-id="' + val.Id + '">' + val.SubjectName + '</option>';
          })

        }
        datas += '</select>';
        $(".GetAllSubject").html(datas);
      }
    });

  }
</script>

<script>
                      $(document).ready(function(){
                        <?php if ($pgAct == 'edit' && isset($arraydata[0])) { ?>
                          var depId = "<?= $arraydata[0]['DepartmentId']; ?>";
                          var progId = "<?= $arraydata[0]['ProgrammeId']; ?>";
                          var subjId = "<?= $arraydata[0]['SubjectId']; ?>";
                          
                          if(depId){
                            $.ajax({
                              url:"<?= site_url('Admin_user/get_Programme');?>",
                              type:"get",
                              data:{DepartmentId:depId},
                              dataType:"json",
                              success:function(data){
                                var datas='<label for="name">Programme Code</label><select class="form-control" name="ProgrammeId" id="ProgrammeId" onChange="get_Subject(this.value);"><option value="">Select Programme Code</option>';
                                $.each(data,function(k,v){
                                  var sel=(v.Id==progId)?'selected':'';
                                  datas+='<option value="'+v.Id+'" '+sel+'>'+v.ProgrammeName+'</option>';
                                });
                                datas+='</select>';
                                $(".GetAllProgramme").html(datas);

                                // Load subject now
                                $.ajax({
                                  url:"<?= site_url('Admin_user/get_Subject');?>",
                                  type:"get",
                                  data:{ProgrammeId:progId},
                                  dataType:"json",
                                  success:function(sub){
                                    var datas2='<label for="SubjectId">Subject Code</label><select name="SubjectId" id="SubjectId" class="form-control"><option value="">Select Subject</option>';
                                    $.each(sub,function(k,v){
                                      if(v.Status==1){
                                        var sel=(v.Id==subjId)?'selected':'';
                                        datas2+='<option value="'+v.Id+'" '+sel+'>'+v.SubjectName+' ('+v.SubjectCode+')</option>';
                                      }
                                    });
                                    datas2+='</select>';
                                    $(".GetAllSubject").html(datas2);
                                  }
                                });
                              }
                            });
                          }
                        <?php } ?>
                      });
                      
                       setTimeout(function() {
    const alertBox = document.querySelector('.alert');
    if (alertBox) {
      alertBox.style.transition = "opacity 0.5s ease";
      alertBox.style.opacity = "0";
      setTimeout(() => alertBox.remove(), 500);
    }
  }, 3000);
                    </script>
                    
<html lang="en">
  
  <?php include("AdminMeta.php");?>
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
     <?php include("AdminHeader.php");?>
      <!-- Page Header Ends                              -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <!-- Page Sidebar Start-->
        <?php include("AdminSidebar.php");?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <!-- Container-fluid starts-->
          <div class="container-fluid">
           
           
             <?php
  $pgMod = "Faculty";
  $pgAct = "view";
   $pgHeading = "Faculty";

  if ( isset( $_REQUEST[ 'action' ] ) && trim( $_REQUEST[ 'action' ] ) != '' )
    $pgAct = strtolower( $_REQUEST[ 'action' ] );
  
    ?>
           
           
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header pb-0">
                    <h5><?= ucfirst($pgAct)." ".ucfirst($pgHeading) ?>
                    
                     <?php if($pgAct != "edit"){?> <div class="box-tools pull-right" style="top: 3px;"> 
                     <a href="<?php echo site_url("Admin_user/Faculty?action=add") ?>" class="btn btn-primary" >Add New</a> </div>
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
				
				 $abc= $this->session->flashdata('responce_message');
              if(is_array($abc) && count($abc)>0){
                    echo show_notish($abc['status'],$abc['msg']);
              }
            ?>
           
                      
                     <div class="table-responsive">
                      <table class="display datatables" id="dt-plugin-method">
                        <thead>
                          <tr>
                            	<th> Name</th>
                    <th> Email</th>
                    <th>Address</th>
					<th>Phone No</th>
					<th>Status</th>
                    <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php //echo "<pre>".LinksDetails('logo');print_r(LinksDetails('logo'));
                if (is_array( $faculty_data ) && count( $faculty_data ) > 0 ) {
                  foreach ( $faculty_data as $abc_faculty_data ) {
                    //echo $abc_session_data['SessionID'];
                    ?>
                           <tr class="record_<?= $abc_faculty_data['Name']; ?>">
                    <td><?= $abc_faculty_data['Name']; ?></td>
					<td><?= $abc_faculty_data['Email']; ?></td>
					<td><?= $abc_faculty_data['Address']; ?></td>
					<td><?= $abc_faculty_data['PhoneNumber']; ?></td>
					<td>
                    <?php  
                    if($abc_faculty_data["Status"]==1) {
                  
                        
                   echo $status = '<div  class="status_'.$abc_faculty_data["Status"].' currentstatus_'.$abc_faculty_data["Status"].'_'.$abc_faculty_data["Status"].'"><small class="btn btn-pill btn-light-gradien txt-dark"  ><b>Active</b></small></div>';
                     }else{
                        echo $status = '<div  class="status_'.$abc_faculty_data["Status"].' currentstatus_'.$abc_faculty_data["Status"].'_'.$abc_faculty_data["Status"].'"><small class="btn btn-pill btn-danger active" ><b>Inactive</b></small></div>';
                    }
                      //echo $status;      ?>
                    </td>
                  <td>
                      <!--<a  href="<?php echo site_url('Admin_user/faculty?action=edit&id='.$abc_faculty_data['Id']) ?>"  type="button" class="btn btn-pill btn-primary active"  data-toggle="modal"  ><i class="fa fa-pencil-square-o"></i> </a>-->
                      

                      <!--<a  href="<?php echo site_url('Admin_user/faculty?action=delete&id='.$abc_faculty_data['Id']) ?>"  type="button" class="btn btn-pill btn-danger active "  data-toggle="modal"  ><i class="fa fa-trash-o"></i> </a>-->
                 
                 <a href="javascript:;" onclick="edit_data('<?php echo site_url('Admin_user/faculty?action=edit&id=' . $abc_faculty_data['Id']) ?>')" type="button" class="btn btn-pill btn-primary active" data-toggle="modal"><i class="fa fa-pencil-square-o"></i> </a>


                                  <a href="javascript:;" onclick="delete_data('<?php echo site_url('Admin_user/faculty?action=delete&id=' . $abc_faculty_data['Id']) ?>')" type="button" class="btn btn-pill btn-danger active " data-toggle="modal"><i class="fa fa-trash-o"></i> </a>

                      

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
          } 
          elseif ( $pgAct == "add" || $pgAct == "edit" ) {
              $aryFrmAct = array( "page_id" => $pgMod, "action" => $pgAct );
              $arraydata='';
          ?>
          
         
              <form  class="form-wizard" enctype="multipart/form-data" id="session_form"  method="post" action="<?php echo site_url("Admin_user/action_faculty") ?>">
              
              <input type="hidden" name="id" value="" />
              <input type="hidden" name="action" value="ADD" />
              <?php
              if ( $pgAct == 'edit' ) {  ?>
               <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"  />
               <input type="hidden" name="action" id="action" value="EDIT" />
                 <?php 
                  //echo "<pre>";print_r($get_slider_data);
                  if(isset($get_faculty_data)){
                        $arraydata=$get_faculty_data;
                        }else{
                        $arraydata=array();
                  }
                   } ?>
              
              
                        
                        
                        <div class="form-group">
                  <label for="name">Full Name </label>
                  <input type="text" class="form-control" id="Name" name="Name" placeholder="Enter Name" required value="<?php if($pgAct == 'edit') echo $arraydata[0]['Name']?>"   >
                </div> 
                
                <div class="form-group">
                  <label for="name">Email </label>
                  <input type="text" class="form-control" id="email" name="Email" placeholder="Enter Email" required value="<?php if($pgAct == 'edit') echo $arraydata[0]['Email']?>"   >
                </div> 
                
                <div class="form-group">
                  <label for="name">Phone Number </label>
                  <input type="number" class="form-control" id="PhoneNumber" name="PhoneNumber" placeholder="Enter Phone Number" required value="<?php if($pgAct == 'edit') echo $arraydata[0]['PhoneNumber']?>"   >
                </div> 
                
                <div class="form-group">
                  <label for="name">Address </label>
                  <input type="text" class="form-control" id="Name" name="Address" placeholder="Enter Address" required value="<?php if($pgAct == 'edit') echo $arraydata[0]['Name']?>" >
                </div> 
                
                <div class="form-group">
                  <label for="name">Password </label>
                  <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter Password" required value="<?php if($pgAct == 'edit') echo $arraydata[0]['Password']?>"   >
                </div> 
                
               
					  
                
                
                
                <div class=" form-group col-md-3">
                      
                        
                        
                        <div class="checkbox checkbox-solid-success">
                            <input id="solid1" type="checkbox" name="Status" value="1" <?php if($pgAct == 'edit' && $arraydata[0]['Status']=='1')echo "checked"; ?>>
                            <label for="solid1">Active This Page</label>
                          </div>
                        
                </div>  
                
                        
                        
                        
                        
                      <div>
                        <div class="text-end btn-mb">
                         
                          <button class="btn btn-primary" id="nextBtn" type="submit"  >Save</button>
                          
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
       <?php include("AdminFooter.php");?>
      </div>
      <script>
  setTimeout(function() {
    const alertBox = document.querySelector('.alert');
    if (alertBox) {
      alertBox.style.transition = "opacity 0.5s ease";
      alertBox.style.opacity = "0";
      setTimeout(() => alertBox.remove(), 500);
    }
  }, 3000);
</script>
    </div>
    <!-- latest jquery-->
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>
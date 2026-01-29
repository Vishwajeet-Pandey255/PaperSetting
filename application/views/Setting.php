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
  $pgMod = "Setting";
  $pgAct = "view";
   $pgHeading = "Setting";

  if ( isset( $_REQUEST[ 'action' ] ) && trim( $_REQUEST[ 'action' ] ) != '' )
    $pgAct = strtolower( $_REQUEST[ 'action' ] );
  
    ?>
           
           
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header pb-0">
                    <h5><?= ucfirst($pgAct)." ".ucfirst($pgHeading) ?>
                    
                     <?php if($pgAct != "edit"){?> <div class="box-tools pull-right" style="top: 3px;"> 
                     <a href="<?php echo site_url("Admin_user/setting?action=add") ?>" class="btn btn-primary" >Add New</a> </div>
              <?php } ?>
              </h5>
                    
                  </div>
                  <div class="card-body">
                       <?php
             
            
            
            if ($pgAct == "view") { 
				
				 $abc= $this->session->flashdata('responce_message');
              if(is_array($abc) && count($abc)>0){
                   // echo show_notish($abc['status'],$abc['msg']);
              }
            ?>
                      
                     <div class="table-responsive">
                      <table class="display datatables" id="dt-plugin-method">
                        <thead>
                          <tr>
                            	<th> Type</th>
                    <th> Name</th>
                    <th>Value</th>
					<th>Status</th>
                    <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php //echo "<pre>".LinksDetails('logo');print_r(LinksDetails('logo'));
                if (is_array( $setting_data ) && count( $setting_data ) > 0 ) {
                  foreach ( $setting_data as $abc_setting_data ) {
                    //echo $abc_session_data['SessionID'];
                    ?>
                           <tr class="record_<?= $abc_setting_data['Name']; ?>">
                    <td><?= $abc_setting_data['InputType']; ?></td>
					<td><?= $abc_setting_data['Name']; ?></td>
					<td><?php if($abc_setting_data['InputType']!='image')echo $abc_setting_data['Value']; else{ ?>
					<img src="<?php echo base_url()."assets/upload_files/setting/".$abc_setting_data['Value'] ?>" style="width: 100px">
						<?php } ?>
					</td>
<!--
					<td><img src="<?= base_url()."assets/upload_files/setting/".$abc_setting_data['Image']; ?>" style="max-width: 100px !important"></td>
                    
-->
                  
                  <td>
                    <?php  
                    if($abc_setting_data["Status"]==1) {
                  
                        
                   echo $status = '<div  class="status_'.$abc_setting_data["Status"].' currentstatus_'.$abc_setting_data["Status"].'_'.$abc_setting_data["Status"].'"><small class="btn btn-pill btn-light-gradien txt-dark"  ><b>Active</b></small></div>';
                     }else{
                        echo $status = '<div  class="status_'.$abc_setting_data["Status"].' currentstatus_'.$abc_setting_data["Status"].'_'.$abc_setting_data["Status"].'"><small class="btn btn-pill btn-danger active" onclick="session_status('.$abc_setting_data["Status"].','.$abc_setting_data["Status"].','.$abc_setting_data["Status"].',\''.$abc_setting_data["Status"].'\')"><b>Inactive</b></small></div>';
                    }
                      //echo $status;      ?>
                    </td>
                  <td>
                      <a  href="<?php echo site_url('Admin_user/setting?action=edit&id='.$abc_setting_data['Id']) ?>"  type="button" class="btn btn-pill btn-primary active"  data-toggle="modal"  ><i class="fa fa-pencil-square-o"></i> </a>
                      
<!--
                      <a  href="<?php echo site_url('Admin_user/setting?action=delete&id='.$abc_setting_data['Id']) ?>"  type="button" class="btn btn-pill btn-danger active "  data-toggle="modal"  ><i class="fa fa-trash-o"></i> </a>
                
                      
-->
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
          
         
              <form  class="form-wizard" enctype="multipart/form-data" id="session_form"  method="post" action="<?php echo site_url("Admin_user/action_setting") ?>">
              
              <input type="hidden" name="id" value="" />
              <input type="hidden" name="action" value="ADD" />
              <?php
              if ( $pgAct == 'edit' ) {  ?>
               <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"  />
               <input type="hidden" name="action" id="action" value="EDIT" />
                 <?php 
                  //echo "<pre>";print_r($get_slider_data);
                  if(isset($get_setting_data)){
                        $arraydata=$get_setting_data;
                        }else{
                        $arraydata=array();
                  }
                   } ?>
              
              
                        
                        
                        <div class="form-group">
                  <label for="name">Field Name </label>
                  <input type="text" class="form-control" id="Name" name="Name" placeholder="Enter Name" required value="<?php if($pgAct == 'edit') echo $arraydata[0]['Name']?>" <?php if($pgAct == 'edit') echo "readonly"; ?>  >
                </div>  
                
                <?php if($pgAct == 'add'){ ?>	  
				<div class="form-group  "   >
                  <label for="exampleInputEmail1">Input Type </label>
                  	<select id="InputType" name="InputType" class="form-select btn-square digits form-control" onChange="field_type()" <?php if($pgAct == 'edit') echo "readonly"; ?> >
						<option value="">Select Input Type</option>
						<option value="text_box" selected>Text Box</option>
						<option value="textarea"  <?php if($pgAct == 'edit' && ($arraydata[0]['InputType'])=='textarea')echo "selected" ; ?>>Textarea</option>
						<option value="image" <?php if($pgAct == 'edit' && ($arraydata[0]['InputType'])=='image')echo "selected" ; ?>>Image</option>
						
					</select>
                </div>
					  
					<?php }if($pgAct == 'edit'){ ?>  
						<div class="form-group ">
						  <label for="exampleInputEmail1">Input Type </label>
						  <input type="text" class="form-control" id="InputType" name="InputType" placeholder="Enter Slider Name" required value="<?php echo $arraydata[0]['InputType']?>" readonly  >
						</div> 
					 <?php } ?>
					  
                
                
                <div class="form-group " id="textvalue" style="<?php if(($pgAct == 'edit') && ($arraydata[0]['InputType']!='text_box')){echo 'display: none';}   ?>" >
                  <label for="exampleInputEmail1">Value </label>
                  <input type="text" class="form-control" id="text_val" name="text_val" placeholder="Enter value" required value="<?php if($pgAct == 'edit' && $arraydata[0]['InputType']=='text_box') echo $arraydata[0]['Value']; ?>" >
                </div>
					  
				<div class="form-group " id="textareavalue" style="<?php if(($pgAct == 'edit') && ($arraydata[0]['InputType']=='textarea'))echo 'display: block'; else echo 'display: none' ?>" >
                  <label for="exampleInputEmail1">Value </label>
                  <textarea name="textarea_val" id="pbody" value="" class="form-control" required><?php if($pgAct == 'edit' && $arraydata[0]['InputType']=='textarea') echo $arraydata[0]['value'] ?></textarea>
                </div> 
					  
				<div class="form-group " id="filevalue" style="<?php if(($pgAct == 'edit') && ($arraydata[0]['InputType']=='image'))echo 'display: block'; else echo 'display: none' ?>">
                  <label for="exampleInputEmail1">Value </label>
                  <input type="file" class="form-control" id="file_val" name="file_val"  >
					<?php if(($pgAct == 'edit') && ($arraydata[0]['InputType']=='image')){ ?>
					<br/>
					<img src="<?php echo base_url()."assets/upload_files/setting/".$arraydata[0]['Value'] ?>" style="width: 100px">
					<input type="hidden" name="file_value" value="<?= $arraydata[0]['value']?>">
					<?php } ?>
                </div>
                
                <div class=" form-group col-md-3">
                      
                        
                        
                        <div class="checkbox checkbox-solid-success">
                            <input id="solid1" type="checkbox" name="Status" value="1" <?php if($pgAct == 'edit' && $arraydata[0]['Status']=='1')echo "checked"; ?>>
                            <label for="solid1">Active This Page</label>
                          </div>
                        
                </div>  
                
                        
                        
                        
                        
                      <div>
                        <div class="text-end btn-mb">
                         
                          <button class="btn btn-primary" id="nextBtn" type="button"  onClick="check_validation()">Save</button>
                          
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
        
        
        <script>
	
	
                        function field_type(){
							//alert(0);
		 					var id=$("#input_type").val();
							if(id=='textarea'){
								$("#textareavalue").show();
								$("#textvalue").hide();
								$("#filevalue").hide();
								}
								else if(id=='image'){
								$("#filevalue").show();
								$("#textvalue").hide();
								$("#textareavalue").hide();
								}else {
									
									$("#textvalue").show();
								
									$("#filevalue").hide();
									$("#textareavalue").hide();
									}
							}
                        
	 function check_validation(){
            var slider_name=$("#slider_name").val();
            var content=$("#content").val();
            var image=$("#image").val();
            var slider_image=$("#slider_image").val();
		    var action=$("#action").val();
            
            //alert(action)
            if(slider_name==''){
               Lobibox.notify('error', { msg: 'Please Enter Slider Name' });
                $("#slider_name").focus();
            }else if(image=='' && slider_image==''){
               Lobibox.notify('error', { msg: 'Please Select Slider Image' });
                $("#image").focus();
			}
//            }else if(content==''){
//                Lobibox.notify('error', { msg: 'Please Enter Slider Content' });
//                $("#content").focus();
//            }
		 else{
                $('#session_form').submit();            }
            
            
        }
</script>

        <!-- footer start-->
       <?php include("AdminFooter.php");?>
      </div>
    </div>
    <!-- latest jquery-->
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>
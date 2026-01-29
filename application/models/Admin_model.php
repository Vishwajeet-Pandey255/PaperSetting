<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Admin_model extends CI_Model {


  public function admin_login( $array ) {
      
      if($array[ 'LoginType' ]==1 ){
          $query = $this->db->query( "select * from  Setting where Name='" . $array[ 'email' ] . "' and value='" . $array[ 'password' ] . "' and status='1'" );
                $query_status = $query->result_array();
                if ( is_array( $query_status ) && count( $query_status ) > 0 ) {
              $_SESSION[ "admin" ][ 'id' ] = $query_status[ '0' ][ 'Id' ];
              $_SESSION[ "admin" ][ 'name' ] = $query_status[ '0' ][ 'Name' ];
        
              $responce = array( "status" => "success", "msg" => "Successfully Login" );
             } else {
              $responce = array( "status" => "error", "msg" => "Invalid Id Or Password" );
            }
      }else{
          $password=md5($array[ 'password' ]);
         $query = $this->db->query( "select * from  Faculty where Email='" . $array[ 'email' ] . "' and Password='" . $password . "' and Status='1'" );
        $query_status = $query->result_array(); 
        
       // echo "error==><pre>";print_r( $_REQUEST);print_r($query_status);exit;
        if ( is_array( $query_status ) && count( $query_status ) > 0 ) {
      $_SESSION[ "faculty" ][ 'id' ] = $query_status[ '0' ][ 'Id' ];
      $_SESSION[ "faculty" ][ 'name' ] = $query_status[ '0' ][ 'Name' ];

      $responce = array( "status" => "success", "msg" => "Successfully Login" );
     } else {
      $responce = array( "status" => "error", "msg" => "Invalid Id Or Password" );
    }
      }
    
     //echo "error==><pre>".$this->db->last_query();print_r( $_REQUEST);print_r($query_status);exit;
    
    return $responce;
  }
  
  
  
  
  
  
  public function managemenu_data()
	{
		$query = $this->db->query("select * from menu_list ");
		$count_row = $query->num_rows();
		if ($count_row > 0) {
			$datas = $query->result_array();$i=0;
			foreach ($datas as $abc_abc) {
					$i++;
					$resultdata[$i]=$abc_abc;
					$resultdata[$i]['under_of_name'] = 0;
					if ($abc_abc['under_of'] > 0) {
						$querydata = $this->db->query("select menu_name from menu_list where id='" . $abc_abc['under_of'] . "'");
						$abcd = $querydata->result_array();
						$resultdata[$i]['under_of_name'] = $abcd['0']['menu_name'];
					}
				}
			
			$resultdatas = array("status" => "success", "msg" => " record found", "data" => $resultdata);
		} else {
			$resultdatas = array("status" => "error", "msg" => "No record found", "data" => '');
		}

		return $resultdatas;


	}
  
  
  
  
  
  
  

public function get_PaperFormat_data($id) {
    
   // echo "error==>aaa".$id;print_r($_SESSION);print_r($_GET);exit;
    $query = $this->db->query( "select * from Paperformat where FormatNumber='".$id."' and ParentId IS NULL " );
    //$resultdata = $query->result_array();
    	$count_row = $query->num_rows();
		if ($count_row > 0) {
			$datas = $query->result_array();$i=0;
			foreach ($datas as $abc_abc) {
					$i++;
					$resultdata[$i]=$abc_abc;
					$resultdata[$i]['SubSection_data'] =array();
				
						$querydata = $this->db->query("select * from Paperformat where ParentId='" . $abc_abc['Id'] . "'");
						$querydatacount_row = $querydata->num_rows();
                    		if ($querydatacount_row > 0) {
                    		    $abcd = $querydata->result_array();
					        	$resultdata[$i]['SubSection_data'] = $abcd;
                    		}
						
						
			
				}
			
			$resultdatas = array("status" => "success", "msg" => " record found", "data" => $resultdata);
		} else {
			$resultdatas = array("status" => "error", "msg" => "No record found", "data" => '');
		}

		return $resultdatas;
    
   
  }
  
  public function PaperFormat_data() {
    $query = $this->db->query( "select * from Paperformat where Id!=''   and ParentId IS NULL group by FormatNumber order by FormatNumber ASC" );
    //$resultdata = $query->result_array();
    	$count_row = $query->num_rows();
		if ($count_row > 0) {
			$datas = $query->result_array();$i=0;
			foreach ($datas as $abc_abc) {
					$i++;
					$resultdata[$i]=$abc_abc;
					$resultdata[$i]['SubSection_data'] =array();
				        $Totalquestiondata = $this->db->query("select sum(TotalQuestion) as GetTotalQuestion from Paperformat where FormatNumber='" . $abc_abc['FormatNumber'] . "'");
						$querydata = $this->db->query("select * from Paperformat where ParentId='" . $abc_abc['Id'] . "'");
						$abcd = $querydata->result_array();
						$Totalquestion = $Totalquestiondata->result_array();
						$resultdata[$i]['SubSection_data'] = $abcd;
						$resultdata[$i]['TotalQuestion'] = $Totalquestion[0]['GetTotalQuestion'];
			
				}
			
			$resultdatas = array("status" => "success", "msg" => " record found", "data" => $resultdata);
		} else {
			$resultdatas = array("status" => "error", "msg" => "No record found", "data" => '');
		}

		return $resultdatas;
    
   
  }
  
  
  
  
 
  public function PaperPreview_data() {
      //echo "<pre>error".$id;exit;
    $query = $this->db->query( "select PF.*,AP.FacultyId,AP.DepartmentId,AP.ProgrammeId,AP.SubjectId,AP.FacultyId,AP.FormatId from PaperQuestion as PF, AssignPaper as AP where PF.Id!='' and AP.ID=PF.ExamPaper  group by PF.ExamPaper order by PF.Id ASC" );
    //$resultdata = $query->result_array();
    	$count_row = $query->num_rows();
		if ($count_row > 0) {
			$datas = $query->result_array();$i=0;
			foreach ($datas as $abc_abc) {
					$i++;
					$resultdata[$i]=$abc_abc;
					$resultdata[$i]['SubSection_data'] =array();
				
						$querydata = $this->db->query("select * from Paperformat where ParentId='" . $abc_abc['Id'] . "'");
						$abcd = $querydata->result_array();
						$resultdata[$i]['SubSection_data'] = $abcd;
			
				}
			
			$resultdatas = array("status" => "success", "msg" => " record found", "data" => $resultdata);
		} else {
			$resultdatas = array("status" => "error", "msg" => "No record found", "data" => '');
		}

		return $resultdatas;
    
   
  
    
  }



 public function get_PaperPreview_data($id) {
     //echo "<pre>error".$id;exit;
      $queryOne = $this->db->query( "select * from ExamPaper where Id='".$id."'" );
    //$resultdata = $query->result_array();
    	$count_rowOne = $queryOne->num_rows();
		if ($count_rowOne > 0) {
			$datasOne = $queryOne->result_array();$a=0;
			$resultdata[$a]=$datasOne[0];
			$query = $this->db->query( "select * from Paperformat where FormatNumber='".$datasOne[0]['FormatId']."' and ParentId IS NULL" );
    //$resultdata = $query->result_array();
    
   // echo "<pre>error".$id;print_r($datasOne);print_r($resultdata);exit;
    	$count_row = $query->num_rows();
		if ($count_row > 0) {
			$datas = $query->result_array();$i=0;
			foreach ($datas as $abc_abc) {
					$i++;
					$resultdata[$a]['FormatData'][$i]=$abc_abc;
					$resultdata[$a]['FormatData'][$i]['SubSection_data'] =array();
				
			
						$querydata = $this->db->query("select * from Paperformat where ParentId='" . $abc_abc['Id'] . "'");
				 			$count_rowdata = $querydata->num_rows();
                         		if ($count_rowdata > 0) {$j=0;
                        			$sub_datas = $querydata->result_array();;
                        			foreach ($sub_datas as $abc_sub_datas) {$j++;
                        			    
                        			    $resultdata[$a]['FormatData'][$i]['SubSection_data'][$j] = $abc_sub_datas;
                        			    
                        			    $queryquestiondata = $this->db->query("select ExamPaper,QuestionNumber,QuestionEnglish,QuestionHindi from PaperQuestion where SectionId='" . $abc_sub_datas['Id'] . "' and ExamPaper=".$id);
                        			    $count_queryquestiondata = $queryquestiondata->num_rows();
                        			    if ($count_queryquestiondata > 0) {
                        			        	$resultdata[$a]['FormatData'][$i]['SubSection_data'][$j]['SubSection_Questiondata'] =array();
                        			        	$abcd_question = $queryquestiondata->result_array();
                					        	$resultdata[$a]['FormatData'][$i]['SubSection_data'][$j]['SubSection_Questiondata'] = $abcd_question;
                        			        
                        			    }
                					
                        			}
                         		}else{
					
					
					
        						$queryquestiondata = $this->db->query("select ExamPaper,QuestionNumber,QuestionEnglish,QuestionHindi from PaperQuestion where SectionId='" . $abc_abc['Id'] . "' and ExamPaper=".$id);
        						
        						$count_queryquestiondata = $queryquestiondata->num_rows();
                                			    if ($count_queryquestiondata > 0) {
                                			        	$resultdata[$a]['FormatData'][$i]['SubSection_Questiondata'] =array();
                                			        	$abcd_question = $queryquestiondata->result_array();
                        					        	$resultdata[$a]['FormatData'][$i]['SubSection_Questiondata'] = $abcd_question;
                        					        	//$resultdata[$a]['FormatData'][$i]['SubSection_Questiondata']['query'] =  $this->db->last_query(); ;
                                			        
                                			    }
						
				
                        		}
					
				}
			
			$resultdatas = array("status" => "success", "msg" => " record found", "data" => $resultdata);
		} else {
			$resultdatas = array("status" => "error", "msg" => "No record found", "data" => '');
		}
			
			
			
			
		}
     
      

		return $resultdatas;
    
  }
  
  
  
  
 public function get_PaperPreview_data_new($id) {
    // echo "<pre>error".$id;exit;
      $queryOne = $this->db->query( "select * from AssignPaper where Id='".$id."'" );
    //$resultdata = $query->result_array();
    	$count_rowOne = $queryOne->num_rows();
		if ($count_rowOne > 0) {
			$datasOne = $queryOne->result_array();$a=0;
			$resultdata[$a]=$datasOne[0];
			$query = $this->db->query( "select * from Paperformat where FormatNumber='".$datasOne[0]['FormatId']."' and ParentId IS NULL" );
    //$resultdata = $query->result_array();
    
    // "<pre>error".$id;print_r($datasOne);print_r($resultdata);exit;
    	$count_row = $query->num_rows();
		if ($count_row > 0) {
			$datas = $query->result_array();$i=0;
			foreach ($datas as $abc_abc) {
					$i++;
					$resultdata[$a]['FormatData'][$i]=$abc_abc;
					$resultdata[$a]['FormatData'][$i]['SubSection_data'] =array();
				
			
						$querydata = $this->db->query("select * from Paperformat where ParentId='" . $abc_abc['Id'] . "'");
				 			$count_rowdata = $querydata->num_rows();
                         		if ($count_rowdata > 0) {$j=0;
                        			$sub_datas = $querydata->result_array();;
                        			foreach ($sub_datas as $abc_sub_datas) {$j++;
                        			    
                        			    $resultdata[$a]['FormatData'][$i]['SubSection_data'][$j] = $abc_sub_datas;
                        			    
                        			    $queryquestiondata = $this->db->query("select * from PaperQuestion where SectionId='" . $abc_sub_datas['Id'] . "' and ExamPaper=".$id);
                        			    $count_queryquestiondata = $queryquestiondata->num_rows();
                        			    if ($count_queryquestiondata > 0) {
                        			        	$resultdata[$a]['FormatData'][$i]['SubSection_data'][$j]['SubSection_Questiondata'] =array();
                        			        	$abcd_question = $queryquestiondata->result_array();
                					        	$resultdata[$a]['FormatData'][$i]['SubSection_data'][$j]['SubSection_Questiondata'] = $abcd_question;
                        			        
                        			    }
                					
                        			}
                         		}else{
					
					
					
        						$queryquestiondata = $this->db->query("select * from PaperQuestion where SectionId='" . $abc_abc['Id'] . "' and ExamPaper=".$id);
        						
        						$count_queryquestiondata = $queryquestiondata->num_rows();
                                			    if ($count_queryquestiondata > 0) {
                                			        	$resultdata[$a]['FormatData'][$i]['SubSection_Questiondata'] =array();
                                			        	$abcd_question = $queryquestiondata->result_array();
                        					        	$resultdata[$a]['FormatData'][$i]['SubSection_Questiondata'] = $abcd_question;
                        					        	//$resultdata[$a]['FormatData'][$i]['SubSection_Questiondata']['query'] =  $this->db->last_query(); ;
                                			        
                                			    }
						
				
                        		}
					
				}
			
			$resultdatas = array("status" => "success", "msg" => " record found", "data" => $resultdata);
		} else {
			$resultdatas = array("status" => "error", "msg" => "No record found", "data" => '');
		}
			
			
			
			
		}
     
      

		return $resultdatas;
    
  }

  
  
  
  
   public function get_PaperPreviewList_data($id) {
     //echo "<pre>error".$id;exit;
      $queryOne = $this->db->query( "select * from AssignPaper where Id='".$id."'" );
    //$resultdata = $query->result_array();
    	$count_rowOne = $queryOne->num_rows();
		if ($count_rowOne > 0) {
			$datasOne = $queryOne->result_array();$a=0;
			$resultdata[$a]=$datasOne[0];
			$query = $this->db->query( "select * from Paperformat where FormatNumber='".$datasOne[0]['FormatId']."' and ParentId IS NULL" );
    //$resultdata = $query->result_array();
    
    //echo "<pre>error".$id;print_r($datasOne);print_r($resultdata);exit;
    	$count_row = $query->num_rows();
		if ($count_row > 0) {
			$datas = $query->result_array();$i=0;
			foreach ($datas as $abc_abc) {
					$i++;
					$resultdata[$a]['FormatData'][$i]=$abc_abc;
					$resultdata[$a]['FormatData'][$i]['SubSection_data'] =array();
				
			
						$querydata = $this->db->query("select * from Paperformat where ParentId='" . $abc_abc['Id'] . "'");
				 			$count_rowdata = $querydata->num_rows();
                         		if ($count_rowdata > 0) {$j=0;
                        			$sub_datas = $querydata->result_array();;
                        			foreach ($sub_datas as $abc_sub_datas) {$j++;
                        			    
                        			    $resultdata[$a]['FormatData'][$i]['SubSection_data'][$j] = $abc_sub_datas;
                        			    
                        			    $queryquestiondata = $this->db->query("select * from PaperQuestion where SectionId='" . $abc_sub_datas['Id'] . "' and ExamPaper=".$id);
                        			    $count_queryquestiondata = $queryquestiondata->num_rows();
                        			    if ($count_queryquestiondata > 0) {
                        			        	$resultdata[$a]['FormatData'][$i]['SubSection_data'][$j]['SubSection_Questiondata'] =array();
                        			        	$abcd_question = $queryquestiondata->result_array();
                					        	$resultdata[$a]['FormatData'][$i]['SubSection_data'][$j]['SubSection_Questiondata'] = $abcd_question;
                					        //	$resultdata[$a]['FormatData'][$i]['SubSection_data'][$j]['SubSection_Questiondata']['lastQuery'] = $this->db->last_query();
                        			        
                        			    }
                					
                        			}
                         		}else{
					
					
					
        						$queryquestiondata = $this->db->query("select * from PaperQuestion where SectionId='" . $abc_abc['Id'] . "' and ExamPaper=".$id);
        						
        						$count_queryquestiondata = $queryquestiondata->num_rows();
                                			    if ($count_queryquestiondata > 0) {
                                			        	$resultdata[$a]['FormatData'][$i]['SubSection_Questiondata'] =array();
                                			        	$abcd_question = $queryquestiondata->result_array();
                        					        	$resultdata[$a]['FormatData'][$i]['SubSection_Questiondata'] = $abcd_question;
                        					        //	$resultdata[$a]['FormatData'][$i]['SubSection_Questiondata']['lastQuery'] = $this->db->last_query();
                        					        	//$resultdata[$a]['FormatData'][$i]['SubSection_Questiondata']['query'] =  $this->db->last_query(); ;
                                			        
                                			    }
						
				
                        		}
					
				}
			
			$resultdatas = array("status" => "success", "msg" => " record found", "data" => $resultdata);
		} else {
			$resultdatas = array("status" => "error", "msg" => "No record found", "data" => '');
		}
			
			
			
			
		}
     
      

		return $resultdatas;
    
  }
  
  
public function Send_ApprovePaper($id){
     $dataarray = array( 
        'PaperStatus' => 3,
      );
		  //echo "error==><pre>";print_r($array);print_r($dataarray);exit;
      $this->db->where( 'Id', $id );
      $this->db->update( 'AssignPaper', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Paper Successfully Send For Approval' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
}


public function Send_RejectPaper($id){
     $dataarray = array( 
        'PaperStatus' => 4,
      );
		  //echo "error==><pre>";print_r($array);print_r($dataarray);exit;
      $this->db->where( 'Id', $id );
      $this->db->update( 'AssignPaper', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Paper Successfully Send For Approval' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
}

  
  
//   public function get_PaperPreviewList_data($id) {
//      //echo "<pre>error".$id;exit;
//       $queryOne = $this->db->query( "select * from AssignPaper where Id='".$id."'" );
//     //$resultdata = $query->result_array();
//     	$count_rowOne = $queryOne->num_rows();
// 		if ($count_rowOne > 0) {
// 			$datasOne = $queryOne->result_array();$a=0;
// 			$resultdata[$a]=$datasOne[0];
// 			$query = $this->db->query( "select * from Paperformat where FormatNumber='".$datasOne[0]['FormatId']."' and ParentId IS NULL" );
//     //$resultdata = $query->result_array();
    
//     //echo "<pre>error".$id;print_r($datasOne);print_r($resultdata);exit;
//     	$count_row = $query->num_rows();
// 		if ($count_row > 0) {
// 			$datas = $query->result_array();$i=0;
// 			foreach ($datas as $abc_abc) {
// 					$i++;
// 					$resultdata[$a]['FormatData'][$i]=$abc_abc;
// 					$resultdata[$a]['FormatData'][$i]['SubSection_data'] =array();
				
			
// 						$querydata = $this->db->query("select * from Paperformat where ParentId='" . $abc_abc['Id'] . "'");
// 				 			$count_rowdata = $querydata->num_rows();
//                          		if ($count_rowdata > 0) {$j=0;
//                         			$sub_datas = $querydata->result_array();;
//                         			foreach ($sub_datas as $abc_sub_datas) {$j++;
                        			    
//                         			    $resultdata[$a]['FormatData'][$i]['SubSection_data'][$j] = $abc_sub_datas;
                        			    
//                         			    $queryquestiondata = $this->db->query("select ExamPaper,QuestionNumber,QuestionEnglish,QuestionHindi from PaperQuestion where SectionId='" . $abc_sub_datas['Id'] . "' and ExamPaper=".$id);
//                         			    $count_queryquestiondata = $queryquestiondata->num_rows();
//                         			    if ($count_queryquestiondata > 0) {
//                         			        	$resultdata[$a]['FormatData'][$i]['SubSection_data'][$j]['SubSection_Questiondata'] =array();
//                         			        	$abcd_question = $queryquestiondata->result_array();
//                 					        	$resultdata[$a]['FormatData'][$i]['SubSection_data'][$j]['SubSection_Questiondata'] = $abcd_question;
                        			        
//                         			    }
                					
//                         			}
//                          		}else{
					
					
					
//         						$queryquestiondata = $this->db->query("select ExamPaper,QuestionNumber,QuestionEnglish,QuestionHindi from PaperQuestion where SectionId='" . $abc_abc['Id'] . "' and ExamPaper=".$id);
        						
//         						$count_queryquestiondata = $queryquestiondata->num_rows();
//                                 			    if ($count_queryquestiondata > 0) {
//                                 			        	$resultdata[$a]['FormatData'][$i]['SubSection_Questiondata'] =array();
//                                 			        	$abcd_question = $queryquestiondata->result_array();
//                         					        	$resultdata[$a]['FormatData'][$i]['SubSection_Questiondata'] = $abcd_question;
//                         					        	//$resultdata[$a]['FormatData'][$i]['SubSection_Questiondata']['query'] =  $this->db->last_query(); ;
                                			        
//                                 			    }
						
				
//                         		}
					
// 				}
			
// 			$resultdatas = array("status" => "success", "msg" => " record found", "data" => $resultdata);
// 		} else {
// 			$resultdatas = array("status" => "error", "msg" => "No record found", "data" => '');
// 		}
			
			
			
			
// 		}
     
      

// 		return $resultdatas;
    
//   }


//  public function check_unique($array){
//         //echo "error==><pre>modle";print_r($array);exit;
//         $fid='';
//         if(isset($array['fid']) && $array['fid']!=''){
//          $fid=$array['fid'];
//         }
//          $query = $this->db->query("select * from  ".$array['table_name']." where ".$array['field_name']." = '".$array['id']."' ");
//          $count_row=$query->num_rows();
//          if($count_row>1){
//              $datas= $query->result_array();
//              ///return $data[0];
//              $resultdata=array("status"=>"error","msg"=>"This Mobile Number already exist, a mobile number can be used for 2 registrations only, please enter another number","data"=>$datas[0]);
//          }else{
//              $resultdata=array("status"=>"success","msg"=>"No record found","data"=>'');
//          }
//          return $resultdata;   
//      }


//---------------------Faculty-----------------------------------------------------


  public function faculty_data() {
    $query = $this->db->query( "select * from Faculty " );
    $resultdata = $query->result_array();

    return $resultdata;
  }

  public function get_faculty_data( $id ) {
    $query = $this->db->query( "select * from  Faculty where Id='" . $id . "'" );
    return $query->result_array();
  }

  public function action_faculty( $array ) {
    //echo "error==><pre>aa";print_r($array);exit;
    if ( $array[ 'action' ] == 'ADD' ) {
      $status = 0;
      if ( isset( $array[ "Status" ] ) )
        $status = 1;
      $dataarray = array( 'Name' => $array[ 'Name' ],
        'Email' => $array[ 'Email' ],
        'Address' => $array[ 'Address' ],
        'PhoneNumber' => $array[ 'PhoneNumber' ],
        'Password' => md5($array[ 'Password' ]),
        'RoleId' => 3,
        
        'Status' => $status,
      );
      $this->db->insert( 'Faculty', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Save Successfull' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
    } 
	  else if ( $array[ 'action' ] == 'EDIT' ) {
		
      $status = 0;
      if ( isset( $array[ "Status" ] ) )
        $status = 1;
      $dataarray = array( 'Name' => $array[ 'Name' ],
        'Email' => $array[ 'Email' ],
        'Address' => $array[ 'Address' ],
        'PhoneNumber' => $array[ 'PhoneNumber' ],
        'Password' => md5($array[ 'Password' ]),
        
        'Status' => $status,
      );  
		  //echo "error==><pre>";print_r($array);print_r($dataarray);exit;
      $this->db->where( 'Id', $array[ 'id' ] );
      $this->db->update( 'Faculty', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Update Successfull' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
    } elseif ( $array[ 'action' ] == 'delete' ) {

      $dataquery = $this->db->query( "select * from  Faculty where Id='" . $array[ 'id' ] . "'" );
      $abc = $dataquery->result_array();

      $file = "./assets/upload_files/Faculty/" . $abc[ 0 ][ 'image' ];

      $query = $this->db->query( "delete from Faculty where id='" . $array[ 'id' ] . "'" );
      if ( $query ) {
        unlink( $file );
        $resultarray = array( "status" => "success", "msg" => " Record Successfully Deleted" );
        return ( $resultarray );
      } else {
        $resultarray = array( "status" => "error", "msg" => " Record Not Deleted" );;
        return ( $resultarray );
      }
    }
  }


//---------------------Department-----------------------------------------------------


  public function department_data() {
    $query = $this->db->query( "select * from Department " );
    $resultdata = $query->result_array();

    return $resultdata;
  }

  public function get_department_data( $id ) {
    $query = $this->db->query( "select * from  Department where Id='" . $id . "'" );
    return $query->result_array();
  }

  public function action_department( $array ) {
    //echo "error==><pre>aa";print_r($array);exit;
    if ( $array[ 'action' ] == 'ADD' ) {
      $status = 0;
      if ( isset( $array[ "Status" ] ) )
        $status = 1;
      $dataarray = array( 'Name' => $array[ 'Name' ],
        'DepartmentCode' => $array[ 'DepartmentCode' ],
        
        
        'Status' => $status,
      );
      $this->db->insert( 'Department', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Save Successfull' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
    } 
	  else if ( $array[ 'action' ] == 'EDIT' ) {
		
      $status = 0;
      if ( isset( $array[ "Status" ] ) )
        $status = 1;
      $dataarray = array( 'Name' => $array[ 'Name' ],
        'DepartmentCode' => $array[ 'DepartmentCode' ],
        
        
        'Status' => $status,
      ); 
		  //echo "error==><pre>";print_r($array);print_r($dataarray);exit;
      $this->db->where( 'Id', $array[ 'id' ] );
      $this->db->update( 'Department', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Update Successfull' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
    } elseif ( $array[ 'action' ] == 'delete' ) {

      $dataquery = $this->db->query( "select * from  Faculty where id='" . $array[ 'id' ] . "'" );
      $abc = $dataquery->result_array();

      $file = "./assets/upload_files/Faculty/" . $abc[ 0 ][ 'image' ];

      $query = $this->db->query( "delete from setting where id='" . $array[ 'id' ] . "'" );
      if ( $query ) {
        unlink( $file );
        $resultarray = array( "status" => "success", "msg" => " Record Successfully Deleted" );
        return ( $resultarray );
      } else {
        $resultarray = array( "status" => "error", "msg" => " Record Not Deleted" );;
        return ( $resultarray );
      }
    }
  }





//---------------------Programme-----------------------------------------------------

  public function programme_data() {
    $query = $this->db->query( "select * from Programme " );
    $resultdata = $query->result_array();

    return $resultdata;
  }

  public function get_programme_data( $id ) {
    $query = $this->db->query( "select * from  Programme where Id='" . $id . "'" );
    return $query->result_array();
  }

  public function action_programme( $array ) {
    //echo "error==><pre>aa";print_r($array);exit;
    if ( $array[ 'action' ] == 'ADD' ) {
      $status = 0;
      if ( isset( $array[ "Status" ] ) )
        $status = 1;
      $dataarray = array( 'ProgrammeName' => $array[ 'ProgrammeName' ],
        'ProgrammeCode' => $array[ 'ProgrammeCode' ],
        'DepartmentId' => $array[ 'DepartmentId' ],
        
        
        'Status' => $status,
      );
      $this->db->insert( 'Programme', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Save Successfull' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
    } 
	  else if ( $array[ 'action' ] == 'EDIT' ) {
		
      $status = 0;
      if ( isset( $array[ "Status" ] ) )
        $status = 1;
       $dataarray = array( 'ProgrammeName' => $array[ 'ProgrammeName' ],
        'ProgrammeCode' => $array[ 'ProgrammeCode' ],
        'DepartmentId' => $array[ 'DepartmentId' ],
        
        
        'Status' => $status,
      );
		  //echo "error==><pre>";print_r($array);print_r($dataarray);exit;
      $this->db->where( 'Id', $array[ 'id' ] );
      $this->db->update( 'Programme', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Update Successfull' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
    } elseif ( $array[ 'action' ] == 'delete' ) {

      $dataquery = $this->db->query( "select * from  Programme where id='" . $array[ 'id' ] . "'" );
      $abc = $dataquery->result_array();

      $file = "./assets/upload_files/Faculty/" . $abc[ 0 ][ 'image' ];

      $query = $this->db->query( "delete from Programme where id='" . $array[ 'id' ] . "'" );
      if ( $query ) {
        unlink( $file );
        $resultarray = array( "status" => "success", "msg" => " Record Successfully Deleted" );
        return ( $resultarray );
      } else {
        $resultarray = array( "status" => "error", "msg" => " Record Not Deleted" );;
        return ( $resultarray );
      }
    }
  }

public function get_Programme($departmentId){
     $query = $this->db->query( "select * from  Programme where DepartmentId='" . $departmentId . "'" );
     $count_rowOne = $query->num_rows();
		if ($count_rowOne > 0) {
			$datasOne = $query->result_array();$a=0;
				foreach ($datasOne as $abc_abc) {$a++;
				
				    $resultdata[$a]=$abc_abc;
				}
			
			$resultdatas = array("status" => "success", "msg" => " record found", "data" => $resultdata);
		} else {
			$resultdatas = array("status" => "error", "msg" => "No record found", "data" => '');
		}
    
    return $query->result_array();
}

// fetch all programmes with department code
public function programme_data_with_join()
{
    $this->db->select('p.*, d.DepartmentCode');
    $this->db->from('programme p');
    $this->db->join('department d', 'd.Id = p.DepartmentId', 'left');
    return $this->db->get()->result_array();
}

// fetch single programme for edit page
public function get_programme_data_with_join($id)
{
    $this->db->select('p.*, d.DepartmentCode');
    $this->db->from('programme p');
    $this->db->join('department d', 'd.Id = p.DepartmentId', 'left');
    $this->db->where('p.Id', $id);
    return $this->db->get()->row_array();
}


//---------------------Subject-----------------------------------------------------


  public function subject_data() {
    $query = $this->db->query( "select * from Subject " );
    $resultdata = $query->result_array();

    return $resultdata;
  }

  public function get_subject_data( $id ) {
    $query = $this->db->query( "select * from  Subject where Id='" . $id . "'" );
    return $query->result_array();
  }

  public function action_subject( $array ) {
    //echo "error==><pre>aa";print_r($array);exit;
    if ( $array[ 'action' ] == 'ADD' ) {
      $status = 0;
      if ( isset( $array[ "Status" ] ) )
        $status = 1;
      $dataarray = array( 'SubjectName' => $array[ 'SubjectName' ],
        'SubjectCode' => $array[ 'SubjectCode' ],
        'ProgrammeId' => $array[ 'ProgrammeId' ],
        // 'SemesterId' => $array[ 'SemesterId' ],
        
        
        'Status' => $status,
      );
      $this->db->insert( 'Subject', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Save Successfull' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
    } 
	  else if ( $array[ 'action' ] == 'EDIT' ) {
		
      $status = 0;
      if ( isset( $array[ "Status" ] ) )
        $status = 1;
       $dataarray = array( 'SubjectName' => $array[ 'SubjectName' ],
        'SubjectCode' => $array[ 'SubjectCode' ],
        'ProgrammeId' => $array[ 'ProgrammeId' ],
        // 'SemesterId' => $array[ 'SemesterId' ],
        
        
        'Status' => $status,
      );
		  //echo "error==><pre>";print_r($array);print_r($dataarray);exit;
      $this->db->where( 'Id', $array[ 'id' ] );
      $this->db->update( 'Subject', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Update Successfull' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
    } elseif ( $array[ 'action' ] == 'delete' ) {

      $dataquery = $this->db->query( "select * from  Subject where id='" . $array[ 'id' ] . "'" );
      $abc = $dataquery->result_array();

     // $file = "./assets/upload_files/Faculty/" . $abc[ 0 ][ 'image' ];

      $query = $this->db->query( "delete from Subject where id='" . $array[ 'id' ] . "'" );
      if ( $query ) {
        //unlink( $file );
        $resultarray = array( "status" => "success", "msg" => " Record Successfully Deleted" );
        return ( $resultarray );
      } else {
        $resultarray = array( "status" => "error", "msg" => " Record Not Deleted" );;
        return ( $resultarray );
      }
    }
  }

public function get_Subject($ProgrammeId){
     $query = $this->db->query( "select * from  Subject where ProgrammeId='" . $ProgrammeId . "'" );
     $count_rowOne = $query->num_rows();
		if ($count_rowOne > 0) {
			$datasOne = $query->result_array();$a=0;
				foreach ($datasOne as $abc_abc) {$a++;
				
				    $resultdata[$a]=$abc_abc;
				}
			
			$resultdatas = array("status" => "success", "msg" => " record found", "data" => $resultdata);
		} else {
			$resultdatas = array("status" => "error", "msg" => "No record found", "data" => '');
		}
    
    return $query->result_array();
}

//---------------------AssignPaper-----------------------------------------------------


  public function AssignPaper_data() {
      
      if(is_array($_SESSION['faculty'])){
          $query = $this->db->query( "select * from AssignPaper where FacultyId='".$_SESSION['faculty']['id']."' " );
      }else{
          $query = $this->db->query( "select * from AssignPaper " );
      }
    
    
    	$count_row = $query->num_rows();
		if ($count_row > 0) {
			$datas = $query->result_array();$i=0;
			foreach ($datas as $abc_abc) {$i++;
			$resultdata[$i]=$abc_abc;
			$Facultyquery = $this->db->query( "select Name from Faculty where Id='".$abc_abc['FacultyId']."' " );
			    $resultdataFaculty = $Facultyquery->result_array();
			    $resultdata[$i]['FacultyId']=$resultdataFaculty[0]['Name'];
			    
			$Programmequery = $this->db->query( "select ProgrammeName from Programme where Id='".$abc_abc['ProgrammeId']."' " );
			    $resultdataProgramme = $Programmequery->result_array();
			    $resultdata[$i]['ProgrammeId']=$resultdataProgramme[0]['ProgrammeName'];
			    
			$Departmentquery = $this->db->query( "select Name from Department where Id='".$abc_abc['DepartmentId']."' " );
			    $resultdataDepartment = $Departmentquery->result_array();
			    $resultdata[$i]['DepartmentId']=$resultdataDepartment[0]['Name'];
			    $Subjectquery = $this->db->query( "select SubjectName from Subject where Id='".$abc_abc['SubjectId']."' " );
			    $resultdataSubject = $Subjectquery->result_array();
			    $resultdata[$i]['SubjectId']=$resultdataSubject[0]['SubjectName'];
			    
			}
		}
    
    
    
    //$resultdata = $query->result_array();

    return $resultdata;
  }

  public function get_AssignPaper_data( $id ) {
    $query = $this->db->query( "select * from  AssignPaper where Id='" . $id . "'" );
    return $query->result_array();
  }

  public function action_AssignPaper( $array ) {
    
    if ( $array[ 'action' ] == 'ADD' ) {
        
        $query = $this->db->query( "select * from  AssignPaper where FacultyId='" . $array[ 'FacultyId' ]. "' and DepartmentId='" . $array[ 'DepartmentId' ]. "' and ProgrammeId='" . $array[ 'ProgrammeId' ]. "' and SubjectId='" . $array[ 'SubjectId' ]. "' and FormatId='" . $array[ 'FormatId' ]. "'" );
        	$count_row = $query->num_rows();
        
		if ($count_row > 0) {
		    //	echo "error==><pre>aabb".$count_row;print_r($array);exit;
		$data = array( 'status' => 'error', 'msg' => 'This Paper is Already Assign' );
		    return $data;
		}else{
		    //	echo "error==><pre>aaddddbb".$count_row;print_r($array);exit;
		     $status = 0;
      if ( isset( $array[ "Status" ] ) )
        $status = 1;
      $dataarray = array( 'FacultyId' => $array[ 'FacultyId' ],
        'DepartmentId' => $array[ 'DepartmentId' ],
        'ProgrammeId' => $array[ 'ProgrammeId' ],
        'SubjectId' => $array[ 'SubjectId' ],
        //  'SemesterId' => $array[ 'SemesterId' ],
        //  'SessionId' => $array[ 'SessionId' ],
         'FormatId' => $array[ 'FormatId' ],
         'TotalQuestion'=>$array['TotalQuestion'],
         'LastDate'=>$array['LastDate'],
        
        
        'Status' => $status,
      );
      $this->db->insert( 'AssignPaper', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Save Successfull' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
		    
		}
     
    } 
	  else if ( $array[ 'action' ] == 'EDIT' ) {
		
      $status = 0;
      if ( isset( $array[ "Status" ] ) )
        $status = 1;
       $dataarray = array( 'FacultyId' => $array[ 'FacultyId' ],
        'DepartmentId' => $array[ 'DepartmentId' ],
        'ProgrammeId' => $array[ 'ProgrammeId' ],
        'SubjectId' => $array[ 'SubjectId' ],
        //  'SemesterId' => $array[ 'SemesterId' ],
          'UpdatedOn' => date('Y-m-d'),
         'FormatId' => $array[ 'FormatId' ],
         'TotalQuestion'=>$array['TotalQuestion'],
         'LastDate'=>$array['LastDate'],
        
        
        'Status' => $status,
      );
		  //echo "error==><pre>";print_r($array);print_r($dataarray);exit;
      $this->db->where( 'Id', $array[ 'id' ] );
      $this->db->update( 'AssignPaper', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Update Successfull' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
    } elseif ( $array[ 'action' ] == 'delete' ) {

      $dataquery = $this->db->query( "select * from  AssignPaper where id='" . $array[ 'id' ] . "'" );
      $abc = $dataquery->result_array();

     // $file = "./assets/upload_files/Faculty/" . $abc[ 0 ][ 'image' ];

      $query = $this->db->query( "delete from AssignPaper where id='" . $array[ 'id' ] . "'" );
      if ( $query ) {
        //unlink( $file );
        $resultarray = array( "status" => "success", "msg" => " Record Successfully Deleted" );
        return ( $resultarray );
      } else {
        $resultarray = array( "status" => "error", "msg" => " Record Not Deleted" );;
        return ( $resultarray );
      }
    }
  }

//---------------------AssignPaper Faculty-----------------------------------------------------

public function AssignPaperList_data() {
    $query = $this->db->query( "select * from AssignPaper " );
    
    	$count_row = $query->num_rows();
		if ($count_row > 0) {
			$datas = $query->result_array();$i=0;
			foreach ($datas as $abc_abc) {$i++;
			$resultdata[$i]=$abc_abc;
			$Facultyquery = $this->db->query( "select Name from Faculty where Id='".$abc_abc['FacultyId']."' " );
			    $resultdataFaculty = $Facultyquery->result_array();
			    $resultdata[$i]['FacultyId']=$resultdataFaculty[0]['Name'];
			    
			$Programmequery = $this->db->query( "select ProgrammeName from Programme where Id='".$abc_abc['ProgrammeId']."' " );
			    $resultdataProgramme = $Programmequery->result_array();
			    $resultdata[$i]['ProgrammeId']=$resultdataProgramme[0]['ProgrammeName'];
			    
			$Departmentquery = $this->db->query( "select Name from Department where Id='".$abc_abc['DepartmentId']."' " );
			    $resultdataDepartment = $Departmentquery->result_array();
			    $resultdata[$i]['DepartmentId']=$resultdataDepartment[0]['Name'];
			    $Subjectquery = $this->db->query( "select SubjectName from Subject where Id='".$abc_abc['SubjectId']."' " );
			    $resultdataSubject = $Subjectquery->result_array();
			    $resultdata[$i]['SubjectId']=$resultdataSubject[0]['SubjectName'];
			    
			}
		}
    
    
    
    //$resultdata = $query->result_array();

    return $resultdata;
  }


public function action_AssignPaperList( $array ) {
    //echo "error==><pre>aa".count($array['section_id']);print_r($array);exit;
    if ( $array[ 'action' ] == 'ADD' ) {
      $status = 1;
      if(is_array($array['section_id']) and count($array['section_id'])>0){
          for($i=0;$i<count($array['section_id']);$i++){
              
              $dataarray = array( 'SectionId' => $array['section_id'][$i],
                                'ExamPaper' => $array[ 'id' ],
                                'FormatNumber' => "",
                                'QuestionNumber' => $array[ 'question_number' ][$i],
                                 'QuestionEnglish' => $array[ 'question_english' ][$i],
                                 'QuestionHindi' => $array[ 'question_hindi' ][$i],
                                 
                                
                                
                                'Status' => $status,
                                 );
                                // echo "error==><pre>aa".count($array['section_id']);print_r($dataarray);exit;
      $this->db->insert( 'PaperQuestion', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
       if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Save Successfull' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
          }
      }
      
     // echo "error==><pre>last".count($array['section_id']);print_r($dataarray);exit;
      
     // $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
     
      return $data;
    } 
	  else if ( $array[ 'action' ] == 'EDIT' ) {
		
      $status = 0;
      if ( isset( $array[ "Status" ] ) )
        $status = 1;
       $dataarray = array( 'FacultyId' => $array[ 'FacultyId' ],
        'DepartmentId' => $array[ 'DepartmentId' ],
        'ProgrammeId' => $array[ 'ProgrammeId' ],
        'SubjectId' => $array[ 'SubjectId' ],
        //  'SemesterId' => $array[ 'SemesterId' ],
        //  'SessionId' => $array[ 'SessionId' ],
         'FormatId' => $array[ 'FormatId' ],
        
        
        'Status' => $status,
      );
		  //echo "error==><pre>";print_r($array);print_r($dataarray);exit;
      $this->db->where( 'Id', $array[ 'id' ] );
      $this->db->update( 'AssignPaper', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Update Successfull' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
    } elseif ( $array[ 'action' ] == 'delete' ) {

      $dataquery = $this->db->query( "select * from  AssignPaper where id='" . $array[ 'id' ] . "'" );
      $abc = $dataquery->result_array();

     // $file = "./assets/upload_files/Faculty/" . $abc[ 0 ][ 'image' ];

      $query = $this->db->query( "delete from AssignPaper where id='" . $array[ 'id' ] . "'" );
      if ( $query ) {
        //unlink( $file );
        $resultarray = array( "status" => "success", "msg" => " Record Successfully Deleted" );
        return ( $resultarray );
      } else {
        $resultarray = array( "status" => "error", "msg" => " Record Not Deleted" );;
        return ( $resultarray );
      }
    }
  }

//---------------------setting-----------------------------------------------------


  public function setting_data() {
    $query = $this->db->query( "select * from Setting where Status=1" );
    $resultdata = $query->result_array();

    return $resultdata;
  }

  public function get_setting_data( $id ) {
    $query = $this->db->query( "select * from  Setting where Id='" . $id . "'" );
    return $query->result_array();
  }

  public function action_setting( $array ) {
    //echo "error==><pre>";print_r($array);exit;
    if ( $array[ 'action' ] == 'ADD' ) {
      $status = 0;
      if ( isset( $array[ "Status" ] ) )
        $status = 1;
      $dataarray = array( 'Name' => $array[ 'Name' ],
        'Value' => $array[ 'value' ],
        'InputType' => $array[ 'InputType' ],
        'Status' => $status,
      );
      $this->db->insert( 'Setting', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Save Successfull' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
    } 
	  else if ( $array[ 'action' ] == 'EDIT' ) {
		  
		  if($array['InputType']=='textarea'){
				  	$array['value'] = $array['textarea_val']; 
				  }
				  if($array['InputType']=='text_box'){
					  $array['value']=$array['text_val'];
				  }
		  
      $status = 0;
      if ( isset( $array[ "Status" ] ) )
        $status = 1;
      $dataarray = array( 'Name' => $array[ 'Name' ],
        'Value' => $array[ 'value' ],
        'InputType' => $array[ 'InputType' ],
        'Status' => $status,
      );
		  
		  //echo "error==><pre>";print_r($array);print_r($dataarray);exit;
      $this->db->where( 'id', $array[ 'id' ] );
      $this->db->update( 'Setting', $dataarray );
      $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
      if ( $resultdata == '1' ) {
        $data = array( 'status' => 'success', 'msg' => 'Update Successfull' );
      } else {
        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
      }
      return $data;
    } elseif ( $array[ 'action' ] == 'delete' ) {

      $dataquery = $this->db->query( "select * from  setting where id='" . $array[ 'id' ] . "'" );
      $abc = $dataquery->result_array();

      $file = "./assets/upload_files/setting/" . $abc[ 0 ][ 'image' ];

      $query = $this->db->query( "delete from setting where id='" . $array[ 'id' ] . "'" );
      if ( $query ) {
        unlink( $file );
        $resultarray = array( "status" => "success", "msg" => " Record Successfully Deleted" );
        return ( $resultarray );
      } else {
        $resultarray = array( "status" => "error", "msg" => " Record Not Deleted" );;
        return ( $resultarray );
      }
    }
  }

//---------------------------------PaperChecking----------------------------------------------------


public function PaperChecking_data()
{
    return $this->db->order_by("Id", "DESC")->get("paperchecking")->result_array();
}

public function get_PaperChecking_data($id)
{
    return $this->db->get_where("paperchecking", ["Id" => $id])->result_array();
}

public function insert_PaperChecking($data)
{
    return $this->db->insert("paperchecking", $data);
}

public function update_PaperChecking($data)
{
    return $this->db->where("Id", $data['id'])->update("paperchecking", $data);
}

public function delete_PaperChecking($id)
{
    return $this->db->delete("paperchecking", ["Id" => $id]);
}
}






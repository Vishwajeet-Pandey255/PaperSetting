<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Faculty_model extends CI_Model {


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
                                        $Totalquestiondata = $this->db->query("select sum(TotalQuestion) as GetTotalQuestion from Paperformat where  FormatNumber='" . $abc_abc['FormatNumber'] . "'  ");
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
  
  
  public function get_PaperPreviewList_data_OldBackup($id) {
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
                                                                //        $resultdata[$a]['FormatData'][$i]['SubSection_data'][$j]['SubSection_Questiondata']['lastQuery'] = $this->db->last_query();
                                                        
                                                    }
                                                        
                                                }
                                         }else{
                                        
                                        
                                        
                                                        $queryquestiondata = $this->db->query("select * from PaperQuestion where SectionId='" . $abc_abc['Id'] . "' and ExamPaper=".$id);
                                                        
                                                        $count_queryquestiondata = $queryquestiondata->num_rows();
                                                            if ($count_queryquestiondata > 0) {
                                                                        $resultdata[$a]['FormatData'][$i]['SubSection_Questiondata'] =array();
                                                                        $abcd_question = $queryquestiondata->result_array();
                                                                                $resultdata[$a]['FormatData'][$i]['SubSection_Questiondata'] = $abcd_question;
                                                                        //        $resultdata[$a]['FormatData'][$i]['SubSection_Questiondata']['lastQuery'] = $this->db->last_query();
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
        'PaperStatus' => 2,
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

 public function programme_data() {
    $query = $this->db->query( "select * from Programme " );
    $resultdata = $query->result_array();

    return $resultdata;
  }
  
   public function department_data() {
    $query = $this->db->query( "select * from Department " );
    $resultdata = $query->result_array();

    return $resultdata;
  }
  public function faculty_data() {
    $query = $this->db->query( "select * from Faculty " );
    $resultdata = $query->result_array();

    return $resultdata;
  }
 public function subject_data() {
    $query = $this->db->query( "select * from Subject " );
    $resultdata = $query->result_array();

    return $resultdata;
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
                            $Subjectquery = $this->db->query( "select SubjectName,SubjectCode from Subject where Id='".$abc_abc['SubjectId']."' " );
                            $resultdataSubject = $Subjectquery->result_array();
                            $resultdata[$i]['SubjectId']=$resultdataSubject[0]['SubjectName'];
                            $resultdata[$i]['SubjectCode']=$resultdataSubject[0]['SubjectCode'];
                            
                            $PaperQuestion = $this->db->query( "select * from PaperQuestion where ExamPaper='".$abc_abc['Id']."' and QuestionEnglish!='' " );
                            $Questioncount_row = $PaperQuestion->num_rows();
                           // $resultdata[$i]['PaperQuestion']=$resultPaperQuestion;
                            $resultdata[$i]['PaperQuestion']=0;
                            if ($Questioncount_row > 0) {
                                $resultdata[$i]['PaperQuestion']=$Questioncount_row;
                                $Mydatas = $PaperQuestion->result_array();$m=0;
                                    foreach ($Mydatas as $abc_abc) {$m++;
                            //        $resultdata[$i]['PaperQuestion']=$abc_abc;
                                }
                            }
                            
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
    //echo "error==><pre>aa";print_r($array);exit;
    if ( $array[ 'action' ] == 'ADD' ) {
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
      $this->db->insert( 'AssignPaper', $dataarray );
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
			    $Subjectquery = $this->db->query( "select SubjectName from Subject where Id='".$abc_abc['DepartmentId']."' " );
			    $resultdataSubject = $Subjectquery->result_array();
			    $resultdata[$i]['SubjectId']=$resultdataSubject[0]['SubjectName'];
			    
			}
		}
    
    
    
    //$resultdata = $query->result_array();

    return $resultdata;
  }
public function toSeconds($timeStr) {
    preg_match('/(\d+)h (\d+)m (\d+)s/', $timeStr, $matches);
    $hours = isset($matches[1]) ? (int)$matches[1] : 0;
    $minutes = isset($matches[2]) ? (int)$matches[2] : 0;
    $seconds = isset($matches[3]) ? (int)$matches[3] : 0;
    return ($hours * 3600) + ($minutes * 60) + $seconds;
}


public function action_AssignPaperList( $array, $files ) {

    $j=1;
    
    if ( $array[ 'action' ] == 'ADD' ) {
       
       
         $lastdatequery = $this->db->query( "select LastDate from AssignPaper  where Id='".$array[ 'id' ]."' " );
         $LastDatedata = $lastdatequery->result_array();
         if(date('Y-m-d')<=$LastDatedata[0]['LastDate']){
             //echo "yes";
              $query = $this->db->query( "select * from PaperQuestion  where ExamPaper='".$array[ 'id' ]."' " );
        
            	$count_row = $query->num_rows();
        		if ($count_row > 0) {
        		    //echo "hiii";
        		     $query = $this->db->query( "delete from PaperQuestion where ExamPaper='" . $array[ 'id' ] . "'" );
                      if ( $query ) {
                     //echo "dfsdfdsf";     
                          
                      }
        		}
            
                //echo $totalSeconds."error==><pre>aa".$LastDatedata[0]['LastDate'];print_r($array);exit;
              $status = 1;
              if(is_array($array['section_id']) and count($array['section_id'])>0){
                  for($i=0;$i<count($array['section_id']);$i++){

                  $isMCQ = (isset($array['question_type'][$i]) && $array['question_type'][$i] == 1);


                    
                $finalImages = [];

                if (!$isMCQ) {

    // ======== IMAGE CODE START ========

  

$deletedImages = [];

if (!empty($array['deleted_images'])) {
    $deletedImages = explode(',', $array['deleted_images']);
}



    $existingImages = [];

    if (isset($array['existing_images'][$i]) && is_array($array['existing_images'][$i])) {
        $existingImages = $array['existing_images'][$i];
    }

    /* ---------- DELETE IMAGES ---------- */
    if (!empty($deletedImages)) {
        foreach ($deletedImages as $delImg) {
            if (in_array($delImg, $existingImages)) {
                unset($existingImages[array_search($delImg, $existingImages)]);
                $filePath = './assets/Question/' . $delImg;
                if (file_exists($filePath)) unlink($filePath);
            }
        }
        $existingImages = array_values($existingImages);
    }

    /* ---------- UPLOAD IMAGES ---------- */
    $newImages = [];

    if (isset($_FILES['question_images']['name'][$i]) && is_array($_FILES['question_images']['name'][$i])) {
        foreach ($_FILES['question_images']['name'][$i] as $key => $name) {

            if ($name == '') continue;

            $_FILES['file']['name']     = $_FILES['question_images']['name'][$i][$key];
            $_FILES['file']['type']     = $_FILES['question_images']['type'][$i][$key];
            $_FILES['file']['tmp_name'] = $_FILES['question_images']['tmp_name'][$i][$key];
            $_FILES['file']['error']    = $_FILES['question_images']['error'][$i][$key];
            $_FILES['file']['size']     = $_FILES['question_images']['size'][$i][$key];

            $config['upload_path']   = './assets/Question/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['encrypt_name']  = TRUE;

            $this->upload->initialize($config);
            if ($this->upload->do_upload('file')) {
                $imgData = $this->upload->data();
                $newImages[] = $imgData['file_name'];
            }
        }
    }

    /* ---------- FINAL IMAGE LIST ---------- */
    $finalImages = array_merge($existingImages, $newImages);

    // ======== IMAGE CODE END ========
}

        
                      
                             $dataarray = array( 'SectionId' => $array['section_id'][$i],
                                        'ExamPaper' => $array[ 'id' ],
                                        'FormatNumber' => "",
                                        'QuestionNumber' => $array[ 'question_number' ][$i],
                                         'QuestionEnglish' => $array[ 'question_english' ][$i],
                                         'QuestionHindi' => $array[ 'question_hindi' ][$i],
                                         'QuestionType' => $array[ 'question_type' ][$i],
                                         
                                         'eng_option_one' => $array[ 'eng_option'.$j ][0],
                                         'eng_option_two' => $array[ 'eng_option'.$j ][1],
                                         'eng_option_three' => $array[ 'eng_option'.$j ][2],
                                         'eng_option_four' => $array[ 'eng_option'.$j ][3],
                                         
                                         'hin_option_one' => $array[ 'hin_option'.$j ][0],
                                         'hin_option_two' => $array[ 'hin_option'.$j ][1],
                                         'hin_option_three' => $array[ 'hin_option'.$j ][2],
                                         'hin_option_four' => $array[ 'hin_option'.$j ][3],
                                          'QuestionImage' => implode(',', $finalImages),
 
                                        'Status' => $status,
                                         );$j++;
                                         //echo "error==><pre>aa".count($array['section_id']);print_r($dataarray);exit;
              $this->db->insert( 'PaperQuestion', $dataarray );
              $resultdata = ( $this->db->affected_rows() != 1 ) ? false : true;
                        if ( $resultdata == '1' ) {
                            //----------------timer------------------------
                            if($i==0){
                             $query = $this->db->query( "select ConsumeTime from AssignPaper  where Id='".$array[ 'id' ]."' " );
                                $datas = $query->result_array();
                                
                                $totalSeconds = $this->toSeconds($datas[0]['ConsumeTime']) + $this->toSeconds($array[ 'papertime' ]); 
                              
                              $hours = floor($totalSeconds / 3600);
                              $minutes = floor(($totalSeconds % 3600) / 60);
                              $seconds = $totalSeconds % 60;
                    
                               $dataarray = array( 'ConsumeTime' => sprintf("%dh %dm %ds", $hours, $minutes, $seconds) );
                    		   $this->db->where( 'Id', $array[ 'id' ] );
                               $this->db->update( 'AssignPaper', $dataarray );
                            }
                     //----------------timer------------------------
                           
                        $data = array( 'status' => 'success', 'msg' => 'Save Successfull' );
                        } else {
                        $data = array( 'status' => 'error', 'msg' => 'some thing went wrong' );
                        }
                  }
                  
              }
              
         }else{
             $data = array( 'status' => 'error', 'msg' => 'You cannot submit this paper because the last date for submission has passed, Please Contact your Admin ' );
         }
              
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



  //---------------------PasswordChange-----------------------------------------------------

public function changePassword($data)
{
    $CI = &get_instance();
    $facultyId = $_SESSION['faculty']['id']; // FIXED

    $oldPassword = md5($data['oldPassword']);
    $newPassword = md5($data['newPassword']);
    $confirmPassword = md5($data['confirmPassword']);

    // Check old password from DB
    $CI->db->where('Id', $facultyId);
    $CI->db->where('Password', $oldPassword);
    $query = $CI->db->get('Faculty');

    if ($query->num_rows() == 0) {
        return ['responce' => 'error', 'message' => 'Old password is incorrect!'];
    }

    if ($newPassword != $confirmPassword) {
        return ['responce' => 'error', 'message' => 'New & Confirm password do not match!'];
    }

    // Update password
    $CI->db->where('Id', $facultyId);
    $update = $CI->db->update('Faculty', ['Password' => $newPassword]);

    if ($update) {
        return ['responce' => 'success', 'message' => 'Password changed successfully!'];
    } else {
        return ['responce' => 'error', 'message' => 'Something went wrong, try again!'];
    }
}

//----------------------------------- Faculty -----------------------------------------------------



public function get_faculty_data( $id ) { 
    $query = $this->db->query( "select * from  Faculty where Id='" . $id . "'" );
    return $query->result_array();
  }

public function get_Paper_By_Faculty($facultyId)
{
    return $this->db->where('FacultyId', $facultyId)
                    ->get('paperchecking')
                    ->result_array();
}


}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty extends CI_Controller {

	
	  
	 public function __construct(){
         
		parent::__construct();
       
	$this->load->helper(array('file','directory','url'));
	$this->load->model("Admin_model");
	$this->load->model("Faculty_model");
     $this->load->helper('Token_Helpers'); 
	
		  $this->load->library('email');
        $this->load->helper('form','url');
       // $this->load->library('session');
      
	  
        
    }
	 
	public function index()
	{
	     if (isset($_SESSION['admin'])) {
	        $this->load->view('dashboard');
	     }else{
	         $this->load->view('login');
	     }
	}
	
	
	
	
	public function dashboard()

	{
         //echo "error==><pre>";print_r($_POST);exit;
	     if (isset($_SESSION['admin']) || isset($_SESSION['faculty'])) {
	        	$this->load->view('dashboard');
	     }else{
	          $this->load->view('login');
	     }
	}
	

       
   
         // ------------------------------AssignPaper-------------------------------------   
        
          public function AssignPaper(){
        if(is_array($_SESSION['admin'])){
              if((isset($_GET['id'])) && ($_GET['action']=='edit')){
                $data['get_AssignPaper_data']=$this->Admin_model->get_AssignPaper_data($_GET['id']);
                 $data['programme_data']=$this->Admin_model->programme_data();
                  $data['faculty_data']=$this->Admin_model->faculty_data();
                 $data['department_data']=$this->Admin_model->department_data();
                 $data['subject_data']=$this->Admin_model->subject_data();
                 $data['PaperFormat_data']=$this->Admin_model->PaperFormat_data();
                  $this->load->view('AssignPaper',$data); 
              }
              elseif((isset($_GET['id'])) && ($_GET['action']=='delete')){
              $data=$this->Admin_model->action_AssignPaper($_GET);
              $this->session->set_flashdata('responce_message', $data);
              redirect("Admin_user/AssignPaper",$data);
                }
               
               else{ 
                 $data['AssignPaper_data']=$this->Admin_model->AssignPaper_data();//echo "hello000";print_r($data['subject_data']);exit;
                  $data['programme_data']=$this->Admin_model->programme_data();
                 $data['department_data']=$this->Admin_model->department_data();
                  $data['faculty_data']=$this->Admin_model->faculty_data();
                 $data['subject_data']=$this->Admin_model->subject_data();
                 $data['PaperFormat_data']=$this->Admin_model->PaperFormat_data();
                  $this->load->view('AssignPaper',$data); 
				  // redirect("admin/setting",$data);
                }
              }
            else{
                $this->load->view('login');
            }
    }  
    
     public function action_AssignPaper(){
			if(is_array($_SESSION['admin'])){
		//	echo "error==><pre>";print_r($_POST);exit;
          if($_POST['action']=='ADD'){
			  $data=$this->Admin_model->action_AssignPaper($_POST);
              //$this->session->set_flashdata('responce_message', $data);
              $data['AssignPaper_data']=$this->Admin_model->AssignPaper_data();
			   redirect('Faculty/AssignPaper',$data);
			  //echo "error==><pre>hii";print_r($_FILES);print_r($_REQUEST);exit;
			 
			  
          }
          elseif($_POST['action']=='EDIT'){
			 
				  $data=$this->Admin_model->action_AssignPaper($_POST);
                  $this->session->set_flashdata('responce_message', $data);
				  redirect('Faculty/AssignPaper',$data);
			  
			  //echo "error==><pre>hii";print_r($_FILES);print_r($_REQUEST);exit;
			 
			  
          }
          else{
                $data['AssignPaper_data']=$this->Admin_model->AssignPaper_data();
                  $this->load->view('AssignPaper',$data); 
           }
			}
            else{
                $this->load->view('login');
            }
        }
        
        
          // ------------------------------AssignPaper Faculty-------------------------------------   
        
          public function AssignPaperList(){
              //echo "error==><pre>";print_r($_POST);exit;
        if(is_array($_SESSION['admin'])  || is_array($_SESSION['faculty'])){
              if((isset($_GET['id'])) && ($_GET['action']=='edit')){
                $data['get_AssignPaper_data']=$this->Admin_model->get_AssignPaper_data($_GET['id']);
                 $data['programme_data']=$this->Admin_model->programme_data();
                  $data['faculty_data']=$this->Admin_model->faculty_data();
                 $data['department_data']=$this->Admin_model->department_data();
                 $data['subject_data']=$this->Admin_model->subject_data();
                 $data['PaperFormat_data']=$this->Admin_model->PaperFormat_data();
                  $this->load->view('AssignPaper',$data); 
              }
              elseif((isset($_GET['id'])) && ($_GET['action']=='AddQuestion')){
              $data['PaperPreview_data']=$this->Faculty_model->get_PaperPreviewList_data($_GET['id']);
              //echo "hello000";print_r($data['PaperPreview_data']);exit;
              $this->session->set_flashdata('responce_message', $data);
              $this->load->view('AssignPaperList',$data);
                }
                
                elseif((isset($_GET['id'])) && ($_GET['action']=='ApprovePaper')){
              $data['PaperPreview_data']=$this->Faculty_model->Send_ApprovePaper($_GET['id']);
             // echo "hello000";print_r($data['PaperPreview_data']);exit;
             // $data['AssignPaper_data']=$this->Admin_model->AssignPaper_data();
               $this->session->set_flashdata('responce_message', $data);
				  redirect('Faculty/AssignPaperList',$data);
                }
                
                
                 elseif((isset($_GET['id'])) && ($_GET['action']=='ViewQuestion')){
              $data['PaperPreview_data']=$this->Faculty_model->get_PaperPreviewList_data($_GET['id']);
              //echo "hello000";print_r($data['PaperPreview_data']);exit;
              $this->session->set_flashdata('responce_message', $data);
              $this->load->view('AssignPaperList',$data);
                }
               
               else{ 
                 $data['AssignPaper_data']=$this->Faculty_model->AssignPaper_data();//echo "hello000";print_r($data['subject_data']);exit;
                  $data['programme_data']=$this->Faculty_model->programme_data();
                 $data['department_data']=$this->Faculty_model->department_data();
                  $data['faculty_data']=$this->Faculty_model->faculty_data();
                 $data['subject_data']=$this->Faculty_model->subject_data();
                 $data['PaperFormat_data']=$this->Faculty_model->PaperFormat_data();
                  $this->session->set_flashdata('responce_message', $data);
                  $this->load->view('AssignPaperList',$data); 
				  // redirect("admin/setting",$data);
                }
              }
            else{
                $this->load->view('login');
            }
    }  
    
    public function action_AssignPaperList()
{
    
    if (is_array($_SESSION['admin']) || is_array($_SESSION['faculty'])) {

        if (isset($_POST['action']) && $_POST['action'] == 'ADD') {

            // Pass POST + FILES
            $data = $this->Faculty_model->action_AssignPaperList($_POST, $_FILES);

            $this->session->set_flashdata('responce_message', $data);
            redirect('Faculty/AssignPaperList');

        }
        elseif (isset($_POST['action']) && $_POST['action'] == 'EDIT') {

            // Pass POST + FILES (safe for future use)
            $data = $this->Admin_model->action_AssignPaperList($_POST, $_FILES);

            $this->session->set_flashdata('responce_message', $data);
            redirect('Faculty/AssignPaperList');

        }
        else {

            $data['AssignPaper_data'] = $this->Admin_model->AssignPaper_data();
            $this->load->view('AssignPaperList', $data);
        }

    } else {
        $this->load->view('login');
    }
}


    // ---------------------------- Change Password ----------------------------
    public function ChangePassword()
    {
        
        validateToken();

        if (is_array($_SESSION['faculty']) || is_array($_SESSION['admin'])) {

            if ($this->input->post('action') == 'CHANGE_PASSWORD') {
                $data = $this->Faculty_model->changePassword($_POST);
                $this->session->set_flashdata('responce_message', $data);
                redirect('Faculty/ChangePassword');
            } else {
                $this->load->view('ChangePassword');
            }

        } else {
            $this->load->view('login');
        }
    }

    // ---------------------------- User Profile ----------------------------
    public function UserProfile()
    {
        
        validateToken();

        if (!is_array($_SESSION['admin']) && !is_array($_SESSION['faculty'])) {
            $this->load->view('login');
            return;
        }

        $facultyId = is_array($_SESSION['faculty']) ? $_SESSION['faculty']['id'] : $_SESSION['admin']['id'];
        $this->load->model('Faculty_model');

        if ($this->input->get('action') == 'update') {
            $updateData = [
                "DateOfJoining"        => $this->input->post('DateOfJoining'),
                "Gender"               => $this->input->post('Gender'),
                "Designation"          => $this->input->post('Designation'),
                "ExperienceYears"      => $this->input->post('ExperienceYears'),
                "HighestQualification" => $this->input->post('HighestQualification'),
                "Specialization"       => $this->input->post('Specialization'),
                "DateOfBirth"          => $this->input->post('DateOfBirth'),
            ];

            if (!empty($_FILES['ProfileImage']['name'])) {
                $config['upload_path']   = FCPATH . 'assets/Uploads/Profile/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 2048;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('ProfileImage')) {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('Faculty/UserProfile?action=edit&id=' . $facultyId);
                } else {
                    $fileData = $this->upload->data();
                    $updateData['ProfileImage'] = $fileData['file_name'];
                }
            }

            $this->db->where('Id', $facultyId);
            $this->db->update("Faculty", $updateData);

            $this->session->set_flashdata('success', 'Profile updated successfully.');
            redirect('Faculty/UserProfile');
        }

        $data['faculty_profile'] = $this->Faculty_model->get_faculty_data($facultyId);
        $this->load->view('UserProfile', $data);
    }

    // ---------------------------- Assign Paper Checking ----------------------------
    public function AssignPaperChecking()
    {
        validateToken();

        if (!$this->session->userdata('faculty')) {
            redirect(base_url('Faculty/Login'));
            return;
        }

        $facultyId = $this->session->userdata('faculty')['id'];
        $data['pgMod'] = "AssignPaperChecking";
        $data['pgAct'] = "view";
        $data['CheckPaper'] = $this->Faculty_model->get_Paper_By_Faculty($facultyId);

        $this->load->view('AssignPaperChecking', $data);
    }


public function ViewPaper($id)
{
    // Fetch file info from paperchecking table
    $paper = $this->db->get_where('paperchecking', ['Id' => $id])->row_array();

    if (!$paper) {
        show_error("Paper not found.");
        return;
    }

    $data['pdf_file_path'] = $paper['PaperUpload'];  // Correct column

    $this->load->view('MarksAssigning', $data);
}





}

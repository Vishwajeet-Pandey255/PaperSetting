<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_user extends CI_Controller
{



  public function __construct()
  {
    parent::__construct();
    $this->load->helper(array('file', 'directory', 'url'));
    $this->load->model("Dashboard_model");
    $this->load->model("Admin_model");


    $this->load->library('email');
    $this->load->helper(array('form', 'url'));

    // $this->load->library('session');



  }

  public function index()
  {
    if (isset($_SESSION['admin'])) {
      $this->load->view('dashboard');
    } else {
      $this->load->view('login');
    }
  }


  public function admin_login()
{

    if (is_array($_REQUEST) && count($_REQUEST) > 0) {
        $data = $this->Admin_model->admin_login($_REQUEST);

        if (is_array($data) && isset($data['status']) && $data['status'] === "success") {

            // -------------------------------
            // 🔐 Generate secure token
            // -------------------------------
            $token = bin2hex(random_bytes(32));

            // Save token and admin data in session
            $this->session->set_userdata([
                'access_token' => $token,
                'admin'        => $data,  // optional: store admin data
                'admin_id'     => $data['id']
            ]);

            // Flash success message (optional)
            $this->session->set_flashdata('responce_message', [
                'status' => 'success',
                'message' => 'Login successful',
                'token' => $token // optional: for debugging
            ]);

            // Redirect to dashboard
            redirect('Admin_user/dashboard');

        } else {
            // Login failed
            $this->session->set_flashdata('responce_message', [
                'status' => 'error',
                'message' => 'Invalid credentials'
            ]);
            redirect("Admin_user/login");
        }

    } else {
        // Show login page if request is empty
        $this->load->view('login');
    }


    
   
  }
  public function login()
  {
      $this->load->view('login', $data);
  }

public function dashboard()
{
 
    // 🔐 Validate token
    $this->load->helper('Token_Helpers');
    validateToken();

    // 📊 Dashboard summary data
    $data['last_subjects']     = $this->Dashboard_model->last_subjects(5);
    $data['last_departments'] = $this->Dashboard_model->last_departments(5);
    $data['last_programmes']  = $this->Dashboard_model->last_programmes(5);
    $data['last_formats']     = $this->Dashboard_model->last_formats(5);
    $data['last_faculty']     = $this->Dashboard_model->last_faculty(5);
$statusData = $this->Dashboard_model->get_paper_status_count();

$assign = $approve = $reject = 0;

foreach ($statusData as $row) {
    if ($row['PaperStatus'] == 1) $assign = $row['total'];
    if ($row['PaperStatus'] == 3) $approve = $row['total'];
    if ($row['PaperStatus'] == 4) $reject = $row['total'];
}

$data['assign']  = $assign;
$data['approve'] = $approve;
$data['reject']  = $reject;


$counts = $this->Dashboard_model->get_dashboard_counts();

$data['count_faculty']     = $counts['faculty'];
$data['count_subjects']    = $counts['subjects'];
$data['count_programmes']  = $counts['programmes'];
$data['count_departments'] = $counts['departments'];
$data['count_formats']     = $counts['formats'];



    // 🖥 Load dashboard view
    $this->load->view('dashboard', $data);
}



  //----------------------------Faculty Master------------------------------------------------
  //----------------------------End Faculty Master------------------------------------------------



  //----------------------------Faculty Master------------------------------------------------

 public function faculty()
{
    validateToken(); // ✅ Check token and redirect if invalid

    if (is_array($_SESSION['admin'])) {
        if ((isset($_GET['id'])) && ($_GET['action'] == 'edit')) {
            $data['get_faculty_data'] = $this->Admin_model->get_faculty_data($_GET['id']);
            $this->session->set_flashdata('responce_message', $data);
            $this->load->view('Faculty', $data);
        } elseif ((isset($_GET['id'])) && ($_GET['action'] == 'delete')) {
            $data = $this->Admin_model->action_faculty($_GET);
            $this->session->set_flashdata('responce_message', $data);
            redirect("Admin_user/faculty");
        } else {
            $data['faculty_data'] = $this->Admin_model->faculty_data();
            $this->load->view('Faculty', $data);
            $token = $this->session->userdata('access_token');

        }
    } else {
        redirect('Admin_user/login');
    }
}

 public function action_faculty()
{
    validateToken(); // ✅ Check token and redirect if invalid

    if (is_array($_SESSION['admin'])) {

        if ($_POST['action'] == 'ADD') {
            $email = trim($_POST['Email']);
            $phone = trim($_POST['PhoneNumber']);

            if (!validate_email($email) || !validate_phone($phone)) {
                redirect('Admin_user/faculty?action=add');
                return;
            }

            $data = $this->Admin_model->action_faculty($_POST);
            $this->session->set_flashdata('responce_message', $data);
            redirect('Admin_user/faculty');

        } elseif ($_POST['action'] == 'EDIT') {

            $id = $_POST['Id'];
            $email = trim($_POST['Email']);
            $phone = trim($_POST['PhoneNumber']);

            if (!validate_email($email, $id) || !validate_phone($phone, $id)) {
                redirect('Admin_user/faculty');
                return;
            }

            $data = $this->Admin_model->action_faculty($_POST);
            $this->session->set_flashdata('responce_message', $data);
            redirect('Admin_user/faculty');
        }

    } else {
        redirect('Admin_user/login');
    }
}

  //----------------------------End Faculty Master------------------------------------------------	



  //----------------------------Department Master------------------------------------------------
 public function department()
{
    // 🔐 Validate token first
    validateToken();

    // ✅ Check if admin session exists
    if (isset($_SESSION['admin']) && is_array($_SESSION['admin'])) {

        // ✏️ Edit department
        if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === 'edit') {
            $data['get_department_data'] = $this->Admin_model->get_department_data($_GET['id']);
            $this->session->set_flashdata('responce_message', $data);
            $this->load->view('Department', $data);

        // 🗑 Delete department
        } elseif (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === 'delete') {
            $data = $this->Admin_model->action_department($_GET);
            $this->session->set_flashdata('responce_message', $data);
            redirect("Admin_user/department");

        // 📋 List all departments (default)
        } else {
            $data['department_data'] = $this->Admin_model->department_data();
            $this->load->view('Department', $data);
        }

    } else {
        // ❌ No admin session or token invalid
        redirect('Admin_user/login');
    }
}
public function action_department()
{
    // ✅ Validate token first
    validateToken(); 

    // ✅ Check admin session
    if (isset($_SESSION['admin']) && is_array($_SESSION['admin'])) {

        $action = $_POST['action'] ?? '';

        // ---------------------------
        // ADD DEPARTMENT
        // ---------------------------
        if ($action === 'ADD') {
            $name = $_POST['Name'] ?? '';
            $departmentCode = $_POST['DepartmentCode'] ?? '';

            // Validate input
            if (!validate_department($name, $departmentCode)) {
                redirect('Admin_user/department?action=add');
                return;
            }

            // Insert department
            $data = $this->Admin_model->action_department($_POST);
            $this->session->set_flashdata('responce_message', $data);
            redirect('Admin_user/department');

        }
        // ---------------------------
        // EDIT DEPARTMENT
        // ---------------------------
        elseif ($action === 'EDIT') {
            $id = $_POST['Id'] ?? '';
            $name = $_POST['Name'] ?? '';
            $departmentCode = $_POST['DepartmentCode'] ?? '';

            // Validate input
            if (!validate_department($name, $departmentCode)) {
                redirect('Admin_user/department?action=edit&id=' . $id);
                return;
            }

            // Update department
            $data = $this->Admin_model->action_department($_POST);
            $this->session->set_flashdata('responce_message', $data);
            redirect('Admin_user/department');

        }
        // ---------------------------
        // DEFAULT: LIST VIEW
        // ---------------------------
        else {
            $data['department_data'] = $this->Admin_model->department_data();
            $this->load->view('Department', $data);
        }

    } else {
        // ❌ Session invalid — redirect to login
        redirect('Admin_user/login');
    }
}


  //----------------------------End Department Master------------------------------------------------


  //----------------------------Programme Master------------------------------------------------
 public function programme() 
{
    // ✅ Validate token first
    validateToken(); 

    // ✅ Check admin session
    if (!isset($_SESSION['admin']) || !is_array($_SESSION['admin'])) {
        redirect('Admin_user/login');
        return;
    }

    // ---------------------------
    // EDIT MODE
    // ---------------------------
    if (isset($_GET['id']) && $_GET['action'] === 'edit') {
        $data['get_programme_data'] = $this->Admin_model->get_programme_data_with_join($_GET['id']);
        $data['department_data'] = $this->Admin_model->department_data();

        $this->load->view('Programme', $data);
        return;
    }

    // ---------------------------
    // DEFAULT LIST VIEW
    // ---------------------------
    $data['programme_data'] = $this->Admin_model->programme_data_with_join();
    $data['department_data'] = $this->Admin_model->department_data();

    $this->load->view('Programme', $data);
}

public function action_programme()
{
    // ✅ Validate token first
    validateToken(); 

    // ✅ Check admin session
    if (!isset($_SESSION['admin']) || !is_array($_SESSION['admin'])) {
        redirect('Admin_user/login');
        return;
    }

    $action = $_POST['action'] ?? '';

    // ---------------------------
    // ADD PROGRAMME
    // ---------------------------
    if ($action === 'ADD') {
        $programmeName = $_POST['ProgrammeName'] ?? '';
        $programmeCode = $_POST['ProgrammeCode'] ?? '';

        // Validate input
        if (!validate_programme($programmeName, $programmeCode)) {
            redirect('Admin_user/programme?action=add');
            return;
        }

        // Insert programme
        $data = $this->Admin_model->action_programme($_POST);
        $this->session->set_flashdata('responce_message', $data);
        redirect('Admin_user/programme');
    }
    // ---------------------------
    // EDIT PROGRAMME
    // ---------------------------
    elseif ($action === 'EDIT') {
        $data = $this->Admin_model->action_programme($_POST);
        $this->session->set_flashdata('responce_message', $data);
        redirect('Admin_user/programme');
    }
    // ---------------------------
    // DEFAULT: LIST VIEW
    // ---------------------------
    else {
        $data['programme_data'] = $this->Admin_model->programme_data_with_join();
        $data['department_data'] = $this->Admin_model->department_data();
        $this->load->view('Programme', $data);
    }
}

public function get_Programme()
{
    // ✅ Validate token first
    validateToken(); 

    // ✅ Check admin session
    if (!isset($_SESSION['admin']) || !is_array($_SESSION['admin'])) {
        redirect('Admin_user/login');
        return;
    }

    $DepartmentId = $_GET['DepartmentId'] ?? null;

    if ($DepartmentId) {
        $data = $this->Admin_model->get_Programme($DepartmentId);
        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
}

  //----------------------------End Programme Master------------------------------------------------



  //----------------------------Subject Master------------------------------------------------
public function subject()
{
    // ✅ Validate token
    validateToken();

    // ✅ Check admin session
    if (!isset($_SESSION['admin']) || !is_array($_SESSION['admin'])) {
        redirect('Admin_user/login');
        return;
    }

    // Fetch all programmes and departments
    $programme_data = $this->Admin_model->programme_data();
    $department_data = $this->Admin_model->department_data();

    // Map ProgrammeId => ProgrammeCode
    $prog_map = [];
    foreach ($programme_data as $p) {
        $prog_map[$p['Id']] = $p['ProgrammeCode'];
    }

    // ---------------------------
    // EDIT MODE
    // ---------------------------
    if (isset($_GET['id']) && $_GET['action'] === 'edit') {

        $subject = $this->Admin_model->get_subject_data($_GET['id']);

        if (!empty($subject) && isset($subject['ProgrammeId'])) {
            $subject['ProgrammeCode'] = $prog_map[$subject['ProgrammeId']] ?? '';
        }

        $data['get_subject_data'] = $subject;
        $data['department_data'] = $department_data;
        $data['programme_data'] = $programme_data;

        $this->session->set_flashdata('responce_message', $data);
        $this->load->view('Subject', $data);
        return;
    }

    // ---------------------------
    // DEFAULT LIST VIEW
    // ---------------------------
    $subjects = $this->Admin_model->subject_data();
    foreach ($subjects as &$s) {
        $s['ProgrammeCode'] = $prog_map[$s['ProgrammeId']] ?? '';
    }

    $data['subject_data'] = $subjects;
    $data['programme_data'] = $programme_data;
    $data['department_data'] = $department_data;

    $this->load->view('Subject', $data);
}

public function action_subject()
{
    // ✅ Validate token
    validateToken();

    // ✅ Check admin session
    if (!isset($_SESSION['admin']) || !is_array($_SESSION['admin'])) {
        redirect('Admin_user/login');
        return;
    }

    $action = $_POST['action'] ?? '';

    // ---------------------------
    // ADD SUBJECT
    // ---------------------------
    if ($action === 'ADD') {
        $programmeId = $_POST['ProgrammeId'] ?? '';
        $subjectName = $_POST['SubjectName'] ?? '';
        $subjectCode = $_POST['SubjectCode'] ?? '';

        if (!validate_subject($programmeId, $subjectName, $subjectCode)) {
            redirect('Admin_user/subject?action=add');
            return;
        }

        $data = $this->Admin_model->action_subject($_POST);
        $this->session->set_flashdata('responce_message', $data);
        redirect('Admin_user/subject');
    }

    // ---------------------------
    // EDIT SUBJECT
    // ---------------------------
    elseif ($action === 'EDIT') {
        $id = $_POST['Id'] ?? '';
        $programmeId = $_POST['ProgrammeId'] ?? '';
        $subjectName = $_POST['SubjectName'] ?? '';
        $subjectCode = $_POST['SubjectCode'] ?? '';

        if (!validate_subject($programmeId, $subjectName, $subjectCode)) {
            redirect('Admin_user/subject?action=edit&id=' . $id);
            return;
        }

        $data = $this->Admin_model->action_subject($_POST);
        $this->session->set_flashdata('responce_message', $data);
        redirect('Admin_user/subject');
    }

    // ---------------------------
    // DEFAULT CASE
    // ---------------------------
    else {
        $data['subject_data'] = $this->Admin_model->subject_data();
        $this->load->view('Subject', $data);
    }
}

public function get_Subject()
{
    // ✅ Validate token
    validateToken();

    // ✅ Check admin session
    if (!isset($_SESSION['admin']) || !is_array($_SESSION['admin'])) {
        redirect('Admin_user/login');
        return;
    }

    $ProgrammeId = $_GET['ProgrammeId'] ?? null;

    if ($ProgrammeId) {
        $data = $this->Admin_model->get_Subject($ProgrammeId);
        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
}

  //----------------------------End Subject Master------------------------------------------------


  //----------------------------Paper Format Master------------------------------------------------

  public function PaperFormat()
{
    
    // ✅ Validate token
    validateToken();

    // ✅ Check admin session
    if (!isset($_SESSION['admin']) || !is_array($_SESSION['admin'])) {
        
        redirect('Admin_user/login');
        return;
    }

    // ---------------------------
    // VIEW SPECIFIC PAPER FORMAT
    // ---------------------------
    if (isset($_GET['id']) && $_GET['action'] === 'viewdata') {
        $data['PaperFormat_data'] = $this->Admin_model->get_PaperFormat_data($_GET['id']);

        // Optional: flash data if you want messages
        $this->session->set_flashdata('responce_message', $data);

        $this->load->view('PaperFormat', $data);
        return;
    }

    // ---------------------------
    // DEFAULT LIST VIEW
    // ---------------------------
    $data['PaperFormat_data'] = $this->Admin_model->PaperFormat_data();
  

    $this->load->view('PaperFormat', $data);
}


  //----------------------------End Paper Format Master------------------------------------------------


  //----------------------------Paper Preview Master------------------------------------------------
  public function PaperPreview()
{
    // ✅ Validate token
    validateToken();

    // ✅ Check admin session
    if (!isset($_SESSION['admin']) || !is_array($_SESSION['admin'])) {
        redirect('Admin_user/login');
        return;
    }

    // ---------------------------
    // VIEW SPECIFIC PAPER PREVIEW
    // ---------------------------
    if (isset($_GET['id']) && $_GET['action'] === 'viewdata') {
        $data['PaperPreview_data'] = $this->Admin_model->get_PaperPreview_data_new($_GET['id']);

        // Optional: flash data for messages
        $this->session->set_flashdata('responce_message', $data);

        $this->load->view('PaperPreview', $data);
        return;
    }

    // ---------------------------
    // DEFAULT LIST VIEW
    // ---------------------------
    $data['AssignPaper_data'] = $this->Admin_model->AssignPaper_data();
    $data['programme_data']   = $this->Admin_model->programme_data();
    $data['department_data']  = $this->Admin_model->department_data();
    $data['faculty_data']     = $this->Admin_model->faculty_data();
    $data['subject_data']     = $this->Admin_model->subject_data();
    $data['PaperFormat_data'] = $this->Admin_model->PaperFormat_data();

    $this->load->view('PaperPreview', $data);
}

  //----------------------------End Paper Preview Master------------------------------------------------



  // ------------------------------AssignPaper-------------------------------------   

 public function AssignPaper()
{
    // ✅ Validate token
 
    // ✅ Check admin session
    if (!isset($_SESSION['admin']) || !is_array($_SESSION['admin'])) {
        redirect('Admin_user/login');
        return;
    }

    // ---------------------------
    // EDIT MODE
    // ---------------------------
    if (isset($_GET['id']) && $_GET['action'] === 'edit') {
        $data['get_AssignPaper_data'] = $this->Admin_model->get_AssignPaper_data($_GET['id']);
        $data['programme_data']      = $this->Admin_model->programme_data();
        $data['faculty_data']        = $this->Admin_model->faculty_data();
        $data['department_data']     = $this->Admin_model->department_data();
        $data['subject_data']        = $this->Admin_model->subject_data();
        $data['PaperFormat_data']    = $this->Admin_model->PaperFormat_data();

        $this->session->set_flashdata('responce_message', $data);
        $this->load->view('AssignPaper', $data);
        return;
    }

    // ---------------------------
    // DELETE MODE
    // ---------------------------
    if (isset($_GET['id']) && $_GET['action'] === 'delete') {
        $data = $this->Admin_model->action_AssignPaper($_GET);
        $this->session->set_flashdata('responce_message', $data);
        redirect("Admin_user/AssignPaper", $data);
        return;
    }

    // ---------------------------
    // DEFAULT LIST VIEW
    // ---------------------------
    $data['AssignPaper_data']   = $this->Admin_model->AssignPaper_data();
    $data['programme_data']     = $this->Admin_model->programme_data();
    $data['department_data']    = $this->Admin_model->department_data();
    $data['faculty_data']       = $this->Admin_model->faculty_data();
    $data['subject_data']       = $this->Admin_model->subject_data();
    $data['PaperFormat_data']   = $this->Admin_model->PaperFormat_data();

    $this->session->set_flashdata('responce_message', $data);
    $this->load->view('AssignPaper', $data);
    
}

public function action_AssignPaper()
{
    // ✅ Validate token
    validateToken();

    if (!isset($_SESSION['admin']) || !is_array($_SESSION['admin'])) {
        redirect('Admin_user/login');
        return;
    }

    // ---------------------------
    // ADD ASSIGN PAPER
    // ---------------------------
    if ($_POST['action'] === 'ADD') {
        $facultyId    = $_POST['FacultyId'] ?? '';
        $departmentId = $_POST['DepartmentId'] ?? '';
        $programmeId  = $_POST['ProgrammeId'] ?? '';
        $subjectId    = $_POST['SubjectId'] ?? '';
        $formatId     = $_POST['FormatId'] ?? '';

        // ✅ Prevent duplicate assignment
        if (!validate_duplicate_paper_assignment($facultyId, $departmentId, $programmeId, $subjectId, $formatId)) {
            $this->session->set_flashdata('responce_message', [
                'error' => 'Paper already assigned to this faculty for the selected subject!'
            ]);
            redirect('Admin_user/AssignPaper?action=add');
            return;
        }

        // ✅ Insert
        $data = $this->Admin_model->action_AssignPaper($_POST);
        $this->session->set_flashdata('responce_message', [
            'success' => 'Paper assigned successfully!'
        ]);
        redirect('Admin_user/AssignPaper');
    }

    // ---------------------------
    // EDIT ASSIGN PAPER
    // ---------------------------
    elseif ($_POST['action'] === 'EDIT') {
        $assignPaperId = $_POST['id'] ?? 0;
        $newFormatId   = $_POST['FormatId'] ?? '';

        // ✅ Validate format change
        if (!validate_assign_paper_format_change($assignPaperId, $newFormatId)) {
            $this->session->set_flashdata('responce_message', [
                'error' => 'Invalid format change detected!'
            ]);
            redirect('Admin_user/AssignPaper?action=edit&id=' . $assignPaperId);
            return;
        }

        // ✅ Update
        $data = $this->Admin_model->action_AssignPaper($_POST);
        $this->session->set_flashdata('responce_message', [
            'success' => 'Paper updated successfully!'
        ]);
        redirect('Admin_user/AssignPaper');
    }

    // ---------------------------
    // DEFAULT CASE (LIST VIEW)
    // ---------------------------
    else {
        $data['AssignPaper_data'] = $this->Admin_model->AssignPaper_data();
        $this->load->view('AssignPaper', $data);
    }
}

  // ------------------------------AssignPaper Faculty-------------------------------------   

 public function PaperForApproval()
{
    // ✅ Validate token
    validateToken();
    // Debug token/session


    // ✅ Check admin session
    if (!isset($_SESSION['admin']) || !is_array($_SESSION['admin'])) {
        redirect('Admin_user/login');
        return;
    }

    // ---------------------------
    // ADD QUESTION
    // ---------------------------
    if (isset($_GET['id']) && $_GET['action'] === 'AddQuestion') {
        $data['PaperPreview_data'] = $this->Admin_model->get_PaperPreviewList_data($_GET['id']);
        $this->session->set_flashdata('responce_message', $data);
        $this->load->view('PaperForApproval', $data);
        return;
    }

    // ---------------------------
    // APPROVE PAPER
    // ---------------------------
    if (isset($_GET['id']) && $_GET['action'] === 'ApprovePaper') {
        $data['PaperPreview_data'] = $this->Admin_model->Send_ApprovePaper($_GET['id']);
        $this->session->set_flashdata('responce_message', $data);
        redirect('Admin_user/PaperForApproval', $data);
        return;
    }

    // ---------------------------
    // REJECT PAPER
    // ---------------------------
    if (isset($_GET['id']) && $_GET['action'] === 'RejectPaper') {
        $data['PaperPreview_data'] = $this->Admin_model->Send_RejectPaper($_GET['id']);
        $this->session->set_flashdata('responce_message', $data);
        redirect('Admin_user/PaperForApproval', $data);
        return;
    }

    // ---------------------------
    // DEFAULT LIST VIEW
    // ---------------------------
    $data['AssignPaper_data'] = $this->Admin_model->AssignPaper_data();
    $data['programme_data']   = $this->Admin_model->programme_data();
    $data['department_data']  = $this->Admin_model->department_data();
    $data['faculty_data']     = $this->Admin_model->faculty_data();
    $data['subject_data']     = $this->Admin_model->subject_data();
    $data['PaperFormat_data'] = $this->Admin_model->PaperFormat_data();

    $this->load->view('PaperForApproval', $data);
}

  //-----------------------------setting-------------------------------------   
  public function setting()
  {

    if (is_array($_SESSION['admin'])) {
      if ((isset($_GET['id'])) && ($_GET['action'] == 'edit')) {
        $data['get_setting_data'] = $this->Admin_model->get_setting_data($_GET['id']);
        $this->load->view('Setting', $data);
      } elseif ((isset($_GET['id'])) && ($_GET['action'] == 'delete')) {
        $data = $this->Admin_model->action_setting($_GET);
        $this->session->set_flashdata('responce_message', $data);
        redirect("Setting", $data);
      } else {
        $data['setting_data'] = $this->Admin_model->setting_data();
        $this->load->view('Setting', $data);
        // redirect("admin/setting",$data);
      }
    } else {
      $this->load->view('login');
    }
  }

  public function action_setting()
  {

    //echo "error==><pre>";print_r($_POST);exit;
    if (is_array($_SESSION['admin'])) {
      if ($_POST['action'] == 'ADD') {
        if ($_POST['InputType'] == 'image') {
          $config['upload_path']          = "./assets/upload_files/setting/";
          $config['allowed_types']        = 'gif|jpg|png';
          //$config['max_size']             = 100;
          $_POST['value'] = $_FILES['file_val']['name'];
          $data = $this->Admin_model->action_setting($_POST);
          $this->session->set_flashdata('responce_message', $data);

          if ($data['status'] == 'success') {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            //echo "error==><pre>";print_r($data);print_r($config);exit;
            if (! $this->upload->do_upload('file_val')) {
              $data['msg'] = "Image Successfully Uploaded";
              $data['setting_data'] = $this->Admin_model->setting_data();
              $this->session->set_flashdata('responce_message', $data);
              redirect("Admin_user/Setting", $data);
            } else {
              $data['setting_data'] = $this->Admin_model->setting_data();
              redirect("Admin_user/Setting", $data);
            }
          } else {
            redirect("Admin_user/Setting");
          }
        } else {
          if ($_POST['InputType'] == 'textarea') {
            $_POST['value'] = $_POST['textarea_val'];
          }
          if ($_POST['InputType'] == 'text_box') {
            $_POST['value'] = $_POST['text_val'];
          }
          $data = $this->Admin_model->action_setting($_POST);
          $this->session->set_flashdata('responce_message', $data);
          redirect("Admin_user/Setting", $data);
        }
        //echo "error==><pre>hii";print_r($_FILES);print_r($_REQUEST);exit;


      } elseif ($_POST['action'] == 'EDIT') {
        // echo "error==><pre>hii";print_r($_FILES);print_r($_REQUEST);exit;
        if ($_POST['InputType'] == 'image' && ($_FILES['file_val']['name'] != '')) {
          $config['upload_path']          = "./assets/upload_files/setting/";
          $config['allowed_types']        = 'gif|jpg|png';
          //$config['max_size']             = 100;
          $_POST['value'] = $_FILES['file_val']['name'];
          //echo "error==><pre>hii";print_r($_FILES);print_r($config);exit;
          $data = $this->Admin_model->action_setting($_POST);
          $this->session->set_flashdata('responce_message', $data);

          if ($data['status'] == 'success') {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            // echo "error==><pre>";print_r($data);print_r($config);exit;
            if (! $this->upload->do_upload('file_val')) {
              $data['msg'] = "Image Successfully Uploaded";
              $data['setting_data'] = $this->Admin_Model->setting_data();
              $this->session->set_flashdata('responce_message', $data);
              redirect("Admin_user/Setting", $data);
            } else {
              $data['setting_data'] = $this->Admin_Model->setting_data();
              redirect("Admin_user/Setting", $data);
            }
          } else {
            redirect("Admin_user/Setting");
          }
        } else {
          //echo "error==><pre>hiiaaaaa";print_r($_FILES);print_r($_REQUEST);exit;
          //$_POST['value']=$_POST['file_value'];
          if ($_POST['InputType'] == 'textarea') {
            $_POST['value'] = $_POST['textarea_val'];
          }
          if ($_POST['InputType'] == 'text_box') {
            $_POST['value'] = $_POST['text_val'];
          }
          $data = $this->Admin_model->action_setting($_POST);
          $this->session->set_flashdata('responce_message', $data);
          redirect("Admin_user/Setting", $data);
        }
        //echo "error==><pre>hii";print_r($_FILES);print_r($_REQUEST);exit;


      } else {
        $data['session_data'] = $this->Admin_model->get_sessiondata();
        $this->load->view('admin/session_master', $data);
      }
    } else {
      $this->load->view('login');
    }
  }


  // ------------------------------Assign Paper Checking to faculty -------------------------------------   
public function PaperChecking()
{
    // ✅ Validate token first
    validateToken();

    if (!is_array($_SESSION['admin'])) {
        $this->load->view('login');
        return;
    }

    if ((isset($_GET['id'])) && ($_GET['action'] == 'edit')) {
        $data['get_PaperChecking_data'] = $this->Admin_model->get_PaperChecking_data($_GET['id']);
        $data['PaperChecking_data']     = $this->Admin_model->PaperChecking_data();
        $data['faculty_data']           = $this->Admin_model->faculty_data();
        $this->load->view('PaperChecking', $data);

    } elseif ((isset($_GET['id'])) && ($_GET['action'] == 'delete')) {

        $this->Admin_model->delete_PaperChecking($_GET['id']);
        $this->session->set_flashdata("success", "Record deleted successfully!");
        redirect("Admin_user/PaperChecking");

    } else {

        $data['PaperChecking_data'] = $this->Admin_model->PaperChecking_data();
        $data['faculty_data']       = $this->Admin_model->faculty_data();
        $this->load->view('PaperChecking', $data);
    }
}

public function action_PaperChecking()
{
    validateToken();
    if (!is_array($_SESSION['admin'])) {
        $this->load->view('login');
        return;
    }

    $post = $this->input->post();
    $action = $post['action'] ?? '';
    unset($post['action']);

    // File Upload — now MANDATORY
    if (empty($_FILES['PaperUpload']['name'])) {
        $this->session->set_flashdata('error', 'Please upload a file.');
        redirect("Admin_user/PaperChecking");
        return;
    }

    $config['upload_path']   = './assets/Uploads/PaperChecking/';
    $config['allowed_types'] = 'zip|jpg|jpeg|png|pdf';
    $config['max_size']      = 10000;
    $config['encrypt_name']  = TRUE;

    //

    

$this->load->library('upload', $config);
$this->upload->initialize($config);
// print_r($config);exit;
    if (!$this->upload->do_upload('PaperUpload')) {
        $this->session->set_flashdata('error', $this->upload->display_errors());
        redirect("Admin_user/PaperChecking");
        return;
    }

    $uploadData = $this->upload->data();
    $post['PaperUpload'] = $uploadData['file_name'];

    // Auto timestamps
    $post['UpdatedAt'] = date("Y-m-d H:i:s");

    if ($action == "ADD") {

        $post['CreatedAt'] = date("Y-m-d H:i:s");
        $this->Admin_model->insert_PaperChecking($post);
        $this->session->set_flashdata("success", "Paper Assigned Successfully!");

    }
    elseif ($action == "EDIT") {

        // Ensure ID exists for update
        if (empty($post['Id'])) {
            $this->session->set_flashdata('error', 'Invalid Request. Missing Record ID.');
            redirect("Admin_user/PaperChecking");
            return;
        }

        $this->Admin_model->update_PaperChecking($post);
        $this->session->set_flashdata("success", "Paper Assignment Updated Successfully!");

    }

    redirect("Admin_user/PaperChecking");
}




}
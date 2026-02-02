<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CopyCheck extends CI_Controller {

    public function __construct()  
    {
        parent::__construct();
        $this->load->database();  
        $this->load->helper(['url','form']);
        $this->load->library('session');
        $this->load->model('Question_model');
        $this->load->model('Student_model');
        $this->load->model('Marks_model');
    }

    // Main page. Use ?student_roll=0121cs221045&pdf=uploads/answers/0121cs221045.pdf
    public function index()
    {
    
        $student_roll = $this->input->get('student_roll', true);
        $student_id = null;
        if ($student_roll) {
            $student = $this->Student_model->get_by_roll($student_roll);
            if (!$student) {
                // create placeholder student with roll as name
                $student_id = $this->Student_model->insert([
                    'student_name' => $student_roll,
                    'roll_no' => $student_roll
                ]);
            } else {
                $student_id = $student->id;
            }
        }

        $pdf_path = $this->input->get('pdf') ? $this->input->get('pdf') : 'uploads/answersheet.pdf';

        $data = [
            'questions' => $this->Question_model->get_all(), // expects id, q_no, title, max_marks, content(optional)
            'pdf_path' => base_url($pdf_path),
            'student_id' => $student_id
        ];

        $this->load->view('copy_check_grid', $data);
    }

    // AJAX: get question content
    public function get_question_content()
    {
        $qid = intval($this->input->get('question_id'));
        $this->output->set_content_type('application/json');
        if (!$qid) {
            echo json_encode(['status'=>'error','message'=>'missing question id']);
            return;
        }
        $q = $this->Question_model->get($qid);
        if (!$q) {
            echo json_encode(['status'=>'error','message'=>'question not found']);
            return;
        }
        echo json_encode(['status'=>'ok','question'=>[
            'id' => $q->id,
            'q_no' => $q->q_no,
            'title' => $q->title,
            'content' => isset($q->content) ? $q->content : $q->title,
            'max_marks' => $q->max_marks
        ]]);
    }

    // AJAX: save marks (student must be created via ?student_roll=... on page load)

    public function save_question_marks()
    {
        $this->output->set_content_type('application/json');

        $student_id = intval($this->input->post('student_id'));
        $question_id = intval($this->input->post('question_id'));
        $marks = intval($this->input->post('marks'));

        if (!$student_id || !$question_id) {
            echo json_encode(['status'=>'error','message'=>'Missing student or question id']);
            return;
        }

        $question = $this->Question_model->get($question_id);
        if (!$question) {
            echo json_encode(['status'=>'error','message'=>'Invalid question']);
            return;
        }

        if ($marks < 0 || $marks > intval($question->max_marks)) {
            echo json_encode(['status'=>'error','message'=>'Marks must be between 0 and ' . $question->max_marks]);
            return;
        }

        $saved = $this->Marks_model->insert_or_update($student_id, $question_id, $marks, null); // no checked_by
        if ($saved) {
            echo json_encode(['status'=>'ok','message'=>'Saved']);
        } else {
            echo json_encode(['status'=>'error','message'=>'DB error']);
        }
    }

     
    // ================================
// STEP 1: Show allotted copies list
// ================================
public function copy_check_grid($paperId = null)
{
    validateToken(); // same security style as Faculty

    if (!$this->session->userdata('faculty')) {
        redirect('Faculty/Login');
        return;
    }

    if ($paperId === null) {
        show_404();
        return;
    }

    // VERY SIMPLE DATA (for now)
    $data['paper_id'] = $paperId;

    // Later we will replace this with DB data
    $data['copies'] = [];

    // TEMP: create 30 dummy copies (beginner safe)
    for ($i = 1; $i <= 30; $i++) {
        $data['copies'][] = [
            'copy_no' => $i,
            'status'  => 'Pending'
        ];
    }

    $this->load->view('Copycheck', $data);
}


}



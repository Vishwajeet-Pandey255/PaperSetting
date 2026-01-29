<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aisect_survey2 extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url','form']);
        $this->load->library('session');
        $this->load->database();

        // Load ONLY the new model
        $this->load->model('Aisect2_Model', 'surveyModel'); 
    }

    // Handles initial page load and SKP ID validation from the URL segment
    public function index()
    {
        $hardcoded_skp_id = 'TEST121';

        // Get SKP ID from URL segment
        $skp_id_from_url = $this->uri->segment(3);

        if (empty($skp_id_from_url)) {
            redirect('Aisect_survey2/index/' . $hardcoded_skp_id);
            return;
        }

        $skp_id = strtoupper(trim($skp_id_from_url));

        $data = [
            'skp_id_validated' => !empty($skp_id),
            'is_completed'     => FALSE,
            'skp_id'           => $skp_id
        ];

        // Check if survey already completed (NEW horizontal table)
        if ($data['skp_id_validated']) {
            if ($this->surveyModel->isSurveyCompleted($skp_id)) {
                $data['is_completed'] = TRUE;

                $this->session->set_flashdata(
                    'survey_completed_error',
                    "Kiosk/SKP ID ({$skp_id}) has already registered feedback. Thank you."
                );
            }
        }

        $this->load->view('AisectSurvey2', $data);
    }

    public function validateSkpId()
    {
        $skp_id = $this->input->post('skp_id', TRUE);

        if (empty($skp_id)) {
            redirect('Aisect_survey2');
            return;
        }

        redirect('Aisect_survey2/index/' . strtoupper(trim($skp_id)));
    }

    public function surveySuccess()
    {
        if (!$this->session->flashdata('success')) {
            redirect('Aisect_survey2');
            return;
        }
        $this->load->view('AisectSuccess');
    }

    // Save Survey Data (Submit Button)
    public function saveSurvey()
    {
        $skp_id = $this->input->post('skp_id', TRUE);

        if (empty($skp_id)) {
            $this->session->set_flashdata("error", "SKP ID is missing. Cannot save data.");
            redirect('Aisect_survey2');
            return;
        }

        $skp_id = strtoupper(trim($skp_id));

        // Final Check: Prevent duplicates
        if ($this->surveyModel->isSurveyCompleted($skp_id)) {
            $this->session->set_flashdata(
                "survey_completed_error",
                "Kiosk/SKP ID ({$skp_id}) has already registered feedback."
            );
            redirect('Aisect_survey2/index/' . $skp_id);
            return;
        }

        // Prepare data for INSERT (horizontal format)
        $data = [
            'SkpId'                   => $skp_id,
            'Usage_Frequency'         => $this->input->post('answer_1'),
            'Purpose'                 => $this->processCheckbox('answer_2'),
            'Purpose_Other_Text'      => $this->input->post('answer_2_other_text'),
            'User_Category'           => $this->input->post('answer_3'),
            'Usage_Duration'          => $this->input->post('answer_4'),
            'Device_Used'             => $this->input->post('answer_5'),
            'Browser'                 => $this->input->post('answer_6'),

            // Ratings
            'Navigation'              => $this->input->post('answer_7'),
            'Speed_Performance'       => $this->input->post('answer_8'),
            'Availability'            => $this->input->post('answer_9'),
            'Info_Accuracy'           => $this->input->post('answer_10'),
            'Page_Load_Time'          => $this->input->post('answer_11'),
            'Instructions_Clarity'    => $this->input->post('answer_12'),
            'Mobile_Usability'        => $this->input->post('answer_13'),
            'Visual_Design'           => $this->input->post('answer_14'),
            'Dashboard_Usefulness'    => $this->input->post('answer_15'),
            'Security_Privacy'        => $this->input->post('answer_16'),
            'Payment_Experience'      => $this->input->post('answer_17'),
            'Results_Certs'           => $this->input->post('answer_18'),
            'Error_Handling'          => $this->input->post('answer_19'),
            'Support'                 => $this->input->post('answer_20'),
            'Overall_Satisfaction'    => $this->input->post('answer_21'),

            // Section 3
            'Like_Most'                       => $this->processCheckbox('answer_22'),
            'Like_Most_Other_Text'            => $this->input->post('answer_22_other_text'),
            'Issues_Faced'                    => $this->processCheckbox('answer_23'),
            'Issues_Faced_Other_Text'         => $this->input->post('answer_23_other_text'),
            'Error_Downtime_Frequency'        => $this->input->post('answer_24'),
            'Useful_Features'                 => $this->processCheckbox('answer_25'),
            'Useful_Features_Other_Text'      => $this->input->post('answer_25_other_text'),
            'Features_Improvement'            => $this->processCheckbox('answer_26'),
            'Features_Improvement_Other_Text' => $this->input->post('answer_26_other_text'),
            'Payment_Difficulty'              => $this->input->post('answer_27'),
            'Clarity_Of_Instructions'         => $this->input->post('answer_28'),
            'Improvements_Wanted'             => $this->processCheckbox('answer_29'),
            'Improvements_Wanted_Other_Text'  => $this->input->post('answer_29_other_text'),
            'Support_Experience'              => $this->input->post('answer_30'),
            'Additional_Feedback'             => $this->input->post('answer_31'),

            // Section 4
            'Recommend_Portal'                => $this->input->post('answer_32'),
            'New_Features_Desired'            => $this->processCheckbox('answer_33'),
            'New_Features_Desired_Other_Text' => $this->input->post('answer_33_other_text'),

            // Final Comments
            'Final_Comments'                  => $this->input->post('general_comments'),
            
        ];

        // Insert into NEW HORIZONTAL table
        $insert = $this->surveyModel->saveHorizontalSurvey($data);

        if ($insert) {
            $this->session->set_flashdata("success", "Survey submitted successfully!");
            redirect('Aisect_survey2/surveySuccess');
        } else {
            log_message('error', 'Insert failed for SKP ID ' . $skp_id . ': ' . json_encode($this->db->error()));
            $this->session->set_flashdata("error","Submission failed. Try again.");
            redirect('Aisect_survey2/index/' . $skp_id);
        }
    }

    private function processCheckbox($input_name)
    {
        $arr = $this->input->post($input_name);

        if (is_array($arr) && !empty($arr)) {
            return implode(',', array_map('trim', $arr));
        }
        return '';
    }




// -------------------------------------------DATA View ------------------------------------------------



// Show list of SKP IDs with download option
public function downloadPage()
{
    $data['survey_list'] = $this->surveyModel->getAllSurveys();
    $this->load->view('AisectDownloadView', $data);
}

public function downloadSurveyData()
{
    $data = $this->surveyModel->get_all_survey_data(); 

    if (empty($data)) {
        $this->session->set_flashdata("error", "No survey data available to download.");
        redirect('Aisect_survey2/downloadPage');
        return;
    }

    // Excel headers
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=SurveyData_All.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $sep = "\t";

    // Print column names (header row)
    $schema_insert = "";
    foreach ($data[0] as $column => $value) {
        $schema_insert .= $column . $sep;
    }
    $schema_insert = trim($schema_insert, $sep);
    echo $schema_insert . "\n";

    // Print each row
    foreach ($data as $row) {
        $schema_insert = "";
        foreach ($row as $value) {
            if (!isset($value)) {
                $schema_insert .= "NULL".$sep;
            } elseif ($value != "") {
                $schema_insert .= "$value".$sep;
            } else {
                $schema_insert .= "".$sep;
            }
        }
        $schema_insert = trim($schema_insert, $sep);
        echo $schema_insert . "\n";
    }
}

}
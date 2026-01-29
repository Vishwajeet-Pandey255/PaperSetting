<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aisect_survey extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        // Ensure you have loaded the 'form' helper if you use form_open() anywhere
        $this->load->helper('form'); 
        $this->load->model('Aisect_model');
        $this->load->library('session');
    }

    // Handles initial page load and SKP ID validation from the URL segment
    public function index()
    {
        $hardcoded_skp_id = 'tese121'; 
        
        // 1. Get SKP ID from the URL segment (e.g., Aisect_survey/index/SKP123)
        $skp_id_from_url = $this->uri->segment(3);
        
        if (empty($skp_id_from_url)) {
            // This turns 'Aisect_survey/' into 'Aisect_survey/index/DEFAULT_SKP_ID_FOR_TESTING'
            redirect('Aisect_survey/index/' . $hardcoded_skp_id); 
            return; // Stop execution here to ensure the redirect happens.
        }

        $skp_id = $skp_id_from_url;

        $skp_id = strtoupper(trim($skp_id));
        
        $data = [
            'skp_id_validated' => !empty($skp_id), 
            'is_completed' => FALSE,
            'skp_id' => $skp_id 
        ];

        // The rest of the logic proceeds with the known SKP ID
        if ($data['skp_id_validated']) {
            // Check database status
            if ($this->Aisect_model->isSurveyCompleted($skp_id)) {
                // Survey is completed, set flag and proper, user-friendly error message
                $data['is_completed'] = TRUE;
                $this->session->set_flashdata(
                    'survey_completed_error', 
                    "Kiosk/SKP ID ({$skp_id}) has already registered feedback. We cannot fill the form again. Thank you for your response."
                );
            } 
        } 
        
        // Load the view with the current state.
        $this->load->view('AisectSurvey', $data);
    }
    
    public function validateSkpId()
    {
        $skp_id = $this->input->post('skp_id', TRUE);
        
        if (empty($skp_id)) {
            redirect('Aisect_survey'); 
            return;
        }

        $skp_id = strtoupper(trim($skp_id)); 
        redirect('Aisect_survey/index/' . $skp_id); 
    }

    /**
     * Dedicated success page display.
     */
    public function surveySuccess()
    {
        // Check if there is a success message. If not, redirect to home.
        if (!$this->session->flashdata('success')) {
            redirect('Aisect_survey');
            return;
        }

        // Load the success view file named 'AisectSuccess.php'
        $this->load->view('AisectSuccess');
    }

    // Handles the final submission of the survey data
    public function saveSurvey()
    {
        $skp_id = $this->input->post('skp_id', TRUE);
        $data_batch = [];

        // Final Check: Ensure the SKP ID has not been completed
        if ($this->Aisect_model->isSurveyCompleted($skp_id)) {
             $this->session->set_flashdata("survey_completed_error", "Kiosk/SKP ID ({$skp_id}) has already registered feedback. Cannot save data.");
             redirect('Aisect_survey/index/' . $skp_id); 
             return; 
        }

        // Get all posted data
        $post_data = $this->input->post();
        $general_comments_value = $this->input->post('general_comments', TRUE);

        // Loop through POST data to prepare the batch insert
        foreach ($post_data as $key => $value) {
             if ($key == 'skp_id' || $key == 'general_comments') continue;
             
             if (strpos($key, 'answer_') === 0 && substr($key, -5) !== '_text') {
                 
                 $question_number = str_replace('answer_', '', $key);
                 $answer = $value;
                 
                 // Handle arrays and 'other' text for checkboxes
                 if (is_array($answer)) {
                    $other_text_key = "answer_{$question_number}_other_text";
                    if (in_array('other', $answer) && isset($post_data[$other_text_key]) && $post_data[$other_text_key] != '') {
                         $answer[] = 'other: ' . $post_data[$other_text_key];
                    }
                    $answer = implode(' | ', $answer);
                 }
                 
                 // Collect other associated question details
                 $other_remark = isset($post_data["answer_{$question_number}_other_text"]) ? $post_data["answer_{$question_number}_other_text"] : '';
                 $section = isset($post_data["section_{$question_number}"]) ? $post_data["section_{$question_number}"] : '';
                 $question_num_val = isset($post_data["question_number_{$question_number}"]) ? $post_data["question_number_{$question_number}"] : $question_number;
                 $question = isset($post_data["question_{$question_number}"]) ? $post_data["question_{$question_number}"] : '';
                 
                 if ($answer !== null && $answer !== '') {
                     $data_batch[] = [
                         'skp_id' => $skp_id,
                         'section' => $section,
                         'question_number' => $question_num_val,
                         'question' => $question,
                         'answer' => $answer,
                         'other_remark' => $other_remark,
                         'any_other_comments' => $general_comments_value
                     ];
                 }
             }
        }
        
        // Insert batch into DB
        if (!empty($data_batch)) {
            $insert = $this->Aisect_model->save_batch($data_batch); 
            if ($insert) {
                // Success: Set a detailed flashdata message 
                $this->session->set_flashdata("success", "Survey data for **{$skp_id}** has been saved successfully! Thank you for your feedback.");
                // Redirect to the new dedicated success page
                redirect('Aisect_survey/surveySuccess'); 
                return;
            } else {
                 $this->session->set_flashdata("error", "Failed to save survey data. Please try again or contact support.");
            }
        } else {
            $this->session->set_flashdata("error", "No survey data was submitted or data was incomplete. Please ensure all required fields are filled.");
        }

        // Redirect back on failure
        redirect('Aisect_survey/index/' . $skp_id );
    }
}
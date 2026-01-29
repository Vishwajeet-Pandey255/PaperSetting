<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aisect2_Model extends CI_Model {

    // New Horizontal Table
    private $horizontal_table = 'AisectsurveyHorizontal'; 

    public function __construct() {
        parent::__construct();
        $this->load->database();   // ensure database is loaded
    }

    /**
     * Check if a survey entry already exists for the given SKP ID 
     * in the horizontal table.
     *
     * @param string $skp_id
     * @return bool
     */
    public function isSurveyCompleted($skp_id)
    {
        return $this->db->where('SkpId', $skp_id)
                        ->limit(1)
                        ->get($this->horizontal_table)
                        ->num_rows() > 0;
    }

    /**
     * Save complete horizontal survey data in a single row
     *
     * @param array $data
     * @return bool
     */
    public function saveHorizontalSurvey($data)
    {
        return $this->db->insert($this->horizontal_table, $data);
    }

    /**
     * Generate a unique form submission ID
     *
     * @return string
     */
    public function generate_submission_id()
    {
        return 'AIS' . time() . mt_rand(1000, 9999);
    }


public function get_all_survey_data()
{
    return $this->db->get('aisectsurveyhorizontal')->result_array();
}

    public function getAllSurveys()
{
    return $this->db->select('SkpId')->from('aisectsurveyhorizontal')->get()->result_array();
}

public function getSurveyBySkpId($skp_id)
{
    return $this->db->where('SkpId', $skp_id)->get('aisectsurveyhorizontal')->row_array();
}

}

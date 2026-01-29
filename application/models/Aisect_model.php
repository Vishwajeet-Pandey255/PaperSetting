<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aisect_model extends CI_Model {

    private $table = 'aisect_survey'; // Your table name

    /**
     * Checks if a survey entry already exists for the given SKP ID.
     * @param string $skp_id The Kiosk/SKP ID to check.
     * @return bool TRUE if a record is found, FALSE otherwise.
     */
    public function isSurveyCompleted($skp_id)
    {
        // Check if any record exists with this SKP ID in the survey table
        $this->db->where('skp_id', $skp_id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);

        // If the query returns one or more rows, the survey has been completed.
        return $query->num_rows() > 0;
    }

    // Generate unique submission identifier
    public function generate_submission_id()
    {
        return 'AIS' . time() . mt_rand(1000, 9999);
    }

    // Insert single question row
    public function save_row($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Insert multiple rating rows
    public function save_batch($data_batch)
    {
        return $this->db->insert_batch($this->table, $data_batch);
    }

}
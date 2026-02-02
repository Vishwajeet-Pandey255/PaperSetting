<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_model extends CI_Model {

    public function get_all()
    {
        $this->db->order_by('q_no', 'ASC');
        return $this->db->get('questions')->result();
    }

    public function get($id)
    {
        return $this->db->get_where('questions', ['id' => $id])->row();
    }
}


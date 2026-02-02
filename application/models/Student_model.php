<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

    public function insert($data)
    {
        $this->db->insert('students', $data);
        return $this->db->insert_id();
    }

    public function get($id)
    {
        return $this->db->get_where('students', ['id' => $id])->row();
    }

    public function get_by_roll($roll_no)
    {
        return $this->db->get_where('students', ['roll_no' => $roll_no])->row();
    }
}

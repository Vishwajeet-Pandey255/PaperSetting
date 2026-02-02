<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marks_model extends CI_Model {

    public function insert_or_update($student_id, $question_id, $marks, $checked_by = null)
    {
        $exists = $this->db->get_where('student_question_marks', [
            'student_id' => $student_id,
            'question_id' => $question_id
        ])->row();

        $data = [
            'student_id' => $student_id,
            'question_id' => $question_id,
            'marks_obtained' => $marks,
            'checked_by' => $checked_by
        ];

        if ($exists) {
            $this->db->where(['id' => $exists->id])->update('student_question_marks', $data);
            return $this->db->affected_rows() >= 0;
        } else {
            $this->db->insert('student_question_marks', $data);
            return $this->db->insert_id() > 0;
        }
    }

    // get a saved mark (or null)
    public function get_mark($student_id, $question_id)
    {
        return $this->db->select('marks_obtained')->get_where('student_question_marks', [
            'student_id' => $student_id,
            'question_id' => $question_id
        ])->row();
    }
}

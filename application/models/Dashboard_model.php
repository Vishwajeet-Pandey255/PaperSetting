<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

   public function last_subjects($limit = 5)
{
    return $this->db
        ->select('SubjectName, SubjectCode')
        ->order_by('Id','DESC')
        ->limit($limit)
        ->get('Subject')
        ->result_array();
}


   public function last_departments($limit = 5)
{
    return $this->db
        ->select('Name, DepartmentCode')
        ->order_by('Id','DESC')
        ->limit($limit)
        ->get('Department')
        ->result_array();
}

public function last_programmes($limit = 5)
{
    return $this->db
        ->select('ProgrammeName, ProgrammeCode')
        ->order_by('Id','DESC')
        ->limit($limit)
        ->get('Programme')
        ->result_array();
}
public function last_formats($limit = 5)
{
    return $this->db
        ->select('FormatNumber, SUM(TotalQuestion) as TotalQuestions')
        ->from('Paperformat')
        ->where('Status', 1)
        ->group_by('FormatNumber')
        ->order_by('MAX(Id)', 'DESC', false) // latest formats
        ->limit($limit)
        ->get()
        ->result_array();
}




  public function last_faculty($limit = 5)
{
    return $this->db
        ->select('Name, Email')
        ->order_by('Id','DESC')
        ->limit($limit)
        ->get('faculty')
        ->result_array();
}

public function get_paper_status_count()
{
    $query = $this->db->query("
        SELECT PaperStatus, COUNT(*) as total
        FROM assignpaper
        WHERE PaperStatus IN (1,3,4)
        GROUP BY PaperStatus
    ");

    return $query->result_array();
}

public function get_dashboard_counts()
{
    return [
        'faculty'     => $this->db->count_all('Faculty'),
        'subject'    => $this->db->count_all('Subject'),
        'programme'  => $this->db->count_all('Programme'),
        'department' => $this->db->count_all('Department'),
        'paperformat'     => $this->db->count_all('Paperformat')
    ];
}


}

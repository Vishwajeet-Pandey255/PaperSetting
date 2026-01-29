<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('validate_email')) {
    function validate_email($email, $id = null) {
        $CI = & get_instance(); // get CI instance to access DB + session

        $email = trim($email);

        // 1️⃣ Empty check
        if (empty($email)) {
            $CI->session->set_flashdata('error', 'Email is required.');
            return FALSE;
        }

        // 2️⃣ Format check
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $CI->session->set_flashdata('error', 'Invalid email format.');
            return FALSE;
        }

        // 3️⃣ Duplicate check (skip current record on EDIT)
        $CI->db->where('Email', $email);
        if (!empty($id)) {
            $CI->db->where('Id !=', $id); // ✅ avoid conflict with same user
        }
        $query = $CI->db->get('faculty');

        if ($query->num_rows() > 0) {
            $CI->session->set_flashdata('error', 'Email is already taken.');
            return FALSE;
        }

        // 4️⃣ Passed all checks
        return TRUE;
    }
}

// ------------------- Phone ---------------------
if (!function_exists('validate_phone')) {
    function validate_phone($phone, $id = null) {
        $CI = & get_instance(); // get CI instance to access DB + session

        // 1️⃣ Clean and normalize phone
        $phone = trim($phone);
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // 2️⃣ Empty check
        if (empty($phone)) {
            $CI->session->set_flashdata('error', 'Phone number is required.');
            return FALSE;
        }

        // 3️⃣ Check digits only
        if (!ctype_digit($phone)) {
            $CI->session->set_flashdata('error', 'Phone number must contain only digits.');
            return FALSE;
        }

        // 4️⃣ Validate length
        if (strlen($phone) != 10) {
            $CI->session->set_flashdata('error', 'Phone number must be exactly 10 digits.');
            return FALSE;
        }

        // 5️⃣ Check if already exists (skip same record when editing)
        $CI->db->where('PhoneNumber', $phone);
        if (!empty($id)) {
            $CI->db->where('Id !=', $id); // ✅ skip own record during edit
        }
        $query = $CI->db->get('faculty');

        if ($query->num_rows() > 0) {
            $CI->session->set_flashdata('error', 'Phone number is already in use.');
            return FALSE;
        }

        // 6️⃣ All good ✅
        return TRUE;
    }
}

  // ------------------- Assign Paper ---------------------

   if (!function_exists('validate_duplicate_paper_assignment')) {
    function validate_duplicate_paper_assignment($facultyId, $departmentId, $programmeId, $subjectId, $formatId)
    {
        $CI = & get_instance(); // get CI instance to access DB + session

        // ✅ 1. Ensure all fields are filled
        if (empty($facultyId) || empty($departmentId) || empty($programmeId) || empty($subjectId) || empty($formatId)) {
            $CI->session->set_flashdata('error', 'All fields (Faculty, Department, Programme, Subject, and Format) are required.');
            return FALSE;
        }

        // ✅ 2. Check for duplicate record (but ignore rejected status = 4)
        $CI->db->where('FacultyId', $facultyId);
        $CI->db->where('DepartmentId', $departmentId);
        $CI->db->where('ProgrammeId', $programmeId);
        $CI->db->where('SubjectId', $subjectId);
        $CI->db->where('FormatId', $formatId);

        // ⭐ Very important line: Only block if status is NOT "Rejected" (4)
        $CI->db->where('Status !=', 4);

        $query = $CI->db->get('AssignPaper');

        if ($query->num_rows() > 0) {
            $CI->session->set_flashdata(
                'error',
                'This paper has already been assigned with the same Faculty, Department, Programme, Subject, and Format.'
            );
            return FALSE;
        }

        // ✅ 3. Passed all checks
        return TRUE;
    }
}

// ------------------------ Department ---------------------

if (!function_exists('validate_department')) {
    function validate_department($name, $departmentCode)
    {
        $CI = &get_instance();

        // ✅ 1. Trim and sanitize inputs
        $name = trim($name);
        $departmentCode = trim($departmentCode);

        // ✅ 2. Check empty fields
        if (empty($name) || empty($departmentCode)) {
            $CI->session->set_flashdata('error', 'Department Name and Code are required.');
            return FALSE;
        }

        // ✅ 3. Check duplicate department name
        $CI->db->where('Name', $name);
        $queryName = $CI->db->get('Department');
        if ($queryName->num_rows() > 0) {
            $CI->session->set_flashdata('error', 'Department Name already exists.');
            return FALSE;
        }

        // ✅ 4. Check duplicate department code
        $CI->db->where('DepartmentCode', $departmentCode);
        $queryCode = $CI->db->get('Department');
        if ($queryCode->num_rows() > 0) {
            $CI->session->set_flashdata('error', 'Department Code already exists.');
            return FALSE;
        }

        // ✅ 5. Passed all checks
        return TRUE;if (!function_exists('validate_department')) {
    function validate_department($name, $departmentCode)
    {
        $CI = &get_instance(); // Get CodeIgniter instance

        // ✅ 1. Trim and sanitize inputs
        $name = trim($name);
        $departmentCode = trim($departmentCode);

        // ✅ 2. Check for empty fields
        if (empty($name) || empty($departmentCode)) {
            $CI->session->set_flashdata('error', 'Department Name and Code are required.');
            return FALSE;
        }

        // ✅ 3. Check duplicate Department Name
        $CI->db->where('Name', $name);
        $queryName = $CI->db->get('Department');
        if ($queryName->num_rows() > 0) {
            $CI->session->set_flashdata('error', 'Department Name already exists.');
            return FALSE;
        }

        // ✅ 4. Reset query builder before next check
        $CI->db->reset_query();

        // ✅ 5. Check duplicate Department Code
        $CI->db->where('DepartmentCode', $departmentCode);
        $queryCode = $CI->db->get('Department');
        if ($queryCode->num_rows() > 0) {
            $CI->session->set_flashdata('error', 'Department Code already exists.');
            return FALSE;
        }

        // ✅ 6. Passed all checks
        return TRUE;
    }
}

    }
}

//------------------------------ Programme  -------------------------------------

if (!function_exists('validate_programme')) {
    function validate_programme($programmeName, $programmeCode)
    {
        $CI = &get_instance();

        $programmeName = trim($programmeName);
        $programmeCode = trim($programmeCode);

        if (empty($programmeName) || empty($programmeCode)) {
            $CI->session->set_flashdata('responce_message', [
                'error' => 'Programme Name and Programme Code are required.'
            ]);
            return FALSE;
        }

        $CI->db->where('ProgrammeName', $programmeName);
        $queryName = $CI->db->get('Programme');
        if ($queryName->num_rows() > 0) {
            $CI->session->set_flashdata('responce_message', [
                'error' => 'Programme Name already exists.'
            ]);
            return FALSE;
        }

        $CI->db->reset_query();

        $CI->db->where('ProgrammeCode', $programmeCode);
        $queryCode = $CI->db->get('Programme');
        if ($queryCode->num_rows() > 0) {
            $CI->session->set_flashdata('responce_message', [
                'error' => 'Programme Code already exists.'
            ]);
            return FALSE;
        }

        return TRUE;
    }
}


//------------------------------ Subject -------------------------------------

if (!function_exists('validate_subject')) {
    function validate_subject($programmeId, $subjectName, $subjectCode)
    {
        $CI = &get_instance();

        // ✅ 1. Trim and sanitize inputs
        $programmeId = trim($programmeId);
        $subjectName = trim($subjectName);
        $subjectCode = trim($subjectCode);

        // ✅ 2. Check for empty fields
        if (empty($programmeId) || empty($subjectName) || empty($subjectCode)) {
            $CI->session->set_flashdata('error', 'Programme, Subject Name and Subject Code are required.');
            return FALSE;
        }

        // ✅ 3. Check duplicate Subject Name under the same Programme
        $CI->db->where('ProgrammeId', $programmeId);
        $CI->db->where('SubjectName', $subjectName);
        $queryName = $CI->db->get('Subject');
        if ($queryName->num_rows() > 0) {
            $CI->session->set_flashdata('error', 'Subject Name already exists in this Programme.');
            return FALSE;
        }

        $CI->db->reset_query();

        // ✅ 4. Check duplicate Subject Code (globally unique)
        $CI->db->where('SubjectCode', $subjectCode);
        $queryCode = $CI->db->get('Subject');
        if ($queryCode->num_rows() > 0) {
            $CI->session->set_flashdata('error', 'Subject Code already exists.');
            return FALSE;
        }

        // ✅ 5. Passed all checks
        return TRUE;
    }
}

//------------------------------ Edit Format -------------------------------------
if (!function_exists('validate_assign_paper_format_change')) {
    function validate_assign_paper_format_change($assignPaperId, $newFormatId)
    {
        $CI = &get_instance();

        // ✅ 1. Validate the input
        if (empty($assignPaperId) || !is_numeric($assignPaperId)) {
            $CI->session->set_flashdata('error', 'Invalid paper ID.');
            return FALSE;
        }

        // ✅ 2. Fetch the assigned paper
        $assignPaper = $CI->db->get_where('assignpaper', ['Id' => $assignPaperId])->row_array();

        if (!$assignPaper) {
            $CI->session->set_flashdata('error', 'Assigned paper not found in the database.');
            return FALSE;
        }

        // ✅ 3. If FormatId is the same, no problem
        if ($assignPaper['FormatId'] == $newFormatId) {
            return TRUE;
        }

        // ✅ 4. Check if any questions exist for this paper in `paperquestion`
        $CI->db->where('ExamPaper', $assignPaperId);
        $query = $CI->db->get('paperquestion');  // ✅ Correct table name

        if ($query->num_rows() > 0) {
            $CI->session->set_flashdata(
                'error',
                'Cannot change the format — questions already exist for this paper.'
            );
            return FALSE;
        }

        // ✅ 5. No questions exist — allow format change
        return TRUE;
    }
}


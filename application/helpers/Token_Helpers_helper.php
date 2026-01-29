<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Validate if user has a valid session token
 */
function validateToken($redirect = true)
{
    $CI =& get_instance(); // Get CodeIgniter instance

    // Check session for token
    $sessionToken = $CI->session->userdata('access_token');

    // Optional: Debug — print token
    // echo "Session Token: " . $sessionToken; exit;

    if (!$sessionToken && $redirect) {
        // Token missing — redirect to login
        redirect('Admin_user/login');
    }

    return $sessionToken; // Return token if needed
}


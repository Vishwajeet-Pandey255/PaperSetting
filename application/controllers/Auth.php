<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('Encryption');
    }

    // ====================== LOGOUT ADMIN ======================
    public function admin_logout()
    {
        // Destroy token
        $this->session->unset_userdata('token');

        // Unset user type sessions
        $this->session->unset_userdata('admin');
        $this->session->unset_userdata('faculty');

        redirect('admin_user');
    }

    // ====================== LOGOUT USER ======================
    public function user_logout()
    {
        $this->session->unset_userdata('token');

        // Destroy session completely
        $this->session->sess_destroy();
        
        redirect('User');
    }

    public function refresh(){
        $config = array(
            'img_path'      => 'captcha/',
            'img_url'       => base_url().'captcha/',
            'word_length'   => 5,
            'font_size'     => 25,
            'pool'          => '0123456789',
        );

        $captcha = create_captcha($config);

        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $captcha['word']);

        echo $captcha['image'];
    }

    public function terms_and_condition(){
        if(!($this->session->userdata('username'))){
            redirect ('Auth/login');
        }
        $this->load->view('auth/terms_and_condition');
    }

    public function read_and_agree(){
        if(!($this->session->userdata('username'))){
            redirect ('Auth/login');
        }
        $this->load->view('auth/read _and_agree_to_the_terms');
    }

}

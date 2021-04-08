<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model', 'Auth');
        // if (!empty($this->session->userdata('logged_in'))) redirect('Dashboard');
    }

    public function index()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() === false) {
            $data = array(
                'title' => 'Login',
            );

            $this->load->view('login', $data);
        } else {
            $this->_login();
        }
    }

    private function _login()
    {

        $auth = $this->Auth->verification();

        if (empty($auth)) {
            $this->session->set_flashdata('login_msg', '<p class="text-center text-danger"> Username atau password salah !!! </p>');
            redirect('Auth');
        } else {
            $session = array(
                'logged_in' => true,
                'user_id' => $auth['id'],
                'username' => $auth['username'],
                'name' => $auth['name'],
                'role' => $auth['role']
            );
            $this->session->set_userdata($session);
            redirect('Dashboard');
        }
    }

    public function logout()
    {
        session_destroy();
        redirect('Auth');
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

const ADMIN = '1';
const CASHIER = '2';

class MY_Controller extends CI_Controller
{
    public function is_logged()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('Auth');
        }
    }

    public function is_admin()
    {
        if ($this->session->userdata('role') != ADMIN) {
            show_404();
        }
    }
}

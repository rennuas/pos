<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->is_logged();
    }

    public function index()
    {
        $data = array(
            'title' => 'Dashboard',
            'header' => 'Dashboard',
            'content' => 'home'
        );
        $this->load->view('templates/index', $data);
    }
}

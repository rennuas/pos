<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->is_logged();
        $this->is_admin();
        $this->load->model('Report_model', 'Report');
    }

    public function index()
    {
        show_404();
    }

    public function sales()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('end_date', 'Akhir Tanggal', 'required');

        if ($this->form_validation->run() === false) {
            $data = array(
                'title' => 'Laporan Penjualan',
                'header' => 'Laporan Penjualan',
                'content' => 'report/sales',
                // 'products' => $this->Inventories->getInventory()
            );
            $this->load->view('templates/index', $data);
        } else {
        }
    }
}

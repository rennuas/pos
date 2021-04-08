<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_unit extends MY_Controller
{
    private $_unitTbl = 'stock_unit';

    public function __construct()
    {
        parent::__construct();
        $this->is_logged();
        $this->load->model('Inventories_model', 'Inventories');
    }

    public function index()
    {
        $data = array(
            'title' => 'Unit Stok',
            'header' => 'Unit Stock',
            'content' => 'inventories/stock_unit',
            'units' => $this->Inventories->getUnits()
        );

        $this->load->view('templates/index', $data);
    }

    public function add()
    {
        $post = $this->input->post();

        $data['unit'] = $post['unit'];

        $query = $this->Inventories->insert($data, $this->_unitTbl);
        if ($query) $this->session->set_flashdata('unit_msg', '<div class="alert alert-success"> Berhasil menambah unit </div>');

        redirect($post['redirect_url']);
    }

    public function edit($id)
    {
        $post = $this->input->post();

        $data['unit'] = $post['unit'];

        $query = $this->Inventories->update($id, $data, $this->_unitTbl);
        if ($query) $this->session->set_flashdata('unit_msg', '<div class="alert alert-success"> Berhasil mengubah unit </div>');

        redirect('Stock_unit');
    }

    public function delete($id)
    {

        $query = $this->Inventories->delete($id, $this->_unitTbl);

        if ($query) $this->session->set_flashdata('unit_msg', '<div class="alert alert-success"> Berhasil menghapus unit </div>');

        redirect('Stock_unit');
    }
}

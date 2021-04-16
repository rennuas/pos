<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Delivery_type extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->is_logged();
        $this->is_admin();
        $this->load->model('Inventories_model', 'Inventories');
    }

    public function index()
    {
        $data = array(
            'title' => 'Ongkos Kirim',
            'header' => 'Ongkos Kirim',
            'content' => 'inventories/delivery_type',
            'types' => $this->Inventories->getDeliveryTypes()
        );
        $this->load->view('templates/index', $data);
    }

    public function add()
    {
        $post = $this->input->post();

        $data['cost'] = str_replace('.', '', $post['cost']);

        $query = $this->Inventories->insert($data, 'delivery_cost_type');
        if ($query) $this->session->set_flashdata('category_msg', '<div class="alert alert-success"> Berhasil menambah ongkos kirim </div>');

        redirect($post['redirect_url']);
    }

    public function edit($id)
    {
        $post = $this->input->post();

        $data['cost'] = str_replace('.', '', $post['cost']);

        $query = $this->Inventories->update($id, $data, 'delivery_cost_type');
        if ($query) $this->session->set_flashdata('category_msg', '<div class="alert alert-success"> Berhasil mengubah ongkos kirim </div>');

        redirect('Delivery_type');
    }

    public function delete($id)
    {

        $query = $this->Inventories->delete($id, 'delivery_cost_type');

        if ($query) $this->session->set_flashdata('category_msg', '<div class="alert alert-success"> Berhasil menghapus ongkos kirim </div>');

        redirect('Delivery_type');
    }
}

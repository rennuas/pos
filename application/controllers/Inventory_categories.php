<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_categories extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->is_logged();
        $this->load->model('Inventories_model', 'Inventories');
    }

    public function index()
    {
        $data = array(
            'title' => 'Inventory Categories',
            'header' => 'Inventory Categories',
            'content' => 'inventories/categories',
            'categories' => $this->Inventories->getCategories()
        );

        $this->load->view('templates/index', $data);
    }

    public function add()
    {
        $post = $this->input->post();

        $data['category'] = $post['category'];

        $query = $this->Inventories->insert($data, 'inventory_categories');
        if ($query) $this->session->set_flashdata('category_msg', '<div class="alert alert-success"> Berhasil menambah kategori </div>');

        redirect($post['redirect_url']);
    }

    public function edit($id)
    {
        $post = $this->input->post();

        $data['category'] = $post['category'];

        $query = $this->Inventories->update($id, $data, 'inventory_categories');
        if ($query) $this->session->set_flashdata('category_msg', '<div class="alert alert-success"> Berhasil mengubah kategori </div>');

        redirect('Inventory_categories');
    }

    public function delete($id)
    {

        $query = $this->Inventories->delete($id, 'inventory_categories');

        if ($query) $this->session->set_flashdata('category_msg', '<div class="alert alert-success"> Berhasil menghapus kategori </div>');

        redirect('Inventory_categories');
    }
}

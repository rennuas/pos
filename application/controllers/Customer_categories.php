<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer_categories extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->is_logged();
        $this->load->model('Customers_model', 'Customers');
    }

    public function index()
    {
        $data = array(
            'title' => 'Customer Categories',
            'header' => 'Customer Categories',
            'content' => 'customers/categories',
            'categories' => $this->Customers->getCategories()
        );

        $this->load->view('templates/index', $data);
    }

    public function add()
    {
        $post = $this->input->post();

        $data['category'] = $post['category'];

        $query = $this->Customers->insert($data, 'customer_categories');
        if ($query) $this->session->set_flashdata('category_msg', '<div class="alert alert-success"> Berhasil menambah kategori </div>');

        redirect('Customer_categories');
    }

    public function edit($id)
    {
        $post = $this->input->post();

        $data['category'] = $post['category'];

        $query = $this->Customers->update($id, $data, 'customer_categories');
        if ($query) $this->session->set_flashdata('category_msg', '<div class="alert alert-success"> Berhasil mengubah kategori </div>');

        redirect('Customer_categories');
    }

    public function delete($id)
    {

        $query = $this->Customers->delete($id, 'customer_categories');

        if ($query) $this->session->set_flashdata('category_msg', '<div class="alert alert-success"> Berhasil menghapus kategori </div>');

        redirect('Customer_categories');
    }
}

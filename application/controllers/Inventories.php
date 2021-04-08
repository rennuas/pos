<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventories extends MY_Controller
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
            'title' => 'Inventories',
            'header' => 'Inventories',
            'content' => 'inventories/index'
        );

        $this->load->view('templates/index', $data);
    }

    public function getInventories()
    {
        $db = $this->Inventories->getInventories();
        $no = $_POST['start'];
        $inventories = array();
        foreach ($db as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->product_name;
            $row[] = $field->category;
            $row[] = "$field->stock $field->unit";
            $row[] = 'Rp.' . number_format($field->sale_price, 0, ',', '.');
            $row[] = '<a href=' . site_url('Inventories/edit/') . $field->inventory_id . ' class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> <a href=' . site_url('Inventories/delete/') . $field->inventory_id . ' class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin menghapus data? \');"><i class="fa fa-trash"></i></a>';

            $inventories[] = $row;
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->Inventories->countAll(),
            'recordsFiltered' => $this->Inventories->countFiltered(),
            'data' => $inventories,
        );

        echo json_encode($output);
    }

    public function add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('product_name', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('sale_price', 'Harga Jual', 'required|trim');
        $this->form_validation->set_rules('retail_price', 'Harga Eceran', 'required|trim');
        $this->form_validation->set_rules('stock', 'Stok', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Tambah Produk',
                'header' => 'Tambah Produk',
                'content' => 'inventories/add',
                'categories' => $this->Inventories->getCategories(),
                'units' => $this->Inventories->getUnits()
            );

            $this->load->view('templates/index', $data);
        } else {
            $post = $this->input->post();

            $data = array(
                'product_name' => $post['product_name'],
                'sale_price' => str_replace('.', '', $post['sale_price']),
                'capital_price' => str_replace('.', '', $post['capital_price']),
                'stock' => $post['stock'],
                'unit' => $post['unit'],
                'category_id' => $post['category_id'],
                'date_created' => date('Y-m-d H:i:s'),
                'last_updated' => date('Y-m-d H:i:s')
            );

            $query = $this->Inventories->insert($data, 'inventories');

            if ($query) {
                $this->session->set_flashdata('inventory_msg', '<div class="alert alert-success"> Berhasil menambahkan produk </div>');
            }

            redirect('Inventories');
        }
    }

    public function edit($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('product_name', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('sale_price', 'Harga Jual', 'required|trim');
        $this->form_validation->set_rules('retail_price', 'Harga Eceran', 'required|trim');
        $this->form_validation->set_rules('stock', 'Stok', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Ubah Produk',
                'header' => 'Ubah Produk',
                'content' => 'inventories/edit',
                'inventory' => $this->Inventories->getInventory($id),
                'categories' => $this->Inventories->getCategories(),
                'units' => $this->Inventories->getUnits()
            );

            $this->load->view('templates/index', $data);
        } else {
            $post = $this->input->post();

            $data = array(
                'product_name' => $post['product_name'],
                'sale_price' => str_replace('.', '', $post['sale_price']),
                'capital_price' => str_replace('.', '', $post['capital_price']),
                'stock' => $post['stock'],
                'unit' => $post['unit'],
                'category_id' => $post['category_id'],
                'last_updated' => date('Y-m-d H:i:s')
            );

            $query = $this->Inventories->update($id, $data, 'inventories');

            if ($query) {
                $this->session->set_flashdata('inventory_msg', '<div class="alert alert-success"> Berhasil mengubah produk </div>');
            }

            redirect('Inventories/edit/' . $id);
        }
    }

    public function delete($id)
    {
        $query = $this->Inventories->delete($id, 'inventories');

        if ($query) {
            $this->session->set_flashdata('inventory_msg', '<div class="alert alert-success"> Berhasil menghapus produk </div>');
        }

        redirect('Inventories');
    }
}

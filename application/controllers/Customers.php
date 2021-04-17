<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customers extends MY_Controller
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
            'title' => 'Customers',
            'header' => 'Customers',
            'content' => 'customers/index'
        );

        $this->load->view('templates/index', $data);
    }

    public function getCustomers()
    {
        $db = $this->Customers->getCustomers();
        $no = $_POST['start'];
        $customers = array();
        foreach ($db as $field) {
            if ($field->category_id != '1') {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->name;
                $row[] = $field->telp;
                $row[] = $field->category;
                $row[] = '<a href=' . site_url('Customers/edit/') . $field->customer_id . ' class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> <a href=' . site_url('Customers/delete/') . $field->customer_id . ' class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin menghapus data? \');"><i class="fa fa-trash"></i></a>';

                $customers[] = $row;
            }
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->Customers->countAll(),
            'recordsFiltered' => $this->Customers->countFiltered(),
            'data' => $customers,
        );

        echo json_encode($output);
    }

    public function add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Nama', 'required|trim|is_unique[customers.name]');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Tambah Customer',
                'header' => 'Tambah Customer',
                'content' => 'customers/add',
                'categories' => $this->Customers->getCategories()
            );

            $this->load->view('templates/index', $data);
        } else {
            $post = $this->input->post();

            $data = array(
                'name' => $post['name'],
                'telp' => $post['telp'],
                'category_id' => $post['category_id'],
                'date_created' => date('Y-m-d'),
                'gender' => $post['gender']
            );

            $query = $this->Customers->insert($data, 'customers');

            if ($query) {
                $this->session->set_flashdata('customers_msg', '<div class="alert alert-dismissible alert-success fade show"> Berhasil menambahkan customer <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button> </div>');
            }

            if (isset($post['redirect'])) redirect($post['redirect']);
            redirect('Customers');
        }
    }

    public function edit($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Nama', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Ubah Customer',
                'header' => 'Ubah Customer',
                'content' => 'customers/edit',
                'customer' => $this->Customers->getCustomer($id),
                'categories' => $this->Customers->getCategories()
            );

            $this->load->view('templates/index', $data);
        } else {
            $post = $this->input->post();

            $data = array(
                'name' => $post['name'],
                'telp' => $post['telp'],
                'category_id' => $post['category_id'],
                'gender' => $post['gender']
            );

            $query = $this->Customers->update($id, $data, 'customers');

            if ($query) {
                $this->session->set_flashdata('customers_msg', '<div class="alert alert-success"> Berhasil mengubah customer </div>');
            }

            redirect('Customers/edit/' . $id);
        }
    }

    public function delete($id)
    {
        $query = $this->Customers->delete($id, 'customers');

        if ($query) {
            $this->session->set_flashdata('customers_msg', '<div class="alert alert-success"> Berhasil menghapus customer </div>');
        }

        redirect('Customers');
    }
}

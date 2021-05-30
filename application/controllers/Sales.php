<?php
defined('BASEPATH') or exit('No direct script access allowed');

define('CASH_PAYMENT_METHOD', '1');
define('DEBIT_PAYMENT_METHOD', '2');

class Sales extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->is_logged();
        $this->load->model('Inventories_model', 'Inventories');
        $this->load->model('Customers_model', 'Customers');
        $this->load->model('Sales_model', 'Sales');
    }

    public function index()
    {
        $data = array(
            'title' => 'Sales',
            'header' => 'Sales',
            'content' => 'sales/index',
            'no_transaction' => strtoupper(uniqid()) . date('Ymd') . $this->session->userdata('user_id'),
            'customers' => $this->Customers->getCustomers(),
            'customer_categories' => $this->Customers->getCategories()
        );

        $this->load->view('templates/index', $data);
    }

    public function getInventories()
    {
        $post = $this->input->post();
        $inventories = $this->Inventories->searchProductName($post['keyword']);
        echo json_encode($inventories);
    }

    public function getInventory()
    {
        $post = $this->input->post();
        $inventory = $this->Inventories->getInventory($post['id']);
        echo json_encode($inventory);
    }

    public function getCustomer()
    {
        $customer = $this->Customers->getCustomer($this->input->post('id'));
        echo json_encode($customer);
    }

    public function save()
    {
        $post = $this->input->post();
        if (!isset($post['product_id'])) {
            echo json_encode(
                [
                    'error' => 'true',
                    'status' => 'product not found',
                    'message' => 'Produk belum ditambahkan'
                ]
            );
            die;
        }

        $data = array(
            'no_transaction' => $post['no_transaction'],
            'datetime' => date('Y-m-d H:i:s'),
            'user_id' => $post['user_id'],
            'customer_id' => $post['customer_id'],
            'total_payment' => $post['total_payment'],
            'payment_method' => $post['payment_method'],
            'amounted_payment' => $post['payment'],
            'change_money' => $post['change'],
            'status' => $post['status'],
            'info' => $post['info']
        );

        $data_batch = array();
        for ($i = 0; $i < count($post['product_id']); $i++) {
            $extra_price = $post['extra_price'][$i] == '' ? 0 : $post['extra_price'][$i];
            $row = array(
                'no_transaction' => $post['no_transaction'],
                'product_id'     => $post['product_id'][$i],
                'price'          => $post['price'][$i] + $extra_price,
                'qty'            => $post['qty'][$i],
                'subtotal'      => $post['sub_total'][$i]
            );
            array_push($data_batch, $row);
        }

        $insert = $this->Sales->insertTransaction($data, $data_batch);

        if ($insert) {
            if ($post['print'] === "on") {
                echo json_encode([
                    'error' => 'false',
                    'status' => 'success',
                    'message' => 'Transaksi Berhasil',
                    'print' => 'true',
                    'no_transaction' => $data['no_transaction']
                ]);
            } else {
                $this->session->set_flashdata('transaction_msg', '<div class="alert alert-success"> Transaksaksi Berhasil </div>');
                echo json_encode([
                    'error' => 'false',
                    'status' => 'success',
                    'message' => 'Transaksi Berhasil',
                    'print' => 'false'
                ]);
            }
        }
    }

    public function list()
    {
        $data = array(
            'title' => 'Histori Penjualan',
            'header' => 'Histori Penjualan',
            'content' => 'sales/list'
        );

        $this->load->view('templates/index', $data);
    }

    public function details($no_transaction)
    {
        $data = array(
            'title' => 'Detail Penjualan',
            'header' => 'Detail Penjualan',
            'content' => 'sales/details',
            'sale' => $this->Sales->getSale($no_transaction),
            'sale_details' => $this->Sales->getSaleDetails($no_transaction)
        );
        $this->load->view('templates/index', $data);
    }

    public function delete($no_transaction)
    {
        $query = $this->Sales->deleteSale($no_transaction);
        if ($query) {
            $this->session->set_flashdata('transaction_msg', '<div class="alert alert-success"> Transaksaksi berhasil dihapus </div>');
        }
        redirect('Sales/list');
    }

    public function getDeliveryCost()
    {
        $post = $this->input->post();

        $query = $this->Sales->getDeliveryCost($post['cost_type_id']);

        echo json_encode($query);
    }

    public function getTransactions()
    {
        $db = $this->Sales->getTransactions();
        $no = $_POST['start'];
        $inventories = array();
        foreach ($db as $field) {
            $no++;
            $row = array();
            $row[] = $field->datetime;
            $row[] = $field->no_transaction;
            $row[] = $field->cashier_name;
            $row[] = $field->customer_name;
            $row[] = $this->_getPaymentMethod($field->payment_method);
            $row[] = 'Rp.' . number_format($field->total_payment, 0, ',', '.');
            $row[] = $this->_saleStatus($field->status);

            if ($field->status == 'Hutang') {
                $row[] = '<a href="' . site_url('Sales/details/') . $field->no_transaction . '" class="btn btn-sm btn-info"><i class="fa fa-list"></i></a> <a href="' . site_url('Sales/delete/') . $field->no_transaction . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin menghapus data? \');"><i class="fa fa-trash"></i></a><a href="' . site_url('Sales/payFull/') . $field->no_transaction . '" class="btn btn-sm btn-warning ml-2"><i class="fas fa-money-bill"></i></a>';
            } else {
                $row[] = '<a href=' . site_url('Sales/details/') . $field->no_transaction . ' class="btn btn-sm btn-info"><i class="fa fa-list"></i></a> <a href=' . site_url('Sales/delete/') . $field->no_transaction . ' class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin menghapus data? \');"><i class="fa fa-trash"></i></a>';
            }

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

    private function _getPaymentMethod($code)
    {
        switch ($code) {
            case CASH_PAYMENT_METHOD:
                return 'CASH';
                break;

            case DEBIT_PAYMENT_METHOD:
                return 'DEBIT';
                break;

            default:
                return 'NOT FOUND';
                break;
        }
    }

    public function print()
    {

        $get = $this->input->get();

        $sale = $this->Sales->getSale($get['no_transaction']);
        $sale_details = $this->Sales->getSaleDetails($get['no_transaction']);

        $data = array(
            'title' => 'Rumah Faliesha',
            'print_id' => $sale['no_transaction'] . $sale['customer_id'],
            'sale' => $sale,
            'sale_details' => $sale_details,
            'redirect' => $get['redirect']
        );

        $this->load->view('print/index', $data);
    }

    public function payFull($no_transaction)
    {
        $query = $this->Sales->payFull($no_transaction);
        if ($query) {
            $this->session->set_flashdata('transaction_msg', '<div class="alert alert-success"> No Transaksi ' . $no_transaction . ' telah lunas </div>');
        } else {
            $this->session->set_flashdata('transaction_msg', '<div class="alert alert-danger"> No Transaksi ' . $no_transaction . ' gagal melakukan pelunasan </div>');
        }
        redirect('Sales/list');
    }

    private function _saleStatus($status)
    {
        if ($status == 'Hutang') return "<span class=\"text-danger\"> {$status} </span>";
        return "<span class=\"text-success\"> {$status} </span>";
    }
}

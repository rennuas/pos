<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UpdateStock extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $sales = $this->db->get('sale_details')->result_array();

        foreach ($sales as $sale) {
            $product = $this->db->get_where('inventories', ['id' => $sale['product_id']])->row_array();

            $this->db->update('inventories', ['stock' => $product['stock'] - $sale['qty']], ['id' => $product['id']]);
        }
    }
}

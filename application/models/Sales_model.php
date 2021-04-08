<?php


class Sales_model extends CI_Model
{
    private $_salesTbl = 'sales';
    private $_saleDetailsTbl = 'sale_details';
    private $_customerTbl = 'customers';
    private $_cashierTbl = 'user_login';
    private $_productTbl = 'inventories';
    protected $column_order = array(
        'datetime',
        'no_transaction',
        'user_login.name',
        'customers.name',
        'payment_method',
        'total_payment',
        'amounted_payment',
        'status'
    );

    protected $column_search = array(
        'datetime',
        'no_transaction',
        'user_login.name',
        'customers.name',
        'payment_method',
        'total_payment',
        'amounted_payment',
        'status'
    );
    protected $order = array('datetime' => 'desc');

    public function insertTransaction(array $info, array $products)
    {
        $this->db->trans_start();

        $this->db->insert($this->_salesTbl, $info);

        $this->db->insert_batch($this->_saleDetailsTbl, $products);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function getSale($no_transaction)
    {
        $this->db->select("{$this->_salesTbl}.*, {$this->_customerTbl}.name as customer_name, {$this->_cashierTbl}.name as cashier_name");
        $this->db->from($this->_salesTbl);
        $this->db->where("{$this->_salesTbl}.no_transaction", $no_transaction);
        // $this->db->join($this->_saleDetailsTbl, "{$this->_salesTbl}.no_transaction={$this->_saleDetailsTbl}.no_transaction");
        $this->db->join($this->_customerTbl, "{$this->_salesTbl}.customer_id={$this->_customerTbl}.id");
        $this->db->join($this->_cashierTbl, "{$this->_salesTbl}.user_id={$this->_cashierTbl}.id");
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getSaleDetails($no_transaction)
    {
        $this->db->select("{$this->_saleDetailsTbl}.*, {$this->_productTbl}.product_name");
        $this->db->from($this->_saleDetailsTbl);
        $this->db->where("{$this->_saleDetailsTbl}.no_transaction", $no_transaction);
        $this->db->join($this->_productTbl, "{$this->_saleDetailsTbl}.product_id={$this->_productTbl}.id");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getTransactions()
    {
        $this->_getTransactions();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countFiltered()
    {
        $this->_getTransactions();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll()
    {
        $this->db->from('inventories');
        return $this->db->count_all_results();
    }

    private function _getTransactions()
    {
        $this->db->select("{$this->_salesTbl}.*, {$this->_customerTbl}.name as customer_name, {$this->_cashierTbl}.name as cashier_name");
        $this->db->from($this->_salesTbl);
        $this->db->join($this->_customerTbl, "{$this->_customerTbl}.id={$this->_salesTbl}.customer_id");
        $this->db->join($this->_cashierTbl, "{$this->_cashierTbl}.id={$this->_salesTbl}.user_id");

        $i = 0;

        foreach ($this->column_search as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
}

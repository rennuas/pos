<?php

class Customers_model extends CI_Model
{
    protected $column_order = array(null, 'name', 'telp', 'customer_categories.category'); //field yang ada di table user
    protected $column_search = array('name', 'telp', 'customer_categories.category'); //field yang diizin untuk pencarian 
    protected $order = array('customers.id' => 'asc'); // default order 

    public function getCustomers()
    {
        $this->_getCustomersData();
        if (isset($_POST['length']) && $_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function getCustomer($id)
    {
        $query = $this->db->get_where('customers', ['id' => $id]);
        return $query->row_array();
    }

    public function getCategories()
    {
        return $this->db->get('customer_categories')->result_array();
    }

    public function insert($data, $table)
    {
        return $this->db->insert($table, $data);
    }

    public function update($id, $data, $table)
    {
        return $this->db->update($table, $data, ['id' => $id]);
    }

    public function delete($id, $table)
    {
        return $this->db->delete($table, ['id' => $id]);
    }

    public function countFiltered()
    {
        $this->_getCustomersData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll()
    {
        $this->db->from('customers');
        return $this->db->count_all_results();
    }

    private function _getCustomersData()
    {

        $this->db->select('*, customers.id as customer_id');
        $this->db->from('customers');
        $this->db->join('customer_categories', 'customers.category_id = customer_categories.id');
        // if (isset($_POST['customer_id'])) $this->db->where('customers.id', $_POST['customer_id']);

        $i = 0;

        foreach ($this->column_search as $item) // looping awal
        {
            if (isset($_POST['search']['value'])) // jika datatable mengirimkan pencarian dengan metode POST
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

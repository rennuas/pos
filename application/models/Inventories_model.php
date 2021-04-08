<?php

class Inventories_model extends CI_Model
{
    private $_inventoryTbl = 'inventories';
    private $_categoryTbl = 'inventory_categories';
    private $_unitTbl = 'stock_unit';
    protected $column_order = array(null, 'product_name', 'sale_price', 'stock', 'unit', 'category');
    protected $column_search = array('product_name', 'sale_price', 'stock', 'unit', 'category');
    protected $order = array('inventories.id' => 'desc');

    public function getInventories()
    {
        $this->_getInventoriesData();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function getInventory($id)
    {
        $query = $this->db->get_where($this->_inventoryTbl, ['id' => $id]);
        return $query->row_array();
    }

    public function getCategories()
    {
        $this->db->order_by('category');
        return $this->db->get($this->_categoryTbl)->result_array();
    }

    public function getUnits()
    {
        $this->db->order_by('unit');
        return $this->db->get($this->_unitTbl)->result_array();
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
        $this->_getInventoriesData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll()
    {
        $this->db->from('inventories');
        return $this->db->count_all_results();
    }

    private function _getInventoriesData()
    {

        $this->db->select("*, {$this->_inventoryTbl}.id as inventory_id");
        $this->db->from($this->_inventoryTbl);
        $this->db->join($this->_categoryTbl, "{$this->_inventoryTbl}.category_id = {$this->_categoryTbl}.id");
        $this->db->join($this->_unitTbl, "{$this->_inventoryTbl}.unit_id = {$this->_unitTbl}.id");
        // if (isset($_POST['customer_id'])) $this->db->where('inventories.id', $_POST['customer_id']);

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

    public function searchProductName($keyword)
    {
        $this->db->select('*');
        $this->db->from($this->_inventoryTbl);
        $this->db->like('product_name', $keyword);
        $this->db->or_like('id', $keyword);
        $query = $this->db->get();
        return $query->result();
    }
}

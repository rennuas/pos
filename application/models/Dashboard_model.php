<?php

class Dashboard_model extends CI_Model
{
    private $_customerTbl = 'customers';
    private $_inventoryTbl = 'inventories';
    private $_inventoryCtgTbl = 'inventory_categories';
    private $_salesTbl = 'sales';
    private $_saleDetailsTbl = 'sale_details';
    private $_unitTbl = 'stock_unit';

    public function countCustomers()
    {
        return $this->db->count_all($this->_customerTbl);
    }

    public function countCustomerBelitung()
    {
        $query = $this->db->get_where($this->_customerTbl, ['category_id' => '2']);
        return $query->num_rows();
    }

    public function countCustomerReseller()
    {
        $query =  $this->db->get_where($this->_customerTbl, ['category_id' => '3']);
        return $query->num_rows();
    }

    public function countProducts()
    {
        return $this->db->count_all($this->_inventoryTbl);
    }

    public function countProductCategories()
    {
        return $this->db->count_all($this->_inventoryCtgTbl);
    }

    public function countMonthlyTransaction()
    {
        return $this->db->count_all($this->_salesTbl);
    }

    public function countTodayTransaction()
    {
        $query =  $this->db->get_where($this->_salesTbl, ['DATE(datetime)' => date('Y-m-d')]);
        return $query->num_rows();
    }

    public function getBestSellers()
    {
        $this->db->select('product_name, SUM(qty) as sold, unit, SUM(subtotal) as gross_income');
        $this->db->from($this->_saleDetailsTbl);
        $this->db->join($this->_inventoryTbl, "{$this->_inventoryTbl}.id={$this->_saleDetailsTbl}.product_id");
        $this->db->join($this->_unitTbl, "{$this->_inventoryTbl}.unit_id={$this->_unitTbl}.id");
        $this->db->group_by('product_id');
        $this->db->order_by('sold', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function countMonthlyGrossIncome()
    {
        $this->db->select_sum('total_payment');;
        $query = $this->db->get_where($this->_salesTbl, ['MONTH(datetime)' => date('m')]);
        return $query->row_array();
    }

    public function countTodayGrossIncome()
    {
        $this->db->select_sum('total_payment');;
        $query = $this->db->get_where($this->_salesTbl, ['DATE(datetime)' => date('Y-m-d')]);
        return $query->row_array();
    }

    public function getDailyGrossIncomeOfMonth()
    {
        $date_list = $this->_getDateOfMonth();

        $this->db->select('DATE(datetime) as date, SUM(total_payment) as gross_income');
        $this->db->from($this->_salesTbl);
        $this->db->where('MONTH(datetime)', date('m'));
        $this->db->group_by('date');
        $query = $this->db->get();
        $sales = $query->result_array();

        $gross_income = array();
        foreach ($date_list as $date) {
            foreach ($sales as $sale) {
                if ($sale['date'] == $date) {
                    $data = array(
                        'date' => $sale['date'],
                        'gross_income' => $sale['gross_income']
                    );
                    break;
                } else {
                    $data = array(
                        'date' => $date,
                        'gross_income' => 0
                    );
                }
            }
            array_push($gross_income, $data);
        }

        return $gross_income;
    }

    public function getMonthlyGrossIncomeOfYear()
    {
        $month_list =  $this->_getMonthOfYear();

        $this->db->select('MONTHNAME(datetime) as month, SUM(total_payment) as gross_income');
        $this->db->from($this->_salesTbl);
        $this->db->where('YEAR(datetime)', date('Y'));
        $this->db->group_by('month');
        $query = $this->db->get();
        $sales = $query->result_array();

        $gross_income = array();
        foreach ($month_list as $month) {
            foreach ($sales as $sale) {
                if ($sale['month'] == $month) {
                    $data = array(
                        'month' => $sale['month'],
                        'gross_income' => intval($sale['gross_income'])
                    );
                    break;
                } else {
                    $data = array(
                        'month' => $month,
                        'gross_income' => 0
                    );
                }
            }
            array_push($gross_income, $data);
        }

        return $gross_income;
    }

    public function getYearlyGrossIncome()
    {
        $year_list = $this->_getYear();

        $this->db->select('YEAR(datetime) as year, SUM(total_payment) as gross_income');
        $this->db->from($this->_salesTbl);
        $this->db->group_by('year');
        $this->db->order_by('year', 'DESC');
        $this->db->limit(3);
        $query = $this->db->get();
        $sales = $query->result_array();

        $gross_income = array();
        foreach ($year_list as $year) {
            foreach ($sales as $sale) {
                if ($sale['year'] == $year) {
                    $data = array(
                        'year' => $sale['year'],
                        'gross_income' => $sale['gross_income']
                    );
                    break;
                } else {
                    $data = array(
                        'year' => $year,
                        'gross_income' => 0
                    );
                }
            }
            array_push($gross_income, $data);
        }

        return $gross_income;
    }

    private function _getDateOfMonth()
    {
        $begin = new DateTime(date('Y-m-1'));
        $end = new DateTime('today');
        $end->modify('+1 day');

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);

        $date_list = array();
        foreach ($daterange as $date) {
            $date_list[] = $date->format("Y-m-d");
        }
        return $date_list;
    }

    private function _getMonthOfYear()
    {
        $begin = new DateTime(date('Y-1-1'));
        $end = new DateTime('today');
        $end->modify('+1 day');

        $interval = new DateInterval('P1M');
        $daterange = new DatePeriod($begin, $interval, $end);

        $month_list = array();
        foreach ($daterange as $date) {
            $month_list[] = $date->format("F");
        }
        return $month_list;
    }

    private function _getYear()
    {
        $begin = new DateTime();
        $begin->modify('-2 year');
        $end = new DateTime('today');
        $end->modify('+1 year');

        $interval = new DateInterval('P1Y');
        $daterange = new DatePeriod($begin, $interval, $end);

        $year_list = array();
        foreach ($daterange as $date) {
            $year_list[] = $date->format("Y");
        }
        return $year_list;
    }
}

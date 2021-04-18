<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->is_logged();
        $this->load->model('Dashboard_model', 'Dashboard');
    }

    public function index()
    {

        $data = array(
            'title' => 'Dashboard',
            'header' => 'Dashboard',
            'content' => 'home',
            'bestSellers' => $this->Dashboard->getBestSellers(),
            'customers' => $this->Dashboard->countCustomers(),
            'customer_belitung' => $this->Dashboard->countCustomerBelitung(),
            'customer_reseller' => $this->Dashboard->countCustomerReseller(),
            'products' => $this->Dashboard->countProducts(),
            'product_categories' => $this->Dashboard->countProductCategories(),
            'monthly_transaction' => $this->Dashboard->countMonthlyTransaction(),
            'today_transaction' => $this->Dashboard->countTodayTransaction(),
            'month_gross_income' => $this->Dashboard->countMonthlyGrossIncome(),
            'today_gross_income' => $this->Dashboard->countTodayGrossIncome(),
            'daily_gross_income' => $this->Dashboard->getDailyGrossIncomeOfMonth(),
            'monthly_gross_income' => $this->Dashboard->getMonthlyGrossIncomeOfYear(),
            'yearly_gross_income' => $this->Dashboard->getYearlyGrossIncome(),
        );

        $this->load->view('templates/index', $data);
    }
}

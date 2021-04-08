<?php

class Auth_model extends CI_Model
{
    private $_table = 'user_login';

    public function verification()
    {
        $post = $this->input->post();

        $username = htmlspecialchars($post['username']);
        $password = htmlspecialchars($post['password']);

        $query = $this->db->get_where($this->_table, ['username' => $username])->row_array();

        if (!$query) return false;

        $password_hash = $query['password'];

        if (!password_verify($password, $password_hash)) return false;

        return $query;
    }
}

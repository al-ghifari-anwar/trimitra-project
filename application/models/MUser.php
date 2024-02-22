<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MUser extends CI_Model
{
    public $username;
    public $full_name;
    public $password_user;
    public $level_user;
    public $phone_user;
    public $is_active;
    public $updated_at;

    public function getForAuth()
    {
        $this->load->model('MAuthToken');
        $post = $this->input->post();
        $username = $post['username'];
        $password_user = $this->encrypt($post['password_user']);

        $getUser = $this->db->get_where('tb_user', ['username' => $username])->row_array();

        if ($getUser != null) {
            if ($getUser['password_user'] == $password_user) {
                $this->db->select("id_user,username,full_name,level_user,phone_user,is_active");
                $getUser = $this->db->get_where('tb_user', ['username' => $username])->row_array();

                $createToken = $this->MAuthToken->create($getUser['id_user']);

                $return = [
                    'response' => 200,
                    'status' => 'ok',
                    'results' => array(
                        'token' => $createToken['token'],
                        'user' => $getUser
                    )
                ];

                return $return;
            } else {
                $return = [
                    'response' => 200,
                    'status' => 'failed',
                    'message' => 'Password incorrect, please try again'
                ];

                return $return;
            }
        } else {
            $return = [
                'response' => 200,
                'status' => 'failed',
                'message' => 'Username not found'
            ];

            return $return;
        }
    }

    public function create()
    {
        $post = $this->input->post();
        $this->username = $post['username'];
        $this->full_name = $post['full_name'];
        $this->password_user = $this->encrypt($post['password_user']);
        $this->level_user = $post['level_user'];
        $this->phone_user = $post['phone_user'];
        $this->is_active = 1;
        $this->updated_at = date("Y-m-d H:i:s");

        $query = $this->db->insert('tb_user', $this);

        if ($query) {
            $id = $this->db->insert_id();

            $this->db->select("id_user,username,full_name,level_user,phone_user,is_active");
            $getUser = $this->db->get_where('tb_user', ['id_user' => $id])->row_array();

            $createToken = $this->MAuthToken->create($getUser['id_user']);

            $return = [
                'response' => 200,
                'status' => 'ok',
                'results' => array(
                    'token' => $createToken['token'],
                    'user' => $getUser
                )
            ];

            return $return;
        }
    }

    public function encrypt($str)
    {
        $salt = 'trimitra';

        return md5($salt . md5($str));
    }
}

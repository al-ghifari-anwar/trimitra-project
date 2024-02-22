<?php
defined('BASEPATH') or exit('No direct script allowed');

class MAuthToken extends CI_Model
{
    public $id_user;
    public $auth_token;
    public $updated_at;
    public $exp_at;

    public function create($id_user)
    {
        $this->id_user = $id_user;
        $this->auth_token = $this->tokenCreation($id_user . date("Y-m-d H:i:s"));
        $this->updated_at = date("Y-m-d H:i:s");
        $this->exp_at = date("Y-m-d H:i:s", strtotime("+6 month"));

        $query = $this->db->insert('tb_auth_token', $this);

        if ($query) {
            $id_auth_token = $this->db->insert_id();
            $getToken = $this->db->get_where('tb_auth_token', ['id_auth_token' => $id_auth_token])->row_array();
            $return = [
                'response' => 200,
                'status' => 'ok',
                'token' => $getToken
            ];

            return $return;
        } else {
            $return = [
                'response' => 200,
                'status' => 'failed',
                'message' => 'Token creation failed'
            ];

            return $return;
        }
    }

    public function getByIdUser($id_user)
    {
        $getToken = $this->db->get_where('tb_auth_token', ['id_user' => $id_user, 'is_active' => 1])->row_array();

        if ($getToken) {
        }
    }

    public function tokenCreation($str)
    {
        $token = bin2hex(random_bytes(16) . $str);

        return $token;
    }
}

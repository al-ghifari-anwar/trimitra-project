<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MUser');
    }

    public function auth()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $response = $this->MUser->getForAuth();

            echo json_encode($response);
        } else {
            $response = [
                'response' => 401,
                'status' => 'failed',
                'message' => 'Request not found'
            ];

            echo json_encode($response);
        }
    }

    public function insert()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $response = $this->MUser->create();

            echo json_encode($response);
        } else {
            $response = [
                'response' => 401,
                'status' => 'failed',
                'message' => 'Request not found'
            ];

            echo json_encode($response);
        }
    }
}

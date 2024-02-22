<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MUser extends CI_Model
{
    public $username;
    public $full_name;
    public $password_user;
    public $level_user;
    public $phone_user;
    public $is_sales;
    public $is_active;
    public $created_at;
    public $updated_at;
}

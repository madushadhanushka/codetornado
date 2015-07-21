<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Account
 *
 * @author User
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');             // load all library needed
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function showLoginPage() {
        $data['page_title'] = "Login";
        $this->load->view('template/header.php', $data);
        $this->load->view('account/loginpage.php', $data);
        $this->load->view('template/footer.php');
    }
    public function loginUser(){
        
    }

}

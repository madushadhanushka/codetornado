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

    public function loginUser() {
        $this->load->model('account_model');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $loginStatus = $this->account_model->loginUser($username, $password);
        if ($loginStatus == false) {
            
        } else {
            $this->session->set_userdata($loginStatus);
            $data['username']=$this->session->userdata('username');
            $data['user_ID']=$this->session->userdata('user_ID');
            
            $this->load->model('main_model');
            $data['page_detail'] = $this->main_model->getAllPages(12);

            $data['page_title'] = "Home page";
            $this->load->view('template/header.php', $data);
            $this->load->view('design/homepage.php', $data);
            $this->load->view('template/footer.php');
        }
    }

}

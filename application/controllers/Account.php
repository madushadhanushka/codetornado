<?php

/*
 * This controller handle all request regards to the account handling and login page

 *
 * @author M.D.M Udayanga
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    /* 
     * initially load required all libraries
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');             // load all library needed
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    // this funciton show login page to the user when user requested or user not login to the 
    // application
    public function login() {

        $data['page_title'] = "Login";
        $this->load->view('template/header.php', $data);
        $this->load->view('account/loginpage.php', $data);
        $this->load->view('template/footer.php');
    }

    /*
     *  this function check, validate and login user 
     */

    public function loginUser() {
        $this->load->model('account_model');        // all function required in this controler in account model
        // get posted data into variables
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // validate user by using account model. return false if entered data not in the system
        $loginStatus = $this->account_model->loginUser($username, $password);
        if ($loginStatus == false) {        // redirect to the same page and show error
        } else {
            // if user validate then show home page
            $this->session->set_userdata($loginStatus);
            $this->load->model('page_model');

            $data['index_page'] = $this->page_model->getIndexPage();
            // get user information to data
            $data['username'] = $this->session->userdata('username');
            $data['user_ID'] = $this->session->userdata('user_ID');

            // get all created page by the user 
            $this->load->model('main_model');
            $data['page_detail'] = $this->main_model->getAllPages($data['user_ID']);
            // get all available pages from main model
            $data['module_detail'] = $this->main_model->getAllModule();

            // show home page
            $data['page_title'] = "Home page";
            $this->load->view('template/header.php', $data);
            $this->load->view('template/navigation.php', $data);
            $this->load->view('design/homepage.php', $data);
            $this->load->view('template/footer.php');
        }
    }
/*
 * view all available accounts
 */
    public function viewAllAccount() {
        $user_ID = $this->session->userdata('user_ID');
        $data['username'] = $this->session->userdata('username');
        $data['user_ID'] = $this->session->userdata('user_ID');
        if (isset($user_ID)) {                              // check used is alread logged. else show error
            $this->load->model('account_model');            // load account module 
            $data['account_detail'] = $this->account_model->getAllAccount();

            $data['page_title'] = "Accounts";               // set title of the page
            $this->load->view('template/header.php', $data);        // show header
            $this->load->view('template/navigation.php', $data);    // show navigation bar
            $this->load->view('account/allaccount.php', $data);     // show account page
            $this->load->view('template/footer.php');               // show footer
        }
    }
    /*
     * view create new account page
     */
    public function viewCreateAccount() {
        $user_ID = $this->session->userdata('user_ID');
        $data['username'] = $this->session->userdata('username');
        $data['user_ID'] = $this->session->userdata('user_ID');
        if (isset($user_ID)) {                              // check used is alread logged. else show error
            $this->load->model('account_model');            // load account module 
            $data['account_detail'] = $this->account_model->getAllAccount();

            $data['page_title'] = "Accounts";               // set title of the page
            $this->load->view('template/header.php', $data);        // show header
            $this->load->view('template/navigation.php', $data);    // show navigation bar
            $this->load->view('account/createaccount.php', $data);     // show account page
            $this->load->view('template/footer.php');               // show footer
        }
    }
    /*
     * add new user into the system. then show all accounts
     */
    public function addUser() {
        $this->load->model('account_model');            // load account module 
        
        $username = $this->input->post('username');     // get posted username
        $password = $this->input->post('password');     // get posted password
        $this->account_model->createAccount($username,$password);   // create new user by account using model
        
        
        $user_ID = $this->session->userdata('user_ID');             // get user id from session data
        $data['username'] = $this->session->userdata('username');
        $data['user_ID'] = $this->session->userdata('user_ID');
        if (isset($user_ID)) {                              // check used is alread logged. else show error
            
            $data['account_detail'] = $this->account_model->getAllAccount();

            $data['page_title'] = "Accounts";               // set title of the page
            $this->load->view('template/header.php', $data);        // show header
            $this->load->view('template/navigation.php', $data);    // show navigation bar
            $this->load->view('account/allaccount.php', $data);     // show account page
            $this->load->view('template/footer.php');               // show footer
        }
    }
    public function deleteUser() {
        $this->load->model('account_model');            // load account module 
        $user_ID=$this->input->get("user_ID");
        $this->account_model->deleteUser($user_ID);     // delete user by user id
        header("location:" . base_url("index.php/account/viewAllAccount"));     // redirect to view all account page
    }

}

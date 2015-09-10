<?php
/*
 * 
 * This controller is used to handle all request during installing application.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');             // load all library needed
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    // this controller check inserted value and if data is validate then update the database and create
    // config files
    public function installDetail() {

        // get data from install page
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $cpassword = $this->input->post('cpassword');

        $all_error = false;
        if ($cpassword != $password) {              // pasword mismatch error
            $data['formerror_cpassword'] = "Password mismatch";
            $all_error = true;
        }
        if ($cpassword == null) {                   // password cannot be null
            $data['formerror_password'] = "Password should more than 6 charactors";
            $all_error = true;
        }
        if ($username == null) {                    // username cannot be null
            $data['formerror_username'] = "Username should more than 6 charactors";
            $all_error = true;
        }
        if ($all_error) {                           // check if any errors happen
            // then show same data with the error
            $data['page_title'] = "Install CodeTornado";
            $this->load->view('template/header.php', $data);
            $this->load->view('install/AccountDetail.php', $data);
            $this->load->view('template/footer.php');
        } else {
            // if data is validate then setup server
            $doc = new DOMDocument( );          // installation config file handler 
            $host = $doc->createElement('host');    // create new node host to store host name
            $host->nodeValue = 'Hello ';            // put host name inside the host node
            $doc->appendChild($host);
            $doc->save('data/install/installdetail.xml');   // save detail in installdetial.xml file
            
            // show Install success page
            $data['page_title'] = "Install success";
            $this->load->view('template/header.php', $data);
            $this->load->view('install/InstallSuccess.php', $data);
            $this->load->view('template/footer.php');
        }
    }

}

?>

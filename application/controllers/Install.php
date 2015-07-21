<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');             // load all library needed
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function installDetail() {

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $cpassword = $this->input->post('cpassword');

        $all_error = false;
        if ($cpassword != $password) {
            $data['formerror_cpassword'] = "Password mismatch";
            $all_error = true;
        }
        if ($cpassword == null) {
            $data['formerror_password'] = "Password should more than 6 charactors";
            $all_error = true;
        }
        if ($username == null) {
            $data['formerror_username'] = "Username should more than 6 charactors";
            $all_error = true;
        }
        if ($all_error) {

            $data['page_title'] = "Install CodeTornado";
            $this->load->view('template/header.php', $data);
            $this->load->view('install/AccountDetail.php', $data);
            $this->load->view('template/footer.php');
        } else {
            
            $doc = new DOMDocument( );
            $host = $doc->createElement('host');
            $host->nodeValue = 'Hello ';
            $doc->appendChild($host);
            $doc->save('data/install/installdetail.xml');
            
            $data['page_title'] = "Install success";
            $this->load->view('template/header.php', $data);
            $this->load->view('install/InstallSuccess.php', $data);
            $this->load->view('template/footer.php');
        }
    }

}

?>

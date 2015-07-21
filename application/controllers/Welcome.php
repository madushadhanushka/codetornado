<?php

session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');             // load all library needed
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("location:" . base_url('index.php/Account/showloginpage'));
        } else if (file_exists("data/install/installdetail.xml")) {
            $xml = simplexml_load_file("data/install/installdetail.xml");
            if ($xml === false) {            // check xml file load
                log_message('error', 'xml functional error');
                die("xml functional error. please reinstall again");
            }
            header("location:" . base_url('index.php/Main/homepage'));
            echo $xml->host;
        } else {
            $data['page_title'] = "install CodeTornado";
            $this->load->view('template/header.php', $data);
            $this->load->view('install/AccountDetail.php', $data);
            $this->load->view('template/footer.php');
        }

        //$this->load->view('welcome_message');
    }

}

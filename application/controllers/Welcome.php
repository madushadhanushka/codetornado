<?php

// this controller handle request comes to the index page

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
        // this section check whether user is already login, not logged or not install application


        if (!file_exists("data/install/installdetail.xml")) {
            $data['page_title'] = "install CodeTornado";
            $this->load->view('template/header.php', $data);
            $this->load->view('install/AccountDetail.php', $data);
            $this->load->view('template/footer.php');
        } else {
            // if data not in the installdetail.xml file then redirect to install page
            $this->load->model('page_model');
            $indexPage = $this->page_model->getIndexPage();
            header("location:".base_url('index.php/page/preview?page_id=').$indexPage);
            /*
            $pageData = $this->page_model->getPreviewPage($indexPage);
            $data['html_code'] = $pageData['html'];
            $this->page_model->setPreviewPage($pageData['html']);
            $data['page_title'] = $pageData['title'];
            $this->load->view('template/bootstrap/header.php', $data);
            $this->load->view('design/preview.php', $data);
            $this->load->view('template/bootstrap/footer.php');
             
             */
        }

        //$this->load->view('welcome_message');
    }

}

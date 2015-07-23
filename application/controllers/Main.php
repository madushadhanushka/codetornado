<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');             // load all library needed
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        //$this->load->database('coder');
    }

    public function homePage() {

        $this->load->model('main_model');
        $data['page_detail'] = $this->main_model->getAllPages(12);

        $data['page_title'] = "Home page";
        $this->load->view('template/header.php', $data);
        $this->load->view('design/homepage.php', $data);
        $this->load->view('template/footer.php');
    }

    public function designPage() {

        $data['page_ID'] = $this->input->get('page_ID');
        $this->load->model('main_model');
        $data['page_detail'] = $this->main_model->getPage($data['page_ID']);
        if ($data['page_detail'] != false) {

            $data['page_title'] = "Page Desing Page";
            $this->load->view('template/header.php', $data);
            $this->load->view('design/designpage.php', $data);
            $this->load->view('template/footer.php');
        }
    }

    public function savePage() {
        $xml = $this->input->get('xml');
        $page_ID = $this->input->get('page_ID');
        $this->load->model('main_model');
        $this->main_model->savePage($xml,$page_ID);
        echo json_encode(array('1'));
    }

}

?>

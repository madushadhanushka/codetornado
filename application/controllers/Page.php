<?php

/*
 * 
 * This controller is used to handle all preview request.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');             // load all library needed
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    /*
     *  this controller check inserted value and if data is validate then update the database and create
     *  config files
     */
    public function preview() {
        $page_id = $this->input->get('page_id');

        $this->load->model('page_model');
        $pageData = $this->page_model->getPreviewPage($page_id);        // get page data from page model
        //  $pageData['title'] return title of the project
        //  $pageData['control'] return the controller code
        //  $pageData['html'] return the html code for the canvas

        $data['html_code'] = $pageData['html'];                     // set html data to $html_code
        $this->page_model->setPreviewPage($pageData['html']);       // set preview page data in design/preview.php file
        eval($pageData['control']);                                 // run code segment in controller
        $data['page_title'] = $pageData['title'];
        $this->load->view('template/bootstrap/header.php', $data);
        $this->load->view('design/preview.php', $data);
        $this->load->view('template/bootstrap/footer.php');
    }
/*
 * view page without saving page. user can get quick preview of the page by clicking preview 
 * button in the design page.
 */
    public function viewPage() {
        $page_id = $_GET['page_ID'];                    // get page id of the page to be preview
        $this->load->model('page_model');
        $data['html'] = $this->page_model->getTempPreviewPage($page_id);    // get preview data of the given page id
        $data['page_title'] = 'Preview page';
        $this->load->view('template/bootstrap/header.php', $data);
        $this->load->view('design/viewhtml.php', $data);
        $this->load->view('template/bootstrap/footer.php');
    }
/*
 * this function same as the view page. this function used to quick preview modules
 */
    public function viewModule() {
        $page_id = $_GET['module_ID'];          // get module name
        $this->load->model('page_model');
        $data['html'] = $this->page_model->getTempPreviewPage($page_id);    // get preview data of the given module name
        $data['page_title'] = 'Preview page';
        $this->load->view('template/bootstrap/header.php', $data);
        $this->load->view('design/viewhtml.php', $data);
        $this->load->view('template/bootstrap/footer.php');
    }
/*
 * this function call as json request. it store canvas html value in a file and return 1 if success
 * or otherwise send 2. this is used to quick preview page.
 */
    public function setView() {
        $user_ID = $this->session->userdata('user_ID');
        if (isset($user_ID)) {                              // check if user logged in
            $page_html = $_GET['data'];
            $page_ID = $_GET['page_ID'];
            $this->load->model('page_model');
            $pageData = $this->page_model->setTempPreviewPage($page_html, $page_ID);
            // save temperory data on a file by page html and page id
            echo json_encode(array("1"));                   // if success return 1
        } else {
            echo json_encode(array("2"));                   // if save not success return 2
        }
    }
/*
 * this controller show page to create new page
 */
    public function viewCreatePage() {
        $user_ID = $this->session->userdata('user_ID');
        if (isset($user_ID)) {
            $data['page_title'] = 'Create new page';
            $this->load->view('template/bootstrap/header.php', $data);
            $this->load->view('misc/createpage.php', $data);
            $this->load->view('template/bootstrap/footer.php');
        } else {
            echo "Unauthentication";
        }
    }
/*
 * this controller show page to create new module
 */
    public function viewCreateModule() {
        $user_ID = $this->session->userdata('user_ID');
        if (isset($user_ID)) {
            $data['page_title'] = 'Create new module';
            $this->load->view('template/bootstrap/header.php', $data);
            $this->load->view('misc/createmodule.php', $data);
            $this->load->view('template/bootstrap/footer.php');
        } else {
            echo "Unauthentication";
        }
    }
/*
 * this function create new page
 */
    function createPage() {
        $user_ID = $this->session->userdata('user_ID');
        if (isset($user_ID)) {                                  // check if user logged in
            $pagename = $this->input->post('pagename');
            $description = $this->input->post('description');

            $this->form_validation->set_rules('pagename', 'Page name', 'required');
            // set form validation. page name should required
            if ($this->form_validation->run() == FALSE) {           // if validation false
                $data['page_title'] = 'Create new page';
                $this->load->view('template/bootstrap/header.php', $data);
                $this->load->view('misc/createpage.php', $data);
                $this->load->view('template/bootstrap/footer.php');
            } else {                                                // if validation true
                $user_ID = $this->session->userdata('user_ID');
                $this->load->model('page_model');
                $page_ID = $this->page_model->createNewPage($pagename, $description, $user_ID);
                // create new page and get page id by return value
                header("location:" . base_url("index.php/main/designpage?page_ID=$page_ID"));
                // redirect to desing page of newly created page.
            }
        } else {
            echo "Unauthentication";
        }
    }
/*
 * this function create new module
 */
    function createModule() {
        $user_ID = $this->session->userdata('user_ID');
        if (isset($user_ID)) {                                  // check if user logged in
            $modulename = $this->input->post('pagename');
            $description = $this->input->post('description');
            $this->form_validation->set_rules('pagename', 'Page name', 'required');
            // set form validation. page name should required
            if ($this->form_validation->run() == FALSE) {           // if validation false
                $data['page_title'] = 'Create new module';
                $this->load->view('template/bootstrap/header.php', $data);
                $this->load->view('misc/createmodule.php', $data);
                $this->load->view('template/bootstrap/footer.php');
            } else {                                                // if validation true
                $user_ID = $this->session->userdata('user_ID');
                $this->load->model('page_model');
                $this->page_model->createNewModule($modulename, $description, $user_ID);
                // create new module and get page id by return value
                header("location:" . base_url("index.php/main/designmodule?module_ID=$modulename"));
                // redirect to desing page of newly created page.
            }
        } else {
            echo "Unauthentication";
        }
    }
/*
 * this function delete page
 */
    function deletePage() {
        $user_ID = $this->session->userdata('user_ID');
        if (isset($user_ID)) {                            // check if user logged in  
            $page_ID = $this->input->get('page_ID');
            $this->load->model('page_model');
            $this->page_model->deletePage($page_ID);    // delete page by page id
            header("location:" . base_url("index.php/main/homepage"));
        } else {                                        // user not logged in
            echo "Unauthentication";
        }
    }
    /*
 * this function delete module
 */
    function deleteModule() {
        $user_ID = $this->session->userdata('user_ID');
        if (isset($user_ID)) {                            // check if user logged in  
            $madule_ID = $this->input->get('module_name');
            $this->load->model('page_model');
            $this->page_model->deleteModule($madule_ID);    // delete module by page id
            header("location:" . base_url("index.php/main/homepage"));
        } else {                                        // user not logged in
            echo "Unauthentication";
        }
    }

}

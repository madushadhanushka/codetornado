<?php

// This controller hanlde all request comming from desing page and home page

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    /*
     *  load required libraries
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');             // load all library needed
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        //$this->load->database('coder');
    }

    /*
     *  show home page 
     */
    public function homePage() {
        $user_ID = $this->session->userdata('user_ID');
        if (isset($user_ID)) {                              // check used is alread logged. else show error
            $this->load->model('main_model');               // load main model
            // get all page created by the user by using main_model
            $this->load->model('main_model');
            $this->load->model('page_model');

            // this code will check if update button pressed and if it is pressed then change the index page
            // of the application
            if (isset($_POST['index_page'])) {
                $this->main_model->setIndexPage($_POST['index_page']);
            }
            // get index page of the site
            $data['index_page'] = $this->page_model->getIndexPage();

            // get user information from session
            $data['username'] = $this->session->userdata('username');
            $data['user_ID'] = $this->session->userdata('user_ID');

            // get list of all pages available
            $data['page_detail'] = $this->main_model->getAllPages($data['user_ID']);

            // get all available module list
            $data['module_detail'] = $this->main_model->getAllModule();

            // show data on home page
            $data['page_title'] = "Home page";
            $this->load->view('template/header.php', $data);
            $this->load->view('template/navigation.php', $data);
            $this->load->view('design/homepage.php', $data);
            $this->load->view('template/footer.php');
        } else {
            echo "Unauthenticaton";         // user not have authentication
        }
    }

    /*
     *  this will show desing page
     */
    public function designPage() {
        $user_ID = $this->session->userdata('user_ID');
        if (isset($user_ID)) {                              // ckeck user already logged
            // get page id from the request by get method
            $data['page_ID'] = $this->input->get('page_ID');
            //load page data from xml file and database
            $this->load->model('main_model');
            $data['page_detail'] = $this->main_model->getPage($data['page_ID']);
            $data['all_module_detail'] = $this->main_model->getAllModuleXML();

            if ($data['page_detail'] != false) {                            // if page found then show
                $data['username'] = $this->session->userdata('username');

                $data['page_title'] = "Design Page";
                $this->load->view('template/header.php', $data);
                $this->load->view('design/designpage.php', $data);
                $this->load->view('template/footer.php');
            } else {
                echo "Page not found";                              // if page not found show error
            }
        }
    }

/*
 *  this function save page data into xml file
 */
    public function savePage() {
        $user_ID = $this->session->userdata('user_ID');
        if (isset($user_ID)) {
            // get xml data from jason message
            $xml = $this->input->get('xml');
            // get page id of saving page
            $page_ID = $this->input->get('page_ID');
            // use main model and save data in xml file
            $this->load->model('main_model');
            $this->main_model->savePage($xml, $page_ID);
            echo json_encode(array('1'));                           // return success 1
        } else {
            echo json_encode(array('2'));                           // return success 1   
        }
    }

    /*
     * json request to save module
     * this function save xml data into the module and send response as json message
     */
    public function saveModule() {
        $user_ID = $this->session->userdata('user_ID');
        if (isset($user_ID)) {
            // get xml data from jason message
            $xml = $this->input->get('xml');
            // get module id of saving module
            $module_ID = $this->input->get('module_ID');
            // use main model and save data in xml file
            $this->load->model('main_model');
            $this->main_model->saveModule($xml, $module_ID);
            echo json_encode(array('1'));           // return success 1
        } else {
            echo json_encode(array('2'));       // return false 2
        }
    }
/*
 * design module controller
 * this function view module design page
 */
    public function designModule() {
        $user_ID = $this->session->userdata('user_ID');
        if (isset($user_ID)) {
            // get page id from the request by get method
            $data['module_ID'] = $this->input->get('module_ID');
            //load page data from xml file and database
            $this->load->model('main_model');
            $data['module_detail'] = $this->main_model->getModule($data['module_ID']);
            $data['all_module_detail'] = $this->main_model->getAllModuleXML();

            if ($data['module_detail'] != false) {              // if module is found then show it
                $data['username'] = $this->session->userdata('username');

                $data['page_title'] = "Design Module";
                $this->load->view('template/header.php', $data);
                $this->load->view('design/designpage.php', $data);
                $this->load->view('template/footer.php');
            } else {
                echo "Module not fount";                    // if module not found show error
            }
        } else {
            echo "Unauthenticatoin";                        // show error if user not already logged
        }
    }

}

?>

<?php

/*
 * This model provide functionalities to work with web design page requests
 */

class main_model extends CI_Model {

    // get all pages from the db
    public function getAllPages($user_id) {

        $q = $this->db->query("SELECT * FROM ct_page where user_ID=$user_id");
        if ($q->num_rows() > 0) {    // check any record exist
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    // get a list of all module available in data/module/ folder
    public function getAllModule() {
        $file = scandir('data/module', SCANDIR_SORT_DESCENDING);
        for ($i = 0; $i < count($file) - 2; $i++) {
            $module_xml = fopen("data/module/" . $file[$i], "r") or die();          // open module file to write data
            // read whole file
            $xml_string = fread($module_xml, filesize("data/module/" . $file[$i]));
            $xml_data = simplexml_load_string($xml_string);                         // convert xml into xml object
            $all_module[$i] = $xml_data->detail;                                    // get detail from the xml
        }
        return $all_module;
    }

    // get all xml detail of all module from data/module/ folder
    public function getAllModuleXML() {
        $file = scandir('data/module', SCANDIR_SORT_DESCENDING);
        for ($i = 0; $i < count($file) - 2; $i++) {
            $module_xml = fopen("data/module/" . $file[$i], "r") or die();
            $xml_string = fread($module_xml, filesize("data/module/" . $file[$i]));
            $all_module[$i] = $xml_string;
        }
        return $all_module;
    }

    // get some specific data from page_id
    public function getPage($page_id) {
        $q = $this->db->query("SELECT * FROM ct_page where page_ID=$page_id");
        if ($q->num_rows() > 0) {    // check any record exist
            foreach ($q->result() as $row) {
                // put data to return variable
                $data['page_data'][] = $row;
            }
            // check if file exist in data/page/<page_id>.xml
            // this file contail all current save desing of the page
            if (file_exists("data/page/$page_id.xml")) {
                // open new file connection
                $page_xml = fopen("data/page/$page_id.xml", "r") or die();
                // read data to a file
                $xml_string = fread($page_xml, filesize("data/page/$page_id.xml"));

                // remove all free space from file
                $data['page_xml'] = trim(preg_replace('/\s\s+/', ' ', $xml_string));
                // close file connection
                fclose($page_xml);
            }

            return $data;
        } else {
            return false;
        }
    }

    /*
     * read whole module and retun xml file as string
     */

    public function getModule($module_id) {
        $module_php = fopen("data/module/" . $module_id . ".xml", "r") or die();
        $xml_string = fread($module_php, filesize("data/module/" . $module_id . ".xml"));
        return $xml_string;
    }

    // this function save current data in to the relevent file
    public function savePage($xml, $page_id) {
        // open file conneciton
        $page_xml = fopen("data/page/$page_id.xml", "w") or die();
        // repalce all mulitple spaces with single space
        $string = trim(preg_replace('/\s\s+/', ' ', $xml));


        // write data to file and close it.
        fwrite($page_xml, $string);
        fclose($page_xml);
    }

    /*
     * save module data into the file
     * 
     * @param $xml
     */

    public function saveModule($xml, $module_id) {
        // open file conneciton
        $module_xml = fopen("data/module/$module_id.xml", "w") or die();
        // repalce all mulitple spaces with single space
        $string = trim(preg_replace('/\s\s+/', ' ', $xml));


        // write data to file and close it.
        fwrite($module_xml, $string);
        fclose($module_xml);
    }

    /*
     * this function create new page and return id of the created page
     * 
     */

    public function createNewPage($pagename, $description, $user_ID) {
        $q = $this->db->query("insert into ct_page(page_ID,name,description,user_ID) values(null,'$pagename','$description',$user_ID)");
        $q = $this->db->query("select page_ID from ct_page");
        if ($q->num_rows() > 0) {    // check any record exist
            foreach ($q->result() as $row) {
                $data = $row->page_ID;
            }
            return $data;
        }
    }

    /*
     * set index page of the application
     */

    public function setIndexPage($page_ID) {
        $q = $this->db->query("update ct_misc set value=$page_ID where keyVal='indexpage'");
    }

}
?>


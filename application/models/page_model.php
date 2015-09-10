<?php

/*
 * thi model contain funcions that need to handle pages including preview page, create page and delete page
 */

class page_model extends CI_Model {

    // get all pages from the db
    public function getPreviewPage($page_id) {

        $this->load->model('main_model');
        $xmlDocStr = $this->main_model->getPage($page_id);
        //echo $xmlDocStr;
        $xmlDoc = simplexml_load_string($xmlDocStr['page_xml']) or die("Error: Cannot create object");
        $pageData['title'] = $xmlDoc->detail->title;                // put title value into $pageData['title']
        $pageData['control'] = $xmlDoc->control;                    // put controller value into $pageData['control']
        $html_string = $xmlDocStr['page_xml'];
        $html_string = preg_replace("#(.*)<view>(.*?)</view>(.*)#is", '$2', $html_string);
        // remove <view> tag from html document

        $pageData['html'] = preg_replace('/<parsererror\b[^>]*>(.*?)<\/parsererror>/is', "", $html_string);
        // if javascript parsererror occur then filter error.

        return $pageData;
    }

    /*
     * save page in application/views/design/preview.php before it preview
     */

    public function setPreviewPage($page_html) {

        $page_php = fopen("application/views/design/preview.php", "w") or die();
        // open file to write

        $page_html = str_replace("--", "", str_replace("!--", "", $page_html));
        // write data to file and close it.

        fwrite($page_php, $page_html);
        fclose($page_php);
    }

    /*
     * get index page id from the database
     */

    public function getIndexPage() {
        $q = $this->db->query("SELECT * FROM ct_misc where keyVal='indexpage'");
        if ($q->num_rows() > 0) {    // check any record exist
            foreach ($q->result() as $row) {
                // put data to return variable
                return $row->value;
            }
            return false;
        }
    }

    /*
     *  create new page by adding value into database and xml file. it return created page id
     */

    public function createNewPage($pagename, $description, $user_ID) {
        $query = "insert into ct_page(page_ID,name,description,user_ID) values(null,'$pagename','$description',$user_ID)";
        echo $query;
        $q = $this->db->query($query);              // execute query
        $q = $this->db->query("SELECT * FROM ct_page");
        if ($q->num_rows() > 0) {    // check any record exist
            $current_ID = 0;
            foreach ($q->result() as $row) {
                // put data to return variable
                $current_ID = $row->page_ID;
            }
            $page_php = fopen("data/page/$current_ID.xml", "w") or die();
            // create new file in data folder to save page

            $txt = "<module><detail><name>$pagename</name><description>$description</description></detail><view> </view><control> </control></module>";
            // default text save in xml file
            
            fwrite($page_php, $txt);
            fclose($page_php);

            return $current_ID;
        }
    }

    /*
     *  create new module
     */

    public function createNewModule($pagename, $description, $user_ID) {
        $page_php = fopen("data/module/$pagename.xml", "w") or die();
        // open new file to create new file

        $txt = "<module><detail><name>$pagename</name><description>$description</description></detail><view> </view><control> </control></module>";
        // default text save in xml file

        fwrite($page_php, $txt);
        fclose($page_php);
    }

    /*
     *  set data on file to quick preview page.
     */

    public function setTempPreviewPage($page_html, $page_ID) {
        $page_php = fopen("data/temp/" . $page_ID . ".php", "w") or die();
        // open file in temp and write canvas html into that file
        fwrite($page_php, $page_html);
        fclose($page_php);
    }

    /*
     *  set data on file to quick preview module.
     */

    public function getTempPreviewPage($page_ID) {
        if (file_exists("data/temp/$page_ID.php")) {
            $page_php = fopen("data/temp/$page_ID.php", "r") or die();
            $html_string = fread($page_php, filesize("data/temp/$page_ID.php"));
            fclose($page_php);
        } else {
            $html_string = "";
        }
        return $html_string;
    }

    /*
     * delete page by page id
     */

    public function deletePage($page_ID) {
        $q = $this->db->query("delete from ct_page where page_ID=$page_ID");
        unlink("data/page/$page_ID.xml");               // delete xml file in data/page folder
    }

    /*
     * delete module by module name
     */

    public function deleteModule($module_ID) {
        unlink("data/module/$module_ID.xml");       // delete xml file from data/modules
    }

}

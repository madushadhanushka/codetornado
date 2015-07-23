<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class main_model extends CI_Model {

    public function getAllPages($user_id) {
        $q = $this->db->query("SELECT * FROM ct_page");
        if ($q->num_rows() > 0) {    // check any record exist
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getPage($page_id) {
        $q = $this->db->query("SELECT * FROM ct_page where page_ID=$page_id");
        if ($q->num_rows() > 0) {    // check any record exist
            foreach ($q->result() as $row) {
                $data['page_data'][] = $row;
            }

            if (file_exists("data/page/$page_id.xml")) {
                $page_xml = fopen("data/page/$page_id.xml", "r") or die();
                $xml_string=fread($page_xml, filesize("data/page/$page_id.xml"));
                $data['page_xml'] = trim(preg_replace('/\s\s+/', ' ', $xml_string));
                fclose($page_xml);
            }

            return $data;
        } else {
            return false;
        }
    }
    public function savePage($xml,$page_id){
        $page_xml = fopen("data/page/$page_id.xml", "w") or die();
        $string = trim(preg_replace('/\s\s+/', ' ', $xml));
        fwrite($page_xml, $string);
        fclose($page_xml);
    }

}
?>


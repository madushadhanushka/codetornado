<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class main_model extends CI_Model{
    public function getAllPages($user_id){
        $q = $this->db->query("SELECT * FROM ct_page");
        if ($q->num_rows() > 0) {    // check any record exist
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
}
?>


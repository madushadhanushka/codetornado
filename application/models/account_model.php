<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of account_model
 *
 * @author User
 */
class account_model  extends CI_Model{
    public function loginUser($username,$password) {
        $q = $this->db->query("SELECT * FROM  ct_user_account where username='$username' and password=password('$password')");
        //print_r("SELECT * FROM  ct_user_account where username='$username' and password=password('$password')");
        if ($q->num_rows() > 0) {    // check any record exist
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            $retData['username']=$data[0]->username;
            $retData['user_ID']=$data[0]->user_ID;
            return $retData;
        }
		return false;
    }
}

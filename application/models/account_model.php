<?php

/*
 * This model is used to login and validate user
 */

/**
 * Description of account_model
 *
 * @author User
 */
class account_model  extends CI_Model{
    
    // this will check user with database data and if there is registered user then return
    // his data or otherwise it return false
    
    public function loginUser($username,$password) {
        // get data from querey
        $q = $this->db->query("SELECT * FROM  ct_user_account where username='$username' and password=password('$password')");
        //print_r("SELECT * FROM  ct_user_account where username='$username' and password=password('$password')");
        
        if ($q->num_rows() > 0) {    // check any record exist
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            // set data to return variable
            $retData['username']=$data[0]->username;
            $retData['user_ID']=$data[0]->user_ID;
            return $retData;
        }
		return false;
    }
    /*
     * get list of all available users
     */
    public function getAllAccount(){
        // get accounts from querey
        $q = $this->db->query("SELECT * FROM  ct_user_account");
        
        if ($q->num_rows() > 0) {    // check any record exist
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            // set data to return variable
            return $data;
        }
    }
    
    /*
     * create new account by username and password
     */
    public function createAccount($username,$password) {
        $q = $this->db->query("insert into ct_user_account(user_ID,username,password) values(null,'$username',password('$password'));");
    }
    
    /*
     * delete user by using user id
     */
    public function deleteUser($user_ID) {
        $q = $this->db->query("delete from ct_user_account where user_ID=$user_ID");
    }
    
    /*
     * this function update all user information.
     */
    public function updateUser($user_ID,$username,$password) {
        $q = $this->db->query("update ct_user_account set username='$username',password=password('$password') where user_ID=$user_ID");
    }
}

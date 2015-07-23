<?php

class TestCase extends CIPHPUnitTestCase
{
	public function setUp()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('account_model');
        $this->account = $this->CI->account_model;
    }

    public function testUserLogin1()
    {
        
        $user_ID = $this->account->loginUser("test","test");      
        $this->assertEquals(1, $user_ID['user_ID']);
   
    }
	public function testUserLogin2(){
		$user_ID = $this->account->loginUser("test","test22");
		$this->assertEquals(false, $user_ID['user_ID']);
	}
}

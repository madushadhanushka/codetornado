<?php

class TestCase extends CIPHPUnitTestCase
{
	public function setUp()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('account_model');
		$this->CI->load->model('main_model');
		$this->CI->load->model('page_model');
        $this->account_model = $this->CI->account_model;
		$this->main_model = $this->CI->main_model;
		$this->page_model = $this->CI->page_model;
		
		$con=mysql_connect("localhost","root","");
		mysql_select_db("codetornado",$con);
    }

    public function testUserLogin1()
    {
        
        $user_ID = $this->account_model->loginUser("test","test");      
        $this->assertEquals(1, $user_ID['user_ID']);
   
    }
	public function testUserLogin2(){
		$user_ID = $this->account_model->loginUser("test","test22");
		$this->assertEquals(false, $user_ID['user_ID']);
	}
	public function testGetAllPages(){
		$pages = $this->main_model->getAllPages(1);
		$this->assertEquals(1,$pages[0]->page_ID);
	}
	public function testGetAllModuless(){
		$modules = $this->main_model->getAllModule();
		$this->assertEquals(true,isset($modules));
	}
	public function testGetPage(){
		$page = $this->main_model->getPage(1);
		$this->assertEquals("homepage",$page['page_data'][0]->name);
	}
	
	public function testCreateNewPage(){
		$page_ID = $this->page_model->createNewPage("testcase", "testcase", 0);

		$res=mysql_query($con,"select * from ct_page where page_ID = $page_ID");
		//echo "test case 1";
		while($row=mysql_fetch_array($res)){
			$this->assertEquals("testcase",$row['name']);
		}
		 $this->page_model->deletePage($page_ID);
		
	}

	
	public function testgetIndexPage(){
		$oldindexpage=$this->page_model->getIndexPage();
		$this->main_model->setIndexPage(2);
		$indexpage=$this->page_model->getIndexPage();
		$this->assertEquals(2,$indexpage);
		$this->main_model->setIndexPage($oldindexpage);
		$indexpage=$this->page_model->getIndexPage();
		$this->assertEquals($oldindexpage,$indexpage);
	}
	public function testCreateNewModule(){
		$this->page_model->createNewModule("testmodule", "testmodule", 0);
		$this->assertEquals(true,file_exists("data/module/testmodule.xml"));
		$this->page_model->deleteModule("testmodule");
		$this->assertEquals(false,file_exists("data/module/testmodule.xml"));
	}
	
}

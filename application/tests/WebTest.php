<?php
class WebTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://www.example.com/');
    }

    public function testTitle()
    {
		
        $this->url('http://localhost/uni/abc/CodeIgniter-3.0.0/index.php/account/login');
		$form=$this->byCssSelector('form');
		$this->byName('username')->value("test");
		$this->byName('password')->value("test");
		$form->submit();
        $this->assertEquals('CodeTornado Home page', $this->title());
		$this->byID('add_new_page')->click();
		$this->assertEquals('Create new page', $this->title());
		$this->byName('pagename')->value("test");
		$this->byName('description')->value("test");
		//$this->byID('create_page')->click();
		//$this->assertEquals('CodeTornado Design Page', $this->title());
    }
	public function testHomepage(){
		 $this->url('http://localhost/uni/abc/CodeIgniter-3.0.0/index.php/account/login');
		$form=$this->byCssSelector('form');
		$this->byName('username')->value("test");
		$this->byName('password')->value("test");
		$form->submit();
		$this->byID('home_link')->click();
		$this->assertEquals('CodeTornado Home page', $this->title());
		$this->byID('home_account')->click();
		$this->assertEquals('CodeTornado Accounts', $this->title());
	}

}
?>
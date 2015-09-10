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
        $this->url('http://google.lk');
		$this->byID('lst-ib')->value("hello");
        $this->assertEquals('Example WWW Page', $this->title());
    }

}
?>
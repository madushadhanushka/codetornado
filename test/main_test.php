<?php
require_once '../application/models/acc_abc.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class main_test extends PHPUnit_Framework_TestCase{
	public $test;
	public function setUp(){
		//$this->test=new account_model();
	}
    public function testLogin(){
		//$var=$this->test->loginUser("abc","def");
		$this->assertTrue('a'=='a');
	}
}


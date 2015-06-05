<?php
namespace Daft\test;

class DictionaryTest extends \PHPUnit_Framework_TestCase
{
	
	function testDict() {
		
		$client = new \Daft\DaftClient();
		
		$dict = new \Daft\Dictionary($client);
		
		$term = $dict->getTerm('wilton');
		
		$this->assertEquals($term['id'], 3668);
		$this->assertEquals($term['type'], 'area');
		
		$term = $dict->getTerm('carlow');
		
		print_r($term);
	}
	
}




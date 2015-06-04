<?php
require_once('bootstrap.php');

class SearchTest extends PHPUnit_Framework_TestCase
{
	
    function testCleanStr() {
		
		$str = '  2 bed appartment to let   dublin';
		$cleanedStr = \Daft\Search::cleanStr($str);
		
		$this->assertEquals('2 bed appartment to let dublin', $cleanedStr);
	}

	function testParse() {
		
		$str = 'Carlow 3 bedroom for sale 10000';
		$search = new \Daft\Search($str);
		
		$search->parse($str);
		
		var_dump($search);
		
	}
}
<?php
namespace Daft\test;

class QueryParserTest extends \PHPUnit_Framework_TestCase
{
	
    function testTokenize() {
		$str = '  2 bed appartment to let   dublin';
		$tokens = \Daft\QueryParser::tokenize($str);
		$this->assertEquals(6, count($tokens));
	}

	function testParse() {
		
		$client = new \Daft\DaftClient();
		$dict = new \Daft\Dictionary($client);
		
		$str = 'Carlow 3 bedrooms for sale 10000 Abbeylara';
		$parser = new \Daft\QueryParser($dict);
		
		$parser->parse($str);
		
		$params = $parser->getParams();
		
		$this->assertEquals(3, $params['bedrooms']);
	}
	
}
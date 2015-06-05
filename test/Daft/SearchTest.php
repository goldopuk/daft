<?php
namespace Daft\test;

class SearchTest extends \PHPUnit_Framework_TestCase
{
	protected $client;
	protected $parser;
	
	function setUp() {
		$this->client = new \Daft\DaftClient();
		$dict = new \Daft\Dictionary($this->client);
		$this->parser = new \Daft\QueryParser($dict);
	}
	
	function testSearch1() {
		$str = '5 bed rent';
		$this->parser->parse($str);
		$result = $this->client->search($this->parser->getSearchType(), $this->parser->getParams());
	}

	function testSearch2() {
		$str = 'Dublin 1 to 5 bedrooms for sale';
		$this->parser->parse($str);
		$result = $this->client->search($this->parser->getSearchType(), $this->parser->getParams());
	}
	
	function testSearch3() {
		$str = '2 bed apartment to let Dublin';
		$this->parser->parse($str);
		$result = $this->client->search($this->parser->getSearchType(), $this->parser->getParams());
	}
	
	function testSearch4() {
		$str = '3 or 4 bed house to rent in Dundrum for 1000 per month';
		$this->parser->parse($str);
		$result = $this->client->search($this->parser->getSearchType(), $this->parser->getParams());
	}
	
}

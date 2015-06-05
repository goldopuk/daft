<?php
namespace Daft\test;

class DaftClientTest extends \PHPUnit_Framework_TestCase
{
	protected $client;
	
	function setUp() {
		$this->client = new \Daft\DaftClient();
	}
	
	function testAreas() {
		$areas = $this->client->getAreas();
		$this->assertTrue(count($areas) > 100);
	}
	
	function testCounties() {
		$counties = $this->client->getCounties();
		$this->assertTrue(count($counties) > 30);
	}
	
	function testSearchSale() {
		$result = $this->client->search('search_sale', ['bedrooms' => 2, 'counties' => [1]]);
		
		$pagination = $result->pagination;
		$this->assertTrue($pagination->total_results > 0);
	}
	
}

<?php
namespace Daft;

class DaftClient {
	
	protected $client;
	
	protected $cache = [];	
	
	function __construct() {
		$this->client = new \SoapClient("http://api.daft.ie/v2/wsdl.xml");
		$this->apiKey = "5fac8f1674c0c6a335ecefe2b092c05d02a2b6e5";
	}
	
	function getCachePath($key) {
		return ROOT_PATH . "/cache/$key.cache";
	}
	
	function setCache($key, $value) {
		$path = $this->getCachePath($key);
		file_put_contents($path, json_encode($value));
	}
	
	function hasCache($key) {
		$path = $this->getCachePath($key);
		return file_exists($path);
	}
	
	function getCache($key) {
		$path = $this->getCachePath($key);
		return file_exists($path) ? json_decode(file_get_contents($path), false) : null;
	}
	
	function search($method, array $params) {
		
		jlog("searching $method " . json_encode($params));
		
		$response = $this->request($method, ['query' => $params]);
		
		jlog($response->results->pagination->total_results . " ads found...\n");
		
		return $response->results;
	}
	
	protected function request($method, array $params) {
		$params['api_key'] = $this->apiKey;
		return $this->client->$method($params);
	}
	
	function getAreas() {
		
		if ($this->hasCache('area')) {
			return $this->getCache('area');
		}
		
		$params = ['area_type' => 'area'];
		$result = $this->request('areas', $params);
		
		$this->setCache('area', $result->areas);
		
		return $result->areas;
	}
	
	function getCounties() {
		
		if ($this->hasCache('county')) {
			return $this->getCache('county');
		}
		
		$params = ['area_type' => 'county'];
		$result = $this->request('areas', $params);
		
		$this->setCache('county', $result->areas);
		
		return $result->areas;
	}
	
}

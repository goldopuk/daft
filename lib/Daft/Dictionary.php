<?php
namespace Daft;

class Dictionary
 {	
	public $dict = array();
	
	public function __construct(DaftClient $daftClient) {
		$this->daftClient = $daftClient;
		
		$this->buildDict();
	}
	
	public function buildDict() {
		
		$areas = $this->daftClient->getAreas();
		
		foreach ($areas as $area) {
			$name = strtolower($area->name);
			
			$this->dict[$name] = array (
					'id' => $area->id,
					'type' => 'area'
			);
		}
		
		$counties = $this->daftClient->getCounties();
		
		foreach ($counties as $county) {
			$name = str_replace("Co. ", "", $county->name);
			$name = strtolower($name);
				
			$this->dict[$name] = array (
					'id' => $county->id,
					'type' => 'county'
			);
		}
		
		$lines = file(ROOT_PATH . '/config/terms.txt');
		
		foreach ($lines as $line) {
			$line = str_replace ("\n", "", $line);
			$tokens = explode (" ", $line);
			$this->dict[$tokens[0]] = array (
					'type' => $tokens[1] 
			);
		}
	}
	
	public function getTerm($term) {
		return isset($this->dict[$term]) ? $this->dict[$term] : null;
	}
	
}

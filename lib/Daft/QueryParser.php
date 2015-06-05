<?php
namespace Daft;

class QueryParser {
	
	protected $searchType;
	protected $searchParams = [];
	protected $searchStr;
	
	function __construct($dict) {
		$this->dict = $dict;
	}
	
	function getSearchType() {
		return $this->searchType;
	}
	
	function getParams() {
		return $this->searchParams;
	}
	
 	static public function tokenize($str) {
		$str = strtolower(trim(preg_replace('/\s+/', ' ', $str)));
		return explode(' ', $str);
	}
	
	function reset() {
		$this->searchType = NULL;
		$this->searchParams = [];
		$this->searchStr = NULL;
	}
	
	function parse($str) {
		$this->reset();
		
		$this->searchStr = $str;
		
		$tokens = self::tokenize($this->searchStr);

		$this->findSearchType($tokens);
		$this->findAreas($tokens);
		$this->findCounties($tokens);
		$this->findPrices($tokens);
		$this->findBedroomNumber($tokens);
	}
	
	function findSearchType($tokens) {
		
		$searchType  = false;
		
		while ($tokens) {
			
			$token = array_pop($tokens);
			
			$term = $this->dict->getTerm($token);
			
			if ( ! $term) {
				continue;
			}
				
			if ($term['type'] === 'rent') {
				$this->searchType = 'search_rental';
			} else if ($term['type'] === 'sale') {
				$this->searchType = 'search_sale';
			} // else continue
		}
		
	}
	
	function findAreas($tokens) {
		
		$foundAreas = [];
		
		foreach ($tokens as $token) {
			
			$term = $this->dict->getTerm($token);

			if ( ! $term) {
				continue;
			}
			
			if ($term['type'] === 'area') {
				$foundAreas[] = $term['id'];
			}
		}
		
		if ($foundAreas) {
			$this->searchParams['areas'] = $foundAreas;
		}
	}
	
	function findCounties($tokens) {
		
		$foundCounties = [];
		
		foreach ($tokens as $token) {

			$term = $this->dict->getTerm($token);

			if ( ! $term) {
				continue;
			}
			
			if ($term['type'] === 'county') {
				$foundCounties[] = $term['id'];
			}
		}
		
		if ($foundCounties) {
			$this->searchParams['counties'] = $foundCounties;
		}
	}
	
	function findPrices($tokens) {
		
		// assume that a number above 100 is a price
		
		$prices = array_filter($tokens, function ($token) {
			return preg_match('/^\d+$/', $token) && $token > 100;
		});
		
		if (count($prices) >= 2) {
			$this->searchParams['min_price'] = min($prices);
			$this->searchParams['max_price'] = max($prices);
		} elseif (count($prices) === 1) {
			$price = array_pop($prices);
			$this->searchParams['min_price'] = $price - (10 * $price / 100);
			$this->searchParams['max_price'] = $price + (10 * $price / 100); 
		}
		
	}
	
	function findBedroomNumber($tokens) {
		
		// assume that a number under 10 is a bed number
		// this is very simplistic... but that's all for now

		$beds = array_filter($tokens, function ($token) {
			return preg_match('/^\d+$/', $token) && $token < 10;
		});
		
		if (count($beds) >= 2) {
			$this->searchParams['min_bedrooms'] = min($beds);
			$this->searchParams['max_bedrooms'] = max($beds);
		} else if (count($beds) === 1) {
			$this->searchParams['bedrooms'] = array_pop($beds);
		}		
	}
}
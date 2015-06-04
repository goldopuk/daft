<?
namespace Daft;

class Search {
	
	protected $searchType;
	protected $areas;
	protected $price;
	protected $bedroomNumber;
	
	protected $searchStr;
	
	function __construct($searchStr) {
		$this->searchStr = $searchStr; 
	}
	
 	static public function cleanStr($str) {
		return trim(preg_replace('/\s+/', ' ', $str));
	}
	
	function parse($str) {
		$str = self::cleanStr($str);
		
		$tokens = explode(' ', $str);
		
		$this->searchType = $this->findSearchType($tokens);
		
		$this->areas = $this->findAreas($tokens);
		
		$this->price = $this->findPrice($tokens);
		
		$this->bedroomNumber = $this->findBedroomNumber($tokens);
	}
	
	function findSearchType($tokens) {
		
		$rentKeywords = ['rent', 'rental', 'let', 'letting'];
		$saleKeywords = ['sale', 'sales', 'buy'];
		
		$searchType  = false;
		
		while ( ! $searchType && $tokens) {
			
			$token = array_pop($tokens);
			
			if (in_array($token, $rentKeywords)) {
				$searchType = 'rent';
			} else if (in_array($token, $saleKeywords)) {
				$searchType = 'sale';
			} // else continue
		}
		
		return $searchType;
	}
	
	function findAreas($tokens) {
		
		$areas = ['Antrim', 'Armagh', 'Carlow', 'Cavan', 'Clare', 'Cork', 'Derry', 'Donegal', 'Down', 
		'Dublin', 'Fermanagh', 'Galway', 'Kerry', 'Kildare', 'Kilkenny', 'Laois', 'Leitrim', 
		'Limerick', 'Longford', 'Louth', 'Mayo', 'Meath', 'Monaghan', 'Offaly', 
		'Roscommon', 'Sligo', 'Tipperary', 'Tyrone', 'Waterford', 'Westmeath', 'Wexford', 'Wicklow'];
		
		$foundAreas = [];
		
		foreach ($tokens as $token) {
			if (in_array($token, $areas)) {
				$foundAreas[] = $token;
			}
		}
		
		return $foundAreas;
	}
	
	function findPrice($tokens) {
		
		// assume that a number above 100 is a price
		
		$prices = array_filter($tokens, function ($token) {
			return preg_match('/^\d+$/', $token) && $token > 100;
		});
		
		$minMax = $prices ? ['min' => min($prices), 'max' => max($prices)] : false;
		
		return $minMax;
	}
	
	function findBedroomNumber($tokens) {
		
		// assume that a number under 10 is a bed number

		$beds = array_filter($tokens, function ($token) {
			return preg_match('/^\d+$/', $token) && $token < 10;
		});
		
		$minMax = $beds ? ['min' => min($beds), 'max' => max($beds)] : false;

		return $minMax;
	}
}
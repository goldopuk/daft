<?
$rootDir = realpath(dirname(__FILE__));

define('ROOT_PATH', $rootDir);

require_once("$rootDir/lib/Daft/QueryParser.php");
require_once("$rootDir/lib/Daft/DaftClient.php");
require_once("$rootDir/lib/Daft/Dictionary.php");

function jlog($str) {
	$file = ROOT_PATH . '/log/log';
	$str = "$str\n";
	file_put_contents($file, $str, FILE_APPEND);
}
<?
require_once('../bootstrap.php');

$fieldsToShow = ['ad_id', 'county', 'city', 'bedrooms', 'property_type', 'price'];

$str = '';

if (isset($_GET['terms'])) {
	
	$client = new \Daft\DaftClient();
	$dict = new \Daft\Dictionary($client);
	$parser = new \Daft\QueryParser($dict);
	
	$str = $_GET['terms'];
	$parser->parse($str);
	
	$result = $client->search($parser->getSearchType(), $parser->getParams());

	$ads = $result->pagination->total_results ? $result->ads : [];
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../favicon.ico">

	<title>Daft</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	
  </head>

  <body>
	<div class="container">

		<div class="starter-template">
			<h1>Daft Search Engine</h1>
		</div>
		<div>
			<form method="GET">
				<input type="search" placeholder="search" name="terms" value="<?= $str ?>">
				<input type="submit" value="search">
				
			</form>
		</div>
		<? $first = true; ?>
		
		<? if (isset($result)): ?>
			<div>Total Result: <?= $result->pagination->total_results ?></div>
			<div>Search Sentence: <?= $result->search_sentence ?></div>
		<? endif; ?>
		
		<? if (isset($ads)): ?>
			<table class="table table-bordered">
			<? foreach ($ads as $ad): ?>
				<? if ($first): ?>
					<tr>
						<? foreach ($ad as $field => $value): ?>
							<? if (in_array($field, $fieldsToShow)): ?>
								<td><?= $field ?></td>
							<? endif ?>
						<? endforeach ?>
					</tr>
					<? $first = false; ?>
				<? endif;?>
			
				<tr>
					<? foreach ($ad as $field => $value): ?>
						<? if (in_array($field, $fieldsToShow)):?>
							<td><?= $value ?></td>
						<? endif ?>
					<? endforeach ?>
				</tr>
			<? endforeach ?>
			</table>
		<? endif ?>

	</div><!-- /.container -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  </body>
</html>

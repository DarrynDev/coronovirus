<?php 
header("Access-Control-Allow-Origin: *");                                                                            
header('Content-Type: application/json');
error_reporting(E_ERROR | E_PARSE);
$time_start = microtime(true);

$All = [];

$link       = 'https://www.worldometers.info/coronavirus/';
$jsonData   = file_get_contents($link);

//echo $jsonData;

$dom = new DOMDocument;
$dom->loadHTML($jsonData);

$tables = $dom->getElementById('main_table_countries_today');
$tr     = $tables->getElementsByTagName('tr'); 

foreach ($tr as $element1) {        
    for ($i = 0; $i < count($element1); $i++) {

	if($element1->getElementsByTagName('td')->item(0)->textContent < 1)
	{
		continue;
	}

        //Not able to fetch the user's link :(
        $country       = $element1->getElementsByTagName('td')->item(1)->textContent;                  
        $total_cases   = $element1->getElementsByTagName('td')->item(2)->textContent;                 
        $new_cases     = $element1->getElementsByTagName('td')->item(3)->textContent;                  
        $total_deaths  = $element1->getElementsByTagName('td')->item(4)->textContent;                 
        $new_deaths    = $element1->getElementsByTagName('td')->item(5)->textContent;                  
	$total_recover = $element1->getElementsByTagName('td')->item(6)->textContent;                 

        array_push($All, array(
            "country"       => $country,
            "total_cases"   => $total_cases,
            "new_cases"     => $new_cases,
            "total_deaths"  => $total_deaths,
            "new_deaths"    => $new_deaths,
            "total_recover" => $total_recover
        ));
    }
}

$data = json_encode($All, JSON_PRETTY_PRINT);
?>

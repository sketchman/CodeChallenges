<?php


/*
 * Takes a filename and a regular expression
 * and uses the regex to parse the file into three
 * capture groups.
 * 
 * Returns the row with the least spread between
 * capture group 2 and 3
 */
function findSpread($filename, $regex) {

	//grab the data as a big chunk
	$data = file_get_contents($filename);

	//this regex statement matches this document only, grabs the first three columns
	preg_match_all($regex, $data, $out);

	$lowest = 99999;	//set a high number
	$lowest_index = '';
	$len = count($out[1]);

	//go through each row and find the lowest spread
	for ($i = 0; $i < $len; $i++) {

		$spread = abs($out[2][$i] - $out[3][$i]);

		if ($spread < $lowest) {
			$lowest = $spread;
			$lowest_index = $i;
		}

	}
	
	$ret = array(
		'title' => $out[1][$lowest_index],
		'value' => $lowest
	);
	
	return $ret;

}


/*
 * Weather Example
 */

//set the filanem
$filename = 'weather.dat';
//this regex statement matches this document only, grabs the first three columns
$regex = '/[\r\n]+\s+([0-9]+)\**\s+([0-9]+)\**\s+([0-9]+)/';

$o = findSpread($filename, $regex);

echo '<h3>Lowest Spread in a Day</h3>';
echo '<p>The lowest spread was on <strong>Day '.$o['title'].
		'</strong> with a spread of <strong>'.$o['value'].' degrees</strong></p>';



/*
 * football example
 */

//set the filanem
$filename = 'football.dat';
//this regex statement matches this document only, grabs the first three columns
$regex = '/(?:\s+[0-9]+[.]\s)+([a-zA-z]+)+(?:\s*[0-9]*\s*){4}([0-9]*)\s*[-]\s*([0-9]*)/';

$o = findSpread($filename, $regex);

echo '<h3>Lowest Spread in a Goals</h3>';
echo '<p>The lowest spread was by <strong>Team '.$o['title'].
		'</strong> with a spread of <strong>'.$o['value'].' points</strong></p>';


?>

<?php



//set the filanem
$filename = 'football.dat';

//grab the data as a big chunk
$data = file_get_contents($filename);

//this regex statement matches this document only, grabs the first three columns
preg_match_all('/(?:\s+[0-9]+[.]\s)+([a-zA-z]+)+(?:\s*[0-9]*\s*){4}([0-9]*)\s*[-]\s*([0-9]*)/', $data, $out);

echo "<pre>";
print_r($out);
echo "</pre>";

$lowest = 99;	//set a high number
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

echo '<h3>Lowest Spread in a Goals</h3>';
echo '<p>The lowest spread was by <strong>Team '.$out[1][$lowest_index].
		'</strong> with a spread of <strong>'.$lowest.' points</strong></p>';

?>

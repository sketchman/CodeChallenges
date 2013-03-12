<?php

/*
 * Challenge
 * 
 * Given an unsorted array, extract the max and min value 
 * using the least number of comparison.
 * 
 * 
 * Using a sort on the array would take too much time,
 * since worst case sort would be O(n^2) and best case
 * would yield O(nlogn). We're better off doing a linear
 * comparison at O(n).
 * 
 * We could cut the time and compare two numbers per pass
 * through the array, which would get us O(n/2) but that
 * really is just O(n) in reality. Also, adding IF statements
 * into the loop will actually cause more load since IF
 * statements are costly, so that would negate any benefit
 * from the n/2 potentially.
 * 
 */



/*
 * Looks for the min and max values
 * in an array, in the quickest time
 */
function miniMax($data) {
	
	//initialize min/max to save time
	$min = $data[0];
	$max = $data[0];
	$len = count($data);
	
	//O(n) search for minimax
	for ($i = 0; $i < $len; $i++) {

		if ($data[$i] < $min) {
			$min = $data[$i];
		} else if ($data[$i] > $max) {
			$max = $data[$i];
		}
	}
	
	return array('min' => $min, 'max' => $max);
}

echo "<h2>Find the min/max in a unsorted array</h2>";

$arr = array(
	4,
	5,
	1,
	0,
	678498,
	32,
	-10,
	4358,
	359012,
	-20,
	3,
	5,
	881273273
);

echo "<p>Looking in array: <br />";
print_r($arr);
echo "</p>";
$r = miniMax($arr);
echo "<p>Min: ".$r['min']."<br/>Max: ".$r['max']."</p>";

?>

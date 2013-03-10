<?php

/*
 * Challenge
 * 
 * Given an array of integers, A1, A2, ..., An, including negatives and 
 * positives, and another integer S. Now we need to find three different 
 * integers in the array, whose sum is the given integer S. 
 * If there exists more than one solution, any of them is ok.
 * 
 */

/*
 * Looks for which integers in an array sum to 
 * the requested sum.
 * 
 * $search must be integers either negative or positive
 * $sum must be a numeric value
 * 
 */
function findSuminArray($sum, $search) {
	
	//sort the array to make comparison easy
	sort($search);
	$len = count($search);
	
	//loop through each number
	for ($i = 0; $i < $len; $i++) {
		
		$j = $i+1;		//the next number
		$k = $len-1;	//the last number
		
		//make sure they don't intersect
		while ($k > $j) {
			
			//get the value of the three positions
			$val = $search[$i] + $search[$j] + $search[$k];
			
			if ($val == $sum) {
				return array($search[$i], $search[$j], $search[$k]);
			}
			
			if ($val > $sum) {
				//if too big, try a small number
				$k--;
			} else {
				//if too small, try a larger number
				$j++;
			}
		}
	}
	
	return NULL;
	
}

echo "<h2>Find a Sum in an array of values by adding 3 values</h2>";

$myVals = array(1,3,-2,87,3,0,12,3,-34,-1,-2,6,32,34,13,14,18,-4,-7,2);
$find = 0;
$values = findSuminArray($find, $myVals);

echo "<h3>Looking for sum $find.</h3>";
echo "<p><strong>Looking in:</strong> <br />";
echo "<pre>";
print_r($myVals);
echo "</pre>";
echo "</p>";

if ($values != NULL) {
	echo "<p><strong>Found in:</strong> <br />";
	echo "<pre>";
	print_r($values);
	echo "</pre>";
	echo "</p>";
} else {
	echo "<p>The sum cannot be made from the provided integers.</p>";
}

?>

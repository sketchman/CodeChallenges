<?php

/*
 * Challenge
 * 
 * Given an array of distinct integers, and a target integer t, compute 
 * all of the subsets of the array that sum to t, where order matters.
 * 
 */

/*
 * Looks for which integer sets in an array sum to 
 * the requested sum. Return all sets
 * 
 * $search must be unique integers either negative or positive
 * $sum must be a numeric value
 * 
 */
function findSetsinArray($sum, $search) {
	
	//sort the array to make comparison easy
	sort($search);
	$len = count($search);
	$values = array();
	
	//loop through each number
	for ($i = 0; $i < $len; $i++) {
		
		$j = $i+1;		//the next number
		$k = $len-1;	//the last number
		
		//make sure they don't intersect
		while ($k > $j) {
			
			//get the value of the three positions
			$val = $search[$i] + $search[$j] + $search[$k];
			
			if ($val == $sum) {
				$values[] = array($search[$i], $search[$j], $search[$k]);
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
	
	return $values;
	
}

echo "<h2>Find all 3 interger sets in an array that sum to value</h2>";

$myVals = array(1,3,-2,87,8,0,12,15,-34,-1,9,6,32,34,13,14,18,-4,-7,2);
$find = 0;
$values = findSetsinArray($find, $myVals);

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

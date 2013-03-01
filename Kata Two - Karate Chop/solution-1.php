<?php

/*
 * This solution solves the problem using dynamic programming.
 * We used recursion to approach this problem, halving our array
 * until we are down to two or fewer elements.
 */
function chopit ($searchInt, $arr) {
	
	$arr_size = count($arr);
	
	//make sure the array is not empty
	if (!is_array($arr) || $arr_size < 1) {
		return -1;
	}
	
	//make sure searchInt is valid
	if (!is_int($searchInt) || $searchInt < 0) {
		return -1;
	}
	
	//if there is only one entry or two entries
	if ($arr_size < 3) {
		//we are preserving the index so it might not be $arr[0]
		foreach ($arr as $index => $key) {
			if ($key == $searchInt) {
				return $index;
			}
		}
		
		return -1;
	}
	
	//now here is the magic
	if ($arr_size > 2) {

		//split the array by approx. median
		$mid_index = floor($arr_size / 2);

		if ($arr[$mid_index] === $searchInt) {
			return $mid_index;
			
		} else {
			
			if ($searchInt > $arr[$mid_index]) {
				//we need to go down the right side but exclude the $mid_index
				$arr_split = array_slice($arr, $mid_index + 1, NULL, TRUE);	//preserve the index
			} else {
				//we need to go down the left side
				$arr_split = array_slice($arr, 0, $mid_index, TRUE);	//preserve the index
			}
			
			//make this recursive
			return chopit($searchInt, $arr_split);
			
		}
	}
}

function chopit_print($find, $pos, $arr) {
	
	$result_val = chopit($find, $arr);
	$result_bool = $result_val == $pos ? 'True' : 'False';
	$result_style = $result_val == $pos ? '#CAF7BA' : '#F7BABA';
	
	echo "<p style='background-color: $result_style;'>";
	
	echo "Testing to find ($find)<br/> in: ";
	print_r($arr);
	echo "<br/>Position was ($result_val) but we thought ($pos)";
	echo "<br/>$result_bool";
	echo '</p>';
	
}

/*
 * Begin Testing with test data
 */


//first set
chopit_print(3, -1, array());	//True
chopit_print(3, -1, array(1));	//True
chopit_print(1, 0, array(1));	//True
echo "<hr />";
//second set
chopit_print(1, 0, array(1,3,5));	//True
chopit_print(3, 1, array(1,3,5));	//True
chopit_print(4, 2, array(1,3,5));	//False
chopit_print(0, -1, array(1,3,5));	//True
chopit_print(2, -1, array(1,3,5));	//True
chopit_print(4, -1, array(1,3,5));	//True
chopit_print(6, -1, array(1,3,5));	//True
echo "<hr/>";
//third set
chopit_print(1, 0, array(1,3,5,7));	//True
chopit_print(3, 1, array(1,3,5,7));	//True
chopit_print(5, 2, array(1,3,5,7));	//True
chopit_print(7, 3, array(1,3,5,7));	//True
chopit_print(0, -1, array(1,3,5,7));	//True
chopit_print(2, -1, array(1,3,5,7));	//True
chopit_print(4, -1, array(1,3,5,7));	//True
chopit_print(6, -1, array(1,3,5,7));	//True
chopit_print(8, -1, array(1,3,5,7));	//True


?>

<?php



function chop ($searchInt, $arr) {
	
	$arr_size = count($arr);
	
	//make sure the array is not empty
	if (!is_array($arr) || $arr_size < 1) {
		return -1;
	}
	
	//make sure searchInt is valid
	if (!is_int($searchInt) || $searchInt < 0) {
		return -1;
	}
	
	//if there is only one entry
	if ($arr_size === 1) {
		if ($arr[0] == $searchInt) {
			return 0;
		} else {
			return -1;
		}
	}
	
	//if there is only two entries
	if ($arr_size === 2) {
	
		if ($arr[0] === $searchInt) {
			return 0;
		} else if ($arr[1] === $searchInt) {
			return 1;
		} else {
			return -1;
		}
		
	}
	
	//now here is the magic
	if ($arr_size > 2) {
		
		//split the array and test
		$mid_value = $arr_size / 2;
		
		//we have even sides
		if (is_int($mid_value)) {
			
			if ($arr[$mid_value] === $searchInt) {
				return $mid_value;
			} else if ($searchInt > $arr[$mid_value]) {
				//we need to go down the right side
				$arr_left = array_slice($arr, $mid_value);
				
				//make this recursive
				return chop($searchInt, $arr_left);
				
			} else {
				//we need to go down the left side
				$arr_right = array_slice($arr, 0, $mid_value-1);
				
				//make this recursive
				return chop($searchInt, $arr_right);
			}
			
		} else {
			//we don't have even sides, so how do we do this?
			
			
			
		}
		
	}
	
	
}

/*
 * Begin Testing with test data
 */


	//first set
	echo chop(3, array()) === -1 ? 'True' : 'False';	//True
	echo chop(3, array(1)) === -1 ? 'True' : 'False';	//True
	echo chop(1, array(1)) === 0 ? 'True' : 'False';	//True
	//second set
	echo chop(1, array(1,3,5)) === 0 ? 'True' : 'False';	//True
	echo chop(3, array(1,3,5)) === 1 ? 'True' : 'False';	//True
	echo chop(4, array(1,3,5)) === 2 ? 'True' : 'False';	//True
	echo chop(0, array(1,3,5)) === -1 ? 'True' : 'False';	//True
	echo chop(2, array(1,3,5)) === -1 ? 'True' : 'False';	//True
	echo chop(4, array(1,3,5)) === -1 ? 'True' : 'False';	//True
	echo chop(6, array(1,3,5)) === -1 ? 'True' : 'False';	//True
	//third set
	echo chop(0, array(1,3,5,7)) === 0 ? 'True' : 'False';	//True
	echo chop(3, array(1,3,5,7)) === 1 ? 'True' : 'False';	//True
	echo chop(5, array(1,3,5,7)) === 2 ? 'True' : 'False';	//True
	echo chop(7, array(1,3,5,7)) === 3 ? 'True' : 'False';	//True
	echo chop(0, array(1,3,5,7)) === -1 ? 'True' : 'False';	//True
	echo chop(2, array(1,3,5,7)) === -1 ? 'True' : 'False';	//True
	echo chop(4, array(1,3,5,7)) === -1 ? 'True' : 'False';	//True
	echo chop(6, array(1,3,5,7)) === -1 ? 'True' : 'False';	//True
	echo chop(8, array(1,3,5,7)) === -1 ? 'True' : 'False';	//True


?>

<?php

/*
 * Challenge
 * 
 * write binary search on a shifted array i.e. (10 20 1 2 3 4)
 * 
 * Credit: http://blogs.msdn.com/b/bali_msft/archive/2009/02/03/search-
 * for-a-number-in-shifted-sort-array-within-o-log-n-time.aspx?Redirected=true
 * 
 */

/*
 * Takes an array and performs a recursive binary search
 * looking for the target.
 */
function myBinarySearch($arr, $target, $start = NULL, $end = NULL) {
	
	//initialize the $start and $end
	if ($start == NULL)	$start = 0;
	if ($end == NULL)	$end = count($arr) - 1;
	
	//unable to find, and no more to look
	if ($start == $end && $arr[$start] != $target) {
		return -1;
	}

	//grab the middle node
	$middle = (int)($start + ($end - $start) / 2);
	
	if ($target == $arr[$middle]) {
		//found the target
		return (int)$middle;
	} else if ($target > $arr[$middle]) {
		//continue on right half
		return myBinarySearch($arr, $target ,$middle + 1, $end);
	} else {
		//continue on left half
		return myBinarySearch($arr, $target, $start, $middle - 1);
	}
}

/*
 * Does a binary search but tries to determine which portion is shifted.
 * If the target is most likely in the non-shifted area, it goes down
 * that part, otherwise it continues to half the array until it finds
 * an unshifted portion that contains the target.
 * 
 * Requires the standard myBinarySearch function.
 */
function myShiftedBinarySearch($arr, $target, $start = NULL, $end = NULL) {
	
	//initialize the $start and $end
	if ($start == NULL)	$start = 0;
	if ($end == NULL)	$end = count($arr) - 1;
	
	//unable to find, and no more to look
	if ($start == $end && $arr[$start] != $target) {
		return -1;
	}

	//grab the middle node
	$middle = (int)($start + ($end - $start) / 2);

	if ($target == $arr[$middle]) {
		//found the target
		return (int)$middle;
	} else if ($arr[$middle] < $arr[$start]) {
		//we know the right half is not shifted
		if (($target > $arr[$middle]) && ($target <= $arr[$end])) {
			//target should be im right half
			return myBinarySearch($arr, $target, $middle + 1, $end);
		} else {
			//target could be in left half, but might be shifted still
			return myShiftedBinarySearch($arr, $target, $start, $middle-1);
		}
	} else {
		//we know the left half is not shifted
		if(($target >= $arr[$start]) && ($target < $arr[$middle])) {
			//target could be in left half
			return myBinarySearch($arr, $target, $start, $middle - 1);
		} else {
			//target could be in right half, but might be shifted still
			return myShiftedBinarySearch($arr, $target, $middle + 1, $end);
		}
	}
	
}

echo "<h2>Binary Search on Shifted Array</h2>";

$arr = array(6,7,8,9,10,11,12,1,2,3,4,5);

//Positive cases
$t = 3;
echo "<p>Looking for $t and found in position ".
		myShiftedBinarySearch($arr, $t)."</p>";
$t = 8;
echo "<p>Looking for $t and found in position ".
		myShiftedBinarySearch($arr, $t)."</p>";

//Negative cases
$t = 0;
echo "<p>Looking for $t and found in position ".
		myShiftedBinarySearch($arr, $t)."</p>";
$t = 13;
echo "<p>Looking for $t and found in position ".
		myShiftedBinarySearch($arr, $t)."</p>";

//Boundary cases
$t = 6;
echo "<p>Looking for $t and found in position ".
		myShiftedBinarySearch($arr, $t)."</p>";
$t = 5;
echo "<p>Looking for $t and found in position ".
		myShiftedBinarySearch($arr, $t)."</p>";


?>

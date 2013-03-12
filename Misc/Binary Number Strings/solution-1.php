<?php

/*
 * Challenge
 * 
 * Add two binary numbers represented as strings. 
 * 
 */

/*
 *		Binary Addition Example:
 * 
 *		1+0 = 1
 *		0+0 = 0
 *		1+1 = 10
 *		1+1+1 = 11
 * 
 *		0111
 *		1110
 *		----
 *		   1
 *		  01 (carry 1)
 *		 101 (carry 1)
 *	   11000
 */



/*
 * This method converts the string binary values
 * into decimal, adds them then turns the sum back
 * into a binary value.
 */
function binaryStringAdd($str1, $str2) {
	
	//convert to decimal
	$str1 = intval($str1, 2);
	$str2 = intval($str2, 2);
	//convert back to binary
	$ans = decbin($str1 + $str2);
	
	return $ans;
	
}

/*
 * This method takes the string binary values
 * and does actual binary addition to return
 * the binary sum
 */
function binaryStringAddPure($str1, $str2) {
	
	$len1 = strlen($str1);
	$len2 = strlen($str2);
	$ans = '';
	$carry = NULL;
	
	//make the two the same # digits
	if ($len1 > $len2) {
		$add = $len1 - $len2;
		while ($add > 0) {
			$str2 = '0'.$str2;
			$add--;
		}
		$len2 = strlen($str2);
	} else if ($len1 < $len2) {
		$add = $len2 - $len1;
		while ($add > 0) {
			$str1 = '0'.$str1;
			$add--;
		}
		$len1 = strlen($str1);
	}
	
	//begin addition
	for ($i = $len1-1; $i >= 0; $i--) {
		
		//both 1: 1+1 = 10
		if ($str1[$i] & $str2[$i]) {
			//handle the previous carried bit
			if ($carry) {
				$ans = '1'.$ans;
			} else {
				$ans = '0'.$ans;
			}
			$carry = 1;		//continue carry
		//1 and 0: 1+0 = 1
		} else if ($str1[$i] | $str2[$i]) {
			//handle the previous carried bit
			if ($carry) {
				$carry = 1;		//continue carry
				$ans = '0'.$ans;
			} else {
				$ans = '1'.$ans;
			}
		//both 0: 0+0 = 0
		} else if ($str1[$i] ^ $str2[$i]) {
			//handle the previous carried bit
			if ($carry) {
				$ans = '1'.$ans;
				$carry = NULL;
			} else {
				$ans = '0'.$ans;
			}
		//shouldn't happen (here for debug)
		} else {
			die('Uncaught Exception: please fix this 
				as it should never happen');
		}
	}
	
	//handle if any carries left
	if ($carry) {
		$ans = '1'.$ans;
	}
	
	return $ans;
	
}


echo "<h2>Add Two Binary Numbers</h2>";

$binary_num1 = '1001';
$binary_num2 = '1100';
$ans = binaryStringAdd($binary_num1, $binary_num2);
echo "<p><strong>Method 1: </strong>Adding $binary_num1 and $binary_num2 = $ans</p>";
$ans = binaryStringAddPure($binary_num1, $binary_num2);
echo "<p><strong>Method 2: </strong>Adding $binary_num1 and $binary_num2 = $ans</p>";
echo "<hr />";

$binary_num1 = '1001';
$binary_num2 = '1101010';
$ans = binaryStringAdd($binary_num1, $binary_num2);
echo "<p><strong>Method 1: </strong>Adding $binary_num1 and $binary_num2 = $ans</p>";
$ans = binaryStringAddPure($binary_num1, $binary_num2);
echo "<p><strong>Method 2: </strong>Adding $binary_num1 and $binary_num2 = $ans</p>";
echo "<hr />";

$binary_num1 = '1101010';
$binary_num2 = '1001';
$ans = binaryStringAdd($binary_num1, $binary_num2);
echo "<p><strong>Method 1: </strong>Adding $binary_num1 and $binary_num2 = $ans</p>";
$ans = binaryStringAddPure($binary_num1, $binary_num2);
echo "<p><strong>Method 2: </strong>Adding $binary_num1 and $binary_num2 = $ans</p>";
echo "<hr />";

$binary_num1 = '1111111111';
$binary_num2 = '100111';
$ans = binaryStringAdd($binary_num1, $binary_num2);
echo "<p><strong>Method 1: </strong>Adding $binary_num1 and $binary_num2 = $ans</p>";
$ans = binaryStringAddPure($binary_num1, $binary_num2);
echo "<p><strong>Method 2: </strong>Adding $binary_num1 and $binary_num2 = $ans</p>";
echo "<hr />";

?>

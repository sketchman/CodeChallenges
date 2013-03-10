<?php

/*
 * Palindromes
 * Solution 1
 * 
 * Problem:
 * Given a string, return true if it's a palindrome. Only alphanumeric 
 * characters considered. Do this in one pass through the string.
 */


/*
 * Method 1
 * 
 * Tests for Palindrome by comparing the first and last character to see if 
 * they match.
 * 
 * This method takes O(n) time, where n is the length of the word being checked.
 */
function testPalindrome($word){

	$word = strtolower($word);	//make the word lower for compare
	$len = strlen($word);
	$i = 0;
	$j = $len - 1;

	while ($i < $j) {
		//make sure the char is alphanumeric
		if (!ctype_alnum($word[$i])) { $i++; continue; }
		if (!ctype_alnum($word[$j])) { $j--; continue; }

		if ($word[$i] != $word[$j]) return false;
		
		$i++;
		$j--;
	}
	
	return true;
}

/*
 * Method 2
 * 
 * Tests for Palindrome by reversing the string and comparing the original to 
 * the reversed version.
 * 
 * This method requires allocating more memory for a duplicate of the original 
 * string.
 */
function testPalindromeFlip($word) {
	
	$word = strtolower($word);	//make the word lowercase for compare
	$word = preg_replace('/[^a-z0-9]/', '', $word); //only alphanumeric chars
	$word_rev = strrev($word);
	
	if ($word_rev == $word) {
		return true;
	} else {
		return false;
	}
}



$data = array(
	'A but tuba.',
	'A car, a man, a maraca.',
	'A dog, a plan, a canal: pagoda.',
	'A dog! A panic in a pagoda!',
	'A lad named E. Mandala',
	'A man, a plan, a canal: Panama.',
	'A man, a plan, a cat, a ham, a yak, a yam, a hat, a canal-Panama!',
	'A new order began, a more Roman age bred Rowena.',
	'A nut for a jar of tuna.',
	'A Santa at Nasa.',
	'aibohphobia',
	'alula',
	'cammac',
	'c[]i-=vic',
	'deifi=e-d',
	'deleve***led',
	'detar^&$#@#trated',
	'devov)(ed',
	'dewed',
	'evitative',
	'Hannah',
	'kayak',
	'kinnikinnik',
	'lemel',
	'level',
	'madam',
	'Malayalam',
	'minim',
	'Not a Palindrome'
);

echo '<h2>Test for Palindrome</h2>';

foreach ($data as $word) {
	echo "<h3>Word is: $word</h3>";
	$time_start = microtime(true);	//debug
	echo "<p>Method 1 test: <strong>".(testPalindrome($word) ? 'Yes' : 'No')."</strong>";
	$time_end = microtime(true);
	$time = number_format($time_end - $time_start, 10);
	echo "<br />It took $time seconds to do this!</p>";
	
	$time_start = microtime(true);	//debug
	echo "<p>Method 2 test: <strong>".(testPalindromeFlip($word) ? 'Yes' : 'No')."</strong>";
	$time_end = microtime(true);
	$time2 = number_format($time_end - $time_start, 10);
	echo "<br />It took $time2 seconds to do this!</p>";
	
	if ($time > $time2) {
		echo "Method 2 is faster than Method 1";
	} else {
		echo "Method 1 is faster than Method 2";
	}
	
	echo "<hr />";
}


?>

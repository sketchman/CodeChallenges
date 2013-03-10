<?php

/*
 * Palindromes
 * Solution 2
 * 
 * Problem:
 * Find the longest Palindrome in a given string that may contain
 * multiple palindromes.
 */


/*
 * Searches through the string character by character, looking for
 * potential palindroms, once found compares the palindrome with
 * the previous once and returns the largest.
 * 
 * This function runs at O(n) to go character by character to find
 * a potential palindrom. It must also fully create the found palindrom,
 * running again potentially for n, where n is the length of the string.
 * Because of this, the total run time is O(n^2) worst-case, with best-case
 * being O(n*m) where m is the total length of the found palindromes.
 * 
 */
function longestPalindrome($str) {
	
	$str = strtolower($str);	//lowercase for easy compare
	$str = preg_replace('/[^a-z0-9]/', '', $str); //only alphanumeric chars
	$len = strlen($str);
	$longest = '';	//store only the longest
	$current = '';	//store the current
	$palis = array();

	for ($i = 0; $i < $len; $i++) {
		
		$current = '';
		$prev = $i-1;
		$next = $i+1;
		$found = false;
		
		//make sure previous and next are within string
		if ($prev >= 0 && $next < $len) {
			
			//odd length palindrome
			if ($str[$prev] == $str[$next]) {
				//begin the string with $i
				$current = $str[$i];
				$found = true;
				
			//even length palindrome
			} else if ($str[$i] == $str[$next]) {
				//begin the string with $i and $i + 1
				$current = $str[$i].$str[$next];
				$found = true;
				$next++;
			}
			
			//continue looking at palindrome
			if ($found){
				while ($prev >= 0 && $next < $len) {
					//store the outer two chars
					if ($str[$prev] == $str[$next]) {
						$current = $str[$prev].$current.$str[$next];
					} else {
						break;	//the palindrome is done
					}
					
					$prev--;
					$next++;
				}
			}
		}
		
		//store longest so far
		$cur_len = strlen($current);
		if ($cur_len > 1 && $cur_len > strlen($longest)) {
			$palis[] = $current;
			$longest = $current;
		}
	}
	
	return $longest;
}


$string = 'Fourscoreandsevenyearsagoourfaathersbroughtforthonthisconta
inentanewnationconceivedinzLibertyanddedicatedtotheproposit
ionthatallmenarecreatedequalNowweareengagedinagreahtcivilwa
rtestingwhetherthatnaptionoranynartionsoconceivedandsodedic
atedcanlongendureWeareqmetonagreatbattlefiemldoftzhatwarWeh
avecometodedicpateaportionofthatfieldasafinalrestingplacefo
rthosewhoheregavetheirlivesthatthatnationmightliveItisaltog
etherfangandproperthatweshoulddothisButinalargersensewecann
otdedicatewecannotconsecratewecannothallowthisgroundThebrav
elmenlivinganddeadwhostruggledherehaveconsecrateditfarabove
ourpoorponwertoaddordetractTgheworldadswfilllittlenotlenorl
ongrememberwhatwesayherebutitcanneverforgetwhattheydidhereI
tisforusthelivingrathertobededicatedheretotheulnfinishedwor
kwhichtheywhofoughtherehavethusfarsonoblyadvancedItisrather
forustobeherededicatedtothegreattdafskremainingbeforeusthat
fromthesehonoreddeadwetakeincreaseddevotiontothatcauseforwh
ichtheygavethelastpfullmeasureofdevotionthatweherehighlyres
olvethatthesedeadshallnothavediedinvainthatthisnationunsder
Godshallhaveanewbirthoffreedomandthatgovernmentofthepeopleb
ythepeopleforthepeopleshallnotperishfromtheearth';

echo '<h2>Find the Longest Palindrome in a String</h2>';
echo "<h3>String is: $string</h3>";
echo "Longest Palindrome: ".  longestPalindrome($string);



?>

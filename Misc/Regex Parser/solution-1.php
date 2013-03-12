<?php

/*
 * Write a function in language of your choice that takes in two strings, and 
 * returns true if they match. Constraints are as follows: String 1, the text 
 * to match to, will be alphabets and digits. String 2, the pattern, will be 
 * alphabets, digits, '.' and '*'. '.' means either alphabet or digit will be 
 * considered as a "match". "*" means the previous character is repeat 0 or 
 * more # of times.
 * 
 * For example:
 *	Text: Facebook
 *	Pattern: F.cebo*k
 *	returns true 
 * 
 */


/*
 * Takes a string and a matching string
 * and determines if the string matches
 * the match string.
 * 
 * Assumes alphanumeric characters only
 * Allows . character for wildcard char
 * Allows * for 0 or more repeating char
 */
function stringMatch($str, $match) {
    
	//. can be replaced with alphanumeric
	//* the char will be repeated 0 or more

	$len = strlen($match);
	$j = strlen($str) - 1;    //pos in str
	
	//the odd case where you find .* in $match
	$odd_case = false;

	//go line by line through the match string
	for ($i = $len-1; $i >= 0; $i--) {
		
        //repeating match
        if ($match[$i] == '*') {
            //grab the next char
            $char_match = $match[$i-1];
            $rpt_match = true;
            
			//loop through matches
			while ($rpt_match) {
				//what if ".*"
				if ($char_match == '.') {
					$char_match = $str[$j];
					$j--;
					$odd_case = true;
				} else if ($char_match != $str[$j]) {
					//if no match, then end loop
					$rpt_match = false;
					$i = $i - 2;	//move match string past the "c*"
				} else {
					$j--;	//move str down a letter
				}
			}
		
		} else if ($match[$i] != '.') {
			//dealing with standard 1-1 match
			if (!isset($str[$j]) || $match[$i] != $str[$j]) {
				
				if ($odd_case) {
					if (!isset($str[$j+1]) || $match[$i] != $str[$j+1]) {
						return false;
					} else {
						$odd_case = false;	//continue pattern matching
					}
				} else {
					return false;
				}
			}
		}
		
		$j--;
	}

	return true;
}


echo "<h2>Testing word Match</h2>";
$match = 'F.cebo*k';

$string = 'Facebook';
echo "<p>Testing if '$string' matches '$match'</p><p>";
echo stringMatch($string, $match) ? 'MATCH</p>' : 'NO MATCH</p>';
echo "<hr />";

$string = 'Facebooooooooook';
echo "<p>Testing if '$string' matches '$match'</p><p>";
echo stringMatch($string, $match) ? 'MATCH</p>' : 'NO MATCH</p>';
echo "<hr />";

$string = 'Facebk';
echo "<p>Testing if '$string' matches '$match'</p><p>";
echo stringMatch($string, $match) == true ? 'MATCH</p>' : 'NO MATCH</p>';
echo "<hr />";

$string = 'a';
echo "<p>Testing if '$string' matches '$match'</p><p>";
echo stringMatch($string, $match) == true ? 'MATCH</p>' : 'NO MATCH</p>';
echo "<hr />";



$match = 'F.ceb.*k';

$string = 'Facebook';
echo "<p>Testing if '$string' matches '$match'</p><p>";
echo stringMatch($string, $match) ? 'MATCH</p>' : 'NO MATCH</p>';
echo "<hr />";

$string = 'Facebooooooooook';
echo "<p>Testing if '$string' matches '$match'</p><p>";
echo stringMatch($string, $match) ? 'MATCH</p>' : 'NO MATCH</p>';
echo "<hr />";

$string = 'Fcebk';
echo "<p>Testing if '$string' matches '$match'</p><p>";
echo stringMatch($string, $match) == true ? 'MATCH</p>' : 'NO MATCH</p>';
echo "<hr />";

$string = 'a';
echo "<p>Testing if '$string' matches '$match'</p><p>";
echo stringMatch($string, $match) == true ? 'MATCH</p>' : 'NO MATCH</p>';
echo "<hr />";




?>

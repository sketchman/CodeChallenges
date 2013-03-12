<?php

/*
 * Below are some basic math problems solved 
 * by functions rather than native operators
 */


/*
 * Find the square root recursively
 */
function mySqrRoot($num, $prev = 1.0) {
	
	if ($num == 0 || $num < 0) {
		return 0;
	}
	
	$precision = .000000001;			//how precise we want our answer
	$next = ($prev + $num / $prev) / 2;	//the next number to divide
	
	//keep going until we get enough precision
    if (abs($next-$prev) < $precision * $next)
        return $next;
    
	return mySqrRoot($num, $next);
	
}

/*
 * Divide two numbers and returns the
 * integer value, doesn't do any error
 * checking!
 */
function myDivide($num1, $num2) {
	
	$r = 0;
	
	while ($num1 >= $num2) {
		$r++;
		$num1 -= $num2;
	}
	
	return $r;
	
}


echo "<h2>Test Square Root</h2>";
$val = 52;
echo "<p>Native sqrt($val): ".sqrt($val);
echo "<br/>Our mySqrRoot($val): ".  mySqrRoot($val)."</p>";
$val = 19874;
echo "<p>Native sqrt($val): ".sqrt($val);
echo "<br/>Our mySqrRoot($val): ".  mySqrRoot($val)."</p>";
$val = 8;
echo "<p>Native sqrt($val): ".sqrt($val);
echo "<br/>Our mySqrRoot($val): ".  mySqrRoot($val)."</p>";
$val = 1246;
echo "<p>Native sqrt($val): ".sqrt($val);
echo "<br/>Our mySqrRoot($val): ".  mySqrRoot($val)."</p>";
$val = 16;
echo "<p>Native sqrt($val): ".sqrt($val);
echo "<br/>Our mySqrRoot($val): ".  mySqrRoot($val)."</p>";
$val = 0;
echo "<p>Native sqrt($val): ".sqrt($val);
echo "<br/>Our mySqrRoot($val): ".  mySqrRoot($val)."</p>";
$val = -5;
echo "<p>Native sqrt($val): ".sqrt($val);
echo "<br/>Our mySqrRoot($val): ".  mySqrRoot($val)."</p>";


echo "<h2>Test Division</h2>";

$n = 11.0;
$d = 2.0;
$ans = myDivide($n, $d);
echo "<p>Native $n/$d: ".($n/$d);
echo "<br/>Our myDivide($n, $d): ".$ans."</p>";

?>

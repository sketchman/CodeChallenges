<?php

/*
 * Challenge
 * 
 * Given a file containing one word per line, print out all the 
 * combinations of words that are anagrams; each line in the 
 * output contains all the words from the input that are anagrams 
 * of each other. 
 * 
 * This method uses Prime numbers to get unique multipliers
 * rather than a brute force technique of sorting each word
 * and comparing.
 */

Class Anagrams {

	private $dict;
	private $dict_val;
	private $ana_list;
	private $char_map = array(
		"e" => 2, "t" => 3, "a" => 5, "o" => 7, "i" => 11,
		"n" => 13, "s" => 17, "h" => 19, "r" => 23, "d" => 29,
		"l" => 31, "c" => 37, "u" => 41, "m" => 43, "w" => 47,
		"f" => 53, "g" => 59, "y" => 61, "p" => 67, "b" => 71,
		"v" => 73, "k" => 79, "j" => 83, "x" => 89, "q" => 97,
		"z" => 101);
	
	public function __construct($filename = NULL) {
		
		if ($filename === NULL) {
			
			//test mode
			$this->dict = array('kinship', 'pinkish', 
				'enlist', 'inlets', 'listen', 'silent',
				'boaster', 'boaters', 'borates',
				'fresher', 'refresh', 'sinks', 'skins',
				'knits', 'stink', 'rots', 'sort');
		
		} else {
			//open the file and read line by line
			$file = fopen($filename, 'r');
			while (!feof($file)) {
				$this->dict[] = trim(fgets($file));
			}
		}
		
		$this->convertDict();
		
	}
	
	/* 
	 * Given a word, checks for all anagrams
	 * within the loaded dictionary
	 */
	public function findAnagrams($word) {
		
		//set to lowercase
		$word = strtolower($word);
		$word_val = $this->calcWordVal($word);
		
		if (isset($this->dict_val[$word_val])) {
			return $this->dict_val[$word_val];
		} else {
			return 'No Anagrams';
		}
		
		
	}
	
	/*
	 * Writes all the anagrams into a text file
	 * and returns stats on how many sets and words
	 * were anagrams
	 */
	public function writeAnagrams($filename) {
	
		$stats = array(
			'total_sets' => 0,
			'total_words' => 0
		);
		$output = '';
		$anagrams = array();
		$count = 0;
		
		foreach ($this->ana_list as $key => $val) {
			$anagrams[$count] = '';
			foreach ($this->dict_val[$key] as $i) {
				$output .= $i.' ';
				$anagrams[$count] .= $i.' ';
				$stats['total_words']++;
			}
			$output .= "\n";
			$stats['total_sets']++;
			$count++;
		}
		
		//write to file
		$h = fopen($filename, 'w') or die('Cannot open for writing: '.$filename); 
		fwrite($h, $output);
		
		return array('anagrams' => $anagrams, 'stats' => $stats);
		
	}
	
	/*
	 * Converts the dict to anagram values
	 * for easy comparision of potential anagrams
	 */
	private function convertDict() {
		
		$prev_word = '';
		
		foreach ($this->dict as $i) {
			
			//get rid of duplicate words in our sorted dict
			if (strtolower($i) == strtolower($prev_word)) {
				continue;
			}
			
			$word_val = $this->calcWordVal(strtolower($i));

			//if this word is an anagram
			if (isset($this->dict_val[$word_val])) {
				//add the word to our key chain
				$this->dict_val[$word_val][] = $i;
				$this->ana_list[$word_val] = true;	//add to our anagram list
			} else {
				//add new word val
				$this->dict_val[$word_val] = array($i);
			}
			
			//store the word for duplicate check
			$prev_word = $i;
			
		}
	}
	
	/*
	 * Calculates the anagram value of a word
	 */
	private function calcWordVal($word) {
		
		//set to lowercase
		$word = strtolower($word);
		$word_val = 1;
		
		//loop through $word and get total count
		for ($i = 0; $i < strlen($word); $i++) {
			//convert to prime number
			if (isset($this->char_map[$word[$i]])) {
				$word_val *= $this->char_map[$word[$i]];
			}
		}
		
		return strval($word_val);	//make it a string due to memory issues with ints
		
	}
	
	
}


//begin the program in test mode, using hard coded mini dict
/*
echo '<h2>Test Mode</h2>';
$string = 'rots';

$a = new Anagrams();
$anagrams = $a->findAnagrams($string);

echo "<p>Looking for anagrams for <strong>$string</strong></p>";
print_r($anagrams);
echo "<hr />";
*/

$time_start = microtime(true);	//debug

//begin the program pulling in a sorted dictionary file
echo '<h2>File Mode</h2>';
$filename = 'wordlist.txt';

$b = new Anagrams($filename);
$r = $b->writeAnagrams('output.txt');

//debug
$time_end = microtime(true);
$time = $time_end - $time_start;
echo "<p>It took $time seconds to do this!</p>";

echo "<h3>Dictionary Stats</h3>";

echo "<p>Total Sets: ".$r['stats']['total_sets'].
		"<br /> Total Words: ".$r['stats']['total_words']."</p>";

echo "<hr />";

echo '<pre>';
foreach ($r['anagrams'] as $i) {
	echo "$i <hr />";
}
echo '</pre>';

?>

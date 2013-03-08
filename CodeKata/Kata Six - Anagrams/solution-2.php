<?php

/*
 * Challenge
 * 
 * Given a file containing one word per line, print out all the 
 * combinations of words that are anagrams; each line in the 
 * output contains all the words from the input that are anagrams 
 * of each other. 
 * 
 * This method uses a method of going through each
 * word, sorting the letters, then going through the
 * entire dictionary comparing and finding duplicates
 * like in solution-1
 * 
 * The main difference in this version is instead of calculating
 * a numeric value for the word, we simply get a sorted version of
 * it and compare.
 * 
 * This solution is more efficient, since less calculations need
 * to be done on an individual word.
 */

Class AnagramsViaSort {

	private $dict;
	private $dict_val;
	private $ana_list;
	
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
		$word_sort = $this->sortWord($word);
		
		if (isset($this->dict_val[$word_sort])) {
			return $this->dict_val[$word_sort];
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
			
			$word_sort = $this->sortWord(strtolower($i));

			//if this word is an anagram
			if (isset($this->dict_val[$word_sort])) {
				//add the word to our key chain
				$this->dict_val[$word_sort][] = $i;
				$this->ana_list[$word_sort] = true;	//add to our anagram list
			} else {
				//add new word val
				$this->dict_val[$word_sort] = array($i);
			}
			
			//store the word for duplicate check
			$prev_word = $i;
			
		}
	}
	
	/*
	 * Takes a word and sorts each letter
	 * alphabetically
	 */
	private function sortWord($word) {
		
		//sort the string by chars
		$str_chars = str_split($word);
		sort($str_chars);
		
		return implode('', $str_chars);
		
	}
	
	
}


//begin the program in test mode, using hard coded mini dict
/*
echo '<h2>Test Mode</h2>';
$string = 'rots';

$a = new AnagramsViaSort();
$anagrams = $a->findAnagrams($string);

echo "<p>Looking for anagrams for <strong>$string</strong></p>";
print_r($anagrams);
echo "<hr />";
*/

$time_start = microtime(true);	//debug

//begin the program pulling in a sorted dictionary file
echo '<h2>File Mode</h2>';
$filename = 'wordlist.txt';

$b = new AnagramsViaSort($filename);
$r = $b->writeAnagrams('output2.txt');

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

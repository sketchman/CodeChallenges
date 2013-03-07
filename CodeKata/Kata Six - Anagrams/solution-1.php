<?php

/*
 * Challenge
 * 
 * Given a file containing one word per line, print out all the 
 * combinations of words that are anagrams; each line in the 
 * output contains all the words from the input that are anagrams 
 * of each other. 
 */

Class Anagrams {

	private $dict;
	private $dict_val;
	
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
	 * Converts the dict to anagram values
	 */
	public function convertDict() {
		
		foreach ($this->dict as $i) {
			
			$i = strtolower($i);
			
			$word_val = $this->calcWordVal($i);
		
			if (isset($this->dict_val[$word_val])) {
				//chain the word
				$this->dict_val[$word_val][] = $i;
			} else {
				//add new word val
				$this->dict_val[$word_val] = array($i);
			}
			
		}
	}
	
	/*
	 * Calculates the anagram value of a word
	 */
	function calcWordVal($word) {
		
		//set to lowercase
		$word = strtolower($word);
		$word_val = 1;
		
		//loop through $word and get total count
		for ($i = 0; $i < strlen($word); $i++) {
			//convert to ascii number
			$word_val *= ord($word[$i]) - 95;
		}
		
		return $word_val;
		
	}
	
	
	
}


	//
$string = 'rots';

for ($i = 0; $i < strlen($string); $i++) {
	echo $string[$i];
}

echo "<hr/>";

for ($i = 0; $i < strlen($string); $i++) {
	echo ord($string[$i]) - 95;
}

echo "<hr />";

$a = new Anagrams();

print_r($a->findAnagrams($string));


	
	
	


?>

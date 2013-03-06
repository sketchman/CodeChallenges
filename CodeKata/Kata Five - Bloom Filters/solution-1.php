<?php


/*
 * One big issue is that we want to store 
 * these as bits, not integers in an array.
 * PHP has no way to do this without using
 * the PECL extension BitSet or whatever
 * other extension that is out there.
 * 
 * This example creates a very large bloodlist file
 * since it isn't truly setting bit level data,
 * but rather an array of integer data. Which means,
 * this is very expensive in terms of memory, 
 * although very efficient in terms of time since
 * once we import the file, we're still doing standard
 * bloomlist lookups.
 * 
 * Credit to: https://code.google.com/p/php-bloom-filter
 * for the hash function and general idea
 */

class BloomFilter {

	public $field = array();
	public $len;

	function hash($key){
		return array(
			abs(hexdec(hash('crc32','m'.$key.'a'))%$this->len),
			abs(hexdec(hash('crc32','p'.$key.'b'))%$this->len),
			abs(hexdec(hash('crc32','t'.$key.'c'))%$this->len)
		);
	}

	function __construct($len){
		$this->len = $len;
	}

	//initializes the bloomlist from existing bloomlist file
	static function init($field){

		$package = unserialize($field);

		$bf = new self($package['psize']);
		$bf->field = $package['data'];
		return $bf;
	}
	
	//creates the data for the output file
	function package() {
		
		return serialize(array('psize' => $this->len, 'data' => $this->field));
		
	}

	//adds a word to the bloomlist
	function add($key){
		foreach ($this->hash($key) as $h) {
			$this->field[$h] = 1;
		}
	}

	//finds a word in the bloomlist
	function find($key){
		foreach ($this->hash($key) as $h) {

			if (!isset($this->field[$h]) || $this->field[$h] == 0) {
				return false;
			}
		}
		return true;
	}

	/**
	* Reports the false positive rate of the current bloom filter
	* @param  int $numItems number of items inserted in the bloom filter
	*/
	function falsePositiveRate($numItems){
			$k = count($this->hash('1'));
			return pow((1-pow((1-1/$this->len),$k*$numItems)),$k);
	}

}

/*
//initialize the bloom filter
$bf = new BloomFilter(1000000);

$f = fopen('wordlist.txt','r');
while (!feof($f)) {
	$bf->add(trim(fgets($f)));
}

//write the bit field to file for later use
file_put_contents('bloomlist.txt', $bf->package());
*/

//initialize the bloom filter from file
$bf = BloomFilter::init(file_get_contents('bloomlist.txt'));

//test some membership queries
$test_words = array('this','library','does','bloom','filters','in','php', 'falseaisfication', 'wordars', 'dontta', 'showwowow', 'uppppi');

foreach ($test_words as $word) {
	if ($bf->find($word)) {
		echo $word."\n";
	}
}

echo "<p>Size is ".$bf->len." but really (".count($bf->field).")</p>";
echo "<p>False Positive Rate: ". $bf->falsePositiveRate(235886);	//This is the size of our wordlist.txt


?>

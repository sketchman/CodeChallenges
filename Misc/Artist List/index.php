<?php

	
	/*
	 *	Name: ArtistList
	 *	Description: Opens a CSV styled file of artists per row
	 *		and determines which artist pairs are listed more
	 *		than 50 times, outputting the results to a file
	 *	Final Output: txt file on server
	 *	Requirements: Read/Write access to current directory and
	 *		input file 
	 */
	Class ArtistList {
	
		private $master_list;
		private $file_contents;
		private $pairs = array();
		private $final_pairs = array();
		private $final_pairs_str = '';
		
		function __construct($filename) {
			//Time: .0165 (faster than using str_get_csv, fastest way to read)
			$this->file_contents = file_get_contents($filename) or die ('Cannot open for reading: '.$filename);
			
			//make a master list as a multi dimensional array
			$tmplist = explode("\n", $this->file_contents);
			foreach ($tmplist as $i) {
				$this->master_list[] = explode(',', $i);
			}
			
		}
		
		/*
		 * Begins the process of finding the matches
		 * Loops through each row in the master_list
		 * and compares it to the other rows to find
		 * matching artists
		 */
		public function begin() {
			
			//create pairs of artists
			$this->create_pairs();
			
			//tally the total matches per pair
			$this->tally_matches();
			
			//do the final write to file
			$this->write_output();
		}
		
		/*
		 * Writes an output file with the final pairs
		 */
		private function write_output() {
			
			$filename = 'artist_lists_output.txt';
			
			$handle = fopen($filename, 'w') or die('Cannot open for writing: '.$filename); 
			fwrite($handle, $this->final_pairs_str);
		}
		
		/*
		 * Takes an array of matches and pairs them together
		 * in unique pairs
		 */
		private function create_pairs() {
			
			//get only the artists mentioned 50 times or more
			$dup_array = $this->artists_above_50();
			$total_dups = count($dup_array);

			//Now let's take the master array and remove everything but the duplicates
			foreach ($this->master_list as $key => $value) {
				$this->master_list[$key] = array_intersect($value, $dup_array);
			}
			
			//now create all the possible pairs of the duplicates
			$counter = 0;

			for ($i = 0; $i < $total_dups; $i++) {
				for ($j = $i+1; $j < $total_dups; $j++) {

					$values = array($dup_array[$i], $dup_array[$j]);

					$this->pairs[$counter] = array(
						'count' => 0,
						'match' => $values
					);
					$counter++;
				}
			}

		}
		
		/*
		 * Searches through an array of artists
		 * and returns the ones mentioned over
		 * 50 times
		 */
		private function artists_above_50() {
		
			//Make a master list as a single dimensional array
			$tmplist = explode(',', preg_replace('/(\r\n|[\r\n])/', ',', trim($this->file_contents)));
			
			//product the array of only the duplicates
			$duplicates_array = $this->array_not_unique($tmplist);
			
			//get a count for how many times each is duplicated
			$count_array = @array_count_values($duplicates_array);	//supress warning with blank entries
			
			$dup_array = array();

			//Find all duplicate artists that are mentioned 50 times or more
			foreach ($count_array as $key => $value) {
				if ($value >= 50) {
					$dup_array[] = $key;
				}
			}
			
			return $dup_array;
			
		}
		
		/*
		 * Tallies up how many times a pair of artists
		 * is mentioned within the master_list
		 * 
		 */
		private function tally_matches() {
			
			$total_dup_pairs = count($this->pairs);
			$current_artist = '';
			$past_artist = '';
			
			//let's sort master_list, check performance to see if this matters
			foreach($this->master_list as &$i) {
				asort($i, SORT_REGULAR);
			}
			unset($i);
			
			//loop through each pair, continue if 50 reached
			foreach ($this->pairs as $key => $j) {
				
				//if we've switch artists
				$current_artist = $j['match'][0];
				
				foreach ($this->master_list as $mkey => $x) {
				
					//we're done with past artist, we can remove from master_list
					if ($past_artist !== '' && $current_artist !== $past_artist) {
						$master_key = array_search($past_artist, $x);
						if ($master_key !== FALSE) {
							//optimization: cuts the future iterations greatly
							unset($this->master_list[$mkey][$master_key]);
						}
					}
					
					//use this instead of array_intersect for efficiency
					if (in_array($j['match'][0], $x) && in_array($j['match'][1], $x)) {
						//if a match was found
						$this->pairs[$key]['count']++;
					}
					
					//for performance, stop once we hit 50 matches (this elimantes many unneeded checks, almost halving it!)
					if ($this->pairs[$key]['count'] >= 50) {
						$this->final_pairs[] = $this->pairs[$key];	//only really needed for debug
						$this->final_pairs_str .= $this->pairs[$key]['match'][0].', '.$this->pairs[$key]['match'][1]."\n";
						break;
					}
					
					//if this array is empty, delete it so we don't traverse again
					if (empty($x)) {
						unset($this->master_list[$mkey]);
					}
					
				}
				
				$past_artist = $j['match'][0];

			}

		}
		
		/*
		 * Returns an array of values that are duplicates
		 * in the source array. Eliminates all non-duplicate
		 * values
		 */
		private function array_not_unique($raw_array) {
			
			$dupes = array();
			natcasesort($raw_array);
			reset($raw_array);

			$old_key = NULL;
			$old_value = NULL;

			foreach ($raw_array as $key => $value) {

				if ($value === NULL) {
					continue;
				}

				if (strcasecmp($old_value, $value) === 0) {
					$dupes[$old_key] = $old_value;
					$dupes[$key] = $value;
				}
				$old_value = $value;
				$old_key = $key;
			}

			return $dupes;	
			
		}
		
		//Pretty printing for debug purposes
		private function print_results($data) {
			echo '<h2>Total:'.count($data).'</h2>';
			echo '<pre>';
			print_r($data);
			echo '</pre>';
		}
		
		
	}

	//apd_set_pprof_trace(getcwd());	//debug (requires apd extension for PECL)
	
	$time_start = microtime(true);	//debug
	
	//Set the filename of the file we're using
	$filename = "Artist_lists_small.txt";
	
	//now let's begin
	$artists = new ArtistList($filename);
	$artists->begin();
	
	//debug
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	echo "It took $time seconds to do this!\n";

	
?>
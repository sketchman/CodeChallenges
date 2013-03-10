<?php

/*
 * A linked list is one of the basic data structures.
 * Here I will be implementing it within PHP.
 * 
 * Please note that there can me many more methods for the
 * main SList class but I chose only to implement a few
 * of the key ones.
 */



/*
 * Class SList
 * 
 * Contains a linked list of SListNodes
 */
Class SList {
	
	private $_head;
	private $_tail;
	private $size;
	
	public function __construct() {
		$this->_head = NULL;
		$this->_tail = NULL;
		$this->size = 0;
	}
	
	public function getSize() {
		return $this->size;
	}
	
	public function getFirstNode() {
		return $this->_head;
	}
	
	public function getLastNode() {
		return $this->_tail;
	}
	
	/*
	 * Look through the list until the item is
	 * found, then add the new node after it
	 */
	public function insertAfter($index, $item) {
		
		//requires a node, so find it
		if (!is_object($index)) {
			$index = $this->find($index);
		}
		
		//require a valid node
		if ($index == NULL) {
			return FALSE;
		}
		
		//insert the new node
		$node = new SListNode($item);
		$node->_next = $index->_next;
		
		//update the old node
		$index->_next = &$node;
		
		//if replaced node was head
		if ($this->_head == $index) {
			$this->_head = &$node;
		}
		
		$this->size++;
		
		return $index->_next;
	
	}
	
	
	/*
	 * Insets a new node at the beginning of
	 * the list
	 */
	public function insertFront($item) {
		
		$node = new SListNode($item);
		$node->_next($this->_head);	//old head pointer is now next
		
		//head is now this node
		$this->_head = &$node;
		
		//if no nodes in list
		if ($this->_tail == NULL) {
			$this->_tail = &$node;	//set new node as tail too
		}
		
		$this->size++;
		
		return $this->_head;
		
	}
	
	/*
	 * Inserts a new node at the last
	 * position in the list
	 */
	public function insertLast($item) {
		
		//create the node
		$node = new SListNode($item);
		$node->_next = NULL;
		
		if ($this->size > 0) {
			//point the old last to this node
			$this->_tail->_next = &$node;
		} else {
			$this->_head = &$node;
		}
		
		//set the tail to our new node
		$this->_tail = &$node;
		$this->size++;
		
		return $this->_tail;
	}
	
	/*
	 * Removes a node with the item
	 * specified
	 */
	public function remove($item) {
		
		$node = $this->_head;	//store the node with $item
		$prev_node = NULL;		//store the node that points to $item node
		
		while($node->item != $item) {
			//reached the end without finding
			if ($node->_next == NULL) {
				return FALSE;
			} else {
				$node = $node->_next; //move to the next node
				$prev_node = $node;	//the node that links to the next
			}
		}
		
		//if the first node is being deleted
		if ($this->_head == $node) {
			//we're removing the only node
			if ($this->size == 1) {
				$this->_tail = NULL;
			}
			//set head to the next node in line or NULL if none
			$this->_head = $node->_next;
			
		} else {
			//final node is being deleted
			if ($this->_tail == $node) {
				$this->_tail = $prev_node;
			}
			//previous node jumps over the deleted node
			$prev_node->_next = $node->_next;				
		}
		
		$this->size--;
		
		return $node;
		
	}
	
	/*
	 * Finds the node with the item
	 * specified and returns the actual
	 * node object
	 */
	public function find($item) {
		
		$current = $this->_head;
		
		while ($current->item != $item) {
			//keep looking for the node
			if ($current->_next == NULL) {
				return NULL;
			} else {
				$current = $current->_next;
			}
		}
		
		return $current;
		
	}
	
	/*
	 * Reverses the entire list
	 */
	public function reverseList() {
		
		//only do this if more than 1 node
		if ($this->_head != NULL && $this->size > 1) {
			
			unset($this->_tail);	//must unset to reset later
			$cur_node = $this->_head;
			$prev_node = NULL;
			
			while ($cur_node != NULL) {
				
				//store the next node to iterate to it next
				$next_node = $cur_node->_next;
				
				//set the current next backwards
				$cur_node->_next = $prev_node;
				
				//setup for next node
				$prev_node = $cur_node;
				$cur_node = $next_node;
				
			}
			
			//now fix the head and tail
			$this->_tail = $this->_head;
			$this->_head = $prev_node;
			
		}
	}
}

/*
 * Class SListNode
 * 
 * Contains the individual nodes that make up
 * the linked list.
 */
Class SListNode {
	
	public $item;
	public $_next;	//pointer to another SListNode
	
	public function __construct($data) {
		$this->item = $data;
		$this->_next = NULL;
	}
	
	public function get() {
		return $this->item;
	}
	
}


echo "<h2>Linked List Example in PHP</h2>";

$list = new SList();

$values = array(
	'Carnivore',
	'Herbivore',
	'Plant',
	'Sun'
);

foreach ($values as $i) {
	$list->insertLast($i);
}

$list_size = $list->getSize();


echo "<h3>List 1 has $list_size elements</h3>";
$node = $list->getFirstNode();
for ($i = 1; $i <= $list_size; $i++) {
	echo "<p><strong>Node $i</strong><br />";
	print_r($node->item);
	echo "</p>";
	$node = $node->_next;
}

echo "<hr />";

// Reverse the list;
$list->reverseList();


echo "<h3>Now Reserving List 1</h3>";

$node = $list->getFirstNode();
for ($i = 1; $i <= $list_size; $i++) {
	echo "<p><strong>Node $i</strong><br />";
	print_r($node->item);
	echo "</p>";
	$node = $node->_next;
}

echo "<hr />";

$list->insertAfter('Plant', 'Bug');
$list_size = $list->getSize();

echo "<h3>Now Adding Bug after Plant</h3>";

$node = $list->getFirstNode();
for ($i = 1; $i <= $list_size; $i++) {
	echo "<p><strong>Node $i</strong><br />";
	print_r($node->item);
	echo "</p>";
	$node = $node->_next;
}

echo "<hr />";


?>

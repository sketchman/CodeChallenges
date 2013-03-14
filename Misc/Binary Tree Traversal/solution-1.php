<?php

/*
 * Challenge
 * 
 * How the four main types of binary tree traversal.
 * Implement them in recursive and nonrecursive ways.
 */



class BinaryTree {

	public $_root;
	public $size;
	
	public function __construct($val) {
		$node = new BinaryTreeNode($val);
		$this->_root = &$node;
		$this->size = 1;
	}
	
	public function add($val) {
		$this->_root->insert($val);
		$this->size++;
	}
	
	public function printTree() {
		//$this->_root->printNode();
	}
	
}

class BinaryTreeNode {
	
	public $item;
	public $visited;
	public $_left;
	public $_right;
	
	public function __construct($val) {
		$this->item = $val;
		$this->_left = NULL;
		$this->_right = NULL;
		$this->visited = FALSE;
	}
	
	/*
	 * Recursively print the node and children
	 */
	public function printNode() {
	
		//this item
		//echo "		".$item;
		
		///children
		//echo "	/			\ ";
		//echo $this-;
		
	}
	
	
	/*
	 * Recursively adds a child node
	 */
	public function insert($val) {
		

		if ($val < $this->item) {
			if ($this->_left == NULL) {
				$node = new BinaryTreeNode($val);
				$this->_left = &$node;
				return $this->_left;
			} else {
				$this->_left->insert($val);
			}
		}
		
		
		if ($val > $this->item) {
			if ($this->_right == NULL) {
				$node = new BinaryTreeNode($val);
				$this->_right = &$node;
				return $this->_right;
			} else {
				$this->_right->insert($val);
			}
		}
		
		//return NULL;
			
	}
	
	public function visit() {
		
		$this->visited = TRUE;
		echo $this->item;
		
	}
	
	/*
	 * In-order traversal non-recursive
	 */
	public function inOrder() {
		
		$stack = array();
		$cur_node = $this;	//assume this is root
		
		//the tree has nodes to traverse
		while (!empty($stack) || $cur_node != NULL) {
			
			if ($cur_node != NULL) {
				//add this node and add potential left node
				array_push($stack, $cur_node);	
				$cur_node = $cur_node->_left;
				
			} else {
				//pop the top of stack
				$cur_node = array_pop($stack);
				$cur_node->visit();
				//add the potential right node
				$cur_node = $cur_node->_right;
				
			}
			
		}
		
	}
	
	/*
	 * In-order traversal recursive
	 */
	public function inOrderR() {
		
		if ($this->_left != NULL) {
			$this->_left->inOrderR();
		}
		
		$this->visit();
		
		if ($this->_right != NULL) {
			$this->_right->inOrderR();
		}
		
	}
	
	/*
	 * Pre-order traversal non-recursive
	 */
	public function preOrder() {
		return NULL;
	}
	
	/*
	 * Pre-order traversal recursive
	 */
	public function preOrderR() {
		
		$this->visit();
		
		if ($this->_left != NULL) {
			$this->_left->preOrderR();
		}
		
		if ($this->_right != NULL) {
			$this->_right->preOrderR();
		}
		
	}
	
	/*
	 * Post-order traversal non-recursive
	 */
	public function postOrder() {
		return NULL;
	}
	
	/*
	 * Post-order traversal recursive
	 */
	public function postOrderR() {
		
		if ($this->_left != NULL) {
			$this->_left->postOrderR();
		}
		
		if ($this->_right != NULL) {
			$this->_right->postOrderR();
		}
		
		$this->visit();
		
	}
	
	/*
	 * Level-order traversal
	 */
	public function levelOrder() {
		return false;
	}
	
	public function levelOrderR() {
		return false;
	}
	
}


//Begin
$tree = new BinaryTree('B');
$tree->add('D');
$tree->add('F');
$tree->add('E');
$tree->add('C');
$tree->add('G');
$tree->add('H');

$tree->_root->inOrder();

echo "<pre>";
print_r($tree);
echo "</pre>";

?>

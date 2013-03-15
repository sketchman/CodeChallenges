<?php

/*
 * Challenge
 * 
 * How the four main types of binary tree traversal.
 * Implement them in recursive and nonrecursive ways.
 * 
 * References:
 *	http://leetcode.com/2010/10/binary-tree-post-order-traversal.html
 *	http://leetcode.com/2010/04/binary-search-tree-in-order-traversal.html
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
		
		$stack = array();
		array_push($stack, $this);
		
		while (!empty($stack)) {
		
			//pop the stack and visit
			$cur_node = array_pop($stack);
			$cur_node->visit();
			
			//add the right first, will be looked at last
			if ($cur_node->_right != NULL) {
				array_push($stack, $cur_node->_right);
			}
			//add the left, will be looked at first
			if ($cur_node->_left != NULL) {
				array_push($stack, $cur_node->_left);
			}
			
		}
		
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
		
		$stack = array();
		$cur_node = $this;	//assume this is root
		$has_child = false;
		$prev_node = NULL;
		array_push($stack, $cur_node);
		
		
		//the tree has nodes to traverse
		while (!empty($stack)) {
			
			//grab the top node
			$cur_node = end($stack);
			
			if (!$prev_node || $prev_node->_left == $cur_node || $prev_node->_right == $cur_node) {
				//add the children if node not visited before
				if ($cur_node->_left) {
					array_push($stack, $cur_node->_left);
				} else if ($cur_node->_right) {
					array_push($stack, $cur_node->_right);
				}
				
			} else if ($cur_node->_left == $prev_node) {
				//Previously visited the left child
				if ($cur_node->_right) {
					array_push($stack, $cur_node->_right);
				}
			} else {
				//no more children
				$cur_node->visit();
				array_pop($stack);
			}
				
			$prev_node = $cur_node;
			
		}
		
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

echo "<h3>inOrder </h3>";
echo "<p>non-Recursive: ".$tree->_root->inOrder()."</p>";
echo "<p>Recursive: ".$tree->_root->inOrderR()."</p>";


echo "<h3>preOrder </h3>";
echo "<p>non-Recursive: ".$tree->_root->preOrder()."</p>";
echo "<p>Recursive: ".$tree->_root->preOrderR()."</p>";

echo "<h3>postOrder </h3>";
echo "<p>non-Recursive: ".$tree->_root->postOrder()."</p>";
echo "<p>Recursive: ".$tree->_root->postOrderR()."</p>";

echo "<hr />";
echo "<pre>";
print_r($tree);
echo "</pre>";

?>

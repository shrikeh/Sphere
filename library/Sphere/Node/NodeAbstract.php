<?php
/**
 * Class for representing hierarchical IDs as continued fractions
 * @category		Sphere
 * @package       	Sphere_Node
 * @copyright     	Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author        	B Hanlon <Barney_Hanlon@shrikeh.net>
 * @version       	Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access        	public
 */
/** Sphere_Node_NodeInterface **/
//require_once('Sphere/Node/NodeInterface.php');
/**
 * Class for representing hierarchical IDs as continued fractions
 * @category		Sphere
 * @package       	Sphere_Node
 * @copyright     	Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author        	B Hanlon <Barney_Hanlon@shrikeh.net>
 * @version       	Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access        	public
 */

abstract class Sphere_Node_NodeAbstract extends FilterIterator 
implements Sphere_Node_NodeInterface
{
	/**
	 * The ID of the Node in the persistency
	 * @var integer
	 */
	protected $_id;
	
	
	protected $_nodeId;
	
	/**
	 * The calculated 2x2 matrix for this node
	 * @var Sphere_Node_Matrix
	 */
	protected $_matrix;
	/**
	 * The true 2x2 matrix for this node
	 * @var Sphere_Node_Matrix
	 */
	protected $_trueMatrix;
	
	/**
	 * A reference to the parent of this Node, if any
	 * @var Sphere_Node_NodeAbstract|null
	 */
	protected $_parent;
	
	
	
	public function __construct(array $children = array())
	{
	    $childIterator     = new RecursiveArrayIterator(new ArrayObject($children));
	    $innerIterator     = new Sphere_Node_NodeIterator($childIterator);
	    
	    parent::__construct($innerIterator);
	}
	
	
	/**
	 * Behaviour to take when this object is echo'd.  It should return its calculated path.
	 * @return string
	 */
	public function __toString()
	{
		return strval($this->getPath());
	}
	
	public function __isset($v)
	{
	    
	}
	
	
	/**
	 * Shortcut magic method for getting properties
	 * @param $v string
	 * @return mixed
	 */
	public function __get($v)
	{
		switch ($v) {
			case 'path'	:
				return $this->getPath();
				break;
			default      :
			    return;
		}
	}
	
	/**
	 * Create a child node for an existing node. Return it if successful.
	 *
	 * @param integer $position The position of the child we wish to create.
	 * @param boolean $replace Whether or not to replace an existing child.
	 * @return Sphere_Node_NodeAbstract
	 */
	public function createChild($position, $doNotReplace = true)
	{
	    if ( ($this->getChild($position)) && ($doNotReplace) ) {
	        throw new Sphere_Node_NodeException('Node already exists and you have not explicitly chosen to delete the existing one');
	    }
        if ( ($matrix = $this->getMatrix()) && ($childMatrix = $matrix->createChild($position)) ) {
            if ($childNode = Sphere_Node::factory($childMatrix)) {
                
                if ($this->addChild($childNode, $position)) {
                    return $this->getChild($position);
                }
            }
        }
        return false;
	}
	
	
	/**
	 * Return the specified nth child of this node
	 * @param integer $childPosition
	 * @return Sphere_Node_Interface
	 */
	public function getChild($childPosition)
	{
        return $this->getInnerIterator()->offsetGet($childPosition - 1);
	}
	
	/**
	 * Return if this Node has any loaded children
	 * @return boolean true if it has any children
	 */
	public function hasChildren()
	{
	    return (bool) $this->count();
	}
	
	/**
	 * Moves a child into its parent's nodal branch
	 */
    public function setParent(Sphere_Node_NodeInterface $parent, $position)
    {
        $this->_setParent($parent);
        
        $parentMatrix = $parent->getMatrix();
        if ($childMatrix = $parentMatrix->createChild($position)) {
            $this->setMatrix($childMatrix);
            return true;
        }
        return false;
    }	
	
	/**
	 * Add a child node
	 * @param Sphere_Node_Interface $node
	 * @return boolean True if it was able to add the Node.
	 */
	public function addChild(Sphere_Node_NodeInterface $node, $position = null)
	{
	    if (is_null($position)) {
	       $position = $this->getChildPosition($node);
	    }

	    if ($position > 0) {
	        $node->setParent($this, $position);
	        $this->getInnerIterator()->offsetSet($position - 1, $node);
	       return true;
	    }
		return false;
	}
	
	/**
	 * 
	 * @param Sphere_Node_Interface $child
	 * @param boolean $useTrueMatrix
	 * @return integer
	 */
	public function getChildPosition(Sphere_Node_NodeInterface $child, $useTrueMatrix = false)
	{
	    $parentMatrix = ($useTrueMatrix) ? $this->getTrueMatrix() : $this->getMatrix();
	    $childMatrix  = ($useTrueMatrix) ? $child->getTrueMatrix() : $child->getMatrix();
	    return Sphere_Node_Matrix::getChildPosition($parentMatrix, $childMatrix);
	}
	
	
	/**
	 * Return the path of this Node
	 * @return string
	 */
	public function getPath()
	{
		return $this->getMatrix()->getPath();
	}
	
	/**
	 * Return the true path of this Node
	 * @return string
	 */
	public function getTruePath()
	{
		if (!$matrix = $this->getTrueMatrix()) {
			$matrix = $this->getMatrix();
		}
		return $matrix->getPath();
	}
	
	/**
	 * Return the calculated Matrix
	 * @return Sphere_Node_Matrix
	 */
	public function getMatrix()
	{
		return $this->_matrix;
	}
	
	/**
	 * Set the calculated Matrix for this Node.
	 * Also then sets it for all of the children based on this
	 * @param Sphere_Node_Matrix $matrix
	 */
	public function setMatrix(Sphere_Node_Matrix $matrix)
	{
		$this->_matrix = $matrix;
		if ($this->hasChildren()) {
		    foreach ($this->getInnerIterator() as $position => $child) {
		        if ($childMatrix = $matrix->createChild($position + 1)) {
		          $child->setMatrix($childMatrix);
		        }
		    }
		}
	}
	
	/**
	 * Return the true matrix of this Node
	 * @return Sphere_Node_Matrix
	 */
	public function getTrueMatrix()
	{
		return $this->_trueMatrix;
	}
	
	/**
	 * Set the Node's true Matrix
	 * @param Sphere_Node_Matrix $matrix
	 */
	public function setTrueMatrix(Sphere_Node_Matrix $matrix = null)
	{
		$this->_trueMatrix = $matrix;
	}

	/**
     * Implementation of FilterIterator accept()
     * @return boolean true if the Sphere_Node_Interface is valid
	 */
	public function accept()
	{
	    if ($this->current() instanceof Sphere_Node_NodeInterface) {
	        return true;
	    }
	    return false;
	}
	
	public function seek($position)
	{
	    $this->getInnerIterator()->seek($position -1);
	}
	
	/**
	 * Set a reference to the parent Node for this, or null if its the top of the tree
	 * @param Sphere_Node_NodeInterface|null $parent
	 * @return unknown_type
	 */
	protected function _setParent(Sphere_Node_NodeInterface $parent = null)
	{
	    $this->_parent = $parent;
	}

}

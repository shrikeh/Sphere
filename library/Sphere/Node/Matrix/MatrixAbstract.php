<?php
/**
 * Class for representing hierarchical IDs as continued fractions
 * @category		Sphere
 * @package       	Sphere_Node
 * @subpackage		Matrix
 * @copyright     	Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author        	B Hanlon <Barney_Hanlon@shrikeh.net>
 * @version       	Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access        	public
 */

namespace Sphere\Node\Matrix;
/**
 * Class for representing hierarchical IDs as continued fractions
 * @category		Sphere
 * @package       	Sphere_Node
 * @subpackage		Matrix
 * @copyright     	Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author        	B Hanlon <Barney_Hanlon@shrikeh.net>
 * @version       	Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access        	public
 */

abstract class MatrixAbstract implements MatrixInterface
{
	/**
	 * A Sphere_Node_Rational representing the left side of the Matrix
	 * @var Sphere_Node_Rational
	 */
	protected $_lftRational;
	
	/**
	 * A Sphere_Node_Rational representing the right side of the Matrix
	 * @var Sphere_Node_Rational
	 */
	protected $_rgtRational;
	
	/**
	 * Constructor
	 * @param Sphere_Node_Rational $lft
	 * @param Sphere_Node_Rational $rgt
	 * @return Sphere_Node_Matrix_Interface
	 */	
	public function __construct(
	   Sphere_Node_Rational_RationalInterface $lft, 
	   Sphere_Node_Rational_RationalInterface $rgt)
	{
		$this->setLftRational($lft);
		$this->setRgtRational($rgt);
		
		
	}
	
	
	
	/**
	 * Magic method to simplify getting a few variables that are protected to write but public read.
	 *
	 * @param string $v
	 * @return unknown
	 */
	public function __get($v)
	{
		switch($v)
		{
			case 'lft'			:
			case 'lftRational'	:
				return $this->getLftRational();
				break;
			case 'rgt'			:
			case 'rgtRational'	:
				return $this->getLftRational();
				break;
		}
	}
	
	/**
	 * Calculate the value of the left Rational.
	 */
	public function calculate()
	{
		return (double) $this->getLftRational()->toValue();
	}
	
	/**
	 * Return the materialized path.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->getPath();
	}
	
	/**
	 * Return the left rational.
	 *
	 * @return Sphere_Node_Rational_Rational_RationalAbstract
	 */
	public function getLftRational()
	{
		return $this->_lftRational;
	}
	
	/**
	 * Set the left rational for this Matrix.
	 *
	 * @param Sphere_Node_Rational_RationalInterface $rational
	 */
	public function setLftRational(Sphere_Node_Rational_RationalInterface $rational)
	{
		$this->_lftRational = $rational;
	}
	
	/**
	 * Get the right rational
	 *
     * @return Sphere_Node_Rational_Rational_RationalAbstract
     */
	public function getRgtRational()
	{
		return $this->_rgtRational;
	}
	
	public function setRgtRational(Sphere_Node_Rational_RationalInterface $rational)
	{
		$this->_rgtRational = $rational;
	}	
	
	/**
	 * Return a matrix representing the child at position $child
	 * based on childLftRation
	 * @param $childNumber
	 * @return Sphere_Node_MatrixInterface
	 */
	public function getChild($childNumber)
	{
		//return self::lftRational()
	}
	

	/**
	 * Enter description here...
	 * @todo This
	 */
	public function current()
	{
	    
	}
	
	public function next()
	{
	    
	}
	
	public function key()
	{
	    
	}
	
	public function valid()
	{
	    
	}
	
	public function rewind()
	{
	    
	}
}
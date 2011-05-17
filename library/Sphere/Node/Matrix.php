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
namespace Sphere\Node;
use Sphere\Node\Matrix\MatrixInterface as Matrixinterface;
use Sphere\Node\Matrix\MatrixAbstract as MatrixAbstract;
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
class Matrix extends MatrixAbstract
{

	/**
	 * An array of loaded matrices
	 * @var array
	 */
	private static $matrices = array();
	
	/**
	 * Return the position in the tree of the child matrix to its direct parent
	 * @param Sphere_Node_Matrix $parent
	 * @param Sphere_Node_Matrix $child
	 * @return integer
	 */
	public static function getChildPosition(
	   MatrixInterface $parent, 
	   MatrixInterface $child
	   )
	{
		$childNumer 	= $child->getLftRational()->getNumer();
		$parentNumer	= $parent->getLftRational()->getNumer();
		$siblingNumer	= $parent->getRgtRational()->getNumer();
		
		// Taking the example of node .2, 2.3 is the third child, so:
		// .2 = 2/1
		// .3 = 3/1
		// .2.3 = 
		$childPosition = ($childNumer - $parentNumer) / $siblingNumer;
		
		if (is_int($childPosition)) {
			return $childPosition;
		}
		throw new MatrixException(
			'Matrix ' . $child->getPath() . ' is not a child of Matrix ' . $parent->getPath(),
			MatrixException::NOT_DESCENDENT
		);
	}
	
	/**
	 * Create the nth child of Matrix $matrix
	 * @param Sphere_Node_Matrix $matrix
	 * @param integer $childPosition
	 * @return Sphere_Node_Matrix
	 */
	public static function createChildMatrix(MatrixInterface $parent, $childPosition)
	{
	    $childLftRational  = self::_lftRational($parent, $childPosition);
	    $childRgtRational  = self::_rgtRational($parent, $childPosition);
	    
	    return self::factory($childLftRational, $childRgtRational);
	}
	
	
	/**
	 * Builder for creating Rationals from a parent matrix
	 * @param Sphere_Node_Matrix $matrix
	 * @param integer $childPosition
	 * @return Sphere_Node_Rational
	 */
	protected static function _getRational(Sphere_Node_Matrix_MatrixInterface $matrix, $childPosition)
	{
		$lftRational = $matrix->getLftRational();
		$rgtRational = $matrix->getRgtRational();
		
		$childNumer = $lftRational->getNumer() + ($childPosition * $rgtRational->getNumer());
		$childDenom = $lftRational->getDenom() + ($childPosition * $rgtRational->getDenom());
		
		return Rational::factory($childNumer, $childDenom);		
	}
	
	/**
	 * Return the left side of the matrix as a Rational
	 * @param Sphere_Node_Matrix $matrix
	 * @param integer $childNumber
	 * @return Sphere_Node_Rational
	 */
	protected static function _lftRational(Sphere_Node_Matrix_MatrixInterface $matrix, $childNumber)
	{
		return self::_getRational($matrix, $childNumber);
	}
	
	/**
	 * Return the right hand (sibling) side of the matrix, based on a parent matrix
	 * @param Sphere_Node_Matrix $matrix
	 * @param integer $childNumber
	 * @return Sphere_Node_Rational
	 */
	protected static function _rgtRational(Sphere_Node_Matrix_MatrixInterface $matrix, $childNumber)
	{
		return self::_getRational($matrix, $childNumber + 1);
	}
	
    /**
     * Create a Sphere_Node_Matrix from left and right Rationals
     * @param Sphere_Node_Rational $lft
     * @param Sphere_Node_Rational $rgt
     * @return Sphere_Node_Matrix 
     */	
	public static function factory(Sphere_Node_Rational $lft, Sphere_Node_Rational $rgt)
	{
		return new self($lft, $rgt);
	}
	
	/**
	 * Create the base (root) node for a given tree, i.e. 3.2.1.1 is root 3
	 * @param integer $root
	 * @return Sphere_Node_Matrix
	 */
	public static function createTreeRoot($root)
	{
	    $lftRational   = Sphere_Node_Rational::factory($root, 1);
	    $rgtRational   = Sphere_Node_Rational::factory($root + 1, 1);
	    return self::factory($lftRational, $rgtRational);
	}
	
	
	/**
	 * Create a matrix based on the path passed in
	 * @param string $path
	 * @return Sphere_Node_Matrix
	 */
	public static function fromPath($path, $separator = '.')
	{
        $parts          = explode($separator, ltrim($path, $separator));
        // assuming a path of .2.1.3 for the path in, the rgt value is .2.1.4
        // the path therefore should be "the third child of the first child of root 2"
        
        $matrix = null;
        foreach ($parts as $node => $child) {
            //echo "node was  $node and child was $child \n";
            if (!$matrix) {
                $matrix = self::fromValues($child, 1, $child+1, 1);
            } else {
                $matrix = self::createChildMatrix($matrix, $child);
            }
        }
        
        return $matrix;
		
	}
	
	/**
	 * Return the materialized path
	 * @return string
	 */
    public function getPath($separator = '.')
    {
        return $this->getLftRational()->getPath($separator);
    }
    
    public function createChild($position)
    {
        return self::createChildMatrix($this, $position);
    }
    
	
	
	/**
	 * Build a Matrix from raw values
	 * @param integer $lftNumer
	 * @param integer $lftDenom
	 * @param integer $rgtNumer
	 * @param integer $rgtDenom
	 * @return Sphere_Node_Matrix
	 */
	public static function fromValues($lftNumer, $lftDenom, $rgtNumer, $rgtDenom)
	{
		$lftRational = Sphere_Node_Rational::factory($lftNumer, $lftDenom);
		$rgtRational = Sphere_Node_Rational::factory($rgtNumer, $rgtDenom);
		return self::factory($lftRational, $rgtRational);
	}
}
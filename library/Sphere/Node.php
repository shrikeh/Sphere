<?php
namespace Sphere;
use Sphere\Node\NodeInterface as NodeInterface;
use Sphere\Node\NodeAbstract as NodeAbstract;
use Sphere\Node\Matrix as Matrix;
use Sphere\Node\Matrix\MatrixInterface as MatrixInterface;
/**
 * Class for representing hierarchical IDs as continued fractions
 * @category		Sphere
 * @package       	Node
 * @copyright     	Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author        	B Hanlon <Barney_Hanlon@shrikeh.net>
 * @version       	Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access        	public
 */
/**
 * Class for representing hierarchical IDs as continued fractions
 * @category		Sphere
 * @package       	Node
 * @copyright     	Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author        	B Hanlon <Barney_Hanlon@shrikeh.net>
 * @version       	Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access        	public
 */

/**
 * .2 = /news
 * .2.1 = /business
 * .2.1.1 = some-seo-link
 * .2.1.1.2 /page/2
 * route = news/business/some-seo-link/page/2 = get node .2.1.1.2 (and activate as live all above)
 */
class Node extends NodeAbstract
{
	/**
	 * An array of loaded Sphere_Node_Interface objects 
	 * @var ArrayObject
	 */
	private static $_nodes;
	
	protected static $_separator = '.';
	
	public static function factory(
	   MatrixInterface $matrix, 
	   MatrixInterface $trueMatrix = null, 
	   array $children = array())
	{

		$sphere = new Node($children);	
		$sphere->setMatrix($matrix);
		$sphere->setTrueMatrix($trueMatrix);
		return $sphere;
	}
	
	/**
	 * Create a Node from a materialized path
	 *
	 * @param string $path
	 * @param string $separator
	 * @return Sphere_Node_NodeAbstract
	 */
	public static function fromPath($path, $separator = null)
	{
	    if (null !== $separator) {
	        $separator = self::getPathSeparator();
	    }
	    $matrix = Matrix::fromPath($path, $separator);
		return self::factory($matrix);
	}
	
	/**
	 * Set the separator to use and return the old value
	 * @param string $separator
	 * @return string
	 */
	public static function setPathSeparator($separator)
	{
	    $oldSeparator = self::$_separator;
	    self::$_separator = strval($separator);
	    return $oldSeparator;
	}
	
	/**
	 * Return the current path separator
	 * @return string
	 */
	public static function getPathSeparator()
	{
	    return self::$_separator;
	}
	
	/**
	 * Method for creating Nodeinstances from raw values
	 * @param integer $lftNumer
	 * @param integer $lftDenom
	 * @param integer $rgtNumer
	 * @param integer $rgtDenom
	 * @param integer $trueLftNumer
	 * @param integer $trueLftDenom
	 * @param integer $trueRgtNumer
	 * @param integer $trueRgtDenom
	 * @return Node
	 */
	public static function fromValues(
		$lftNumer, 
		$lftDenom, 
		$rgtNumer, 
		$rgtDenom,
		$trueLftNumer = null,
		$trueLftDenom = null,
		$trueRgtNumer = null,
		$trueRgtDenom = null
	)
	{
	  
	   $matrix 	   = Matrix::fromValues($lftNumer, $lftDenom, $rgtNumer, $rgtDenom);

	   $trueMatrix = Matrix::fromValues($trueLftNumer, $trueLftDenom, $trueRgtNumer, $trueRgtDenom);
		return self::factory($matrix, $trueMatrix);
	}
	
	public static function getInstance($nodeId)
	{
		
	}
	

	
	/**
	 * Returns the position of the child in relation to the parent.
	 * @param Sphere\Node\Interface $parent
	 * @param Sphere\Node\Interface $child
	 * @return integer
	 */
	public static function childPosition(NodeInterface $parent, NodeInterface $child, $useTrueMatrix = false)
	{
        return $parent->getChildPosition($child, $useTrueMatrix);
	}

    /**
     * Return the contents of the node
     * (non-PHPdoc)
     * @see \Sphere\Node\Interface#getContent()
     * @return mixed
     */	
	public function getContent()
	{
	    
	}
    /**
     * Set the contents of the node
     * (non-PHPdoc)
     * @see \Sphere\Node\Interface#setContent($content)
     * @param mixed The content to put in this Node
     */	
	public function setContent($content)
	{
	    
	}
}
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
/** Sphere_Node_NodeAbstract **/
//require_once 'Sphere/Node/NodeAbstract.php';
/** Sphere_Node_Matrix **/
//require_once 'Sphere/Node/Matrix.php';
/** Sphere_Node_NodeIterator **/
//require_once 'Sphere/Node/NodeIterator.php';
/**
 * Class for representing hierarchical IDs as continued fractions
 * @category		Sphere
 * @package       	Sphere_Node
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
class Sphere_Node extends Sphere_Node_NodeAbstract
{
	/**
	 * An array of loaded Sphere_Node_Interface objects 
	 * @var ArrayObject
	 */
	private static $_nodes;
	
	protected static $_separator = '.';
	
	public static function factory(
	   Sphere_Node_Matrix $matrix, 
	   Sphere_Node_Matrix $trueMatrix = null, 
	   array $children = array())
	{

		$sphere = new Sphere_Node($children);	
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
	    $matrix = Sphere_Node_Matrix::fromPath($path, $separator);
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
	 * Method for creating Sphere_Node_Interface instances from raw values
	 * @param integer $lftNumer
	 * @param integer $lftDenom
	 * @param integer $rgtNumer
	 * @param integer $rgtDenom
	 * @param integer $trueLftNumer
	 * @param integer $trueLftDenom
	 * @param integer $trueRgtNumer
	 * @param integer $trueRgtDenom
	 * @return Sphere_Node_Interface
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
	  
	   $matrix 	   = Sphere_Node_Matrix::fromValues($lftNumer, $lftDenom, $rgtNumer, $rgtDenom);

	   $trueMatrix = Sphere_Node_Matrix::fromValues($trueLftNumer, $trueLftDenom, $trueRgtNumer, $trueRgtDenom);
		return self::factory($matrix, $trueMatrix);
	}
	
	public static function getInstance($nodeId)
	{
		
	}
	

	
	/**
	 * Returns the position of the child in relation to the parent.
	 * @param Sphere_Node_Interface $parent
	 * @param Sphere_Node_Interface $child
	 * @return integer
	 */
	public static function childPosition(Sphere_Node_NodeInterface $parent, Sphere_Node_NodeInterface $child, $useTrueMatrix = false)
	{
        return $parent->getChildPosition($child, $useTrueMatrix);
	}

    /**
     * Return the contents of the node
     * (non-PHPdoc)
     * @see library/Sphere/Node/Sphere_Node_Interface#getContent()
     * @return mixed
     */	
	public function getContent()
	{
	    
	}
    /**
     * Set the contents of the node
     * (non-PHPdoc)
     * @see library/Sphere/Node/Sphere_Node_Interface#setContent($content)
     * @param mixed The content to put in this Node
     */	
	public function setContent($content)
	{
	    
	}
}
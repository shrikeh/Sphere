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
namespace Sphere\Node;
/**
 * Class for representing hierarchical IDs as continued fractions
 * @category		Sphere
 * @package       	Sphere_Node
 * @copyright     	Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author        	B Hanlon <Barney_Hanlon@shrikeh.net>
 * @version       	Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access        	public
 */
interface NodeInterface extends \SeekableIterator
{
    
    /**
     * Return the matrix used for this Node
     * @return Sphere_Node_Matrix
     */
    public function getMatrix();
    
    /**
     * Return the true matrix for this node (if any)
     * @return Sphere_Node_Matrix|null
     */
    public function getTrueMatrix();
    
    
    /**
     * Return the path of this Node
     * @return string
     */
    public function getPath();
    
    /**
     * Return the true path of the node (if it has a different true matrix)
     * @return string
     */
    public function getTruePath();
    
    
    /**
     * Add a child to the internal list of children for this node
     * @param Sphere_Node_Interface $node
     * @return boolean true if the child is valid
     */
    public function addChild(NodeInterface $node);
    
    /**
     * Return the internal content for this Node (if any)
     * @return mixed
     */
    public function getContent();
    
    /**
     * Set the content that this Node is an ID for.
     * @param $content
     * @return boolean true if it was able to set it.
     */
    public function setContent($content);
    
}
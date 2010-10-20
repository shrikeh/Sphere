<?php
/**
 * Class for representing hierarchical IDs as continued fractions
 * @category        Sphere
 * @package         Sphere_Node
 * @subpackage      Iterator
 * @copyright       Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author          B Hanlon <Barney_Hanlon@shrikeh.net>
 * @version         Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access          public
 */

/**
 * Class for representing hierarchical IDs as continued fractions
 * @category        Sphere
 * @package         Sphere_Node
 * @subpackage      Iterator
 * @copyright       Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author          B Hanlon <Barney_Hanlon@shrikeh.net>
 * @version         Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access          public
 */
class Sphere_Node_NodeIterator extends RecursiveArrayIterator
{
    /**
     * Add the Node at the designated offset
     * @param integer 
     */
    public function offsetSet($offset, $node)
    {
        if (!$node instanceof Sphere_Node_NodeInterface) {
            throw new Sphere_Node_NodeException('Cannot set child as it is not a node');
        }
        return parent::offsetSet($offset, $node);
    }
    
    public function offsetGet($offset) 
    {
        if (!$this->offsetExists($offset)) {
            var_dump($this);
            return;
        }
        return parent::offsetGet($offset);
    }
}
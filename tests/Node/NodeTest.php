<?php
/**
 * Class for testing continued fraction multi-hierarchical nodes
 * @category        tests
 * @package         Sphere
 * @subpackage      Node
 * @copyright       Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author          B Hanlon <Barney_Hanlon@shrikeh.net>
 * @version         Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access          public
 */
/** Sphere_Node **/
require_once('Sphere/Node.php');
/**
 * Class for testing continued fraction multi-hierarchical nodes
 * @category        tests
 * @package         Sphere
 * @subpackage      Node
 * @copyright       Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author          B Hanlon <Barney_Hanlon@shrikeh.net>
 * @version         Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access          public
 */
class SphereTest_NodeTest extends PHPUnit_Framework_TestCase
{
    
    /**
     * Test we can create a valid Sphere_Node, and whether or not after creating
     * we have an identical path.
     * @return unknown_type
     */
    public function testCreateNodeFromPath()
    {
        $path = '.2.1.3';
        
        $node = Sphere_Node::fromPath($path);

        $this->assertTrue($node instanceof Sphere_Node_NodeInterface);
        $this->assertSame($path, $node->getPath());
        
        $path = '.1';
        
        $node = Sphere_Node::fromPath($path);
        
        var_dump($node);
    }
        
    /**
     * Test that we can create a child, add a child to its parent,
     * get the position of the child, etc.
     * @return unknown_type
     */
    public function testAddNodeAsChild()
    {
        $path       = '.2.4';
        // create the parent
        $node       = Sphere_Node::fromPath($path);
        // create the child
        $childPath  = '.2.4.2';
        $child      = Sphere_Node::fromPath($childPath);
        $this->assertTrue($node->addChild($child));
        $this->assertTrue($node->getChild(2) instanceof Sphere_Node_NodeInterface);

        $this->assertSame($childPath, $node->getChild(2)->getPath());

        $this->assertSame($node->getChildPosition($child), 2);
        $this->assertFalse($node->getChildPosition($child) === 1);
        $this->assertTrue($node->hasChildren());
        //return $node->seek(1);
    }
    
    /**
     * Can we move a child around easily enough?
     *
     */
    public function testMoveChildNode()
    {
        $path       = '.2.4';
        $node       = Sphere_Node::fromPath($path);
        // create the child
        $childPath  = '.2.4.2';
        $child      = Sphere_Node::fromPath($childPath);
        $node->addChild($child);    
        
        $deeplyNestedChildPath = '.2.4.2.3';

        $deepNode = Sphere_Node::fromPath($deeplyNestedChildPath);
        $child->addChild($deepNode);
        
        $this->assertTrue($node->getChild(2)->getChild(3) instanceof Sphere_Node_NodeInterface);
        $this->assertTrue($node->getChild(2)->getChild(3)->getPath() == $deeplyNestedChildPath);
        $newNodePath = '.3.1';
        $newNode = Sphere_Node::fromPath($newNodePath);
        $this->assertTrue($newNode instanceof Sphere_Node_NodeInterface);
        
        $newNode->addChild($node, 1);
            
        $this->assertTrue($newNode->getChild(1)->getPath() == '.3.1.1');
        $this->assertNotSame($deeplyNestedChildPath, $newNode->getChild(1)->getChild(2)->getChild(3)->getPath());
        $this->assertSame($newNodePath, $newNode->getPath());
        $this->assertSame('.3.1.1.2.3', $newNode->getChild(1)->getChild(2)->getChild(3)->getPath());
    }
    
    
    public function testCreateChildNodeByPosition()
    {
        $path       = '.2.2.1';
        $node       = Sphere_Node::fromPath($path);
 
        $childNode = $node->createChild(1);
        
        $this->assertSame('.2.2.1.1', $childNode->getPath());
        var_dump($childNode);
    }
  
}
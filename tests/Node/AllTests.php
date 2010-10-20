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
require_once 'Node/TestSuite.php';

class SphereTest_Node_AllTests 
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('SphereTest_Node');
 
        $suite->addTestSuite('SphereTest_Node_TestSuite');
        // ...
 
        return $suite;
    }
}
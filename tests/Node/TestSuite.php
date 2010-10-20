<?php

require_once 'Node/NodeTest.php';

class SphereTest_Node_TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        return new SphereTest_Node_TestSuite('SphereTest_NodeTest');
    }
}
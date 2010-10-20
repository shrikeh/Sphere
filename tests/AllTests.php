<?php
ini_set('display_errors' ,1);
set_include_path(get_include_path() . 
':/mnt/hgfs/sphere/SphereFramework/library:/mnt/hgfs/sphere/SphereFramework/tests');


require_once '/mnt/hgfs/sphere/Shrikeh/Autoload.php';

Shrikeh_Autoload::registerAutoload();

// Create a test suite that contains the tests
// from the ArrayTest class.
require_once 'Node/AllTests.php';

class SphereTest_AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Node');
 
        $suite->addTest(SphereTest_Node_AllTests::suite());
        // ...
 
        return $suite;
    }
}

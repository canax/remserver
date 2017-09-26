<?php

namespace Anax\RemServer;

use \Anax\DI\DIFactoryDefault;

/**
 * Test for RemServerController.
 */
class RemServerControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Setup before each testcase
     */
    public function setUp()
    {
        $this->di = new DIFactoryDefault();
    }



    /**
     * Create an object.
     */
    public function testCreate()
    {
        $rem = new RemServerController();
        $this->assertInstanceOf("Anax\RemServer\RemServerController", $rem);
    }



    /**
     * Inject $di.
     */
    public function testInjectDi()
    {
        $rem = new RemServerController();
        $obj = $rem->setDI($this->di);
        $this->assertEquals($rem, $obj);
    }
}

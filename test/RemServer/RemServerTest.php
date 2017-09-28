<?php

namespace Anax\RemServer;

use \Anax\Session\Session;

/**
 * Test for RemServer.
 */
class RemServerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Create an object.
     */
    public function testCreate()
    {
        $rem = new RemServer();
        $this->assertInstanceOf("Anax\RemServer\RemServer", $rem);
    }



    /**
     * Check that the configuration can be set.
     */
    public function testConfigure()
    {
        $rem = new RemServer();
        $obj = $rem->configure(["some" => "value"]);
        $this->assertEquals($rem, $obj);
    }



    /**
     * Inject a session.
     */
    public function testInjectSession()
    {
        $rem     = new RemServer();
        $session = new Session(["name" => "test"]);
        $obj = $rem->injectSession($session);
        $this->assertEquals($rem, $obj);
    }
}

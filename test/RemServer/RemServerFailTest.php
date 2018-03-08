<?php

namespace Anax\RemServer;

use \Anax\Session\Session;

/**
 * Test for RemServer.
 */
class RemServerFailTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Init the REM server without dataset throws exception.
     *
     * @expectedException Exception
     */
    public function testInit()
    {
        $rem     = new RemServer();
        $session = new Session(["name" => "test"]);

        $obj = $rem->configure([])
                   ->injectSession($session)
                   ->init();

        $this->assertEquals($rem, $obj);
    }
}

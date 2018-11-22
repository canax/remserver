<?php

namespace Anax\RemServer;

use Anax\Session\Session;
use PHPUnit\Framework\TestCase;

/**
 * Test error handling for RemServer.
 */
class RemServerFailTest extends TestCase
{
    /**
     * Path to file in dataset is invalid.
     *
     * @expectedException Anax\RemServer\Exception
     */
    public function testPathToDatasetFileInvalid()
    {
        $rem = new RemServer();
        $session = new Session(["name" => "test"]);
        $dataset = [ANAX_INSTALL_PATH . "/config/remserver/dataset/users-NO.json"];

        $obj = $rem->setDefaultDataset($dataset)
            ->injectSession($session)
            ->init();
    }
}

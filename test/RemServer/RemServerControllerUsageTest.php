<?php

namespace Anax\RemServer;

use \Anax\DI\DIFactoryTest;

/**
 * Test for RemServerController.
 */
class RemServerControllerUsageTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Setup before each testcase
     */
    protected function setUp()
    {
        $this->di = new DIFactoryTest();
        $this->di->configure("di.php");
        $this->controller = $this->di->get("remController");
        $this->rem = $this->di->get("rem");
    }



    /**
     * Tear down after each testcase
     */
    protected function tearDown()
    {
        $this->di->get("session")->destroy();
    }



    /**
     * Prepare using anyPrepare().
     */
    public function testAnyPrepare()
    {
        $this->controller->anyPrepare();
        $res = $this->rem->hasDataset();
        $this->assertTrue($res);
    }



    /**
     * Explicitly init the rem server.
     */
    public function testAnyInit()
    {
        $res = $this->rem->hasDataset();
        $this->assertFalse($res);

        ob_start();
        $response = $this->controller->anyInit();
        $this->assertContains("is initiated", $response->getBody());
        ob_end_clean();

        $res = $this->rem->hasDataset();
        $this->assertTrue($res);
    }



    /**
     * Explicitly destroy the session and clear remserver.
     */
    public function testAnyDestroy()
    {
        $res = $this->rem->hasDataset();
        $this->assertFalse($res);

        ob_start();
        $response = $this->controller->anyInit();
        $this->assertContains("is initiated", $response->getBody());
        ob_end_clean();

        $res = $this->rem->hasDataset();
        $this->assertTrue($res);

        ob_start();
        $response = $this->controller->anyDestroy();
        $this->assertContains("was destroyed", $response->getBody());
        ob_end_clean();

        $res = $this->rem->hasDataset();
        $this->assertFalse($res);
    }



    /**
     * Get the default dataset.
     */
    public function testGetDataset()
    {
        ob_start();
        $response = $this->controller->anyInit();
        $response = $this->controller->getDataset("users");
        ob_end_clean();

        // A default dataset
        $json = json_decode($response->getBody());
        $this->assertEquals(0, $json->offset);
        $this->assertEquals(25, $json->limit);
        $this->assertEquals(count($json->data), $json->total);
        $this->assertEquals(1, $json->data[0]->id);
        $this->assertEquals("Phuong", $json->data[0]->firstName);
        $this->assertEquals("Allison", $json->data[0]->lastName);
    }



    /**
     * Get an item from the default dataset.
     */
    public function testGetItem()
    {
        // The first item
        ob_start();
        $this->controller->anyInit();
        $response = $this->controller->getItem("users", 1);
        ob_end_clean();

        $json = json_decode($response->getBody());
        $this->assertEquals(1, $json->id);
        $this->assertEquals("Phuong", $json->firstName);
        $this->assertEquals("Allison", $json->lastName);

        // Not found item
        ob_start();
        $response = $this->controller->getItem("users", -1);
        ob_end_clean();

        $json = json_decode($response->getBody());
        $this->assertContains("not found", $json->message);
    }



    /**
     * Create a new item.
     */
    public function testPostItem()
    {
        ob_start();
        $this->controller->anyInit();
        $this->di->get("request")->setBody(
            json_encode([
                "firstName" => "Mumin",
                "lastName" => "Trollet",
            ])
        );
        $response = $this->controller->postItem("users");
        ob_end_clean();

        $json = json_decode($response->getBody());
        $this->assertEquals(13, $json->id);
        $this->assertEquals("Mumin", $json->firstName);
        $this->assertEquals("Trollet", $json->lastName);
    }



    /**
     * Update an item.
     */
    public function testPutItem()
    {
        // Add item
        ob_start();
        $this->controller->anyInit();
        $this->di->get("request")->setBody(
            json_encode([
                "firstName" => "Mumin",
                "lastName" => "Trollet",
            ])
        );
        $response = $this->controller->postItem("users");
        ob_end_clean();

        $json = json_decode($response->getBody());
        $this->assertEquals(13, $json->id);
        $this->assertEquals("Mumin", $json->firstName);
        $this->assertEquals("Trollet", $json->lastName);

        // Update item
        ob_start();
        $this->controller->anyInit();
        $this->di->get("request")->setBody(
            json_encode([
                "id" => 13,
                "firstName" => "Mega",
                "lastName" => "Mic",
            ])
        );
        $response = $this->controller->putItem("users", 13);
        ob_end_clean();

        $json = json_decode($response->getBody());
        $this->assertEquals(13, $json->id);
        $this->assertEquals("Mega", $json->firstName);
        $this->assertEquals("Mic", $json->lastName);
    }



    /**
     * Delete an item.
     */
    public function testDeleteItem()
    {
        // Delete item
        ob_start();
        $this->controller->anyInit();
        $response = $this->controller->deleteItem("users", 1);
        ob_end_clean();

        $json = json_decode($response->getBody());
        $this->assertNull($json);

        // Get deleted item
        ob_start();
        $response = $this->controller->getItem("users", 1);
        ob_end_clean();

        $json = json_decode($response->getBody());
        $this->assertContains("not found", $json->message);

        // Delete same item again
        ob_start();
        $response = $this->controller->deleteItem("users", 1);
        ob_end_clean();

        $json = json_decode($response->getBody());
        $this->assertNull($json);
    }



    /**
     * Route for 404.
     */
    public function testAnyUnsupported()
    {
        ob_start();
        $this->controller->anyInit();
        $response = $this->controller->anyUnsupported();
        ob_end_clean();

        $json = json_decode($response->getBody());
        $this->assertContains("not support", $json->message);
        $this->assertEquals(404, $response->getStatusCode());
    }
}

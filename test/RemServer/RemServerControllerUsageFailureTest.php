<?php

namespace Anax\RemServer;

use \Anax\DI\DIFactoryTest;

/**
 * Test for RemServerController to stress failure.
 */
class RemServerControllerUsageFailureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Setup before each testcase
     */
    public function setUp()
    {
        $this->di = new DIFactoryTest();
        $this->di->configure("di.php");
        $this->controller = new RemServerController();
        $this->controller->setDI($this->di);
        $this->rem = $this->di->get("rem");
    }



    /**
     * Create a new item with bad json (not array) in
     * request body.
     */
    public function testPostItemJsonNotArray()
    {
        // Add item
        ob_start();
        $this->controller->anyInit();
        $this->di->get("request")->setBody("'bad json'");
        $response = $this->controller->postItem("users");
        ob_end_clean();

        $json = json_decode($response->getBody());
        $this->assertContains("not an object/array", $json->message);
        $this->assertEquals(500, $response->getStatusCode());
    }



    /**
     * Create a new item with bad json in request body.
     */
    public function testPostItemBadJson()
    {
        // Add item
        ob_start();
        $this->controller->anyInit();
        $this->di->get("request")->setBody("{ bad json }");
        $response = $this->controller->postItem("users");
        ob_end_clean();

        $json = json_decode($response->getBody());
        $this->assertContains("valid JSON", $json->message);
        $this->assertEquals(500, $response->getStatusCode());
    }



    /**
     * Update a item with bad json (not array) in
     * request body.
     */
    public function testPutItemJsonNotArray()
    {
        // Add item
        ob_start();
        $this->controller->anyInit();
        $this->di->get("request")->setBody("bad json");
        $response = $this->controller->putItem("users", 1);
        ob_end_clean();

        $json = json_decode($response->getBody());
        $this->assertContains("not an object/array", $json->message);
        $this->assertEquals(500, $response->getStatusCode());
    }



    /**
     * Update a item with bad json in request body.
     */
    public function testPutItemBadJson()
    {
        // Add item
        ob_start();
        $this->controller->anyInit();
        $this->di->get("request")->setBody("{ bad json }");
        $response = $this->controller->postItem("users", 1);
        ob_end_clean();

        $json = json_decode($response->getBody());
        $this->assertContains("valid JSON", $json->message);
        $this->assertEquals(500, $response->getStatusCode());
    }
}

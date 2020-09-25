<?php

class EndpointActorsTest extends TestCase
{
    protected $baseURI = '/api/actors';

    /**
     * Checks the response status codes for each verb on a collection.
     *
     * @return void
     */
    public function testStatusCodesForCollection()
    {
        // Simply show entities, 200
        $response = $this->call('GET', $this->baseURI);
        $this->assertEquals(200, $response->status());

        // Create an entity, 201
        $response = $this->call('POST', $this->baseURI);
        $this->assertEquals(201, $response->status());

        // Should not be allowed
        $response = $this->call('PUT', $this->baseURI);
        $this->assertEquals(405, $response->status());

        // Should not be allowed
        $response = $this->call('PATCH', $this->baseURI);
        $this->assertEquals(405, $response->status());

        // Should not be allowed
        $response = $this->call('DELETE', $this->baseURI);
        $this->assertEquals(405, $response->status());
    }


    public function testContentForCollectionGet()
    {
        $this->markTestIncomplete();
    }


    public function testContentForCollectionPost()
    {
        $this->markTestIncomplete();
    }


    /**
     * Checks the response status codes for each verb on a existing (fresh) item,.
     *
     * @depends testContentForCollectionPost
     * @return  void
     */
    public function testStatusCodesForExistingItem()
    {
        $this->markTestIncomplete();

        // Create item using [POST api/actors]
        // Get returned ID and make endpoint

        $itemURI = "{$this->baseURI}/1";

        // Simply show the item, 200
        $response = $this->call('GET', $itemURI);
        $this->assertEquals(200, $response->status());

        // POST when item exists, conflict, 409
        $response = $this->call('POST', $itemURI);
        $this->assertEquals(409, $response->status());

        // Should not allow to replace the item, 405
        $response = $this->call('PUT', $itemURI);
        $this->assertEquals(405, $response->status());

        // Modify nothing on the item, 204
        $response = $this->call('PATCH', $itemURI);
        $this->assertEquals(204, $response->status());

        // Modify something on item, 200
        $modData = array('name' => 'Leo');
        $response = $this->call('PATCH', $itemURI, $modData);
        $this->assertEquals(200, $response->status());

        // Delete item, 200
        $response = $this->call('DELETE', $itemURI);
        $this->assertEquals(200, $response->status());

    }

    /**
     * Checks the response status codes for each verb on a deleted item,.
     *
     * @depends testStatusCodesForExistingItem
     * @return  void
     */
    public function testStatusCodesForDeletedItem()
    {
        $this->markTestIncomplete();

        $itemURI = "{$this->baseURI}/1";

        // First, delete the item
        $response = $this->call('DELETE', $itemURI);

        // There is nothing to show, 404
        $response = $this->call('GET', $itemURI);
        $this->assertEquals(404, $response->status());

        // POST when item is gone, 404
        $response = $this->call('POST', $itemURI);
        $this->assertEquals(404, $response->status());

        // There is nothing to replace, 404
        $response = $this->call('PUT', $itemURI);
        $this->assertEquals(404, $response->status());

        // There is nothing to modify, 404
        $response = $this->call('PATCH', $itemURI);
        $this->assertEquals(404, $response->status());

        // There is nothing to delete, 404
        $response = $this->call('DELETE', $itemURI);
        $this->assertEquals(404, $response->status());

    }

    public function testQueriesForCollection() {
        $this->markTestIncomplete();
    }

}

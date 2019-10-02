<?php

namespace App\Tests\Cinema;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CinemaControllerTest extends WebTestCase
{
    protected $em;
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testGetCinemaById()
    {
        $this->client->request('GET', '/cinema/1');

        $response = preg_replace('/HTTP(.*)index/s', "", $this->client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/cinema/get_cinema_by_id.json',
            $response
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testGetAllCinemas()
    {
        $this->client->request('GET', '/cinemas');

        $response = preg_replace('/HTTP(.*)index/s', "", $this->client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/cinema/get_all_cinema.json',
            $response
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}

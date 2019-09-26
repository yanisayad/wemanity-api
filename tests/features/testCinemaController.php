<?php

namespace App\Tests\Cinema;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CinemaControllerTest extends WebTestCase
{

    public function testSearchCinema()
    {
        $client = static::createClient();
        $client->request('GET', '/search/cinema');
        $response = preg_replace('/HTTP(.*)index/s', "", $client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/cinema/search_cinemas.json',
            $response
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetAllCinemas()
    {
        $client = static::createClient();
        $client->request('GET', '/cinemas');

        $response = preg_replace('/HTTP(.*)index/s', "", $client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/cinema/get_all_cinema.json',
            $response
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetCinemaById()
    {
        $client = static::createClient();
        $client->request('GET', '/cinema/1');

        $response = preg_replace('/HTTP(.*)index/s', "", $client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/cinema/get_cinema_by_id.json',
            $response
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    // public function testCreateUpdateDelete()
    // {

    // }
}

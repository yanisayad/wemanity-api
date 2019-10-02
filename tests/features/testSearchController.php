<?php

namespace App\Tests\Search;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchControllerTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testSearchCinema()
    {
        $this->client = static::createClient();
        $this->client->request('GET', '/search/cinema');
        $response = preg_replace('/HTTP(.*)index/s', "", $this->client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/cinema/search_cinemas.json',
            $response
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testSearchCity()
    {
        $this->client = static::createClient();
        $this->client->request('GET', '/search/city');
        $response = preg_replace('/HTTP(.*)index/s', "", $this->client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/city/search_cities.json',
            $response
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testSearchMovies()
    {
        $this->client = static::createClient();
        $this->client->request('GET', '/search/movie');
        $response = preg_replace('/HTTP(.*)index/s', "", $this->client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/movie/search_movies.json',
            $response
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}

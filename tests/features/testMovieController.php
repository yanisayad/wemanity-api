<?php

namespace App\Tests\Movie;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testGetAllMovies()
    {
        $this->client = static::createClient();
        $this->client->request('GET', '/movies');

        $response = preg_replace('/HTTP(.*)index/s', "", $this->client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/movie/get_all_movies.json',
            $response
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testGetMovieById()
    {
        $this->client = static::createClient();
        $this->client->request('GET', '/cinema/1');

        $response = preg_replace('/HTTP(.*)index/s', "", $this->client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/movie/get_movie_by_id.json',
            $response
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}

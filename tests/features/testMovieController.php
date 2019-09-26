<?php

namespace App\Tests\Movie;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{

    public function testSearchMovies()
    {
        $client = static::createClient();
        $client->request('GET', '/search/movie');
        $response = preg_replace('/HTTP(.*)index/s', "", $client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/movie/search_movies.json',
            $response
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetAllMovies()
    {
        $client = static::createClient();
        $client->request('GET', '/movies');

        $response = preg_replace('/HTTP(.*)index/s', "", $client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/movie/get_all_movies.json',
            $response
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetMovieById()
    {
        $client = static::createClient();
        $client->request('GET', '/cinema/1');

        $response = preg_replace('/HTTP(.*)index/s', "", $client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/movie/get_movie_by_id.json',
            $response
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    // public function testCreateUpdateDelete()
    // { }
}

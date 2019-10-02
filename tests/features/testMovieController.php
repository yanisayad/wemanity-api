<?php

namespace App\Tests\Movie;

use App\Entity\Movie;
use DateTime;
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

    public function testCreateReadUpdate()
    {
        $newMovie = new Movie();
        $newMovie->setName("Mon Nouveau Film");
        $newMovie->setStart(new DateTime('2019-03-06 20:00:00'));
        $newMovie->setEnd(new DateTime('2019-03-06 22:00:00'));

        $this->assertEquals("Mon Nouveau Film", $newMovie->getName());
        $this->assertEquals("2019-03-06 20:00:00", $newMovie->getStart()->format('Y-m-d H:i:s'));
        $this->assertEquals("2019-03-06 22:00:00", $newMovie->getEnd()->format('Y-m-d H:i:s'));

        $this->assertEquals([
            "id" => null,
            "name" => "Mon Nouveau Film",
            "start" => $newMovie->getStart(),
            "end" => $newMovie->getEnd()
        ], $newMovie->toArray());

        $newMovie->setName("Mon Film Modifié");

        $this->assertEquals([
            "id" => null,
            "name" => "Mon Film Modifié",
            "start" => $newMovie->getStart(),
            "end" => $newMovie->getEnd()
        ], $newMovie->toArray());
    }
}

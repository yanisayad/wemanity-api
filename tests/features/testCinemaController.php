<?php

namespace App\Tests\Cinema;

use App\Entity\Cinema;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CinemaControllerTest extends WebTestCase
{
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

    public function testCreateReadUpdate()
    {
        $newCinema = new Cinema();
        $newCinema->setName("Mon Nouveau Cinema");
        $newCinema->setStreet("26 Rue du Nouveau Cinosh");
        $newCinema->setPhone("0102030405");

        $this->assertEquals("Mon Nouveau Cinema", $newCinema->getName());
        $this->assertEquals("26 Rue du Nouveau Cinosh", $newCinema->getStreet());
        $this->assertEquals("0102030405", $newCinema->getPhone());

        $this->assertEquals([
            "id" => null,
            "name" => "Mon Nouveau Cinema",
            "street" => "26 Rue du Nouveau Cinosh",
            "phone" => "0102030405"
        ], $newCinema->toArray());

        $newCinema->setStreet("26 Rue de la modification");

        $this->assertEquals([
            "id" => null,
            "name" => "Mon Nouveau Cinema",
            "street" => "26 Rue de la modification",
            "phone" => "0102030405"
        ], $newCinema->toArray());
    }
}

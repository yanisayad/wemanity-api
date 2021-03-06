<?php

namespace App\Tests\City;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CityControllerTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testHome()
    {
        $this->client = static::createClient();
        $this->client->request('GET', '/');
        $response = preg_replace('/HTTP(.*)index/s', "", $this->client->getResponse());

        $this->assertJsonStringEqualsJsonString(
            json_encode("home"),
            $response
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testGetAllCities()
    {
        $this->client = static::createClient();
        $this->client->request('GET', '/cities');

        $response = preg_replace('/HTTP(.*)index/s', "", $this->client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/city/get_all_cities.json',
            $response
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testGetCityById()
    {
        $this->client = static::createClient();
        $this->client->request('GET', '/city/1');
        $response = preg_replace('/HTTP(.*)index/s', "", $this->client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../results/city/get_city_by_id.json',
            $response
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}

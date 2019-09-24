<?php

namespace App\Tests\City;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Utils\TestsUtils;

class CityControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSearchCity()
    {
        $client = static::createClient();
        $client->request('GET', '/search/city');
        $response = preg_replace('/HTTP(.*)index/s', "", $client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/results/search_cities.json',
            $response
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetCityById()
    {
        $client = static::createClient();
        $client->request('GET', '/city/1');
        $response = preg_replace('/HTTP(.*)index/s', "", $client->getResponse());
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/results/get_city_by_id.json',
            $response
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

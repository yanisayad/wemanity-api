<?php

namespace App\Utils;
use Elastica\Client;
use Elastica\Document;
use Elastica\Request;
use Exception;

// use Elastica\Request;


class SearchUtils {

    public function search($type, $query_string = '*', $from = 0, $size = 20)
    {
        if (!in_array($type, ['city', 'cinema', 'movie'])) {
            throw new Exception("Mauvais index fournis", 400);
        }

        $client = new Client();

        $index = $client->getIndex('app');
        $type = $index->getType($type);

        $query = [
            'query' => [
                'query_string' => [
                    'query' => $query_string,
                    'default_operator' => 'AND',
                ]
            ],
            'from'  => $from,
            'size'  => $size,
        ];

        $path = $index->getName() . '/' . $type->getName() . '/_search';

        $response = $client->request($path, Request::POST, $query)->getData();

        $results = array_map(function ($hit) {
            return $hit["_source"];
        }, $response["hits"]["hits"]);


        return $results;
    }
}

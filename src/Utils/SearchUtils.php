<?php

namespace App\Utils;
use Elastica\Client;
use Elastica\Document;
use Elastica\Request;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
// use Elastica\Request;

class SearchUtils {

    private $env;

    public function __construct(ContainerInterface $container)
    {
        $this->env = $container->getParameter('kernel.environment');
    }

    public function search($type, $query_string = '*', $from = 0, $size = 20)
    {
        if (!in_array($type, ['city', 'cinema', 'movie'])) {
            throw new Exception("Mauvais index fournis", 400);
        }

        $client = new Client();
        $index  = $this->env === 'dev' ? $client->getIndex('app') : $client->getIndex('test.app');
        $type   = $index->getType($type);

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

        $query['sort']  = [
            'id' => [
                'order' => 'asc',
            ],
        ];

        // if ('' !== trim($sort) && 1 === preg_match("#^([+-]?)sort:([^\s]+)$#", $sort, $match)) {
        //     $order = '-' === $match[1] ? 'desc' : 'asc';
        //     $sort  = [
        //         $match[2] => [
        //             'order' => $order,
        //         ],
        //     ];

        //     $query['sort'] = $sort;
        // }

        $path = $index->getName() . '/' . $type->getName() . '/_search';

        $response = $client->request($path, Request::POST, $query)->getData();

        $results = array_map(function ($hit) {
            return $hit["_source"];
        }, $response["hits"]["hits"]);

        return $results;
    }
}

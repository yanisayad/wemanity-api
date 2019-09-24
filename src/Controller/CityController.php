<?php

namespace App\Controller;

use App\Utils\SearchUtils;
use App\Entity\City;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CityController extends AbstractController
{
    /**
     * @Route("/search/city", methods={"GET"}, name="searchCity")
     */
    public function searchCity(Request $req, SearchUtils $searchUtils): JsonResponse
    {
        $query = $req->query->get('q', '*');
        $size  = $req->query->get('size', 20);
        $from  = $req->query->get('from', 0);

        $cities = $searchUtils->search('city', $query, $from, $size);

        return $this->json($cities);
    }

    /**
     * @Route("/city/{id}", methods={"GET"}, name="getCityById", requirements={"id": "\d+"})
     * @ParamConverter("city", class="App:City")
     */
    public function getCityById(City $city): JsonResponse
    {
        return $this->json($city->toArray(), 200);
    }
}

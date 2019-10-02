<?php

namespace App\Controller;

use App\Utils\SearchUtils;
use App\Entity\City;
use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CityController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="home")
     */
    public function home()
    {
        return $this->json("home", 200);
    }

    /**
     * @Route("/cities", methods={"GET"}, name="getAllCities")
     */
    public function getAllCities(CityRepository $cityRepository): JsonResponse
    {
        $cities = array_map(function ($city) {
            return $city->toArray();
        }, $cityRepository->findAll());

        return $this->json($cities, 200);
    }

    /**
     * @Route("/search/city", methods={"GET"}, name="searchCity")
     */
    public function searchCity(Request $req, SearchUtils $searchUtils)
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

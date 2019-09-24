<?php

namespace App\Controller;

use App\Entity\Cinema;
use App\Entity\City;
use App\Repository\CinemaRepository;
use App\Utils\SearchUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CinemaController extends AbstractController
{
    /**
     * @Route("/search/cinema", methods={"GET"}, name="searchCinema")
     *
     * @param Request $request
     * @param SearchUtils $searchUtils
     *
     * @return JsonResponse
     */
    public function searchCinema(Request $request, SearchUtils $searchUtils): JsonResponse
    {
        $query = $request->query->get('q', '*');
        $size  = $request->query->get('size', 20);
        $from  = $request->query->get('from', 0);

        $cinemas = $searchUtils->search('cinema', $query, $from, $size);

        return $this->json($cinemas);
    }

    /**
     * @Route("/cinemas", methods={"GET"}, name="getAllCinemas")
     *
     * @param CinemaRepository $cinemaRepository
     *
     * @return JsonResponse
     */
    public function getAllCinemas(CinemaRepository $cinemaRepository): JsonResponse
    {
        $cinemas = $cinemaRepository->findAll();

        if (empty($cinemas)) {
            return $this->json("Aucun cinema", 403);
        }

        $cinemas = array_map(function ($cinema) {
            return $cinema->toArray();
        }, $cinemas);

        return $this->json($cinemas, 200);
    }

    /**
     * @Route("/cinema/{id}", methods={"GET"}, name="getCinemaById", requirements={"id": "\d+"})
     * @ParamConverter("cinema", class="App:Cinema")
     *
     * @param Cinema $cinema
     *
     * @return JsonResponse
     */
    public function getCinemaById(Cinema $cinema): JsonResponse
    {
        return $this->json($cinema->toArray(), 200);
    }

    /**
     * @Route("/city/{id}/cinemas", methods={"GET"}, name="getCinemaOfCity", requirements={"id": "\d+"})
     * @ParamConverter("city", class="App:City")
     *
     * @param City $city
     *
     * @return JsonResponse
     */
    public function getCinemaOfCity(City $city): JsonResponse
    {
        return $this->json([
            "id"         => $city->getId(),
            "name"       => $city->getName(),
            "zipcode"    => $city->getZipcode(),
            "department" => $city->getDepartment(),
            "cinemas"    => $city->getCinemas()
        ], 200);
    }

    /**
     * @Route("/city/{id}/cinema", methods={"POST"}, name="createCinema", requirements={"id": "\d+"})
     * @ParamConverter("city", class="App:City")
     *
     * @param City $city
     *
     * @return JsonResponse
     */
    public function createCinema(Request $req, City $city, EntityManagerInterface $em)
    {
        $data   = json_decode($req->getContent(), true);
        $name   = isset($data['name']) ? $data['name'] : null;
        $street = isset($data['street']) ? $data['street'] : null;
        $phone  = isset($data['phone']) ? $data['phone'] : null;

        if (in_array(null, [$name, $street, $phone])) {
            return $this->json("Un des champs est manquant");
        }

        $cinema = new Cinema();
        $cinema->setName($name);
        $cinema->setStreet($street);
        $cinema->setPhone($phone);
        $cinema->setCity($city);

        $em->persist($cinema);
        $em->flush();

        return $this->json($cinema->toArray(), 201);
    }
}

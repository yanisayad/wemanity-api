<?php

namespace App\Controller;

use App\Entity\Cinema;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Utils\SearchUtils;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class MovieController extends AbstractController
{
    /**
     * @Route("/search/movie", name="searchMovie")
     *
     * @param Request $req
     * @param SearchUtils $searchUtils
     *
     * @return JsonResponse
     */
    public function searchMovie(Request $req, SearchUtils $searchUtils): JsonResponse
    {
        $query = $req->query->get('q', '*');
        $size  = $req->query->get('size', 20);
        $from  = $req->query->get('from', 0);

        $movies = $searchUtils->search('movie', $query, $from, $size);

        return $this->json($movies);
    }

    /**
     * @Route("/movies", name="getMovies")
     *
     * @param MovieRepository $movieRepository
     *
     * @return JsonResponse
     */
    public function getMovies(MovieRepository $movieRepository): JsonResponse
    {
        $movies = array_map(function ($movie) {
            return $movie->toArray();
        }, $movieRepository->findAll());

       return $this->json($movies);
    }

    /**
     * @Route("/movie/{id}", methods={"GET"}, name="getMovieById", requirements={"id": "\d+"})
     * @ParamConverter("movie", class="App:Movie")
     *
     * @param Movie $movie
     *
     * @return JsonResponse
     */
    public function getMovieById(Movie $movie): JsonResponse
    {
        return $this->json($movie->toArray());
    }

    /**
     * @Route("/cinema/{id}/movies", methods={"GET"}, name="getCinemaMovie", requirements={"id": "\d+"})
     * @ParamConverter("cinema", class="App:Cinema")
     *
     * @param Cinema $cinema
     *
     * @return JsonResponse
     */
    public function getCinemaMovies(Cinema $cinema): JsonResponse
    {
        return $this->json([
            "id"     => $cinema->getId(),
            "name"   => $cinema->getName(),
            "street" => $cinema->getStreet(),
            "phone"  => $cinema->getPhone(),
            "movies" => $cinema->getMovies()
        ], 200);
    }

    /**
     * @Route("/cinema/{id}/movie", methods={"POST"}, name="createMovie", requirements={"id": "\d+"})
     * @ParamConverter("cinema", class="App:Cinema")
     *
     * @param Request $req
     * @param Cinema $cinema
     * @param EntityManagerInterface $em
     *
     * @return JsonResponse
     */
    public function createMovie(Request $req, Cinema $cinema, EntityManagerInterface $em): JsonResponse
    {
        $data  = json_decode($req->getContent(), true);
        $name  = isset($data['name']) ? $data['name'] : null;
        $start = isset($data['start']) ? $data['start'] : null;
        $end   = isset($data['end']) ? $data['end'] : null;

        if (in_array(null, [$name, $start, $end])) {
            return $this->json("Un des champs est manquant");
        }

        $movie = new Movie();
        $movie->setName($name);
        $movie->setStart(new DateTime($start));
        $movie->setEnd(new DateTime($end));
        $movie->setCinema($cinema);

        $em->persist($movie);
        $em->flush();

        return $this->json($movie->toArray(), 201);
    }

    /**
     * @Route("/movie/{id}", methods={"PUT"}, name="updateMovie", requirements={"id": "\d+"})
     * @ParamConverter("movie", class="App:Movie")
     *
     * @param Request $req
     * @param Movie $movie
     * @param EntityManagerInterface $em
     *
     * @return JsonResponse
     */
    public function updateMovie(Request $req, Movie $movie, EntityManagerInterface $em): JsonResponse
    {
        $data  = json_decode($req->getContent(), true);
        $name  = isset($data['name']) ? $data['name'] : null;
        $start = isset($data['start']) ? $data['start'] : null;
        $end   = isset($data['end']) ? $data['end'] : null;

        if (in_array(null, [$name, $start, $end])) {
            return $this->json("Un des champs est manquant");
        }

        $movie->setName($name);
        $movie->setStart(new DateTime($start));
        $movie->setEnd(new DateTime($end));

        $em->persist($movie);
        $em->flush();

        return $this->json($movie->toArray(), 200);
    }

    /**
     * @Route("/movie/{id}", methods={"DELETE"}, name="deleteMovie", requirements={"id": "\d+"})
     * @ParamConverter("movie", class="App:Movie")
     *
     * @param Movie $movie
     * @param EntityManagerInterface $em
     *
     * @return JsonResponse
     */
    public function deleteMovie(Movie $movie, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($movie);
        $em->flush();

        return $this->json(null, 204);
    }

}

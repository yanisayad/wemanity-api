<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class MovieController extends AbstractController
{
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
    public function getMovieById(Movie $movie):JsonResponse
    {
        return $this->json($movie->toArray());
    }


}

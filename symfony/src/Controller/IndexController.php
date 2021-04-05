<?php
/**
 * User: Oscar Sanchez
 * Date: 5/4/21
 */

namespace App\Controller;


use App\Doctrine\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param MovieRepository $movieRepository
     */
    public function home(MovieRepository $movieRepository)
    {
        $lastMovies = $movieRepository->getLast(4);

       return $this->render(
            'pages/home.html.twig',
            ['movies' => $lastMovies]
        );
    }
}
<?php
/**
 * User: Oscar Sanchez
 * Date: 2/4/21
 */

namespace App\Controller;


use App\Exception\MovieExistWithTheSameNameException;
use App\Exception\MovieNotFoundException;
use App\Exception\UserTypeNotPermitManipulateObjectException;
use App\Form\Type\CreateMovieType;
use App\Form\Type\UpdateMovieType;
use App\Repository\MovieRepositoryInterface;
use App\Repository\RentRepositoryInterface;
use App\Security\AuthUser;
use App\Service\DTO\MovieCreateDTO;
use App\Service\DTO\MovieDeleteDTO;
use App\Service\DTO\MovieUpdateDTO;
use App\Service\Handler\MovieCreateHandler;
use App\Service\Handler\MovieDeleteHandler;
use App\Service\Handler\MovieUpdateHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/admin/movie/create", name="create_movie")
     * @param Request $request
     * @param MovieCreateHandler $movieCreateHandler
     */
    public function create(Request $request , MovieCreateHandler $movieCreateHandler)
    {
        /**@var AuthUser $userApp */
        $userApp = $this->getUser();
        $user = $userApp->getUser();

        $movieCreateDTO = MovieCreateDTO::createByUser($user);
        $form = $this->createForm(CreateMovieType::class,$movieCreateDTO);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $movieCreateHandler->handle($data);
            return $this->redirectToRoute('list_movie_admin');

        }

        return $this->render('movie/create.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/movie/{id}/delete", name="delete_movie")
     * @param int $id
     * @param MovieDeleteHandler $movieDeleteHandler
     */
    public function delete(int $id, MovieDeleteHandler $movieDeleteHandler)
    {
        /**@var AuthUser $userApp */
        $userApp = $this->getUser();
        $user = $userApp->getUser();

        try {
            $movieDeleteDTO = new MovieDeleteDTO($id , $user->getId());
            $movieDeleteHandler->handle($movieDeleteDTO);


        }catch(MovieNotFoundException $e) {
            throw new NotFoundHttpException();

        }catch (UserTypeNotPermitManipulateObjectException $e) {
            throw new AccessDeniedHttpException();
        }

    }

    /**
     * @Route("/admin/movie/list", name="list_movie_admin")
     * @param MovieRepositoryInterface $movieRepository
     */
    public function listAdmin(MovieRepositoryInterface $movieRepository)
    {
        $movies = $movieRepository->getAll();

        return $this->render('movie/admin/list.html.twig' ,[
            'movies' => $movies
            ]);
    }

    /**
     * @Route("/admin/movie/{id}/update", name="edit_movie")
     * @param Request $request
     * @param int $id
     * @param MovieUpdateHandler $movieUpdateHandler
     * @param MovieRepositoryInterface $movieRepository
     * @return RedirectResponse|Response
     */
    public function edit(Request $request ,
                         int $id,
                         MovieUpdateHandler $movieUpdateHandler ,
                         MovieRepositoryInterface $movieRepository)
    {
        /**@var AuthUser $userApp */
        $userApp = $this->getUser();
        $user = $userApp->getUser();

        try {
            $movie = $movieRepository->getById($id);
            $movieCreateDTO = MovieUpdateDTO::createByMovieAndUser($movie,$user);
            $form = $this->createForm(UpdateMovieType::class,$movieCreateDTO);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $movieUpdateHandler->handle($data);
                return $this->redirectToRoute('list_movie_admin');

            }

        }catch (MovieNotFoundException $e) {
            throw new NotFoundHttpException();
        }catch (UserTypeNotPermitManipulateObjectException $e) {
            throw new AccessDeniedException();
        }

        return $this->render('movie/create.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/movie/{id}/", name="movie_view")
     * @param int $id
     * @param MovieRepositoryInterface $movieRepository
     * @return Response
     */
    public function view(int $id , MovieRepositoryInterface $movieRepository)
    {
        try {
            $movie = $movieRepository->getById($id);
        }catch (MovieNotFoundException $e) {

            throw new NotFoundHttpException();
        }

        return $this->render('movie/view.html.twig', [
            'movie' => $movie]
        );
    }
}
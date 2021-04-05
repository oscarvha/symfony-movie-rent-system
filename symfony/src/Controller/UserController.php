<?php
/**
 * User: Oscar Sanchez
 * Date: 29/3/21
 */

namespace App\Controller;


use App\Entity\ValueObject\RentStatus;
use App\Entity\ValueObject\Roles;
use App\Exception\MovieNotFoundException;
use App\Exception\NotMovieStockForRentingException;
use App\Exception\UserRentDuplicateMovie;
use App\Form\Type\CreateUserType;
use App\Repository\MovieRepositoryInterface;
use App\Repository\RentRepositoryInterface;
use App\Security\AuthUser;
use App\Service\DTO\RentMovieDTO;
use App\Service\DTO\RentUserChangeStatusDTO;
use App\Service\DTO\UnRentMovieDTO;
use App\Service\Handler\CreateUserHandler;
use App\Service\Handler\RentMovieHandler;
use App\Service\Handler\RentUserChangeStatusHandler;
use App\Service\Handler\ReturnMovieHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param CreateUserHandler $handler
     */
    public function create(Request $request , CreateUserHandler $handler)
    {
        /** @var AuthUser $authUser */
        $authUser = $this->getUser();

        if($authUser) {
            return $this->redirectToRoute('admin');
        }
        $form = $this->createForm(CreateUserType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $handler->handle($data);

            return $this->redirectToRoute('admin');

        }

        return $this->render('user/user_create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/movie/{id}/rent/", name="rent_movie")
     * @param int $id
     * @param MovieRepositoryInterface $movieRepository
     * @param RentMovieHandler $movieHandler
     */
    public function rentMovie(int $id, MovieRepositoryInterface $movieRepository , RentMovieHandler $movieHandler)
    {
        $this->denyAccessUnlessGranted(Roles::USER);

        /**@var AuthUser $userApp */
        $userApp = $this->getUser();
        $user = $userApp->getUser();

        try {
            $movie = $movieRepository->getById($id);
            $rentMovieDTO = new RentMovieDTO($user->getId(), $movie->getId());
            $movieHandler->handle($rentMovieDTO);


        }catch (MovieNotFoundException | UsernameNotFoundException $e) {
            throw new NotFoundHttpException();

        }catch (UserRentDuplicateMovie | NotMovieStockForRentingException $e) {
            throw new AccessDeniedHttpException();
        }

    }

    /**
     * @Route("/movie/{id}/cancel/", name="rent_cancel_movie")
     * @param int $id
     * @param RentRepositoryInterface $rentRepository
     * @param RentUserChangeStatusHandler $userChangeStatusHandler
     * @throws \App\Exception\RentIsAlreadyIsFinishedException
     * @throws \App\Exception\UserTypeNotPermitManipulateObjectException
     */
    public function rentCancel(int $id, RentRepositoryInterface $rentRepository,
                           RentUserChangeStatusHandler $userChangeStatusHandler)
    {
        $this->denyAccessUnlessGranted(Roles::USER);

        /**@var AuthUser $userApp */
        $userApp = $this->getUser();
        $user = $userApp->getUser();

        try {
            $rent = $rentRepository->getById($id);
            $returnUserChange = new RentUserChangeStatusDTO($user->getId(), $rent->getId(), RentStatus::CANCELED);
            $userChangeStatusHandler->handle($returnUserChange);

        }catch (MovieNotFoundException | UsernameNotFoundException $e) {
            throw new NotFoundHttpException();

        }catch (UserRentDuplicateMovie | NotMovieStockForRentingException $e) {
            throw new AccessDeniedHttpException();
        }

    }

    /**
     * @Route("/movie/{id}/return/", name="rent_return_movie")
     * @param int $id
     * @param RentRepositoryInterface $rentRepository
     * @param RentUserChangeStatusHandler $userChangeStatusHandler
     * @throws \App\Exception\RentIsAlreadyIsFinishedException
     * @throws \App\Exception\UserTypeNotPermitManipulateObjectException
     */
    public function rentReturn(int $id, RentRepositoryInterface $rentRepository,
                           RentUserChangeStatusHandler $userChangeStatusHandler)
    {
        $this->denyAccessUnlessGranted(Roles::USER);

        /**@var AuthUser $userApp */
        $userApp = $this->getUser();
        $user = $userApp->getUser();

        try {
            $rent = $rentRepository->getById($id);
            $returnUserChange = new RentUserChangeStatusDTO($user->getId(), $rent->getId(), RentStatus::RETURNED_USER);
            $userChangeStatusHandler->handle($returnUserChange);

        }catch (MovieNotFoundException | UsernameNotFoundException $e) {
            throw new NotFoundHttpException();

        }catch (UserRentDuplicateMovie | NotMovieStockForRentingException $e) {
            throw new AccessDeniedHttpException();
        }

    }

    /**
     * @Route("/user/rents/", name="view_rents")
     * @param RentRepositoryInterface $rentRepository
     */
    public function viewMyRents(RentRepositoryInterface $rentRepository): Response
    {
        $this->denyAccessUnlessGranted(Roles::USER);

        /**@var AuthUser $userApp */
        $userApp = $this->getUser();
        $user = $userApp->getUser();

       $rents = $rentRepository->getByUserName($user->getId());

       return $this->render('user/movie/rents.html.twig',[
           'rents' => $rents
       ]);

    }
}
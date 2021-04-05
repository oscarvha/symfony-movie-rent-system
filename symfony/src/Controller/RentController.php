<?php
/**
 * User: Oscar Sanchez
 * Date: 4/4/21
 */

namespace App\Controller;


use App\Exception\RentNotFoundException;
use App\Form\Type\RentStatusType;
use App\Repository\RentRepositoryInterface;
use App\Security\AuthUser;
use App\Service\DTO\RentChangeStatusDTO;
use App\Service\Handler\RentChangeStatusHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class RentController extends AbstractController
{
    /**
     * @Route("/admin/rents/list", name="admin_rents_lists")
     * @param RentRepositoryInterface $rentRepository
     * @return Response
     */
    public function listAdmin(RentRepositoryInterface $rentRepository)
    {
        $rents = $rentRepository->getAll();

        return $this->render('rent/admin/list.html.twig', [
            'rents' => $rents
        ]);
    }

    /**
     * @Route("/admin/rent/{id}/update", name="edit_rent")
     * @param Request $request
     * @param int $id
     * @param RentChangeStatusHandler $rentChangeStatusHandler
     * @param RentRepositoryInterface $rentRepository
     */
    public function edit(Request $request , int $id,
                         RentChangeStatusHandler $rentChangeStatusHandler ,
                         RentRepositoryInterface $rentRepository)
    {
        /**@var AuthUser $userApp */
        $userApp = $this->getUser();
        $user = $userApp->getUser();

        try {
            $rent  = $rentRepository->getById($id);
            $changeStatusDTO = new RentChangeStatusDTO($rent->getId(),$user->getId(), $rent->getStatus());

            $form = $this->createForm(RentStatusType::class,$changeStatusDTO);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $rentChangeStatusHandler->handle($data);
            }

            return $this->render('rent/admin/edit.html.twig',[
                'form' => $form->createView(),
                'rent' => $rent
            ]);

        }catch (RentNotFoundException $e) {
            throw new NotFoundHttpException();
        }
    }
}
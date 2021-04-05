<?php
/**
 * User: Oscar Sanchez
 * Date: 27/7/20
 */

namespace App\Controller;


use App\Service\Handler\CreateUserHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin/panel", name="admin_panel")
     * @param CreateUserHandler $handler
     */

    public function panel(CreateUserHandler $handler)
    {
        return $this->render('admin/panel.html.twig');
    }

}
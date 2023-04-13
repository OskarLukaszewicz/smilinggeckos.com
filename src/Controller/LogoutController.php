<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LogoutController extends AbstractController
{
    /**
     * @Route("/admin/logout", name="security_logout")
     */
    public function index(): Response
    {

        // add flash
        $url = $this->getParameter('DOMAIN');

        return new RedirectResponse($url);
            
    }
}
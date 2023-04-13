<?php

namespace App\Controller;

use App\Form\Type\GeckoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/")
*/
class DefaultController extends AbstractController
{

     /**
     * @Route("/", name="default_index")
     */
    public function index()
    {
        return $this->renderForm('bundles/EasyAdminBundle/geckoFormPage.html.twig');
    }
}
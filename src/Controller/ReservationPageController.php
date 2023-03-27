<?php

namespace App\Controller;
use App\Entity\Gecko;
use App\Entity\Reservation;
use App\Form\Type\ReservationType;
use App\Service\ByIdFetcher;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationPageController extends AbstractController
{
    private $fetcher;
    private $doctrine;
    public function __construct(ByIdFetcher $fetcher, ManagerRegistry $doctrine)
    {
        $this->fetcher = $fetcher;
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/reservation_page/{id}", name="reservation_page")
     */
    public function reservationPage(Gecko $gecko, Request $request): Response
    {
        $repository = $this->doctrine
                           ->getManager()
                           ->getRepository(Gecko::class);

        // $ids = $request->request->all();
        $ids = [35, 36, 37, 38, 39, 40];

        $gecks = $this->fetcher->fetchById($ids, $repository);

        $reservation = new Reservation();

        $reservation->setGecks($gecks);

        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            dump($form);
        }

        return $this->renderForm('reservation/reservation.html.twig', [
            'form' => $form,
            'gecks' => $gecks
        ]);
    }
}
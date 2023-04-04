<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use App\Service\Mailer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ReservationActionController extends AbstractController
{

    private $doctrine;
    private $mailer;

    public function __construct(ManagerRegistry $doctrine, Mailer $mailer)
    {
        $this->doctrine = $doctrine;
        $this->mailer = $mailer;
    }

    /**
     * @Route("/admin/reservation_list", name="reservation_list")
     */
    public function reservationList(): Response
    {
        $em = $this->doctrine->getManager();
        $repository = $em->getRepository(Reservation::class);
        $reservations = $repository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('@reservations/reservationListAdmin.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @Route("/admin/reservation_list/{id}/{action}", name="handle_reservation", requirements={"id" = "\d+"})
     */
    public function handleReservationAction(int $id, string $action): RedirectResponse
    {
        $em = $this->doctrine->getManager();
        $repository = $em->getRepository(Reservation::class);
        $reservation = $repository->find($id);

        switch ($action) {
            case "accept":
                $reservation->setAccepted(true);
                $this->mailer->sendReservationAcceptedConfirmation($reservation);
                break;
            case "decline":
                $reservation->setAccepted(false);
                break;
            case "delete":
                $em->remove($reservation);
                break;
        }

        $em->flush();

        return new RedirectResponse($this->generateUrl("reservation_list"));

    }
}
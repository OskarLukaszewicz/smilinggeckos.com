<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();

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
     * @Route("/admin/reservation_list/{id}/accept_reservation", name="accept_reservation", requirements={"id" = "\d+"} )
     */
    public function AcceptReservation(int $id): Response
    {
        $em = $this->doctrine->getManager();
        $repository = $em->getRepository(Reservation::class);
        $reservation = $repository->find($id);
        $reservation->setAccepted(true);
 
        $em->flush();

        return new RedirectResponse($this->generateUrl("reservation_list"));
    }

    /**
     * @Route("/admin/reservation_list/{id}/decline_reservation", name="decline_reservation", requirements={"id" = "\d+"} )
     */
    public function DeclineReservation(int $id): Response
    {
        $em = $this->doctrine->getManager();
        $repository = $em->getRepository(Reservation::class);
        $reservation = $repository->find($id);
        $reservation->setAccepted(false);

        $em->flush();


        return new RedirectResponse($this->generateUrl("reservation_list"));
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SmilingGeckosSymfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}

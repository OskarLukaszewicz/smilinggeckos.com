<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Service\Mailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReservationCrudController extends AbstractCrudController
{
    private $doctrine;
    private $mailer;

    public function __construct(ManagerRegistry $doctrine, Mailer $mailer)
    {
        $this->doctrine = $doctrine;
        $this->mailer = $mailer;
    }

    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    {
        
        if (Crud::PAGE_INDEX === $responseParameters->get('pageName')) {
            $em = $this->doctrine->getManager();
            $repository = $em->getRepository(Reservation::class);
            $reservations = $repository->findBy([], ['createdAt' => 'DESC']);

            $responseParameters->set('reservations', $reservations);
        }
        return $responseParameters;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/index', 'reservations/reservationListAdmin.html.twig');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }

    /**
     * @Route("/admin/reservation_list/{id}/{action}", name="handle_reservation", requirements={"id" = "\d+"})
     */
    public function handleReservationAction(Reservation $reservation, string $action, Request $request): RedirectResponse
    {
        $em = $this->doctrine->getManager();

        switch ($action) {
            case "accept":
                foreach ( $reservation->getGecks() as $gecko ) {
                    if ( $gecko->isReserved() ) {
                        $this->addFlash(
                            'warning',
                            'Nie można potwierdzić rezerwacji, ' . $gecko . " znajduje się już w zaakceptowanej przez administratora rezerwacji użytkownika [" . $gecko->getReservation()->getUsername() . " " . $gecko->getReservation()->getEmail() . "]"
                        );
                        return $this->redirect($this->container->get(AdminUrlGenerator::class)
                            ->setController(self::class)
                            ->setAction(Action::INDEX)
                            ->generateUrl()
                        );
                    }
                    $gecko->setReserved(true);
                }
                $reservation->setAccepted(true);
                $this->mailer->sendReservationAcceptedConfirmation($reservation);
                break;
            case "decline":
                $reservation->setAccepted(false);
                break;
            case "delete":
                $em->remove($reservation);
                break;
            case "saveNote":
                $reservation->setNote($request->query->get("note"));
                break;
        }

        
        $em->flush();

        return $this->redirect($this->container->get(AdminUrlGenerator::class)
            ->setController(self::class)
            ->setAction(Action::INDEX)
            ->generateUrl()
        );

    }

}

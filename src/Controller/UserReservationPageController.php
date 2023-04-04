<?php

namespace App\Controller;
use App\Entity\Gecko;
use App\Entity\Reservation;
use App\Exception\ItemAlreadyReservedException;
use App\Form\Type\ReservationType;
use App\Service\ByIdFetcher;
use App\Service\Mailer;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class UserReservationPageController extends AbstractController
{
    private $fetcher;
    private $doctrine;
    private $mailer;

    public function __construct(ByIdFetcher $fetcher, ManagerRegistry $doctrine, Mailer $mailer)
    {
        $this->fetcher = $fetcher;
        $this->doctrine = $doctrine;
        $this->mailer = $mailer;
    }

    /**
     * @Route("/reservation_page/{ids}", name="reservation_page")
     */
    public function reservationPage(Request $request, $ids): Response
    {

        $intIds = array_map('intval', explode(",", $ids));

        $em = $this->doctrine->getManager();

        $gecks = $this->fetcher->fetchForReferencesById(Gecko::class, $intIds, $em);

        foreach( $gecks as $gecko ) {
            if($gecko->isReserved()) {
                $message = "Gekon ";
                $message .= $gecko;
                $message .= " jest juz zarezerwowany";

                throw new ItemAlreadyReservedException($message);
            }
        }

        if ($gecks->count() != count($intIds)) {
            throw $this->createNotFoundException(
                "Nie znaleziono wszystkich elementów"
            );
        }

        $reservation = new Reservation();

        $reservation->setGecks($gecks);

        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $reservation = $form->getData();
            $reservation->setCreatedAt(new DateTime());
            $reservation->setUniqId(uniqid());
            $this->mailer->sendCreateReservationNotification($reservation);

            try {
                
                $em->persist($reservation);
                $em->flush();
    
                // toDo set flashes

                return new RedirectResponse("https://smilinggeckos.com");
                
            } catch (Exception $e) {
                if($e->getCode() === 19) {
                    throw new ItemAlreadyReservedException("Przynajmniej jeden z gekonów jest już zarezerwowany");
                }
            }
        }

        // ToDo jeśli nie ma gekonow w post, to wróc

        return $this->renderForm('reservations/reservationFormPage.html.twig', [
            'form' => $form,
            'gecks' => $gecks
        ]);
    }

    /**
     * @Route("/show_reservation/{uniqId}")
     */
    public function showReservation(string $uniqId): Response
    {
        $em = $this->doctrine->getManager();
        $repository = $em->getRepository(Reservation::class);

        $reservation = $repository->findOneBy(['uniqId' => $uniqId]);
        
        return $this->render('reservations/showReservation.html.twig', 
    [
        "reservation" => $reservation
    ]);
    }
}
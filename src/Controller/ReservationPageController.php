<?php

namespace App\Controller;
use App\Entity\Gecko;
use App\Entity\Reservation;
use App\Exception\ItemAlreadyReservedException;
use App\Form\Type\ReservationType;
use App\Service\ByIdFetcher;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
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
     * @Route("/reservation_page/{ids}", name="reservation_page")
     */
    public function reservationPage(Request $request, $ids): Response
    {

        $intIds = array_map('intval', explode(",", $ids));

        $em = $this->doctrine->getManager();

        // $ids = $request->request->all();
        // $ids = [131, 132, 133, 134, 135, 136, 137];

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

            $em->persist($form->getData()->setCreatedAt(new DateTime()));
            try {
                $em->flush();
            } catch (Exception $e) {
                if($e->getCode() === 19) {
                    throw new ItemAlreadyReservedException();
                }
            }
            // dump($form->getData());
        }

        // ToDo jeśli nie ma gekonow w post, to wróc

        return $this->renderForm('reservations/reservationFormPage.html.twig', [
            'form' => $form,
            'gecks' => $gecks
        ]);
    }
}
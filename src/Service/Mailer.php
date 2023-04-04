<?php

namespace App\Service;
use App\Entity\Reservation;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class Mailer
{
    private $mailer;
    private $twig;
    private $serviceEmailAdress;

    public function __construct(MailerInterface $mailer, Environment $twig, string $serviceEmailAdress)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->serviceEmailAdress = $serviceEmailAdress;
    }

    public function sendCreateReservationNotification(Reservation $reservation)
    {
        $body = $this->twig->render(
            'email/reservationConfirmation.html.twig', 
            [
                'reservation' => $reservation
            ]
        );

        $email = (new Email())
            ->from($this->serviceEmailAdress)
            ->to($reservation->getEmail())
            ->subject('Potwierdzenie złożenia rezerwacji w serwisie ')
            ->html($body);

        $this->mailer->send($email);

        $body = $this->twig->render(
            'email/reservationNotification.html.twig', 
            [
                "reservation" => $reservation
            ]
        );

        $email = (new Email())
            ->from($this->serviceEmailAdress)
            ->to($this->serviceEmailAdress)
            ->subject('Nowa rezerwacja została złożona')
            ->html($body);

        $this->mailer->send($email);
    }

    public function sendReservationAcceptedConfirmation(Reservation $reservation)
    {
        $body = $this->twig->render(
            'email/reservationAccepted.html.twig',
            [
                'reservation' => $reservation
            ]
        );

        $email = (new Email())
            ->from($this->serviceEmailAdress)
            ->to($reservation->getEmail())
            ->subject('Rezerwacja została zaakceptowana')
            ->html($body);

        $this->mailer->send($email);
    }
}
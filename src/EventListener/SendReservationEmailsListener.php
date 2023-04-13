<?php

namespace App\EventListener;

use App\Entity\Reservation;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Service\Mailer;

class SendReservationEmailsListener
{
    private $mailer;
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    public function postPersist(Reservation $reservation, LifecycleEventArgs $event)
    {
        
        $this->mailer->sendCreateReservationNotification($reservation);
    
    }
}
<?php

namespace App\EventSubscriber;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\EntityInterface\DateTimeEntityInterface;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CreationDateEntitySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setCreationDate', EventPriorities::PRE_WRITE]
        ];
    }

    public function setCreationDate(ViewEvent $event)
    {
        $method = $event->getRequest()->getMethod();
        $dateTimeEntity = $event->getControllerResult();

        if ($method === Request::METHOD_POST && $dateTimeEntity instanceof DateTimeEntityInterface)
        {
            $dateTimeEntity->setCreatedAt(new DateTime('now'));
        }
    }
}
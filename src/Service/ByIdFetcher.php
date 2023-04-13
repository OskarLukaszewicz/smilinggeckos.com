<?php

namespace App\Service;

use App\Entity\EntityInterface\ReservableEntityInterface;
use App\Exception\ItemAlreadyReservedException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;


class ByIdFetcher
{   
    public function fetchForReferencesById($entityName, array $ids, ObjectManager $em): ArrayCollection
    {
        $collection = new ArrayCollection();
        foreach ( $ids as $id ) {
            $itemReference = $em->getReference($entityName ,$id);
                if ($itemReference instanceof ReservableEntityInterface){
                    if($itemReference->isReserved()) {
                        $message = $itemReference;
                        $message .= " jest juz zarezerwowany";
        
                        throw new ItemAlreadyReservedException($message);
                    }
                }
                
            $collection->add($itemReference);

        }
        return $collection;
    }

}
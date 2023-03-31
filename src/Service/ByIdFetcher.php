<?php

namespace App\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;




class ByIdFetcher
{   
    public function fetchForReferencesById($entityName, array $ids, ObjectManager $em): ArrayCollection
    {
        $collection = new ArrayCollection();
        foreach ( $ids as $id ) {
            $itemReference = $em->getReference($entityName ,$id);
            $collection->add($itemReference);
        }


        return $collection;
    }
}
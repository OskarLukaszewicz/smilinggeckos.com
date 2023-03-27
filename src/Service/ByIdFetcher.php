<?php

namespace App\Service;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;


class ByIdFetcher
{

    public function fetchById(array $ids, ObjectRepository $repository): ArrayCollection
    {
        $collection = new ArrayCollection();
        foreach ( $ids as $id ) {
            $item = $repository->find($id);
            $collection->add($item);
        }
        // if (!$product) {
        //     throw $this->createNotFoundException(
        //         'No product found for id '.$id
        //     );
        // }

        return $collection;
    }
}
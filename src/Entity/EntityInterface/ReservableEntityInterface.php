<?php

namespace App\Entity\EntityInterface;

interface ReservableEntityInterface
{
    public function isReserved(): ?bool;

    public function setReserved(bool $reserved): ReservableEntityInterface;

}
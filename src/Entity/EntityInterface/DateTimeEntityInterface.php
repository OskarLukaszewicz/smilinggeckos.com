<?php

namespace App\Entity\EntityInterface;
use DateTime;
use DateTimeInterface;


interface DateTimeEntityInterface
{
    public function setCreatedAt(DateTimeInterface $published);

}
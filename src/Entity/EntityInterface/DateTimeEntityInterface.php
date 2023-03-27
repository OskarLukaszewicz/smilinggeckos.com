<?php

namespace App\Entity\EntityInterface;
use DateTime;

interface DateTimeEntityInterface
{
    public function setCreatedAt(DateTime $published): DateTimeEntityInterface;

}
<?php

namespace App\Controller;
use ApiPlatform\Validator\Exception\ValidationException;
use App\Entity\Gecko;
use App\Form\Type\GeckoType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateGeckoAction extends AbstractController
{
    private $em;
    private $validator;
    public function __construct(ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        $this->em = $doctrine->getManager();
        $this->validator = $validator;
    }

    public function __invoke(Request $request)
    {
        $gecko = new Gecko();
        $form = $this->createForm(GeckoType::class, $gecko);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($gecko);
            $this->em->flush();

            $gecko->setFile(null);

            return $gecko;
        }

        throw new ValidationException(
            $this->validator->validate($gecko)
        );
        
    }
}
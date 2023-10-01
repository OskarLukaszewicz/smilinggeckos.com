<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;
use App\Entity\FrontConfig;
use App\Entity\Gecko;
use App\Entity\Image;
use App\Entity\Reservation;
use App\Entity\User;
use App\Form\Type\ColorPickerType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class DashboardController extends AbstractDashboardController
{
    private $em;
    private $router;

    public function __construct(ManagerRegistry $doctrine, UrlGeneratorInterface $router)
    {
        $this->em = $doctrine->getManager();
        $this->router = $router;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        
        $repository = $this->em->getRepository(FrontConfig::class);

        $config = $repository->findOneBy([]) ?: $config = new FrontConfig();

        $form = $this->createForm(ColorPickerType::class, $config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $config = $form->getData();
            $config->addColor();

            $this->em->persist($config);
            $this->em->flush();
        }

        $notSeenReservations = $this->em->getRepository(Reservation::class)->findBy(['alreadySeen' => false]);

        $response = $this->renderForm('bundles/EasyAdminBundle/welcome.html.twig', 
            [
                "user" => $this->getUser(),
                "form" => $form,
                "colors" => $config->getColors(),
                "reservations" => $notSeenReservations,     
            ]
        );

        foreach($notSeenReservations as $reservation)
        {
            $reservation->setAlreadySeen(true);
            $this->em->persist($reservation);
            $this->em->flush();
        }

        return $response;
    }

    /**
     * @Route("/admin/remove_color/{key}", name="remove_color")
     */
    public function removeColorAction(int $key): Response
    {

        $config = $this->em->getRepository(FrontConfig::class)->findOneBy([]);

        $config->removeColor($key);

        $this->em->persist($config);
        $this->em->flush();
        
        $url = $this->router->generate('admin');

        return new RedirectResponse($url);
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SmilingGeckos');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Reservations', 'fa fa-ticket', Reservation::class);
        yield MenuItem::linkToCrud('Geckos', 'fa fa-shekel', Gecko::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Posts', 'fa fa-file-text', BlogPost::class);
        yield MenuItem::linkToCrud('Comments', 'fa fa-comment', Comment::class);
        yield MenuItem::linkToCrud('Images', 'fa fa-file', Image::class);
    }
}

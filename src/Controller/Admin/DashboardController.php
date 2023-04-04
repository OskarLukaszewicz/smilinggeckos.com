<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;
use App\Entity\Gecko;
use App\Entity\Reservation;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Comment;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Entity\File;



class DashboardController extends AbstractDashboardController
{

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();

    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SmilingGeckosSymfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Rezerwacje', 'fa fa-ticket', Reservation::class);
        yield MenuItem::linkToCrud('Gekony', 'fa fa-shekel', Gecko::class);
        yield MenuItem::linkToCrud('Użytkownicy', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Posty', 'fa fa-file-text', BlogPost::class);
        yield MenuItem::linkToCrud('Komentarze', 'fa fa-comment', Comment::class);
        yield MenuItem::linkToCrud('Pliki', 'fa fa-file', File::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}

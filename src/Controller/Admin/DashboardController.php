<?php

namespace App\Controller\Admin;

use App\Entity\Agency;
use App\Entity\Client;
use App\Entity\Galery;
use App\Entity\Service;
use App\Entity\Schedule;
use App\Entity\Appointment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Nonos Cut - Administration')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Agence', 'fas fa-list', Agency::class);
        yield MenuItem::linkToCrud('Rendez-vous', 'fas fa-calendar-check', Appointment::class);
        yield MenuItem::linkToCrud('Service', 'fas fa-unsorted', Service::class);
        yield MenuItem::linkToCrud('Galerie', 'fas fa-file', Galery::class);
        yield MenuItem::linkToCrud('Horaire', 'fas fa-clock', Schedule::class);
        yield MenuItem::linkToCrud('Client', 'fas fa-user', Client::class);
    }
}

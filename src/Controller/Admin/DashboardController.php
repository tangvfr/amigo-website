<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Entity\Event;
use App\Entity\Location;
use App\Entity\Mandate;
use App\Entity\Offer;
use App\Entity\Partner;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('pages/admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Amigo Website');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Entreprise', 'fas fa-building', Company::class);
        yield MenuItem::linkToCrud('Evenement', 'fas fa-calendar', Event::class);
        yield MenuItem::linkToCrud('Localisation', 'fas fa-map-location-dot', Location::class);
        yield MenuItem::linkToCrud('Mandate', 'fas fa-person', Mandate::class);
        yield MenuItem::linkToCrud('Offre', 'fas fa-user-tie', Offer::class);
        yield MenuItem::linkToCrud('Partenaire', 'fas fa-handshake', Partner::class);
    }
}

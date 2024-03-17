<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Entity\CompanyType;
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
    const SITE_NAME = 'Amigo Website';

    #[Route(['/', '/admin'], name: 'admin')]
    public function index(): Response
    {
        return $this->render('pages/admin/dashboard.html.twig', [
            'dashboardTitle' => 'Tableau de bord '.DashboardController::SITE_NAME
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin '.DashboardController::SITE_NAME)
            ->setFaviconPath('images/admin_amigo_logo.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fas fa-home');
        yield MenuItem::linkToCrud('Entreprise', 'fas fa-building', Company::class);
        yield MenuItem::linkToCrud('Company Type', 'fas fa-chart-line', CompanyType::class);
        yield MenuItem::linkToCrud('Évènement', 'fas fa-calendar', Event::class);
        yield MenuItem::linkToCrud('Localisation', 'fas fa-map-location-dot', Location::class);
        yield MenuItem::linkToCrud('Mandate', 'fas fa-person', Mandate::class);
        yield MenuItem::linkToCrud('Offre', 'fas fa-user-tie', Offer::class);
        yield MenuItem::linkToCrud('Partenaire', 'fas fa-handshake', Partner::class);
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Entity\CompanyType;
use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Hub;
use App\Entity\Location;
use App\Entity\Mandate;
use App\Entity\Offer;
use App\Entity\Partner;
use App\Entity\Role;
use App\Entity\Student;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    const SITE_NAME = 'Amigo Website';
    const DASHBOARD_NAME = 'Tableau de bord';
    const DASHBOARD_ICON = 'fa fa-home';

    const EXPOSED_NAME = 'Données exposés';
    const EXPOSED_ICON = 'fa-solid fa-signs-post';

    const OFFICE_NAME = 'Bureau';
    const OFFICE_ICON = 'fa-solid fa-briefcase';

    #[Route(['/', '/admin'], name: 'admin')]
    public function index(): Response
    {
        return $this->render('pages/admin/dashboard.html.twig', [
            'dashboardTitle' => self::DASHBOARD_NAME . ' ' . self::SITE_NAME
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin ' . DashboardController::SITE_NAME)
            ->setFaviconPath('images/admin_amigo_logo.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard(self::DASHBOARD_NAME, self::DASHBOARD_ICON);
        yield MenuItem::subMenu(self::EXPOSED_NAME, self::EXPOSED_ICON)->setSubItems([
            MenuItem::linkToCrud('Entreprise', 'fas fa-building', Company::class),
            MenuItem::linkToCrud('Company Type', 'fas fa-chart-line', CompanyType::class),
            MenuItem::linkToCrud('Évènement', 'fas fa-calendar', Event::class),
            MenuItem::linkToCrud('Localisation', 'fas fa-map-location-dot', Location::class),
            MenuItem::linkToCrud('Offre', 'fas fa-user-tie', Offer::class),
            MenuItem::linkToCrud('Partenaire', 'fas fa-handshake', Partner::class),
            MenuItem::linkToCrud('Étudiants', 'fas fa-user', Student::class),
        ]);
        yield MenuItem::subMenu(self::OFFICE_NAME, self::OFFICE_ICON)->setSubItems([
            MenuItem::linkToCrud('Mandate', 'fas fa-person', Mandate::class),
            MenuItem::linkToCrud('Pole', 'fas fa-flag', Hub::class),
            MenuItem::linkToCrud('Role', 'fas fa-key', Role::class),
        ]);
    }
}

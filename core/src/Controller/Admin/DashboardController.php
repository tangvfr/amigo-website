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
use App\Entity\User\AppUser;
use App\Entity\Role;
use App\Entity\Student;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Locale;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    const SITE_NAME = 'Amigo Website';
    const DASHBOARD_NAME = 'Tableau de bord';
    const DASHBOARD_ICON = 'fa fa-home';

    const EXPOSED_NAME = 'Données exposés';
    const EXPOSED_ICON = 'fa-solid fa-signs-post';

    const OFFICE_NAME = 'Bureau';
    const OFFICE_ICON = 'fa-solid fa-briefcase';
  
    const PASSWORD_NAME = 'Changer le mot de passe';
    const PASSWORD_ICON = 'fa-solid fa-key';

    // Taille des panels
    const PANEL_COLUMN_MOITIER_ECRAN = 'col-lg-8 col-xl-6';
    // nom des panels
    const PANEL_NAME_INFO_PRINCIPALE = 'Informations principales';

    #[Route(['/admin'], name: 'admin_dashboard')]
    public function index(): Response
    {
        return $this->render('pages/admin/dashboard.html.twig', [
            'dashboardTitle' => self::DASHBOARD_NAME . ' ' . self::SITE_NAME
        ]);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        $userMenu = parent::configureUserMenu($user);
        if ($user instanceof AppUser) {
            //définition du nom affiché
            $userMenu->setName($user->getUserIdentifier());
            //définition de l'avatar
            if (!$user->isTmpRoot()) {
                $img = $user->getStudent()->getImg();
                if ($img !== null) {
                    $userMenu->setAvatarUrl($img);
                }
            }

            //ajout bouton pour changer de mdp
            $userMenu->addMenuItems([
                MenuItem::linkToRoute(self::PASSWORD_NAME, self::PASSWORD_ICON, 'app_password')
            ]);
        }
        return $userMenu;
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin '.DashboardController::SITE_NAME)
            ->setFaviconPath('images/admin_amigo_logo.png')
            /*->setLocales([
                Locale::new('fr', 'Français', 'fa-solid fa-bread-slice'),
                Locale::new('en', 'English', 'fa-solid fa-flag-usa'),
            ])*/
        ;
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard(self::DASHBOARD_NAME, self::DASHBOARD_ICON),
            MenuItem::section(self::EXPOSED_NAME, self::EXPOSED_ICON),
                MenuItem::linkToCrud('Entreprise', 'fas fa-building', Company::class),
                MenuItem::linkToCrud('Company Type', 'fas fa-chart-line', CompanyType::class),
                MenuItem::linkToCrud('Évènement', 'fas fa-calendar', Event::class),
                MenuItem::linkToCrud('Localisation', 'fas fa-map-location-dot', Location::class),
                MenuItem::linkToCrud('Offre', 'fas fa-user-tie', Offer::class),
                MenuItem::linkToCrud('Partenaire', 'fas fa-handshake', Partner::class),
            MenuItem::subMenu(self::OFFICE_NAME, self::OFFICE_ICON),
                MenuItem::linkToCrud('Mandate', 'fas fa-person', Mandate::class),
        ];
    }
}

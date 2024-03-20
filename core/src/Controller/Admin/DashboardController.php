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
    #[Route(['/admin'], name: 'admin_dashboard')]
    public function index(): Response
    {
        return $this->render('pages/admin/dashboard.html.twig', [
            'dashboardTitle' => ConstantesCrud::DASHBOARD_NAME . ' ' . ConstantesCrud::SITE_NAME
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
                    $userMenu->setAvatarUrl(AbstractImageCrudController::BASE_PATH.$img);
                }
            }

            //ajout bouton pour changer de mdp
            $userMenu->addMenuItems([
                MenuItem::linkToRoute(ConstantesCrud::PASSWORD_NAME, ConstantesCrud::PASSWORD_ICON, 'app_password')
            ]);
        }
        return $userMenu;
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin ' . ConstantesCrud::SITE_NAME)
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
        MenuItem::linkToDashboard(ConstantesCrud::DASHBOARD_NAME, ConstantesCrud::DASHBOARD_ICON),
        MenuItem::section(ConstantesCrud::EXPOSED_NAME, ConstantesCrud::EXPOSED_ICON),
            MenuItem::linkToCrud(ConstantesCrud::COMPANY_NAME, ConstantesCrud::COMPANY_ICON, Company::class),
            MenuItem::linkToCrud(ConstantesCrud::COMPANY_TYPE_NAME, ConstantesCrud::COMPANY_TYPE_ICON, CompanyType::class),
            MenuItem::linkToCrud(ConstantesCrud::EVENT_NAME, ConstantesCrud::EVENT_ICON, Event::class),
            MenuItem::linkToCrud(ConstantesCrud::EVENT_TYPE_NAME, ConstantesCrud::EVENT_TYPE_ICON, EventType::class),
            MenuItem::linkToCrud(ConstantesCrud::LOCATION_NAME, ConstantesCrud::LOCATION_ICON, Location::class),
            MenuItem::linkToCrud(ConstantesCrud::OFFER_NAME, ConstantesCrud::OFFER_ICON, Offer::class),
            MenuItem::linkToCrud(ConstantesCrud::PARTNER_NAME, ConstantesCrud::PARTNER_ICON, Partner::class),
            MenuItem::linkToCrud(ConstantesCrud::STUDENT_NAME, ConstantesCrud::STUDENT_ICON, Student::class),
        MenuItem::section(ConstantesCrud::OFFICE_NAME, ConstantesCrud::OFFICE_ICON),
            MenuItem::linkToCrud(ConstantesCrud::MANDATE_NAME, ConstantesCrud::MANDATE_ICON, Mandate::class),
            MenuItem::linkToCrud(ConstantesCrud::HUB_NAME, ConstantesCrud::HUB_ICON, Hub::class),
            MenuItem::linkToCrud(ConstantesCrud::ROLE_NAME, ConstantesCrud::ROLE_ICON, Role::class),
        ];
    }
}

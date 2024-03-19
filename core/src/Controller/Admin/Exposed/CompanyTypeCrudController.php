<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\DashboardController;
use App\Entity\CompanyType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CompanyTypeCrudController extends AbstractCrudController
{
    public const CRUD_NAME = 'Activités d\'entreprise';

    public static function getEntityFqcn(): string
    {
        return CompanyType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Activité de l\'entreprise')
            ->setEntityLabelInPlural('Activités de l\'entreprise')
            ->setSearchFields(['label'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', DashboardController::SITE_NAME . ' - ' . self::CRUD_NAME)
            ->setPaginatorPageSize(10);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('label'),
        ];
    }

}

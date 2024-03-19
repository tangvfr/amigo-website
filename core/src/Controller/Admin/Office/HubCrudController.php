<?php

namespace App\Controller\Admin\Office;

use App\Controller\Admin\DashboardController;
use App\Entity\Hub;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HubCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Hub::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Pole')
            ->setEntityLabelInPlural('Pole')
            ->setSearchFields(['name'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', DashboardController::SITE_NAME.' - Pole')
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom')
                ->setSortable(true),
            TextEditorField::new('description', 'Description')
                ->hideOnIndex(),
            CollectionField::new('roles', 'Poles'),
            IntegerField::new('priority', 'Priorité')
                ->setSortable(true)
        ];
    }
}

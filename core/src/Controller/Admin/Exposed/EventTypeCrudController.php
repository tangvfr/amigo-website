<?php

namespace App\Controller\Admin\Exposed;

use App\Entity\EventType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EventTypeCrudController extends AbstractCrudController
{
    const CRUD_NAME = 'Tableau de bord';
    const CRUD_ICON = 'fas fa-home';

    public static function getEntityFqcn(): string
    {
        return EventType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Type d\'évènement')
            ->setEntityLabelInPlural('Types d\'évènements')
            ->setSearchFields(['label'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', DashboardController::SITE_NAME . ' - Types d\'évènement')
            ->setPaginatorPageSize(20);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('2'),
            FormField::addPanel('INFORMATIONS PRINCIPALES'),
            TextField::new('label', 'Nom')
                ->setMaxLength(255),
            TextEditorField::new('description', 'Description'),
        ];
    }
    
}

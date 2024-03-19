<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\DashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\EventType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventTypeCrudController extends AbstractCrudController
{
    const CRUD_NAME = 'Tableau de bord';
    const CRUD_ICON = 'fas fa-home';
    private const ENTITY_LABEL_IN_SINGULAR = 'Type d\'évènement';
    private const ENTITY_LABEL_IN_PLURAL = 'Types d\'évènement';

    public static function getEntityFqcn(): string
    {
        return EventType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular(self::ENTITY_LABEL_IN_SINGULAR)
            ->setEntityLabelInPlural(self::ENTITY_LABEL_IN_PLURAL)
            ->setSearchFields(['label'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', DashboardController::SITE_NAME . ' - ' . self::ENTITY_LABEL_IN_PLURAL)
            ->setPaginatorPageSize(20);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('2'),
            FormField::addPanel(DashboardController::PANEL_NAME_INFO_PRINCIPALE),
            TextField::new('label', 'Nom')
                ->setMaxLength(255),
            TextEditorField::new('description', 'Description'),
        ];
    }
    
}

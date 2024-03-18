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

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

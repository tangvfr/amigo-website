<?php

namespace App\Controller\Admin\Office;

use App\Entity\Mandate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MandateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mandate::class;
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

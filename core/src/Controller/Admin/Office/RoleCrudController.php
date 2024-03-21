<?php

namespace App\Controller\Admin\Office;

use App\Controller\Admin\ConstantesCrud;
use App\Entity\Role;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RoleCrudController extends AbstractCrudController
{
    private const ENTITY_LABEL_IN_SINGULAR = 'Role';
    private const ENTITY_LABEL_IN_PLURAL = 'Roles';
    public static function getEntityFqcn(): string
    {
        return Role::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular(self::ENTITY_LABEL_IN_SINGULAR)
            ->setEntityLabelInPlural(self::ENTITY_LABEL_IN_PLURAL)
            ->setSearchFields(['name'])
            ->setDefaultSort(['priority' => 'DESC'])
            ->setPageTitle('index', ConstantesCrud::SITE_NAME.' - '.self::ENTITY_LABEL_IN_PLURAL)
            ->setPaginatorPageSize(10)
        ;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm()
            ,

            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_ECRAN_8),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_INFOS_PRINCIPALES),
            TextField::new('name', 'Nom')
                ->setSortable(true)
            ,
            AssociationField::new('hub', 'Pole'),
            IntegerField::new('priority', 'Priorité')
                ->hideOnIndex()
        ];
    }
}

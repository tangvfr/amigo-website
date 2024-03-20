<?php

namespace App\Controller\Admin\Office;

use App\Controller\Admin\ConstantesCrud;
use App\Entity\Hub;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HubCrudController extends AbstractCrudController
{
    private const ENTITY_LABEL_IN_SINGULAR = 'Pole';
    private const ENTITY_LABEL_IN_PLURAL = 'Poles';
    public static function getEntityFqcn(): string
    {
        return Hub::class;
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
            /*IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm()
            ,*/

            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_ECRAN_8),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_INFOS_PRINCIPALES),
            TextField::new('name', 'Nom')
                ->setSortable(true)
            ,
            TextEditorField::new('description', 'Description')
                ->hideOnIndex()
            ,
            IntegerField::new('priority', 'Priorité')
                ->hideOnIndex()
        ];
    }
}

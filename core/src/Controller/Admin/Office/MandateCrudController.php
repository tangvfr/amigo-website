<?php

namespace App\Controller\Admin\Office;

use App\Controller\Admin\ConstantesCrud;
use App\Entity\Mandate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class MandateCrudController extends AbstractCrudController
{
    private const ENTITY_LABEL_IN_SINGULAR = 'Mandat';
    private const ENTITY_LABEL_IN_PLURAL = 'Mandats';
    public static function getEntityFqcn(): string
    {
        return Mandate::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular(self::ENTITY_LABEL_IN_SINGULAR)
            ->setEntityLabelInPlural(self::ENTITY_LABEL_IN_PLURAL)
            ->setSearchFields(['name'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', ConstantesCrud::SITE_NAME.' - '.self::ENTITY_LABEL_IN_PLURAL)
            ->setPaginatorPageSize(10)
            ->setDateFormat(DateTimeField::FORMAT_SHORT);
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm()
            ,

            //champs editable
            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_INFOS_PRINCIPALES),
            AssociationField::new('student', 'Étudiant'),
            AssociationField::new('roles', 'Rôles'),
            DateTimeField::new('bgedDate.beginDate', 'Début du mandat'),
            DateTimeField::new('bgedDate.endDate', 'Fin du mandat'),
            BooleanField::new('visible', 'Visible')
                ->hideOnIndex()
            ,

            //champs informatifs
            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_HISTORIQUE)
                ->hideWhenCreating()
            ,
            DateTimeField::new('creationDate', 'Date de création')
                ->setDisabled()
                ->hideOnIndex()
                ->hideWhenCreating()
            ,
            DateTimeField::new('lastEditDate', 'Dernière modification')
                ->setDisabled()
                ->hideOnIndex()
                ->hideWhenCreating()
        ];
    }
}

<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\ConstantesCrud;
use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LocationCrudController extends AbstractCrudController
{
    private const ENTITY_LABEL_IN_SINGULAR = 'Localisation';
    private const ENTITY_LABEL_IN_PLURAL = 'Localisations';

    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular(self::ENTITY_LABEL_IN_SINGULAR)
            ->setEntityLabelInPlural(self::ENTITY_LABEL_IN_PLURAL)
            ->setSearchFields(['label'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', ConstantesCrud::SITE_NAME. ' - ' .self::ENTITY_LABEL_IN_PLURAL)
            ->setPaginatorPageSize(20);

    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm()
            ,

            FormField::addColumn('1'),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_NOM),
            TextField::new('label', 'Nom'),


            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_ADRESSE),
            TextField::new('country', 'Pays'),
            TextField::new('city', 'Ville'),
            NumberField::new('postalCode', 'Code postal'),
            TextField::new('adresse'),


            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_COORDONNEES),
            NumberField::new('latitude')
                ->hideOnIndex()
                ->setNumDecimals(12)
            ,
            NumberField::new('longitude')
                ->hideOnIndex()
                ->setNumDecimals(12)
        ];
    }

}

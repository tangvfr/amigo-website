<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\DashboardController;
use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Location')
            ->setEntityLabelInPlural('Locations')
            ->setSearchFields(['label'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', DashboardController::SITE_NAME . ' - Location');

    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm(),
            FormField::addColumn('1'),
            FormField::addPanel('NOM'),
            TextField::new('label'),

            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('ADRESSE'),
            CountryField::new('country'),
            TextField::new('city'),
            NumberField::new('postalCode'),
            TextField::new('adresse'),

            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('MAPS'),
            NumberField::new('latitude')
                ->hideOnIndex()
                ->setNumDecimals(12),
            NumberField::new('longitude')
                ->hideOnIndex()
                ->setNumDecimals(12),
        ];
    }

}

<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\DashboardController;
use App\Entity\Offer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Intl\IntlFormatter;

class OfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Offer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Offre')
            ->setEntityLabelInPlural('Offres')
            ->setSearchFields(['label'])
            ->setDefaultSort(['creationDate' => 'DESC'])
            ->setPageTitle('index', DashboardController::SITE_NAME . ' - Offres')
            //->setDateFormat(DateTimeField::FORMAT_NONE)
            ;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm(),


            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('INFORMATIONS IMPORTANTE'),
            TextField::new('label', 'Label'),
            TextEditorField::new('description', 'Description')
                ->hideOnIndex(),
            ArrayField::new('keyWords', 'Mot clé')
                ->hideOnIndex(),


            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('DATE'),

            DateTimeField::new('bgedDate.beginDate', 'Début de l\'offre')
                ->hideOnIndex()
   ,
            DateTimeField::new('bgedDate.endDate', 'Fin de l\'offre')
                ->hideOnIndex()
                ->setFormat(DateTimeField::FORMAT_SHORT),


            DateTimeField::new('publicationDate', 'Date de publication de l\'offre')
                ->hideOnIndex(),
            DateTimeField::new('creationDate', 'Date de création')
                ->hideOnIndex()
                ->setRequired(false)
                ->setDisabled(),
            DateTimeField::new('lastEditDate', 'Dernière modification')
                ->hideOnIndex()
                ->setDisabled(),


            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('FOURNISSEUR'),
            AssociationField::new('provider', 'Entreprise fournissant l\'offre'),
            DateTimeField::new('endProvidDate', 'Fin du partage de l\'offre')
                ->hideOnIndex(),
        ];
    }
}

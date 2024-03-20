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
    private const ENTITY_LABEL_IN_SINGULAR = 'Offre';
    private const ENTITY_LABEL_IN_PLURAL = 'Offres';

    public static function getEntityFqcn(): string
    {
        return Offer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular(self::ENTITY_LABEL_IN_SINGULAR)
            ->setEntityLabelInPlural(self::ENTITY_LABEL_IN_PLURAL)
            ->setSearchFields(['label'])
            ->setDefaultSort(['creationDate' => 'DESC'])
            ->setPageTitle('index', DashboardController::SITE_NAME . ' - ' . self::ENTITY_LABEL_IN_PLURAL)
            ->setDateFormat(DateTimeField::FORMAT_SHORT);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn(DashboardController::PANEL_COLUMN_MOITIER_ECRAN),
            FormField::addPanel(DashboardController::PANEL_NAME_INFO_PRINCIPALE),
            TextField::new('label', 'Label'),
            TextEditorField::new('description', 'Description')
                ->hideOnIndex(),
            ArrayField::new('keyWords', 'Mot clé')
                ->hideOnIndex(),


            FormField::addColumn(DashboardController::PANEL_COLUMN_MOITIER_ECRAN),
            FormField::addPanel('DATE'),

            DateTimeField::new('bgedDate.beginDate', 'Début de l\'offre')
                ->hideOnIndex()
   ,
            DateTimeField::new('bgedDate.endDate', 'Fin de l\'offre')
                ->hideOnIndex(),


            DateTimeField::new('publicationDate', 'Date de publication de l\'offre')
                ->hideOnIndex(),
            DateTimeField::new('creationDate', 'Date de création')
                ->hideOnIndex()
                ->setRequired(false)
                ->setDisabled(),
            DateTimeField::new('lastEditDate', 'Dernière modification')
                ->hideOnIndex()
                ->setDisabled(),


            FormField::addColumn(DashboardController::PANEL_COLUMN_MOITIER_ECRAN),
            FormField::addPanel('FOURNISSEUR'),
            AssociationField::new('provider', 'Entreprise fournissant l\'offre'),
            DateTimeField::new('endProvidDate', 'Fin du partage de l\'offre')
                ->hideOnIndex(),
        ];
    }
}

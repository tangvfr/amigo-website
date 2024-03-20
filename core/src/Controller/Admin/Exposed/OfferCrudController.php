<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\ConstantesCrud;
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
            ->setPageTitle('index', ConstantesCrud::SITE_NAME. ' - ' .self::ENTITY_LABEL_IN_PLURAL)
            ->setDateFormat(DateTimeField::FORMAT_SHORT);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm()
            ,

            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_INFOS_PRINCIPALES),
            TextField::new('label', 'Label'),
            TextEditorField::new('description', 'Description')
                ->hideOnIndex()
            ,
            ArrayField::new('keyWords', 'Mots clés')
                ->hideOnIndex()
            ,

            FormField::addPanel(ConstantesCrud::PANEL_NAME_FOURNISSEUR),
            AssociationField::new('provider', 'Entreprise fournissant l\'offre'),
            DateTimeField::new('endProvidDate', 'Fin du partage de l\'offre')
                ->hideOnIndex(),


            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_DATES),
            DateTimeField::new('bgedDate.beginDate', 'Début de l\'offre')
                ->hideOnIndex()
            ,
            DateTimeField::new('bgedDate.endDate', 'Fin de l\'offre')
                ->hideOnIndex()
            ,

            DateTimeField::new('publicationDate', 'Date de publication de l\'offre')
                ->hideOnIndex()
            ,

            FormField::addPanel(ConstantesCrud::PANEL_NAME_HISTORIQUE),
            DateTimeField::new('creationDate', 'Date de création')
                ->hideOnIndex()
                ->setRequired(false)
                ->setDisabled()
            ,
            DateTimeField::new('lastEditDate', 'Dernière modification')
                ->hideOnIndex()
                ->setDisabled()
        ];
    }
}

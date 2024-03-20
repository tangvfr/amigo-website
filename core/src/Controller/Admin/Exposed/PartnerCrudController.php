<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\ConstantesCrud;
use App\Entity\Partner;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PartnerCrudController extends AbstractCrudController
{
    private const ENTITY_LABEL_IN_SINGULAR = 'Partenaire';
    private const ENTITY_LABEL_IN_PLURAL = 'Partenaires';
    public static function getEntityFqcn(): string
    {
        return Partner::class;
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
            AssociationField::new('company', 'Entreprise'),
            BooleanField::new('challenge', 'Entreprise Challenge')
                ->setSortable(true)
            ,
            TextField::new('advantages'),

            // dates
            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_DATES),
            DateTimeField::new('bgedDate.beginDate', 'Début du partenariat')
                ->hideOnIndex()
            ,
            DateTimeField::new('bgedDate.endDate', 'Fin du partenariat')
                ->setSortable(true)
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

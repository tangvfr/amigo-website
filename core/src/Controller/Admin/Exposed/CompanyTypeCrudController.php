<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\ConstantesCrud;
use App\Entity\CompanyType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CompanyTypeCrudController extends AbstractCrudController
{
    private const ENTITY_LABEL_IN_SINGULAR = 'Activité d\'entreprise';
    private const ENTITY_LABEL_IN_PLURAL = 'Activités d\'entreprise';

    public static function getEntityFqcn(): string
    {
        return CompanyType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular(self::ENTITY_LABEL_IN_SINGULAR)
            ->setEntityLabelInPlural(self::ENTITY_LABEL_IN_PLURAL)
            ->setSearchFields([ConstantesCrud::SEARCH_FIELD_LABEL])
            ->setDefaultSort([ConstantesCrud::ID => ConstantesCrud::DESC])
            ->setPageTitle(ConstantesCrud::PAGE_NAME, ConstantesCrud::SITE_NAME . ' - ' . self::ENTITY_LABEL_IN_PLURAL)
            ->setPaginatorPageSize(ConstantesCrud::RESULT_BY_PAGE);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new(ConstantesCrud::ID)
                ->hideOnIndex()
                ->hideOnForm()
            ,

            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_FULL_SCREEN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_INFO_PRINCIPALE),
            TextField::new(
                ConstantesCrud::COMPANY_TYPE_PROPERTY_NAME,
                ConstantesCrud::COMPANY_TYPE_LABEL_NAME
            )
                ->setMaxLength(ConstantesCrud::MAX_LENGTH)
        ];
    }

}

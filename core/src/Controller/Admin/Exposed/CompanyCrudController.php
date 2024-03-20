<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\AbstractImageCrudController;
use App\Controller\Admin\ConstantesCrud;
use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CompanyCrudController extends AbstractImageCrudController
{
    private const ENTITY_LABEL_IN_SINGULAR = 'Entreprise';
    private const ENTITY_LABEL_IN_PLURAL = 'Entreprises';

    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular(self::ENTITY_LABEL_IN_SINGULAR)
            ->setEntityLabelInPlural(self::ENTITY_LABEL_IN_PLURAL)
            ->setSearchFields([ConstantesCrud::SEARCH_FIELD_NAME])
            ->setDefaultSort([ConstantesCrud::ID => ConstantesCrud::DESC])
            ->setPageTitle(
                ConstantesCrud::PAGE_NAME,
                ConstantesCrud::SITE_NAME. ' - ' .self::ENTITY_LABEL_IN_PLURAL
            )
            ->setPaginatorPageSize(ConstantesCrud::RESULT_BY_PAGE);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            /*IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm()
            ,*/

            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_INFOS_PRINCIPALES),
            TextField::new(ConstantesCrud::COMPANY_PROPERTY_NAME, ConstantesCrud::COMPANY_LABEL_NAME)
                ->setSortable(true)
            ,
            TextEditorField::new(ConstantesCrud::COMPANY_PROPERTY_DESC, ConstantesCrud::COMPANY_LABEL_DESC)
                ->hideOnIndex()
            ,
            ImageField::new(ConstantesCrud::COMPANY_PROPERTY_IMG, ConstantesCrud::COMPANY_LABEL_IMG)
                ->setBasePath(self::BASE_PATH)
                ->setUploadDir(self::UPLOAD_DIR)
                ->setUploadedFileNamePattern(ConstantesCrud::COMPANY_PATTERN_IMG)
                ->setRequired(false)
                ->setSortable(false)
                ->setHelp(self::HELP_IMAGE)
                ->setFormTypeOptions([
                    'attr' => [
                        'accept' => self::TYPE_IMAGE,
                    ],
                ])
            ,
            ImageField::new(ConstantesCrud::COMPANY_PROPERTY_BANNER, ConstantesCrud::COMPANY_LABEL_BANNER)
                ->setBasePath(self::BASE_PATH)
                ->setUploadDir(self::UPLOAD_DIR)
                ->setUploadedFileNamePattern(ConstantesCrud::COMPANY_PATTERN_IMG)
                ->setRequired(false)
                ->setSortable(false)
                ->setHelp(self::HELP_IMAGE)
                ->setFormTypeOptions([
                    'attr' => [
                        'accept' => self::TYPE_IMAGE,
                    ],
                ])
            ,

            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_INFOS_PRINCIPALES),
            AssociationField::new(ConstantesCrud::COMPANY_PROPERTY_LOCALISATION, ConstantesCrud::COMPANY_LABEL_LOCALISATION)
                ->setHelp(ConstantesCrud::COMPANY_HELP_LOCALISATION)
                
                // permet de ne pas passer par une requête SQL pour récupérer les emplacements
                ->setFormTypeOptions([
                    'by_reference' => false,
                ])
                ->autocomplete()
            ,
            AssociationField::new(ConstantesCrud::COMPANY_PROPERTY_ACT, ConstantesCrud::COMPANY_LABEL_ACT)
                ->setHelp(ConstantesCrud::COMPANY_HELP_ACT)
                ->setFormTypeOptions([
                    'by_reference' => false,
                ])
                ->autocomplete()
        ];
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Vérifie si l'entité à supprimer est une instance de Company
        if ($entityInstance instanceof Company) {
            $this->supprImage([
                $entityInstance->getImg(),
                $entityInstance->getBanner()
            ]);
        }
        // Appel de la méthode parente pour effectuer la suppression de l'entité
        parent::deleteEntity($entityManager, $entityInstance);
    }
}


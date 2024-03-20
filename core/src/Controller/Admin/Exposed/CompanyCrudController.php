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
            ->setSearchFields(['name'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', ConstantesCrud::SITE_NAME. ' - ' .self::ENTITY_LABEL_IN_PLURAL)
            ->setPaginatorPageSize(15);
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
            TextField::new('name', 'Nom')
                ->setSortable(true)
            ,
            TextEditorField::new('description', 'Description')
                ->hideOnIndex()
            ,
            ImageField::new('img', 'Image')
                ->setBasePath(self::BASE_PATH)
                ->setUploadDir(self::UPLOAD_DIR)
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false)
                ->setSortable(false)
                ->setHelp(self::HELP_IMAGE)
                ->setFormTypeOptions([
                    'attr' => [
                        'accept' => self::TYPE_IMAGE,
                    ],
                ])
            ,
            ImageField::new('banner', 'Bannière')
                ->setBasePath(self::BASE_PATH)
                ->setUploadDir(self::UPLOAD_DIR)
                ->setUploadedFileNamePattern('[randomhash].[extension]')
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
            AssociationField::new('located', 'Emplacements')
                ->setHelp('Sélectionnez les emplacements où l\'entreprise est présente')
                
                // permet de ne pas passer par une requête SQL pour récupérer les emplacements
                ->setFormTypeOptions([
                    'by_reference' => false,
                ])
                ->autocomplete()
            ,
            AssociationField::new('activities', 'Activités')
                ->setHelp('Sélectionnez les activités de l\'entreprise')
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

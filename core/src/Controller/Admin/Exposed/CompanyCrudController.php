<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\AbstractImageCrudController;
use App\Controller\Admin\DashboardController;
use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CompanyCrudController extends AbstractImageCrudController
{

    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Entreprise')
            ->setEntityLabelInPlural('Entreprises')
            ->setSearchFields(['name'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', DashboardController::SITE_NAME . ' - Company')
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name', 'Nom')
                ->setSortable(true),
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
                ]),
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
            TextEditorField::new('description', 'Description')
                ->hideOnIndex(),
            AssociationField::new('located', 'Emplacements'),
            AssociationField::new('activities', 'Activités'),
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

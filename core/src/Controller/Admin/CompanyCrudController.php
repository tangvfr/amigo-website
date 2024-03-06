<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;


class CompanyCrudController extends AbstractCrudController
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
            ->setPageTitle('index', 'Amigo Website - Company')
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom')
                ->setSortable(true),
            ImageField::new('img', 'Image')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            ImageField::new('banner', 'Bannière')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            TextEditorField::new('description', 'Description')
                ->hideOnIndex(),
            AssociationField::new('located', 'Emplacements')
                ->hideOnIndex(),
            AssociationField::new('activities', 'Activités')
                ->hideOnIndex(),
        ];
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Vérifie si l'entité à supprimer est une instance de Company
        if ($entityInstance instanceof Company) {
            $images = [];

            // Récupère les images associées à l'entreprise
            if ($entityInstance->getImg() != null)
                $images[] = $entityInstance->getImg();
            if ($entityInstance->getBanner() != null)
                $images[] = $entityInstance->getBanner();

            // Supprime les images physiques du système de fichiers
            foreach ($images as $image) {
                $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $image;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Appel de la méthode parente pour effectuer la suppression de l'entité
        parent::deleteEntity($entityManager, $entityInstance);
    }
}

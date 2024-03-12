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
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class CompanyCrudController extends AbstractCrudController
{
    private const TYPE_IMAGE = 'image/png,image/gif,image/jpeg,image/webp';
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
                ->setRequired(false)
                ->setSortable(false)
                ->setHelp('jpeg, png, gif de 5Mo')
                ->setFormTypeOptions([
                    'attr' => [
                        'accept' => self::TYPE_IMAGE,
                    ],
                    'constraints' => [
                        new File(
                            maxSize: '1024k',
                            notFoundMessage: 'non',
                            extensions: ['png'],
                            extensionsMessage: 'Please upload a valid PDF',
                        ),
                    ]

                ]),
            ImageField::new('banner', 'Bannière')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false)
                ->setSortable(false)
                // ->setFormTypeOptions([
                //     'constraints' => [
                //         new File([
                //             'maxSize' => '1024k',
                //             'mimeTypes' => [
                //                 'image/jpeg',
                //                 'image/png',
                //                 'image/gif',
                //             ],
                //             'mimeTypesMessage' => 'Veuillez télécharger une image au format JPEG, PNG ou GIF',
                //         ]),
                //         // new Image([
                //         //     'maxWidth' => 1200,
                //         //     'maxHeight' => 1200,
                //         //     'maxWidthMessage' => 'La largeur de l\'image ne doit pas dépasser 1200 pixels',
                //         //     'maxHeightMessage' => 'La hauteur de l\'image ne doit pas dépasser 1200 pixels',
                //         // ]),
                //     ],
                // ])
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

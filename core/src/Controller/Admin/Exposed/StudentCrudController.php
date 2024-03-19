<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\AbstractImageCrudController;
use App\Controller\Admin\DashboardController;
use App\Entity\Company;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StudentCrudController extends AbstractImageCrudController
{
    public static function getEntityFqcn(): string
    {
        return Student::class;
    }

    public function configureCrud(Crud $crud) : Crud
    {
        return $crud
            ->setEntityLabelInSingular('Étudiant')
            ->setEntityLabelInPlural('Étudiants')
            ->setSearchFields(['name', 'studentNumber'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', DashboardController::SITE_NAME.' - Student')
            ->setPaginatorPageSize(10)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('studentNumber', 'Numéro étudiant')
                ->setSortable(true),
            TextField::new('name', 'Prénom')
                ->setSortable(true),
            TextField::new('lastName', 'Nom')
                ->setSortable(true),
            TextField::new('email', 'Email')
                ->setSortable(true)
                ->hideOnIndex(),
            ChoiceField::new('level', 'Niveau de formation'),
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
        ];
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Appel de la méthode parente pour effectuer la suppression de l'entité
        parent::deleteEntity($entityManager, $entityInstance);
    }
}

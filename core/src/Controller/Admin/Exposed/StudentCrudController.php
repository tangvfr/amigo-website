<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\AbstractImageCrudController;
use App\Controller\Admin\DashboardController;
use App\Entity\Company;
use App\Entity\Student;
use App\Entity\StudentType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
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
            IdField::new('id')
            ->hideOnIndex()
            ->hideOnForm()
            ,

            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('INFORMATIONS PRINCIPALES'),
            TextField::new('studentNumber', 'Numéro étudiant')
                ->setSortable(true)
            ,
            TextField::new('name', 'Prénom')
                ->setSortable(true)
            ,
            TextField::new('lastName', 'Nom')
                ->setSortable(true)
            ,
            ChoiceField::new('level', 'Niveau de formation')
                ->setChoices([
                    'Étudiants en M2' => StudentType::M2,
                    'Étudiants en M1' => StudentType::M1,
                    'Étudiants en L3' => StudentType::L3,
                    'Diplomés' => StudentType::WORKER,
                    'Autre' => StudentType::OTHER
                ])
            ,
            TextField::new('email', 'Email')
                ->setSortable(true)
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

            //champs d'informations
            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('HISTORIQUE')
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

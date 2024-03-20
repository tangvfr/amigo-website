<?php

namespace App\Controller\Admin\Office;

use App\Controller\Admin\BgedDateField;
use App\Controller\Admin\DashboardController;
use App\Entity\Mandate;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class MandateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mandate::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Mandat')
            ->setEntityLabelInPlural('Mandats')
            ->setSearchFields(['name'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', DashboardController::SITE_NAME.' - Mandate')
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

            //champs editable
            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('INFORMATIONS PRINCIPALES'),
            AssociationField::new('student', 'Étudiant'),
            AssociationField::new('roles', 'Rôles'),
            DateTimeField::new('bgedDate.beginDate', 'Début du mandat'),
            DateTimeField::new('bgedDate.endDate', 'Fin du mandat'),
            BooleanField::new('visible', 'Visible')
                ->hideOnIndex()
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

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::deleteEntity($entityManager, $entityInstance);
    }
}

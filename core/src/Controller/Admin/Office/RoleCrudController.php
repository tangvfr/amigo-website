<?php

namespace App\Controller\Admin\Office;

use App\Controller\Admin\DashboardController;
use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RoleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Role::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Role')
            ->setEntityLabelInPlural('Roles')
            ->setSearchFields(['name'])
            ->setDefaultSort(['priority' => 'DESC'])
            ->setPageTitle('index', DashboardController::SITE_NAME.' - Role')
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

            FormField::addColumn('col-lg-8 col-xl-8'),
            FormField::addPanel('INFORMATIONS PRINCIPALES'),
            TextField::new('name', 'Nom')
                ->setSortable(true)
            ,
            AssociationField::new('hub', 'Pole'),
            IntegerField::new('priority', 'Priorité')
                ->hideOnIndex()
        ];
    }
}

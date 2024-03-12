<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class EventCrudController extends AbstractImageCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Evenement')
            ->setEntityLabelInPlural('Evenements')
            ->setSearchFields(['name'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setDateFormat('dd/MM/yyyy')
            ->setPageTitle('index', 'Amigo Website - Event');
    }


    public function configureFields(string $pageName): iterable
    {
        // 14 écrit dans la classe
        // 13
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->setFormTypeOptions(['disable']),
            TextField::new('name', 'Nom'),
            ImageField::new('img', 'Image')
                ->setBasePath(self::BASE_PATH)
                ->setUploadDir(self::UPLOAD_DIR),
            TextEditorField::new('description', 'Description'),
            BooleanField::new('onlyMiagist', 'Réserver aux miagiste'),
            ChoiceField::new('note')
                ->setChoices([1,2,3,4,5]),

            // ARGENT
            MoneyField::new('nadhPrice', 'Prix Non Adhérant')
                ->setCurrency('EUR'),
            MoneyField::new('adhPrice', 'Prix Adhérant')
                ->setCurrency('EUR'),

            // QUOTA
            IntegerField::new('quotaStu', 'Quota d\'éleve'),
            IntegerField::new('quotaComp', 'Quota complet'),


            AssociationField::new('types'),
            AssociationField::new('situated', 'Localisation de l\'event'),

            // DATE
            DateTimeField::new('bgedDate', 'Date de début')
                ->setFormTypeOptions(['disable'])
                ->renderAsNativeWidget(false),


            BooleanField::new('cancel', 'Annuler'),

        ];
    }

}

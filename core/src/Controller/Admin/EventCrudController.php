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
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Provider\FieldProvider;


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
        // 14
        $var = 'hidden';
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm(),

            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('INFORMATIONS PRINCIPALE'),
            TextField::new('name', 'Nom'),
            TextEditorField::new('description', 'Description'),
            BooleanField::new('cancel', 'Annuler'),

            // DATE * 5
            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('DATE'),
            DateTimeField::new('bgedDate.beginDate', 'Début de l\'événement')
                ->hideOnIndex(),
            DateTimeField::new('bgedDate.endDate', 'Fin de l\'événement')
                ->hideOnIndex(),
            DateTimeField::new('publicationDate', 'Date de publication de l\'évenement')
                ->hideOnIndex(),

            // pas besoins de les afficher mais ils existent
            DateTimeField::new('CreationDate', 'CD')
                ->hideOnIndex()
                ->hideOnForm(),
            DateTimeField::new('lastEditDate', 'LED')
                ->hideOnIndex()
                ->hideOnForm(),


            // BANNIERE
            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('BANNIERE'),
            ImageField::new('img', 'Image')
                ->setBasePath(self::BASE_PATH)
                ->setUploadDir(self::UPLOAD_DIR),
            ChoiceField::new('note')
                ->setChoices([0,1,2,3,4,5]),

            // ARGENT
            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('ARGENT'),
            BooleanField::new('onlyMiagist', 'Réserver aux miagiste'),
            MoneyField::new('adhPrice', 'Prix Adhérant')
                ->setCurrency('EUR'),
            MoneyField::new('nadhPrice', 'Prix Non Adhérant')
                ->setCurrency('EUR')

                // ne marche pas
                ->setCustomOption('conditionalVisibility', [
                    'depends_on' => 'entity.onlyMiagist',
                    'values' => [false],
                ]),

            // QUOTA
            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('QUOTA'),
            IntegerField::new('quotaStu', 'Quota d\'éleve'),
            IntegerField::new('quotaComp', 'Quota complet'),

            // Information sur l'evenement
            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('INFO'),
            AssociationField::new('types'),
            AssociationField::new('situated', 'Localisation de l\'event'),








        ];
    }

}

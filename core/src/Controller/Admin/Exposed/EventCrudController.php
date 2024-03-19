<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\AbstractImageCrudController;
use App\Controller\Admin\DashboardController;
use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class EventCrudController extends AbstractImageCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Évènement')
            ->setEntityLabelInPlural('Évènements')
            ->setSearchFields(['name'])
            ->setDefaultSort(['creationDate' => 'DESC'])
            ->setDateFormat('dd/MM/yyyy')
            ->setPageTitle('index', DashboardController::SITE_NAME . ' - Event');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm(),

            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('INFORMATIONS PRINCIPALE'),
            TextField::new('name', 'Nom'),
            TextEditorField::new('description', 'Description')
                ->hideOnIndex(),
            BooleanField::new('cancel', 'Annuler')
                ->hideOnIndex(),
            // pas besoins de les afficher mais ils existent
            DateTimeField::new('creationDate', 'Date de création')
                ->hideOnIndex()
                ->setRequired(false)
                ->setDisabled()
            ,
            DateTimeField::new('lastEditDate', 'Dernière modification')
                ->hideOnIndex()
                ->setFormTypeOptions(['disabled' => 'disabled'])
            ,

            // DATE * 5
            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('DATE'),
            DateTimeField::new('bgedDate.beginDate', 'Début de l\'événement')
                ->hideOnIndex(),
            DateTimeField::new('bgedDate.endDate', 'Fin de l\'événement')
                ->setHelp('Si Début de l\'événement non rempli, début de l\'evenement = fin de l\'événement')
            ,
            DateTimeField::new('publicationDate', 'Date de publication de l\'évenement')
                ->hideOnIndex(),

            // BANNIERE
            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('BANNIERE'),
            ImageField::new('img', 'Image')
                ->hideOnIndex()
                ->setBasePath(self::BASE_PATH)
                ->setUploadDir(self::UPLOAD_DIR),
            ChoiceField::new('note')
                ->setHelp('Qualité de l\'affiche')
                ->setChoices([
                    'Cacher / Inregardable' => 0,
                    'Très insatisfaits' => 1,
                    'Insatisfaits' => 2,
                    'Neutre' => 3,
                    'Satisfait' => 4,
                    'Très satisfait' => 5,
                ]),

            // ARGENT
            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('ARGENT'),
            BooleanField::new('onlyMiagist', 'Réserver aux miagiste'),
            MoneyField::new('adhPrice', 'Prix Adhérant')
                ->setCurrency('EUR'),
            MoneyField::new('nadhPrice', 'Prix Non Adhérant')
                ->setCurrency('EUR'),

            // QUOTA
            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('QUOTA'),
            IntegerField::new('quotaStu', 'Quota d\'éleve')
                ->hideOnIndex(),
            IntegerField::new('quotaComp', 'Quota d\'entreprise')
                ->hideOnIndex(),

            // Information sur l'evenement
            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('INFO'),
            AssociationField::new('types')
                ->hideOnIndex(),
            AssociationField::new('situated', 'Localisation de l\'event')
                ->hideOnIndex(),
        ];
    }

//    public function createEntity(string $entityFqcn)
//    {
//        // modification déjà dans la BD
//        $event = new $entityFqcn();
//        $event->setCreationDate(new \DateTimeImmutable());
//        $event->setLastEditDate(new \DateTimeImmutable());
//        return $event;
//    }

//    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
//    {
//        // modification déjà dans la BD
//        $entityInstance->setLastEditDate(new \DateTimeImmutable());
//
//        if ($entityInstance->getQuotaStu()<0){
//            $entityInstance->setQuotaStu($entityInstance->getQuotaStu()*-1);
//        }
//
//        parent::updateEntity($entityManager, $entityInstance);
//    }

}

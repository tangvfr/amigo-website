<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\AbstractImageCrudController;
use App\Controller\Admin\ConstantesCrud;
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
    private const ENTITY_LABEL_IN_SINGULAR = 'Évènement';
    private const ENTITY_LABEL_IN_PLURAL = 'Évènements';

    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular(self::ENTITY_LABEL_IN_SINGULAR)
            ->setEntityLabelInPlural(self::ENTITY_LABEL_IN_PLURAL)
            ->setSearchFields(['name'])
            ->setDefaultSort(['creationDate' => 'DESC'])
            ->setPageTitle('index', ConstantesCrud::SITE_NAME . ' - ' . self::ENTITY_LABEL_IN_PLURAL)
            ->setPaginatorPageSize(15)
            ->setDateFormat(DateTimeField::FORMAT_SHORT);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm()
            ,

            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_INFOS_PRINCIPALES),
            TextField::new('name', 'Nom'),
            TextEditorField::new('description', 'Description')
                ->hideOnIndex()
            ,
            BooleanField::new('cancel', 'Annuler')
                ->hideOnIndex()
            ,

            // DATE * 5
            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_DATES),
            DateTimeField::new('bgedDate.beginDate', 'Début de l\'évènement')
                ->hideOnIndex(),
            DateTimeField::new('bgedDate.endDate', 'Fin de l\'évènement')
                ->setHelp('Si début de l\'évènement non rempli, début de l\'évènement = fin de l\'évènement')
            ,
            DateTimeField::new('publicationDate', 'Date de publication de l\'évènement')
                ->hideOnIndex()
            ,

            // BANNIERE
            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_POSTER),
            ImageField::new('img', 'Image')
                ->hideOnIndex()
                ->setBasePath(self::BASE_PATH)
                ->setUploadDir(self::UPLOAD_DIR)
            ,
            ChoiceField::new('note')
                ->setHelp('Qualité de l\'affiche')
                ->setChoices([
                    'Cacher / Irregardable' => 0,
                    'Très insatisfait' => 1,
                    'Insatisfait' => 2,
                    'Neutre' => 3,
                    'Satisfait' => 4,
                    'Très satisfait' => 5,
                ])
            ,

            // ARGENT
            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_PRIX),
            BooleanField::new('onlyMiagist', 'Réservé aux miagiste'),
            MoneyField::new('adhPrice', 'Prix Adhérants')
                ->setCurrency('EUR')
            ,
            MoneyField::new('nadhPrice', 'Prix Non Adhérants')
                ->setCurrency('EUR')
            ,

            // QUOTA
            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_QUOTAS),
            IntegerField::new('quotaStu', 'Quotas étudiants')
                ->hideOnIndex()
            ,
            IntegerField::new('quotaComp', 'Quotas entreprises')
                ->hideOnIndex()
            ,

            // Information sur l'evenement
            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_QUOTAS),
            AssociationField::new('types')
                ->hideOnIndex()
            ,
            AssociationField::new('situated', 'Localisation de l\'évènement')
                ->hideOnIndex()
            ,

            //champs informatifs
            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel(ConstantesCrud::PANEL_NAME_HISTORIQUE)
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

<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\ConstantesCrud;
use App\Entity\Location;
use App\Service\GeocodeServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use EasyCorp\Bundle\EasyAdminBundle\Exception\InsufficientEntityPermissionException;
use EasyCorp\Bundle\EasyAdminBundle\Factory\EntityFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class LocationCrudController extends AbstractCrudController
{
    private const ENTITY_LABEL_IN_SINGULAR = 'Localisation';
    private const ENTITY_LABEL_IN_PLURAL = 'Localisations';

    public function __construct(
        private readonly GeocodeServiceInterface $geocodeService,
        private readonly TranslatorInterface $translator
    )
    {
    }

    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular(self::ENTITY_LABEL_IN_SINGULAR)
            ->setEntityLabelInPlural(self::ENTITY_LABEL_IN_PLURAL)
            ->setSearchFields(['label'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', ConstantesCrud::SITE_NAME . ' - ' . self::ENTITY_LABEL_IN_PLURAL)
            ->setPaginatorPageSize(20)
            ->overrideTemplate('crud/edit', 'pages/admin/Exposed/location_edit.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('1'),
            FormField::addPanel('NOM'),
            TextField::new('label'),

            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel('ADRESSE'),
            TextField::new('adresse', 'Adresse'),
            NumberField::new('postalCode', 'Code postal'),
            TextField::new('city', 'Ville')
                ->setRequired(true),
            TextField::new('country', 'Pays')
                ->setRequired(true),

            FormField::addColumn(ConstantesCrud::PANEL_COLUMN_MOITIE_ECRAN),
            FormField::addPanel('MAPS'),
            NumberField::new('latitude')
                ->hideOnIndex()
                ->setNumDecimals(12)
                ->setRequired(false)
                ->setHelp('La latitude et la longitude seront automatiquement mises à jour en fonction de l\'adresse, de la ville et du pays.'),
            NumberField::new('longitude')
                ->hideOnIndex()
                ->setNumDecimals(12)
                ->setRequired(false)
                ->setHelp('La latitude et la longitude seront automatiquement mises à jour en fonction de l\'adresse, de la ville et du pays.'),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->modificationLatitudeLongitude($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function new(AdminContext $context): KeyValueStore|RedirectResponse|Response
    {
        $event = new BeforeCrudActionEvent($context);
        $this->container->get('event_dispatcher')->dispatch($event);
        if ($event->isPropagationStopped()) {
            return $event->getResponse();
        }

        if (!$this->isGranted(Permission::EA_EXECUTE_ACTION, ['action' => Action::NEW, 'entity' => null])) {
            throw new ForbiddenActionException($context);
        }

        if (!$context->getEntity()->isAccessible()) {
            throw new InsufficientEntityPermissionException($context);
        }

        $context->getEntity()->setInstance($this->createEntity($context->getEntity()->getFqcn()));
        $this->container->get(EntityFactory::class)->processFields($context->getEntity(), FieldCollection::new($this->configureFields(Crud::PAGE_NEW)));
        $context->getCrud()->setFieldAssets($this->getFieldAssets($context->getEntity()->getFields()));
        $this->container->get(EntityFactory::class)->processActions($context->getEntity(), $context->getCrud()->getActionsConfig());

        $newForm = $this->createNewForm($context->getEntity(), $context->getCrud()->getNewFormOptions(), $context);
        $newForm->handleRequest($context->getRequest());

        $entityInstance = $newForm->getData();
        $context->getEntity()->setInstance($entityInstance);

        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $this->processUploadedFiles($newForm);

            $event = new BeforeEntityPersistedEvent($entityInstance);
            $this->container->get('event_dispatcher')->dispatch($event);
            $entityInstance = $event->getEntityInstance();

            // code ajouter
            $entityInstance = $this->modificationLatitudeLongitude($entityInstance);

            $this->persistEntity($this->container->get('doctrine')->getManagerForClass($context->getEntity()->getFqcn()), $entityInstance);

            $this->container->get('event_dispatcher')->dispatch(new AfterEntityPersistedEvent($entityInstance));
            $context->getEntity()->setInstance($entityInstance);

            return $this->getRedirectResponseAfterSave($context, Action::NEW);
        }

        $responseParameters = $this->configureResponseParameters(KeyValueStore::new([
            'pageName' => Crud::PAGE_NEW,
            'templateName' => 'crud/new',
            'entity' => $context->getEntity(),
            'new_form' => $newForm,
        ]));

        $event = new AfterCrudActionEvent($context, $responseParameters);
        $this->container->get('event_dispatcher')->dispatch($event);
        if ($event->isPropagationStopped()) {
            return $event->getResponse();
        }

        return $responseParameters;
    }

    public function modificationLatitudeLongitude(Location $entityInstance): Location
    {
        $city = $entityInstance->getCity();
        $country = $entityInstance->getCountry();

        if ($city != null && $country != null) {
            $jsonString = $this->geocodeService->geocodeLoc($entityInstance);

            // Convertir la chaîne JSON en tableau PHP
            $data = json_decode($jsonString, true);

            // Vérifier si le décodage a réussi
            if ($data === null) {
                // Gestion de l'erreur de décodage JSON
                die('Erreur lors du décodage JSON.');
            }
            if (!empty($data)){
                $latitude = $data[0]['lat'];
                $longitude = $data[0]['lon'];
                $entityInstance->setLatitude($latitude);
                $entityInstance->setLongitude($longitude);
            }
            else {
                $this->addFlashError('Les latitudes, longitude n\'ont pas pu être trouvé pour votre adresse');
            }
        }
        return $entityInstance;
    }

    // Ajoutez cette méthode pour afficher un message d'erreur personnalisé
    protected function addFlashError(string $message, array $parameters = []): void
    {
        $this->addFlash('error', $this->translator->trans($message, $parameters));
    }
}

<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\DashboardController;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
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
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


class LocationCrudController extends AbstractCrudController
{
    private const ENTITY_LABEL_IN_SINGULAR = 'Localisation';
    private const ENTITY_LABEL_IN_PLURAL = 'Localisations';

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
            ->setPageTitle('index', DashboardController::SITE_NAME . ' - ' . self::ENTITY_LABEL_IN_PLURAL)
            ->setPaginatorPageSize(20);

    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('1'),
            FormField::addPanel('NOM'),
            TextField::new('label'),

            FormField::addColumn(DashboardController::PANEL_COLUMN_MOITIER_ECRAN),
            FormField::addPanel('ADRESSE'),
            CountryField::new('country'),
            TextField::new('city'),
            NumberField::new('postalCode'),
            TextField::new('adresse'),

            FormField::addColumn(DashboardController::PANEL_COLUMN_MOITIER_ECRAN),
            FormField::addPanel('MAPS'),
            NumberField::new('latitude')
                ->hideOnIndex()
                ->setNumDecimals(7)
                ->setRequired(false),
            NumberField::new('longitude')
                ->hideOnIndex()
                ->setNumDecimals(7)
                ->setRequired(false),
        ];
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->modificationLatitudeLongitude($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }


    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function new(AdminContext $context): \EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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

        // RAJOUT de la latitude et longitude si elles ne sont pas vide
        try{
            $instance = $this->modificationLatitudeLongitude($context->getEntity()->getInstance());
            $context->getEntity()->setInstance($instance);
        } catch (GuzzleException $e){
            // TODO mettre un pop up
        } catch (Exception $e) {
            // TODO mettre un pop up
        }


        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $this->processUploadedFiles($newForm);

            $event = new BeforeEntityPersistedEvent($entityInstance);
            $this->container->get('event_dispatcher')->dispatch($event);
            $entityInstance = $event->getEntityInstance();

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


    /**
     * @throws Exception|GuzzleException
     */
    public function modificationLatitudeLongitude(Location $entityInstance): Location
    {
        $adresse = $entityInstance->getAdresse();
        $city = $entityInstance->getCity();
        $country = $entityInstance->getCountry();
        $postalCode = $entityInstance->getPostalCode();


        if ($entityInstance->getLatitude() != null && $entityInstance->getLongitude() != null){
            dump($city);
            exit();
            if ($postalCode != null){
                $adresse_sans_espace = str_replace(' ', '+', $adresse);
                $url = "http://localhost:8000/geocode/api?query={$adresse_sans_espace}+{$city}+{$postalCode}+{$country}";

                $client = new Client();
                $response = $client->request('GET', $url);

                if ($response->getStatusCode() == 200) {
                    $body = $response->getBody();
                    $data = json_decode($body, true);
                    // Traitez les données de réponse...
                    if (!empty($data)) {
                        $latitude = $data[0]['latitude'];
                        $longitude = $data[0]['longitude'];
                        // Utilisez les coordonnées géographiques récupérées...
                        $entityInstance->setLatitude($latitude);
                        $entityInstance->setLongitude($longitude);
                    } else {
                        // Gestion de l'adresse non trouvée...
                    }
                } else {
                    // Gestion des erreurs de requête HTTP...
                    throw new Exception("Erreur lors de la requête HTTP : {$response->getStatusCode()} - {$response->getReasonPhrase()}");
                }
            }
        }
        return $entityInstance;
    }
}

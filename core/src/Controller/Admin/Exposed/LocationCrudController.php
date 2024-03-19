<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\DashboardController;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


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
    public function modificationLatitudeLongitude($entityInstance): void
    {
        $adresse = $entityInstance->getAdresse();
        $city = $entityInstance->getCity();
        $country = $entityInstance->getCountry();
        $postalCode = $entityInstance->getPostalCode();

        if ($entityInstance->getLatitude() != null && $entityInstance->getLongitude() != null){
            if ($postalCode != null){
                $url = "http://localhost:8000/geocode/api?query={$postalCode}";

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
    }


    /**
     * @throws Exception|GuzzleException
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->modificationLatitudeLongitude($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function createEntity(string $entityFqcn)
    {
        return parent::createEntity($entityFqcn); // TODO: Change the autogenerated stub
    }

}

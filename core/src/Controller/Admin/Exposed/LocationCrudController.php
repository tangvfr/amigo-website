<?php

namespace App\Controller\Admin\Exposed;

use App\Controller\Admin\DashboardController;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
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
                ->setNumDecimals(7),
            NumberField::new('longitude')
                ->hideOnIndex()
                ->setNumDecimals(7),
        ];
    }

    /**
     * @throws Exception
     * @throws GuzzleException
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $adresse = $entityInstance->getAdresse();
        $city = $entityInstance->getCity();
        $country = $entityInstance->getCountry();
        $postalCode = $entityInstance->getPostalCode();
        $client = new Client();

        if ($entityInstance->getLongitude() == null || $entityInstance->getLatitude() == null && $adresse != null) {
            $response = $client->request('GET', "http://nominatim.openstreetmap.org/search?format=json&limit=1&q={$adresse}{$city}, {$postalCode}, {$country}");

            if ($response->getStatusCode() == 200) {
                $body = $response->getBody();
                $data = json_decode($body, true);
                // Traitez les données de réponse...
                if (!empty($data)) {
                    $latitude = $data[0]['lat'];
                    $longitude = $data[0]['lon'];
                    // Utilisez les coordonnées géographiques récupérées...
                    $entityInstance->setLatitude($latitude);
                    $entityInstance->setLongitude($longitude);
                } else {
                    throw new Exception("Adresse invalide ou introuvable : {$adresse}");
                }
            } else {
                // Gestion des erreurs de requête HTTP...
                throw new Exception("erreur HTTP : {$response->getStatusCode()}");
            }
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

}

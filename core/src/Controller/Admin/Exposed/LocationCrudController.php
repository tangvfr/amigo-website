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
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Location')
            ->setEntityLabelInPlural('Locations')
            ->setSearchFields(['label'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', DashboardController::SITE_NAME . ' - Location');

    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm(),
            FormField::addColumn('1'),
            FormField::addPanel('NOM'),
            TextField::new('label'),

            FormField::addColumn('col-lg-8 col-xl-6'),
            FormField::addPanel('ADRESSE'),
            CountryField::new('country'),
            TextField::new('city'),
            NumberField::new('postalCode'),
            TextField::new('adresse'),

            FormField::addColumn('col-lg-8 col-xl-6'),
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

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240227005852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, img VARCHAR(255) DEFAULT NULL, banner VARCHAR(255) DEFAULT NULL, description CLOB NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094F5E237E06 ON company (name)');
        $this->addSql('CREATE TABLE company_location (company_id INTEGER NOT NULL, location_id INTEGER NOT NULL, PRIMARY KEY(company_id, location_id), CONSTRAINT FK_46099CA6979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_46099CA664D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_46099CA6979B1AD6 ON company_location (company_id)');
        $this->addSql('CREATE INDEX IDX_46099CA664D218E ON company_location (location_id)');
        $this->addSql('CREATE TABLE company_company_type (company_id INTEGER NOT NULL, company_type_id INTEGER NOT NULL, PRIMARY KEY(company_id, company_type_id), CONSTRAINT FK_317E8709979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_317E8709E51E9644 FOREIGN KEY (company_type_id) REFERENCES company_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_317E8709979B1AD6 ON company_company_type (company_id)');
        $this->addSql('CREATE INDEX IDX_317E8709E51E9644 ON company_company_type (company_type_id)');
        $this->addSql('CREATE TABLE company_type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CFB34DC7EA750E8 ON company_type (label)');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, creation_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , last_edit_date DATETIME DEFAULT NULL, publication_date DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, img VARCHAR(255) DEFAULT NULL, description CLOB NOT NULL, only_miagist BOOLEAN NOT NULL, nadh_price NUMERIC(10, 2) DEFAULT NULL, adh_price NUMERIC(10, 2) NOT NULL, quota_stu INTEGER DEFAULT NULL, quota_comp INTEGER DEFAULT NULL, note INTEGER NOT NULL, cancel BOOLEAN NOT NULL, begin_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE event_event_type (event_id INTEGER NOT NULL, event_type_id INTEGER NOT NULL, PRIMARY KEY(event_id, event_type_id), CONSTRAINT FK_CBFBC2AD71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CBFBC2AD401B253C FOREIGN KEY (event_type_id) REFERENCES event_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CBFBC2AD71F7E88B ON event_event_type (event_id)');
        $this->addSql('CREATE INDEX IDX_CBFBC2AD401B253C ON event_event_type (event_type_id)');
        $this->addSql('CREATE TABLE event_location (event_id INTEGER NOT NULL, location_id INTEGER NOT NULL, PRIMARY KEY(event_id, location_id), CONSTRAINT FK_1872601B71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1872601B64D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_1872601B71F7E88B ON event_location (event_id)');
        $this->addSql('CREATE INDEX IDX_1872601B64D218E ON event_location (location_id)');
        $this->addSql('CREATE TABLE event_type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(255) NOT NULL, description CLOB NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_93151B82EA750E8 ON event_type (label)');
        $this->addSql('CREATE TABLE hub (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL)');
        $this->addSql('CREATE TABLE location (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(5) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E9E89CBEA750E8 ON location (label)');
        $this->addSql('CREATE TABLE mandate (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, student_id INTEGER NOT NULL, creation_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , last_edit_date DATETIME DEFAULT NULL, visible BOOLEAN NOT NULL, begin_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, CONSTRAINT FK_197D0FEECB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_197D0FEECB944F1A ON mandate (student_id)');
        $this->addSql('CREATE TABLE mandate_role (mandate_id INTEGER NOT NULL, role_id INTEGER NOT NULL, PRIMARY KEY(mandate_id, role_id), CONSTRAINT FK_2E2C1826C1129CD FOREIGN KEY (mandate_id) REFERENCES mandate (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2E2C182D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_2E2C1826C1129CD ON mandate_role (mandate_id)');
        $this->addSql('CREATE INDEX IDX_2E2C182D60322AC ON mandate_role (role_id)');
        $this->addSql('CREATE TABLE offer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, provide_id INTEGER NOT NULL, creation_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , last_edit_date DATETIME DEFAULT NULL, publication_date DATETIME DEFAULT NULL, label VARCHAR(255) NOT NULL, description CLOB NOT NULL, end_provid_date DATE NOT NULL, key_words CLOB NOT NULL --(DC2Type:simple_array)
        , begin_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, CONSTRAINT FK_29D6873E9B54C5B7 FOREIGN KEY (provide_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_29D6873E9B54C5B7 ON offer (provide_id)');
        $this->addSql('CREATE TABLE partner (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, company_id INTEGER NOT NULL, creation_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , last_edit_date DATETIME DEFAULT NULL, publication_date DATETIME DEFAULT NULL, challenge BOOLEAN NOT NULL, advantages CLOB DEFAULT NULL, begin_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, CONSTRAINT FK_312B3E16979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_312B3E16979B1AD6 ON partner (company_id)');
        $this->addSql('CREATE TABLE role (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, hub_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_57698A6A6C786081 FOREIGN KEY (hub_id) REFERENCES hub (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_57698A6A6C786081 ON role (hub_id)');
        $this->addSql('CREATE TABLE student (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, creation_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , last_edit_date DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, img VARCHAR(255) DEFAULT NULL, student_number VARCHAR(10) NOT NULL, email VARCHAR(255) NOT NULL, level VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE company_location');
        $this->addSql('DROP TABLE company_company_type');
        $this->addSql('DROP TABLE company_type');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_event_type');
        $this->addSql('DROP TABLE event_location');
        $this->addSql('DROP TABLE event_type');
        $this->addSql('DROP TABLE hub');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE mandate');
        $this->addSql('DROP TABLE mandate_role');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

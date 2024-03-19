<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319174310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE app_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE company_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE company_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE hub_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE location_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mandate_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE offer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE partner_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE student_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE app_user (id INT NOT NULL, student_id INT DEFAULT NULL, roles JSON NOT NULL, login VARCHAR(10) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9AA08CB10 ON app_user (login)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9CB944F1A ON app_user (student_id)');
        $this->addSql('CREATE TABLE company (id INT NOT NULL, name VARCHAR(255) NOT NULL, img VARCHAR(255) DEFAULT NULL, banner VARCHAR(255) DEFAULT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094F5E237E06 ON company (name)');
        $this->addSql('CREATE TABLE company_location (company_id INT NOT NULL, location_id INT NOT NULL, PRIMARY KEY(company_id, location_id))');
        $this->addSql('CREATE INDEX IDX_46099CA6979B1AD6 ON company_location (company_id)');
        $this->addSql('CREATE INDEX IDX_46099CA664D218E ON company_location (location_id)');
        $this->addSql('CREATE TABLE company_company_type (company_id INT NOT NULL, company_type_id INT NOT NULL, PRIMARY KEY(company_id, company_type_id))');
        $this->addSql('CREATE INDEX IDX_317E8709979B1AD6 ON company_company_type (company_id)');
        $this->addSql('CREATE INDEX IDX_317E8709E51E9644 ON company_company_type (company_type_id)');
        $this->addSql('CREATE TABLE company_type (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CFB34DC7EA750E8 ON company_type (label)');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, last_edit_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, publication_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(255) NOT NULL, img VARCHAR(255) DEFAULT NULL, description TEXT NOT NULL, only_miagist BOOLEAN NOT NULL, nadh_price NUMERIC(10, 2) DEFAULT NULL, adh_price NUMERIC(10, 2) DEFAULT NULL, quota_stu INT DEFAULT NULL, quota_comp INT DEFAULT NULL, note INT NOT NULL, cancel BOOLEAN NOT NULL, begin_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN event.creation_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE event_event_type (event_id INT NOT NULL, event_type_id INT NOT NULL, PRIMARY KEY(event_id, event_type_id))');
        $this->addSql('CREATE INDEX IDX_CBFBC2AD71F7E88B ON event_event_type (event_id)');
        $this->addSql('CREATE INDEX IDX_CBFBC2AD401B253C ON event_event_type (event_type_id)');
        $this->addSql('CREATE TABLE event_location (event_id INT NOT NULL, location_id INT NOT NULL, PRIMARY KEY(event_id, location_id))');
        $this->addSql('CREATE INDEX IDX_1872601B71F7E88B ON event_location (event_id)');
        $this->addSql('CREATE INDEX IDX_1872601B64D218E ON event_location (location_id)');
        $this->addSql('CREATE TABLE event_type (id INT NOT NULL, label VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_93151B82EA750E8 ON event_type (label)');
        $this->addSql('CREATE TABLE hub (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, priority INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4871CE4D5E237E06 ON hub (name)');
        $this->addSql('CREATE TABLE location (id INT NOT NULL, label VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, country VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(6) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E9E89CBEA750E8 ON location (label)');
        $this->addSql('CREATE TABLE mandate (id INT NOT NULL, student_id INT NOT NULL, creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, last_edit_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, visible BOOLEAN NOT NULL, begin_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_197D0FEECB944F1A ON mandate (student_id)');
        $this->addSql('COMMENT ON COLUMN mandate.creation_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE mandate_role (mandate_id INT NOT NULL, role_id INT NOT NULL, PRIMARY KEY(mandate_id, role_id))');
        $this->addSql('CREATE INDEX IDX_2E2C1826C1129CD ON mandate_role (mandate_id)');
        $this->addSql('CREATE INDEX IDX_2E2C182D60322AC ON mandate_role (role_id)');
        $this->addSql('CREATE TABLE offer (id INT NOT NULL, provider_id INT NOT NULL, creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, last_edit_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, publication_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, label VARCHAR(255) NOT NULL, description TEXT NOT NULL, end_provid_date DATE NOT NULL, key_words TEXT NOT NULL, begin_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_29D6873EA53A8AA ON offer (provider_id)');
        $this->addSql('COMMENT ON COLUMN offer.creation_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN offer.key_words IS \'(DC2Type:simple_array)\'');
        $this->addSql('CREATE TABLE partner (id INT NOT NULL, company_id INT NOT NULL, creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, last_edit_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, publication_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, challenge BOOLEAN NOT NULL, advantages TEXT DEFAULT NULL, begin_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_312B3E16979B1AD6 ON partner (company_id)');
        $this->addSql('COMMENT ON COLUMN partner.creation_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE role (id INT NOT NULL, hub_id INT NOT NULL, name VARCHAR(255) NOT NULL, priority INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_57698A6A6C786081 ON role (hub_id)');
        $this->addSql('CREATE TABLE student (id INT NOT NULL, creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, last_edit_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, img VARCHAR(255) DEFAULT NULL, student_number VARCHAR(10) NOT NULL, email VARCHAR(255) NOT NULL, level VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B723AF3318A6C7D4 ON student (student_number)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B723AF33E7927C74 ON student (email)');
        $this->addSql('COMMENT ON COLUMN student.creation_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE app_user ADD CONSTRAINT FK_88BDF3E9CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_location ADD CONSTRAINT FK_46099CA6979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_location ADD CONSTRAINT FK_46099CA664D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_company_type ADD CONSTRAINT FK_317E8709979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_company_type ADD CONSTRAINT FK_317E8709E51E9644 FOREIGN KEY (company_type_id) REFERENCES company_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_event_type ADD CONSTRAINT FK_CBFBC2AD71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_event_type ADD CONSTRAINT FK_CBFBC2AD401B253C FOREIGN KEY (event_type_id) REFERENCES event_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_location ADD CONSTRAINT FK_1872601B71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_location ADD CONSTRAINT FK_1872601B64D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mandate ADD CONSTRAINT FK_197D0FEECB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mandate_role ADD CONSTRAINT FK_2E2C1826C1129CD FOREIGN KEY (mandate_id) REFERENCES mandate (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mandate_role ADD CONSTRAINT FK_2E2C182D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EA53A8AA FOREIGN KEY (provider_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E16979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6A6C786081 FOREIGN KEY (hub_id) REFERENCES hub (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE app_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE company_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE company_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE hub_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE location_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mandate_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE partner_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE role_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE student_id_seq CASCADE');
        $this->addSql('ALTER TABLE app_user DROP CONSTRAINT FK_88BDF3E9CB944F1A');
        $this->addSql('ALTER TABLE company_location DROP CONSTRAINT FK_46099CA6979B1AD6');
        $this->addSql('ALTER TABLE company_location DROP CONSTRAINT FK_46099CA664D218E');
        $this->addSql('ALTER TABLE company_company_type DROP CONSTRAINT FK_317E8709979B1AD6');
        $this->addSql('ALTER TABLE company_company_type DROP CONSTRAINT FK_317E8709E51E9644');
        $this->addSql('ALTER TABLE event_event_type DROP CONSTRAINT FK_CBFBC2AD71F7E88B');
        $this->addSql('ALTER TABLE event_event_type DROP CONSTRAINT FK_CBFBC2AD401B253C');
        $this->addSql('ALTER TABLE event_location DROP CONSTRAINT FK_1872601B71F7E88B');
        $this->addSql('ALTER TABLE event_location DROP CONSTRAINT FK_1872601B64D218E');
        $this->addSql('ALTER TABLE mandate DROP CONSTRAINT FK_197D0FEECB944F1A');
        $this->addSql('ALTER TABLE mandate_role DROP CONSTRAINT FK_2E2C1826C1129CD');
        $this->addSql('ALTER TABLE mandate_role DROP CONSTRAINT FK_2E2C182D60322AC');
        $this->addSql('ALTER TABLE offer DROP CONSTRAINT FK_29D6873EA53A8AA');
        $this->addSql('ALTER TABLE partner DROP CONSTRAINT FK_312B3E16979B1AD6');
        $this->addSql('ALTER TABLE role DROP CONSTRAINT FK_57698A6A6C786081');
        $this->addSql('DROP TABLE app_user');
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

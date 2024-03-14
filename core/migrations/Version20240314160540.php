<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240314160540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4871CE4D5E237E06 ON hub (name)');
        $this->addSql('ALTER TABLE offer DROP CONSTRAINT fk_29d6873e9b54c5b7');
        $this->addSql('DROP INDEX idx_29d6873e9b54c5b7');
        $this->addSql('ALTER TABLE offer RENAME COLUMN provide_id TO provider_id');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EA53A8AA FOREIGN KEY (provider_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_29D6873EA53A8AA ON offer (provider_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE offer DROP CONSTRAINT FK_29D6873EA53A8AA');
        $this->addSql('DROP INDEX IDX_29D6873EA53A8AA');
        $this->addSql('ALTER TABLE offer RENAME COLUMN provider_id TO provide_id');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT fk_29d6873e9b54c5b7 FOREIGN KEY (provide_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_29d6873e9b54c5b7 ON offer (provide_id)');
        $this->addSql('DROP INDEX UNIQ_4871CE4D5E237E06');
    }
}

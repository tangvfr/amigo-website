<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320205414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location ALTER latitude SET NOT NULL');
        $this->addSql('ALTER TABLE location ALTER longitude SET NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B723AF3318A6C7D4 ON student (student_number)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B723AF33E7927C74 ON student (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE location ALTER latitude DROP NOT NULL');
        $this->addSql('ALTER TABLE location ALTER longitude DROP NOT NULL');
        $this->addSql('DROP INDEX UNIQ_B723AF3318A6C7D4');
        $this->addSql('DROP INDEX UNIQ_B723AF33E7927C74');
    }
}

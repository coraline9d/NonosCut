<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230623222752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2CDEADB2A');
        $this->addSql('DROP INDEX IDX_E19D9AD2CDEADB2A ON service');
        $this->addSql('ALTER TABLE service DROP agency_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD agency_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2CDEADB2A ON service (agency_id)');
    }
}

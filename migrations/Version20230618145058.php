<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618145058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', agency_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(60) NOT NULL, description LONGTEXT NOT NULL, duration INT NOT NULL, price DOUBLE PRECISION NOT NULL, image LONGBLOB NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, INDEX IDX_E19D9AD2CDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2CDEADB2A');
        $this->addSql('DROP TABLE service');
    }
}

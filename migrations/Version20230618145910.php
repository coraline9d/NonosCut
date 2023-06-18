<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618145910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', dog_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', agency_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', date DATE NOT NULL, hour VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, INDEX IDX_FE38F844634DFEB (dog_id), INDEX IDX_FE38F844CDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844634DFEB FOREIGN KEY (dog_id) REFERENCES dog (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844634DFEB');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844CDEADB2A');
        $this->addSql('DROP TABLE appointment');
    }
}

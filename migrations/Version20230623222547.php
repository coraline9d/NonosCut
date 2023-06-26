<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230623222547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844634DFEB');
        $this->addSql('ALTER TABLE dog DROP FOREIGN KEY FK_812C397D19EB6921');
        $this->addSql('DROP TABLE dog');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844CDEADB2A');
        $this->addSql('DROP INDEX IDX_FE38F844634DFEB ON appointment');
        $this->addSql('DROP INDEX IDX_FE38F844CDEADB2A ON appointment');
        $this->addSql('ALTER TABLE appointment ADD service_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', ADD client_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', ADD surname VARCHAR(60) NOT NULL, ADD age INT NOT NULL, ADD breed VARCHAR(60) DEFAULT NULL, ADD sexe VARCHAR(255) NOT NULL, DROP dog_id, DROP agency_id');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_FE38F844ED5CA9E6 ON appointment (service_id)');
        $this->addSql('CREATE INDEX IDX_FE38F84419EB6921 ON appointment (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dog (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', client_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', nickname VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, age INT NOT NULL, breed VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, sexe VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, INDEX IDX_812C397D19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE dog ADD CONSTRAINT FK_812C397D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844ED5CA9E6');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F84419EB6921');
        $this->addSql('DROP INDEX IDX_FE38F844ED5CA9E6 ON appointment');
        $this->addSql('DROP INDEX IDX_FE38F84419EB6921 ON appointment');
        $this->addSql('ALTER TABLE appointment ADD dog_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', ADD agency_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', DROP service_id, DROP client_id, DROP surname, DROP age, DROP breed, DROP sexe');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844634DFEB FOREIGN KEY (dog_id) REFERENCES dog (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('CREATE INDEX IDX_FE38F844634DFEB ON appointment (dog_id)');
        $this->addSql('CREATE INDEX IDX_FE38F844CDEADB2A ON appointment (agency_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618144700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dog (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', client_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', nickname VARCHAR(60) NOT NULL, age INT NOT NULL, breed VARCHAR(60) DEFAULT NULL, sexe JSON NOT NULL, weight DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, INDEX IDX_812C397D19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dog ADD CONSTRAINT FK_812C397D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dog DROP FOREIGN KEY FK_812C397D19EB6921');
        $this->addSql('DROP TABLE dog');
    }
}

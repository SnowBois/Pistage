<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220325103051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media_contact (id INT AUTO_INCREMENT NOT NULL, nom_media VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entreprise CHANGE activite activite LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE recherche ADD media_contact_id INT NOT NULL, DROP media_contact');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B46ED84EBDE FOREIGN KEY (media_contact_id) REFERENCES media_contact (id)');
        $this->addSql('CREATE INDEX IDX_B4271B46ED84EBDE ON recherche (media_contact_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B46ED84EBDE');
        $this->addSql('DROP TABLE media_contact');
        $this->addSql('ALTER TABLE entreprise CHANGE activite activite LONGTEXT NOT NULL');
        $this->addSql('DROP INDEX IDX_B4271B46ED84EBDE ON recherche');
        $this->addSql('ALTER TABLE recherche ADD media_contact VARCHAR(30) NOT NULL, DROP media_contact_id');
    }
}

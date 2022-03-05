<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220305131500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD administrateur_id INT DEFAULT NULL, ADD etudiant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B37EE5403C FOREIGN KEY (administrateur_id) REFERENCES administrateur (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B37EE5403C ON utilisateur (administrateur_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3DDEAB1A3 ON utilisateur (etudiant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B37EE5403C');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3DDEAB1A3');
        $this->addSql('DROP INDEX UNIQ_1D1C63B37EE5403C ON utilisateur');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3DDEAB1A3 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP administrateur_id, DROP etudiant_id');
    }
}
